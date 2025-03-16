<?php

/**
 * Общий класс для работы с Продуктами
 * 
 * Отвечает за базовые фунции работы с продуктами, 
 * которые не используются больше нигде
 */
class Products extends AdminStandard {
    ## Выводим хлебные крошки
    protected function formBreadcrumbs(string $thisPage): string {
        $return = '
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/terpsihora/index.php">Главная</a></li>';
                if($thisPage == 'mainPage')
                    $return .= '
                    <li class="breadcrumb-item active" aria-current="page">Продукты</li>';
                if($thisPage == 'addPage')
                    $return .= '
                    <li class="breadcrumb-item active" aria-current="page"><a href="?p=products">Продукты</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Добавление продукта</li>';
                if($thisPage == 'editPage')
                    $return .= '
                    <li class="breadcrumb-item active" aria-current="page"><a href="?p=products">Продукты</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Редактирование продукта</li>';
                if($thisPage == 'logsPage')
                    $return .= '
                    <li class="breadcrumb-item active" aria-current="page"><a href="?p=products">Продукты</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Логи раздела</li>';
                if($thisPage == 'statPage')
                    $return .= '
                    <li class="breadcrumb-item active" aria-current="page"><a href="?p=products">Продукты</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Статистика раздела</li>';
            $return .= '
            </ol>
        </nav>';
        
        return $return;
    }

    ## Выводим дополнительную навигацию раздела
    protected function formDopNavigation(): string {
        $return = '
        <div class="dopNavigation">
            <a href="?p=products&a=new" title="Создать продукт"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-plus-square" viewBox="0 0 16 16"><path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2z"/><path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4"/></svg></a>
            <a href="https://oborussia.ru/catalog/" title="Просмотр Каталога на сайте" target="_blank"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-eye-fill" viewBox="0 0 16 16"><path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0"/><path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8m8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7"/></svg></a>
            <a href="?p=products&a=stat" title="Статистика (какая-то)"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-bar-chart" viewBox="0 0 16 16"><path d="M4 11H2v3h2zm5-4H7v7h2zm5-5v12h-2V2zm-2-1a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h2a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1zM6 7a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v7a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1zm-5 4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1z"/></svg></a>
            <a href="?p=products&a=logs" title="Логи раздела"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-clock-history" viewBox="0 0 16 16"><path d="M8.515 1.019A7 7 0 0 0 8 1V0a8 8 0 0 1 .589.022zm2.004.45a7 7 0 0 0-.985-.299l.219-.976q.576.129 1.126.342zm1.37.71a7 7 0 0 0-.439-.27l.493-.87a8 8 0 0 1 .979.654l-.615.789a7 7 0 0 0-.418-.302zm1.834 1.79a7 7 0 0 0-.653-.796l.724-.69q.406.429.747.91zm.744 1.352a7 7 0 0 0-.214-.468l.893-.45a8 8 0 0 1 .45 1.088l-.95.313a7 7 0 0 0-.179-.483m.53 2.507a7 7 0 0 0-.1-1.025l.985-.17q.1.58.116 1.17zm-.131 1.538q.05-.254.081-.51l.993.123a8 8 0 0 1-.23 1.155l-.964-.267q.069-.247.12-.501m-.952 2.379q.276-.436.486-.908l.914.405q-.24.54-.555 1.038zm-.964 1.205q.183-.183.35-.378l.758.653a8 8 0 0 1-.401.432z"/><path d="M8 1a7 7 0 1 0 4.95 11.95l.707.707A8.001 8.001 0 1 1 8 0z"/><path d="M7.5 3a.5.5 0 0 1 .5.5v5.21l3.248 1.856a.5.5 0 0 1-.496.868l-3.5-2A.5.5 0 0 1 7 9V3.5a.5.5 0 0 1 .5-.5"/></svg></a>
        </div>';

        return $return;
    }
}

/**
 * Класс рендера таблицы Продуктов
 * 
 * Возвращает таблицу продуктов
 * без дополнительных действий
 */
class ProductsTable extends Products {
    ## Основная функция рендеринга таблицы
    public function returnTable(string $spec): string {
        ## Данные для пагинации
        $page = 1;
        $n = 80;
        if(isset($_GET['page']))
            $page = $this->clearString($_GET['page']);
        $start = (intval($page) - 1) * $n;
        $return = '
        <div class="inside">
            '.$this->formBreadcrumbs('mainPage').'
            '.$this->formDopNavigation().'
            <h1>Продукты</h1>
            <p class="lead">В данном разделе создаются, редактируются и удаляются продукты в Каталоге.</p>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col" style="width: 2%">ID</th>
                        <th scope="col" style="width: 6%"></th>
                        <th scope="col">Название</th>
                        <th scope="col">Расположение</th>
                        <th scope="col" style="width: 8%">Артикул</th>
                        <th scope="col" style="width: 10%">Тип</th>
                        <th scope="col">ETIM</th>
                        <th scope="col" class="text-center">Действия</th>
                    </tr>
                </thead>
                <tbody>';
                $db = mysqli_query($GLOBALS['link'], "SELECT * FROM `db_objects` ORDER BY id_struct LIMIT $start, $n");
                while($rows = mysqli_fetch_array($db))
                    $return .= $this->formTableLine($rows['id']);
                $return .= '
                </tbody>
            </table>            
        </div>';
        ## Рендер пагинации
        $return .= $this->renderPaginationBlock($n, $page, 'products');

        return $return;
    }

