<?php

class AdminStandard {


    
    /**
     * Функция очистки строки
     * 
     * @access protected
     * @param string $string Строка, которую следует очистить
     * @return string
     */
    protected function clearString(string $string): string {
        $string = trim($string);
        $string = stripslashes($string);
        $string = str_replace("'", "&#8217;", $string);

        return $string;
    }    

    ## Функция вложенности и построение дерева вложенностей
    protected function returnNesting(int $parent_id): string {
        if($parent_id == 0)
            return ' - ';

        $tree = '';
        while($parent_id != 0) {
            $db = mysqli_query($GLOBALS['link'], "SELECT * FROM `db_structure` WHERE `id` = '$parent_id'");
            if(mysqli_num_rows($db) > 0):
                $row = mysqli_fetch_array($db);
                $tree = $row['title'] . ' > ' . $tree;
                $parent_id = $row['level'];
            else:
                $parent_id = 0;
            endif;
        }

        return $tree;
    }

    ## Возвращение селекта со структурой каталога
    protected function catalogStructure(int $parent_id, int $position, $isSelect = 0): string {
        $return = '';

        $db = mysqli_query($GLOBALS['link'], "SELECT * FROM `db_structure` WHERE `level` = '$parent_id' ORDER BY `order`");
        while($rows = mysqli_fetch_array($db)) {
            ## Вовзращаем позицию в базу
            $newPosition = $position;
            ## Делаем логический отступ для дочерних элементов
            $returnDop = '';
            for($i = 1; $i <= $position; $i++)
                $returnDop .= '- ';
            ## Возвращаем элемент
            if($position < 2) {
                $return .= '<option value="'.$rows['id'].'"';
                if($rows['id'] == $isSelect) $return .= ' selected';
                $return .= '><b>'.$returnDop.''.$rows['title'].'</b></option>';
            } else {
                $return .= '<option value="'.$rows['id'].'"';
                if($rows['id'] == $isSelect) $return .= ' selected';
                $return .= '>'.$returnDop.''.$rows['title'].'</option>';
            }
            ## Изучаем его дочерние
            $newPosition = $position + 1;
            $return .= $this->catalogStructure($rows['id'], $newPosition);
        }

        return $return;
    }

    ## Универсальная пагинация
    protected function renderPaginationBlock(int $n, int $page, string $type): string {
        if(strlen($type) < 1)
            return '';
        ## Выбираем, какую таблицу использовать
        if($type == 'products')
            $table = 'db_objects';
        if($type == 'categories')
            $table = 'db_structure';
        ## Рендерим пагинацию
        $return = '
        <div class="row" style="margin-bottom: 80px">
            <nav aria-label="Страницы раздела">
                <ul class="pagination justify-content-center pagination-sm">';
                $db = mysqli_query($GLOBALS['link'], "SELECT * FROM $table");
                $full = ceil(mysqli_num_rows($db) / $n);
                for($i = 1; $i <= $full; $i++) {
                    $return .= '
                    <li class="page-item';
                        if($i == $page) 
                            $return .= ' active';
                        $return .= '">
                        <a class="page-link" href="?p='.$type.'&page='.$i.'">'.$i.'
                        </a>
                    </li>';
                }
                $return .= '
                </ul>
            </nav>
        </div>';

        return $return;
    }
}