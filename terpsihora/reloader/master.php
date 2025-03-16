<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
ini_set('memory_limit', '1024M');

class MasterDB {

    ## Данные подключения БД
    private $dbhost;
    private $dbname;
    private $dbusername; 
    private $dbpass; 
    ## Название Мастер-файла
    private $masterFile;
    ## Адрес изображений
    private $path_of_images;
    private $path_of_passports;

    ## Инициализируем переменные
    public function __construct() {
        $this->dbhost = "localhost";
        $this->dbname = "obo6855747_tempdb";
        $this->dbusername = "obo6855747_site";
        $this->dbpass = "123Jpn123";
        $this->masterFile = $_SERVER['DOCUMENT_ROOT'].'/terpsihora/reloader/master.csv';
        $this->path_of_images = $_SERVER['DOCUMENT_ROOT'].'/uploads/images/catalog/products/';
        $this->path_of_passports = $_SERVER['DOCUMENT_ROOT'].'/uploads/files/passports/';
    }

    ## Основная функция
    public function masterReloader(): string {
        ## Подключение к БД
        $GLOBALS['link'] = mysqli_connect($this->dbhost, $this->dbusername, $this->dbpass, $this->dbname);
        mysqli_set_charset($GLOBALS['link'], "UTF8");
        $db = mysqli_query($GLOBALS['link'], "SET SESSION sql_mode = ''");

        ## Обновляем Технические характеристики
        $lines = $this->openMasterFile($this->masterFile);
        ## Удаляем старые характеристики, кроме безкодных (без ЕТИМ) и все значения
        $this->deleteOldData();
        ## Заносим в БД полный список Технических характеристик
        $chars_array = [];
        $i = 0;
        foreach($lines[0] as $td) {
            if($i > 10){
                $char_title = $lines[1][$i];
                $char_unit = $lines[2][$i];
                $chars_array[$i] = array('char_code' => $td, 'title' => $lines[1][$i], 'unit' => $lines[2][$i]);
                $db = mysqli_query($GLOBALS['link'], "INSERT INTO `db_objects_chars` (`id`, `char_title`, `char_unit`, `char_code`) VALUES ('$i', '$char_title', '$char_unit', '$td')");
            }
            $i++;
        }
        unset($lines[0]);
        unset($lines[1]);
        unset($lines[2]);

        ## Наполняем базу продукты
        $bigarray = array();
        $ib = 1;
        $bib = 1;
        $array_tmp_s = [];
        foreach($lines as $line) {
            ## Готовим переменные для записи по продукту
            $obo_id = trim($line[0]);
            $articul = trim($line[1]);
            $title = trim($line[2]);
            $description = trim($line[3]);
            $alias = $this->formAlias($title).'-'.$obo_id;
            $etim_group = trim($line[4]);
            $etim_class = trim($line[5]);
            $status = trim($line[6]);
            ## Определяем элемент структуры
            $struct_id = $this->searchForStructID($line);            
            ## Заносим финальные значения в базу
            $dbnn = mysqli_query($GLOBALS['link'], "INSERT INTO `db_objects` (`id`, `obo_id`, `articul`, `title`, `description`, `alias`, `id_struct`, `etim_group`, `etim_class`, `status`) 
            VALUES ('$ib', '$obo_id', '$articul', '$title', '$description', '$alias', '$struct_id', '$etim_group', '$etim_class', '$status')");
            ## $dop_documents = ?
            $i = 0;
            ## Насыщаем базу Техническими характеристиками
            foreach($line as $finalline) {
                if($i > 10)
                    if(strlen($finalline) > 0)
                        $dbnnn = mysqli_query($GLOBALS['link'], "INSERT INTO `db_objects_chars_values` (`id`, `id_object`, `id_char`, `value`) VALUES ('$bib', '$ib', '$i', '$finalline')");
                $i++;
                $bib++;
            }
            $ib++;
        }

        ## Обновляем данные о картинках
        $this->formImagesArray();

        ## Обновляем данные о Паспортах
        $this->formPassportsArray();

        echo '<br>База обновлена!';

        return 'success';
    }

    private function openMasterFile(string $file): array {
        ## Открываем мастер-файл
        $handle = fopen($file, "r");
        ## Забираем все строки из мастер-файла
        $row = 0;
        $lines = [];
        while (($cont = fgetcsv($handle, 100000, ";")) !== FALSE) {
            $lines[$row] = $cont;
            $row++;
        }
        ## Возвращаем нужную кодировку
        $lp = mb_convert_variables('UTF-8', 'windows-1251', $lines);

        return $lines;
    }

    private function deleteOldData(): bool {
        $db = mysqli_query($GLOBALS['link'], "DELETE FROM `db_objects_chars_values`");
        $db = mysqli_query($GLOBALS['link'], "DELETE FROM `db_objects_chars` WHERE `char_code` <> '' AND `id` < 2000");
        $db = mysqli_query($GLOBALS['link'], "DELETE FROM `db_objects`");

        return true;
    }

    private function searchForStructID(array $line): int {
        ## Определяем последовательность родителей для элемента
        $struct_array = array(trim($line[7]), trim($line[8]));
        if(strlen($line[9]) > 3) $struct_array[] = trim($line[9]);
        if(strlen($line[10]) > 3) $struct_array[] = trim($line[10]);
        $search_struct_id = end($struct_array); // - Последний элемент
        array_pop($struct_array);
        $search_struct_parent_id = end($struct_array); // - Предпоследний элемент
        if(count($struct_array) > 1) {
            array_pop($struct_array);
            $search_struct_parentofparent_id = trim(end($struct_array)); // - Предпредпоследний элемент
            $db = mysqli_query($GLOBALS['link'], "SELECT `id` FROM `db_structure` WHERE `title` = '$search_struct_id' AND `level` = (SELECT `id` FROM `db_structure` WHERE `title` LIKE '$search_struct_parent_id' AND `level` = (SELECT `id` FROM `db_structure` WHERE `title` LIKE '$search_struct_parentofparent_id'))");
        } else {
            $db = mysqli_query($GLOBALS['link'], "SELECT `id` FROM `db_structure` WHERE `title` LIKE '$search_struct_id' AND `level` = (SELECT `id` FROM `db_structure` WHERE `title` LIKE '$search_struct_parent_id')");
        }
        $row = mysqli_fetch_array($db);
        
        return $row['id'];
    }

    private function formImagesArray(): bool {
        ## Собираем массив файлов
        $files = [];
        foreach (glob($this->path_of_images . '/*.jpg') as $fileName)
            $files[] = basename($fileName);

        $final_array = [];
        $db = mysqli_query($GLOBALS['link'], "SELECT `id`, `obo_id` FROM `db_objects` ORDER BY `obo_id`");
        while($rows = mysqli_fetch_array($db))
            foreach($files as $file) 
                if(str_contains($file, $rows['obo_id']))
                    if(isset($final_array[ $rows['obo_id'] ]))
                        $final_array[ $rows['obo_id'] ] .= ';'.$file;
                    else
                        $final_array[ $rows['obo_id'] ] = $file;

        foreach($final_array as $key => $images) {
            $key_n = trim($key);
            $db = mysqli_query($GLOBALS['link'], "UPDATE `db_objects` SET `image` = '$images', `obo_id` = '$key_n' WHERE `obo_id` = '$key'");
        }

        return true;
    }

    private function formPassportsArray(): bool {        
        $files = array();
        foreach (glob($this->path_of_passports . '/*.pdf') as $fileName)
            $files[] = basename($fileName);

        $final_array = [];
        $db = mysqli_query($GLOBALS['link'], "SELECT `id`, `obo_id` FROM `db_objects` ORDER BY `obo_id`");
        while($rows = mysqli_fetch_array($db))
            foreach($files as $file) 
                if(str_contains($file, trim($rows['obo_id'])))
                    if(isset($final_array[ $rows['obo_id'] ]))
                        $final_array[ $rows['obo_id'] ] .= ';'.$file;
                    else
                        $final_array[ $rows['obo_id'] ] = $file;

        foreach($final_array as $key => $passports) {
            $key_n = trim($key);
            $object = '{"Технический паспорт, .pdf": "'.$passports.'"}';
            $db = mysqli_query($GLOBALS['link'], "UPDATE `db_objects` SET `dop_documents` = '$object', `obo_id` = '$key_n' WHERE `obo_id` = '$key'");
        }

        return true;
    }

    ## Функция формирования алиаса
    private function formAlias(string $string): string {
        $converter = array(
            'а' => 'a',    'б' => 'b',    'в' => 'v',    'г' => 'g',    'д' => 'd',
            'е' => 'e',    'ё' => 'e',    'ж' => 'zh',   'з' => 'z',    'и' => 'i',
            'й' => 'y',    'к' => 'k',    'л' => 'l',    'м' => 'm',    'н' => 'n',
            'о' => 'o',    'п' => 'p',    'р' => 'r',    'с' => 's',    'т' => 't',
            'у' => 'u',    'ф' => 'f',    'х' => 'h',    'ц' => 'c',    'ч' => 'ch',
            'ш' => 'sh',   'щ' => 'sch',  'ь' => '',     'ы' => 'y',    'ъ' => '',
            'э' => 'e',    'ю' => 'yu',   'я' => 'ya'
        );
    
        $value = mb_strtolower($string);
        $value = strtr($value, $converter);
        $value = mb_ereg_replace('[^-0-9a-z]', '-', $value);
        $value = mb_ereg_replace('[-]+', '-', $value);
        $value = trim($value, '-');	
    
        return $value;
    }

}

$ml = new MasterDB();
$ml->masterReloader();