<?php

class AdminInterface extends AdminStandard  {

    public function returnContent(string $chpu): string {
        include("parts/Logger.php");
        if($this->clearString($chpu) == 'categories'):            
            include("categories.class.php");
            $content = $this->loadCategoriesTable();
        endif;
        if($this->clearString($chpu) == 'products'):                      
            include("products.class.php");
            $content = $this->loadProductsTable();
        endif;
        if($this->clearString($chpu) == 'techs')
            $content = $this->loadTechsTable();
        if($this->clearString($chpu) == 'mass')
            $content = $this->loadMassTable();
        if($this->clearString($chpu) == '')
            $content = $this->loadMainPage();

        return $content;
    }

## Функция печати Таблицы Категорий
    private function loadCategoriesTable(): string {
        $spec = '';

        ## Добавление Категории
        if( (isset($_GET['a'])) AND ($this->clearString($_GET['a']) == 'new') ):
            ## Если есть добавление
            if(isset($_POST['newCategory'])):
                $addToDB = new AddCategoryToDB();
                ## Редирект на редактирование Категории
                $new_id = $addToDB->addToDataBase();
                if($new_id > 0):                    
                    ## Логируем результат
                    $logger = new Listener();
                    $logger->listenForAction('Создана категория с идентификатором '.$new_id, 'categories');
                    header("Location: /terpsihora/index.php?p=categories&eid=".$new_id."&d=y");
                    exit();
                endif;

                ## Логируем результат
                $logger = new Listener();
                $logger->listenForAction('Ошибка при создании категории', 'categories');
                header("Location: /terpsihora/index.php?p=?p=categories&a=new&d=n");
                exit();
            endif;
            ## Подгружаем нужный класс добавления Категории
            $table = new AddCategoryForm();
            $return = $table->returnForm();

            return $return;
        endif;

        ## Редактирование категории
        if(isset($_GET['eid'])):
            $id = $this->clearString($_GET['eid']);
            $table = new EditCategoryForm();
            $return = $table->returnForm($id);
    
            return $return;
        endif;

        ## Статистический блок
        if( (isset($_GET['a'])) AND ($this->clearString($_GET['a']) == 'stat') ):
            $table = new StatTable();
            $return = $table->returnTable();

            return $return;
        endif;

        ## Логи Категории
        if( (isset($_GET['a'])) AND ($this->clearString($_GET['a']) == 'logs') ):
            $table = new LogsTable();
            $return = $table->returnTable();

            return $return;
        endif;

        ## Удаление категории
        if( (isset($_GET['did'])) AND (strlen($_GET['did']) > 0) ):
            $id = $this->clearString($_GET['did']);
            $db = mysqli_query($GLOBALS['link'], "DELETE FROM `db_structure` WHERE `id` = '$id'");
            $spec = '<div class="alert alert-danger" role="alert">Категория была удалена!</div>';
            ## Логируем результат
            $logger = new Listener();
            $logger->listenForAction('Удалена категория с идентификатором '.$id, 'categories');
        endif;

        ## Подгружаем нужный класс ОБЩИЙ
        $table = new CategoriesTable();
        $return = $table->returnTable($spec);

        return $return;
    }


#################################################################################################################################
##########################################################  ПРОДУКТЫ  ###########################################################
#################################################################################################################################
    private function loadProductsTable(): string {
        $spec = '';

        ## Добавление Продукта
        if( (isset($_GET['a'])) AND ($this->clearString($_GET['a']) == 'new') ):
            ## Подгружаем нужный класс добавления Продукта
            $table = new AddProductForm();
            $return = $table->returnForm();

            return $return;
        endif;

        ## Редактирование продукта
        if(isset($_GET['eid'])):
            $id = $this->clearString($_GET['eid']);
            $table = new EditProductForm();
            $return = $table->returnForm($id);
    
            return $return;
        endif;

        ## Удаление продукта
        if( (isset($_GET['did'])) AND (strlen($_GET['did']) > 0) ):
            $id = $this->clearString($_GET['did']);
            $db = mysqli_query($GLOBALS['link'], "DELETE FROM `db_objects` WHERE `id` = '$id'");
            $db = mysqli_query($GLOBALS['link'], "DELETE FROM `db_objects_chars_values` WHERE `id_object` = '$id'");
            $spec = '<div class="alert alert-danger" role="alert">Продукт был удалён!</div>';
            ## Логируем результат
            $logger = new Listener();
            $logger->listenForAction('Удалён продукт с идентификатором '.$id.' и его технические характеристики', 'products');
        endif;
        
        ## Подгружаем нужный класс ОБЩИЙ
        $table = new ProductsTable();
        $return = $table->returnTable($spec);

        return $return;
    }

    

#################################################################################################################################
#################################################  Технические характеристики  ##################################################
#################################################################################################################################