    ## Одна строка таблицы
    private function formTableLine(int $id): string {
        ## Получаем данные строки
        $db = mysqli_query($GLOBALS['link'], "SELECT * FROM `db_objects` WHERE `id` = '$id'");
        if(mysqli_num_rows($db) < 1)
            return '';

        $row = mysqli_fetch_array($db);
        $image = 'https://oborussia.ru/uploads/images/nophoto.png';
        if(strlen($row['image']) > 0){
            $image_tmp = explode(';', $row['image']);
            $image = 'https://oborussia.ru/uploads/images/catalog/products/'.$image_tmp[0];
        }
        $return = '
        <tr>
            <th scope="row">'.$row['id'].'</th>
            <td class="text-center"><img src="'.$image.'" width="60"></td>
            <td class="small">'.$row['title'].'<br><small>[ '.$row['alias'].' ]</small></td>
            <td class="small">'.$this->returnNesting($row['id_struct']).'</td>
            <td class="small">'.$row['obo_id'].'</td>
            <td class="small">'.$row['articul'].'</td>
            <td class="small">'.$row['etim_group'].'</td>
            <td class="text-center">
            <a href="?p=products&eid='.$row['id'].'" title="Редактировать"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
                <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325"/>
            </svg></a>
            <a href="?p=products&did='.$row['id'].'" onclick="return confirm(\'Вы уверены, что хотите удалить этот Продукт?\')" title="Удалить"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
                <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8z"/>
            </svg></a>
            </td>
        </tr>';

        return $return;
    }    
}

/**
 * Класс, который рендерит форму добавления Продукта
 * 
 * Форма добавления - базовая вёрстка,
 * подключение сторонних функций для 
 * интерфейса формы
 */
class AddProductForm extends Products {
## Основная функция рендеринга формы
    public function returnForm(): string {
        ## Начинаем рендерить форму добавления Категории
        $return = '
        <div class="inside">
            '.$this->formBreadcrumbs('addPage').'
            '.$this->formDopNavigation().'<h1>Добавление продукта</h1>
            <form action="" method="POST" name="addProduct">
                <div class="row">
                    <div class="col-md-8">
                        <label for="title" class="form-label">Название продукта*</label>
                        <input type="text" name="title" id="title" class="form-control" placeholder="Введите название нового продукта"><br>
                        <label for="basic-url" class="form-label">ЧПУ продукта</label>
                        <div class="input-group mb-3"><input type="text" class="form-control" id="clias" aria-describedby="basic-addon3" placeholder="ЧПУ продукта (формируется автоматически)" disabled readonly></div><br>
                        <label for="description" class="form-label">Описание продукта</label>
                        <textarea class="form-control" placeholder="Введите описание продукта" id="description" name="description" style="height: 100px"></textarea><br>
                        <label class="form-label">Дополнительные данные</label><br>
                        <div class="accordion" id="accordionExample">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingOne"><button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">Артикулы и коды</button></h2>
                                <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <label for="obo_id" class="form-label">Артикул (ранее: OBO ID)</label>
                                        <input type="text" name="obo_id" id="obo_id" class="form-control" placeholder="Введите Артикул">
                                    </div>
                                    <div class="accordion-body">
                                        <label for="articul" class="form-label">Тип</label>
                                        <input type="text" name="articul" id="articul" class="form-control" placeholder="Введите Тип">
                                    </div>
                                    <div class="accordion-body">
                                        <label for="etim_group" class="form-label">Группа ETIM</label>
                                        <input type="text" name="etim_group" id="etim_group" class="form-control" placeholder="Введите Группу ETIM">
                                    </div>
                                    <div class="accordion-body">
                                        <label for="etim_class" class="form-label">Класс ETIM</label>
                                        <input type="text" name="etim_class" id="etim_class" class="form-control" placeholder="Введите Класс ETIM">
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingTwo"><button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">Галерея изображений</button></h2>
                                <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <label for="gallery" class="form-label">Изображения галереи</label>
                                        <input type="file" name="gallery" id="gallery" class="form-control" multiple>
                                        <div id="galleryHelpBlock" class="form-text">Для каждой галереи на сервере автоматически создаётся отдельная папка в каталоге "/uploads/images/galleries/".</div>
                                        <div class="imagesForGallery"><p class="lead text-center">Пока в галерее нет ни одного изображения.</p></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="level" class="form-label">Вложенность*</label>
                        <select name="level" id="level" class="form-select form-select-sm">'.$this->catalogStructure(0, 0).'</select><br>
                        <label for="status" class="form-label">Статус продукта</label>
                        <input type="text" name="status" id="status" class="form-control" placeholder="Выберите статус продукта"><br>
                        <input type="submit" name="newProduct" id="newProduct" value="Создать" class="btn btn-primary btn-lg">
                    </div>
                </div>
            </form>
        </div>';

        return $return;
    }
}

/**
 * Класс, отвечающий за редактирование Продукта
 * 
 * Возвращает форму редактирования Продукта
 */
class EditProductForm extends Products {

    ## Возвращаем форму редактирования Категории
    function returnForm(int $id): string {
        $return = '';
        $db = mysqli_query($GLOBALS['link'], "SELECT * FROM `db_objects` WHERE `id` = '$id'");
        $row = mysqli_fetch_array($db);
        $return = '
        <div class="inside">
            '.$this->formBreadcrumbs('editPage').'
            '.$this->formDopNavigation().'            
            <h1>Редактирование продукта</h1>
            <p class="lead">В данном разделе вы можете отредактировать Продукт.</p>
            '.$this->returnAlert().'
            <form action="" method="POST" name="addNews">
                <div class="row">
                    <div class="col-md-8">
                        <label for="title" class="form-label">Название продукта*</label>
                        <input type="text" name="title" id="title" class="form-control" placeholder="Введите название категории" maxlength="55" value="'.$row['title'].'"><br>
                        <label for="alias" class="form-label">ЧПУ продукта</label>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" id="alias" placeholder="ЧПУ категории (формируется автоматически)" value="'.$row['alias'].'" readonly>
                        </div><br>
                        <label for="catDescription" class="form-label">Описание продукта</label>
                        <textarea class="form-control" placeholder="Введите описание категории" id="catDescription" name="description" style="height: 100px">'.$row['description'].'</textarea><br>
                        <label class="form-label">Дополнительные данные</label><br>
                        <div class="accordion" id="accordionExample">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingOne"><button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">Артикулы и коды</button></h2>
                                <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <label for="obo_id" class="form-label">Артикул (ранее: OBO ID)</label>
                                        <input type="text" name="obo_id" id="obo_id" class="form-control" placeholder="Введите Артикул" value="'.$row['obo_id'].'">
                                    </div>
                                    <div class="accordion-body">
                                        <label for="articul" class="form-label">Тип</label>
                                        <input type="text" name="articul" id="articul" class="form-control" placeholder="Введите Тип" value="'.$row['articul'].'">
                                    </div>
                                    <div class="accordion-body">
                                        <label for="etim_group" class="form-label">Группа ETIM</label>
                                        <input type="text" name="etim_group" id="etim_group" class="form-control" placeholder="Введите Группу ETIM" value="'.$row['etim_group'].'">
                                    </div>
                                    <div class="accordion-body">
                                        <label for="etim_class" class="form-label">Класс ETIM</label>
                                        <input type="text" name="etim_class" id="etim_class" class="form-control" placeholder="Введите Класс ETIM" value="'.$row['etim_class'].'">
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingTwo"><button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">Галерея изображений</button></h2>
                                <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <label for="gallery" class="form-label">Изображения галереи</label>
                                        <div class="row productGallery">';
                                            $images = explode(';', $row['image']);
                                            foreach($images as $image)
                                                $return .= '<div class="col-md-2"><img src="/uploads/images/catalog/products/'.$image.'"></div>';
                                        $return .= '
                                        </div><br>
                                        <input type="file" name="gallery" id="gallery" class="form-control" multiple>
                                        <div id="galleryHelpBlock" class="form-text">Все изображения продуктов лежат в одном каталоге "/uploads/images/catalog/products/" и должны содержать Артикул прибора, чтобы не быть утерянными при массовом обновлении.</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="date" class="form-label">Вложенность*</label>
                        <select name="level" id="level" class="form-select form-select-sm">
                            '.$this->catalogStructure(0, 0, $row['id_struct']).'
                        </select><br>
                        <label for="status" class="form-label">Статус продукта</label>
                        <input type="text" name="status" id="status" class="form-control" placeholder="Выберите статус продукта" value="'.$row['status'].'"><br>
                        <input type="suubmit" name="editProduct" id="editProduct" value="Сохранить" class="btn btn-primary btn-lg">
                    </div>
                </div>
            </form>
        </div>';

        return $return;
    }

    private function returnAlert(): string {
        $return = '';
        if( (isset($_GET['d'])) AND ($_GET['d'] == 'y') )
            $return .= '<div class="alert alert-primary" role="alert">Спасибо, продукт добавлен!</div>';
        if( (isset($_GET['d'])) AND ($_GET['d'] == 'ey') )
            $return .= '<div class="alert alert-primary" role="alert">Спасибо, продукт отредактирован!</div>';
        if( (isset($_GET['d'])) AND ($_GET['d'] == 'n') )
            $return .= '<div class="alert alert-danger" role="alert">К сожалению, редактирование не удалось!</div>';

        return $return;
    }

}