    private function loadTechsTable(): string {        

        /* Данные для пагинации */
        $page = 1;
        $n = 50;
        if(isset($_GET['page']))
            $page = $this->clearString($_GET['page']);

        $start = (intval($page) - 1) * $n;

        $return = '
        <div class="inside">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="?">Главная</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Технические характеристики</li>
                </ol>
            </nav>
            <div class="dopNavigation">
                <a href="?p=techs&a=new" title="Создать характеристику"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-plus-square" viewBox="0 0 16 16"><path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2z"/><path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4"/></svg></a>                
                <a href="https://oborussia.ru/catalog/" title="Просмотр Каталога на сайте" target="_blank"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-eye-fill" viewBox="0 0 16 16"><path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0"/><path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8m8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7"/></svg></a>
                <a href="?p=news&a=stat" title="Статистика (какая-то)"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-bar-chart" viewBox="0 0 16 16"><path d="M4 11H2v3h2zm5-4H7v7h2zm5-5v12h-2V2zm-2-1a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h2a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1zM6 7a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v7a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1zm-5 4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1z"/></svg></a>
                <a href="?p=products&a=logs" title="Логи раздела"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-clock-history" viewBox="0 0 16 16"><path d="M8.515 1.019A7 7 0 0 0 8 1V0a8 8 0 0 1 .589.022zm2.004.45a7 7 0 0 0-.985-.299l.219-.976q.576.129 1.126.342zm1.37.71a7 7 0 0 0-.439-.27l.493-.87a8 8 0 0 1 .979.654l-.615.789a7 7 0 0 0-.418-.302zm1.834 1.79a7 7 0 0 0-.653-.796l.724-.69q.406.429.747.91zm.744 1.352a7 7 0 0 0-.214-.468l.893-.45a8 8 0 0 1 .45 1.088l-.95.313a7 7 0 0 0-.179-.483m.53 2.507a7 7 0 0 0-.1-1.025l.985-.17q.1.58.116 1.17zm-.131 1.538q.05-.254.081-.51l.993.123a8 8 0 0 1-.23 1.155l-.964-.267q.069-.247.12-.501m-.952 2.379q.276-.436.486-.908l.914.405q-.24.54-.555 1.038zm-.964 1.205q.183-.183.35-.378l.758.653a8 8 0 0 1-.401.432z"/><path d="M8 1a7 7 0 1 0 4.95 11.95l.707.707A8.001 8.001 0 1 1 8 0z"/><path d="M7.5 3a.5.5 0 0 1 .5.5v5.21l3.248 1.856a.5.5 0 0 1-.496.868l-3.5-2A.5.5 0 0 1 7 9V3.5a.5.5 0 0 1 .5-.5"/></svg></a>
            </div>
            <h1>Технические характеристики</h1>
            <p class="lead">В данном разделе создаются, редактируются и удаляются Технические характеристики Продуктов.</p>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col" style="width: 2%">ID</th>
                        <th scope="col" style="width: 40%">Название</th>
                        <th scope="col">Мера измерения</th>
                        <th scope="col">Обяз.</th>
                        <th scope="col">КОД</th>
                        <th scope="col" class="text-center">Действия</th>
                    </tr>
                </thead>
                <tbody>';
                $db = mysqli_query($GLOBALS['link'], "SELECT * FROM `db_objects_chars` ORDER BY `id` LIMIT $start, $n");
                while($rows = mysqli_fetch_array($db)) {
                    $char_required = ($rows['char_required'] == 1) ? 'да' : 'нет';
                    $return .= '
                    <tr>
                        <th scope="row">'.$rows['id'].'</th>
                        <td class="small">'.$rows['char_title'].'</td>
                        <td>'.$rows['char_unit'].'</td>
                        <td>'.$char_required.'</td>
                        <td>'.$rows['char_code'].'</td>
                        <td class="text-center">
                        <a href="?p=techs&eid='.$rows['id'].'" title="Редактировать"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
                            <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325"/>
                        </svg></a>
                        <a href="?p=techs&did='.$rows['id'].'" title="Удалить"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
                            <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8z"/>
                        </svg></a>
                        </td>
                    </tr>';
                }
                $return .= '
                </tbody>
            </table>
            
        </div>
        <div class="row" style="margin-bottom: 80px">
            <nav aria-label="Страницы раздела">
                <ul class="pagination justify-content-center pagination-sm">';
                $db = mysqli_query($GLOBALS['link'], "SELECT * FROM `db_objects_chars`");
                $full = ceil(mysqli_num_rows($db) / $n);
                for($i = 1;$i <= $full; $i++) {
                    $return .= '
                    <li class="page-item';
                        if($i == $page) 
                            $return .= ' active';
                        $return .= '">
                        <a class="page-link" href="?p=techs&page='.$i.'">'.$i.'
                        </a>
                    </li>';
                }
                $return .= '
                </ul>
            </nav>
        </div>';

        return $return;
    }

#################################################################################################################################
######################################################  МАССОВЫЕ ДЕЙСТВИЯ  ######################################################
#################################################################################################################################
    private function loadMassTable(): string {
        $return = '
        <div class="inside">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="?">Главная</a></li>
                    <li class="breadcrumb-item active" aria-current="mass">Массовые действия</li>
                </ol>
            </nav>
            <div class="dopNavigation">
                <a href="?p=promo&a=logs" title="Логи раздела"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-clock-history" viewBox="0 0 16 16"><path d="M8.515 1.019A7 7 0 0 0 8 1V0a8 8 0 0 1 .589.022zm2.004.45a7 7 0 0 0-.985-.299l.219-.976q.576.129 1.126.342zm1.37.71a7 7 0 0 0-.439-.27l.493-.87a8 8 0 0 1 .979.654l-.615.789a7 7 0 0 0-.418-.302zm1.834 1.79a7 7 0 0 0-.653-.796l.724-.69q.406.429.747.91zm.744 1.352a7 7 0 0 0-.214-.468l.893-.45a8 8 0 0 1 .45 1.088l-.95.313a7 7 0 0 0-.179-.483m.53 2.507a7 7 0 0 0-.1-1.025l.985-.17q.1.58.116 1.17zm-.131 1.538q.05-.254.081-.51l.993.123a8 8 0 0 1-.23 1.155l-.964-.267q.069-.247.12-.501m-.952 2.379q.276-.436.486-.908l.914.405q-.24.54-.555 1.038zm-.964 1.205q.183-.183.35-.378l.758.653a8 8 0 0 1-.401.432z"/><path d="M8 1a7 7 0 1 0 4.95 11.95l.707.707A8.001 8.001 0 1 1 8 0z"/><path d="M7.5 3a.5.5 0 0 1 .5.5v5.21l3.248 1.856a.5.5 0 0 1-.496.868l-3.5-2A.5.5 0 0 1 7 9V3.5a.5.5 0 0 1 .5-.5"/></svg></a>
            </div>
            <h1>Массовые действия</h1>
            <p class="lead">В данном разделе вы можете массово обновлять БД.<br><b>ВНИМАНИЕ:</b> массовые действия требуют особенно внимательного отношения!</p>
            <h3>Обновление всей базы</h3>
            <div class="row">
                <div class="col-md-9">
                    <input type="file" name="reloadMaster" id="reloadMaster" class="form-control form-control-lg">
                    <div id="reloadMasterHelpBlock" class="form-text">
                        Внимательно изучите <a href="/terpsihora/reloader/default.csv" title="Скачать шаблон мастер-файла">пример мастер-файла</a>, чтобы не нанести базе данных ущерб! Помните, что последовательность столбцов должна быть в точности такой же, как в примере, за исключением последовательности технических характеристик.
                    </div>
                </div>
                <div class="col-md-3">
                    <button class="btn btn-primary btn-lg" id="reloadMasterButton">Обновить базу</button>
                    <div class="answearReloadMaster"></div>
                </div>
            </div>
        </div>
        <script>
        $("body").on("click", "#reloadMasterButton", function(){
            var file = $("#reloadMaster").prop("files")[0]; 
            var parts = file.name.split(".");
            if(parts[1] !== "csv") {
                $(".answearReloadMaster").html("Неверный формат файла!");
            } else {
                $("#reloadMasterButton").replaceWith(\'<button class="btn btn-primary btn-lg" type="button" id="reloadMasterButtonDisabled" disabled><span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>Обновляем...</button>\');
                var formData = new FormData();
                formData.append("file", file);
                $.ajax({
                    url: "/terpsihora/classes/ajax/loadMaster.php",
                    method: "post",
                    contentType: false,
                    processData: false,
                    data: formData,
                    success: function(y) {
                        $(".answearReloadMaster").html(y);
                        $("#reloadMasterButtonDisabled").replaceWith(\'<button class="btn btn-primary btn-lg" id="reloadMasterButton">Обновить базу</button>\');
                    }
                });
            }
        });
        </script>';

        return $return;
    }





#################################################################################################################################
###########################################################  ГЛАВНАЯ  ###########################################################
#################################################################################################################################
    private function loadMainPage(): string {
        $return = '
        <div class="inside">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active" aria-current="page">Главная</li>
                </ol>
            </nav>
            <h1>Выберите раздел</h1>
            <h3>База данных</h3>
            <div class="row catsline">
                <div class="col-md-1">
                    <a href="?p=categories"><svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor" class="bi bi-diagram-3" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M6 3.5A1.5 1.5 0 0 1 7.5 2h1A1.5 1.5 0 0 1 10 3.5v1A1.5 1.5 0 0 1 8.5 6v1H14a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-1 0V8h-5v.5a.5.5 0 0 1-1 0V8h-5v.5a.5.5 0 0 1-1 0v-1A.5.5 0 0 1 2 7h5.5V6A1.5 1.5 0 0 1 6 4.5zM8.5 5a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5zM0 11.5A1.5 1.5 0 0 1 1.5 10h1A1.5 1.5 0 0 1 4 11.5v1A1.5 1.5 0 0 1 2.5 14h-1A1.5 1.5 0 0 1 0 12.5zm1.5-.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5zm4.5.5A1.5 1.5 0 0 1 7.5 10h1a1.5 1.5 0 0 1 1.5 1.5v1A1.5 1.5 0 0 1 8.5 14h-1A1.5 1.5 0 0 1 6 12.5zm1.5-.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5zm4.5.5a1.5 1.5 0 0 1 1.5-1.5h1a1.5 1.5 0 0 1 1.5 1.5v1a1.5 1.5 0 0 1-1.5 1.5h-1a1.5 1.5 0 0 1-1.5-1.5zm1.5-.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5z"/></svg><br>Структура</a>
                </div>
                <div class="col-md-1">
                    <a href="?p=products"><svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor" class="bi bi-basket" viewBox="0 0 16 16"><path d="M5.757 1.071a.5.5 0 0 1 .172.686L3.383 6h9.234L10.07 1.757a.5.5 0 1 1 .858-.514L13.783 6H15a1 1 0 0 1 1 1v1a1 1 0 0 1-1 1v4.5a2.5 2.5 0 0 1-2.5 2.5h-9A2.5 2.5 0 0 1 1 13.5V9a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h1.217L5.07 1.243a.5.5 0 0 1 .686-.172zM2 9v4.5A1.5 1.5 0 0 0 3.5 15h9a1.5 1.5 0 0 0 1.5-1.5V9zM1 7v1h14V7zm3 3a.5.5 0 0 1 .5.5v3a.5.5 0 0 1-1 0v-3A.5.5 0 0 1 4 10m2 0a.5.5 0 0 1 .5.5v3a.5.5 0 0 1-1 0v-3A.5.5 0 0 1 6 10m2 0a.5.5 0 0 1 .5.5v3a.5.5 0 0 1-1 0v-3A.5.5 0 0 1 8 10m2 0a.5.5 0 0 1 .5.5v3a.5.5 0 0 1-1 0v-3a.5.5 0 0 1 .5-.5m2 0a.5.5 0 0 1 .5.5v3a.5.5 0 0 1-1 0v-3a.5.5 0 0 1 .5-.5"/></svg><br>Продукты</a>
                </div>
                <div class="col-md-1">
                    <a href="?p=techs"><svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor" class="bi bi-list-columns" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M0 .5A.5.5 0 0 1 .5 0h9a.5.5 0 0 1 0 1h-9A.5.5 0 0 1 0 .5m13 0a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5m-13 2A.5.5 0 0 1 .5 2h8a.5.5 0 0 1 0 1h-8a.5.5 0 0 1-.5-.5m13 0a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5m-13 2A.5.5 0 0 1 .5 4h10a.5.5 0 0 1 0 1H.5a.5.5 0 0 1-.5-.5m13 0a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5m-13 2A.5.5 0 0 1 .5 6h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5m13 0a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5m-13 2A.5.5 0 0 1 .5 8h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5m13 0a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5m-13 2a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5m13 0a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5m-13 2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5m13 0a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5m-13 2a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H.5a.5.5 0 0 1-.5-.5m13 0a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5"/></svg><br>Характеристики</a>
                </div>
            </div>
            <h3>Массовые действия</h3>
            <div class="row catsline">
                <div class="col-md-1">
                    <a href="?p=mass"><svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor" class="bi bi-database" viewBox="0 0 16 16"><path d="M4.318 2.687C5.234 2.271 6.536 2 8 2s2.766.27 3.682.687C12.644 3.125 13 3.627 13 4c0 .374-.356.875-1.318 1.313C10.766 5.729 9.464 6 8 6s-2.766-.27-3.682-.687C3.356 4.875 3 4.373 3 4c0-.374.356-.875 1.318-1.313M13 5.698V7c0 .374-.356.875-1.318 1.313C10.766 8.729 9.464 9 8 9s-2.766-.27-3.682-.687C3.356 7.875 3 7.373 3 7V5.698c.271.202.58.378.904.525C4.978 6.711 6.427 7 8 7s3.022-.289 4.096-.777A5 5 0 0 0 13 5.698M14 4c0-1.007-.875-1.755-1.904-2.223C11.022 1.289 9.573 1 8 1s-3.022.289-4.096.777C2.875 2.245 2 2.993 2 4v9c0 1.007.875 1.755 1.904 2.223C4.978 15.71 6.427 16 8 16s3.022-.289 4.096-.777C13.125 14.755 14 14.007 14 13zm-1 4.698V10c0 .374-.356.875-1.318 1.313C10.766 11.729 9.464 12 8 12s-2.766-.27-3.682-.687C3.356 10.875 3 10.373 3 10V8.698c.271.202.58.378.904.525C4.978 9.71 6.427 10 8 10s3.022-.289 4.096-.777A5 5 0 0 0 13 8.698m0 3V13c0 .374-.356.875-1.318 1.313C10.766 14.729 9.464 15 8 15s-2.766-.27-3.682-.687C3.356 13.875 3 13.373 3 13v-1.302c.271.202.58.378.904.525C4.978 12.71 6.427 13 8 13s3.022-.289 4.096-.777c.324-.147.633-.323.904-.525"/></svg><br>Обновление БД</a>
                </div>
            </div>
        </div>
        ';

        return $return;
    }

}