<?php

/**
 * Общий класс для работы с Категориями
 * 
 * Отвечает за базовые фунции работы с категориями, 
 * которые не используются больше нигде
 */
class Categories extends AdminStandard {

    ## Выводим хлебные крошки
    protected function formBreadcrumbs(string $thisPage): string {
        $return = '
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/terpsihora/index.php">Главная</a></li>';
                if($thisPage == 'mainPage')
                    $return .= '
                    <li class="breadcrumb-item active" aria-current="page">Структура</li>';
                if($thisPage == 'addPage')
                    $return .= '
                    <li class="breadcrumb-item active" aria-current="page"><a href="?p=categories">Структура</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Добавление категории</li>';
                if($thisPage == 'editPage')
                    $return .= '
                    <li class="breadcrumb-item active" aria-current="page"><a href="?p=categories">Структура</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Редактирование категории</li>';
                if($thisPage == 'logsPage')
                    $return .= '
                    <li class="breadcrumb-item active" aria-current="page"><a href="?p=categories">Структура</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Логи раздела</li>';
                if($thisPage == 'statPage')
                    $return .= '
                    <li class="breadcrumb-item active" aria-current="page"><a href="?p=categories">Структура</a></li>
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
            <a href="?p=categories&a=new" title="Создать категорию"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-plus-square" viewBox="0 0 16 16"><path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2z"/><path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4"/></svg></a>
            <a href="https://oborussia.ru/catalog/" title="Просмотр Каталога на сайте" target="_blank"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-eye-fill" viewBox="0 0 16 16"><path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0"/><path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8m8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7"/></svg></a>
            <a href="?p=categories&a=stat" title="Статистика (какая-то)"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-bar-chart" viewBox="0 0 16 16"><path d="M4 11H2v3h2zm5-4H7v7h2zm5-5v12h-2V2zm-2-1a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h2a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1zM6 7a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v7a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1zm-5 4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1z"/></svg></a>
            <a href="?p=categories&a=logs" title="Логи раздела"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-clock-history" viewBox="0 0 16 16"><path d="M8.515 1.019A7 7 0 0 0 8 1V0a8 8 0 0 1 .589.022zm2.004.45a7 7 0 0 0-.985-.299l.219-.976q.576.129 1.126.342zm1.37.71a7 7 0 0 0-.439-.27l.493-.87a8 8 0 0 1 .979.654l-.615.789a7 7 0 0 0-.418-.302zm1.834 1.79a7 7 0 0 0-.653-.796l.724-.69q.406.429.747.91zm.744 1.352a7 7 0 0 0-.214-.468l.893-.45a8 8 0 0 1 .45 1.088l-.95.313a7 7 0 0 0-.179-.483m.53 2.507a7 7 0 0 0-.1-1.025l.985-.17q.1.58.116 1.17zm-.131 1.538q.05-.254.081-.51l.993.123a8 8 0 0 1-.23 1.155l-.964-.267q.069-.247.12-.501m-.952 2.379q.276-.436.486-.908l.914.405q-.24.54-.555 1.038zm-.964 1.205q.183-.183.35-.378l.758.653a8 8 0 0 1-.401.432z"/><path d="M8 1a7 7 0 1 0 4.95 11.95l.707.707A8.001 8.001 0 1 1 8 0z"/><path d="M7.5 3a.5.5 0 0 1 .5.5v5.21l3.248 1.856a.5.5 0 0 1-.496.868l-3.5-2A.5.5 0 0 1 7 9V3.5a.5.5 0 0 1 .5-.5"/></svg></a>
        </div>';

        return $return;
    }
}

/**
 * Класс рендера таблицы Категорий
 * 
 * Возвращает таблицу категорий
 * без дополнительных действий
 */
class CategoriesTable extends Categories {

    ## Основная функция рендеринга таблицы
    public function returnTable(string $spec): string {
        ## Для пагинации
        $n = 20;
        $page = $this->returnPage();
        $start = (($page) - 1) * $n;
        ## Рендер таблицы
        $return = '
        <div class="inside">
            '.$this->formBreadcrumbs('mainPage').'
            '.$this->formDopNavigation().'
            <h1>Структура каталога</h1>
            <p class="lead">В данном разделе создаются, редактируются и удаляются Категории каталога.</p>
            '.$spec.'
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col" style="width: 2%">ID</th>
                        <th scope="col" style="width: 6%"></th>
                        <th scope="col" style="width: 30%">Название</th>
                        <th scope="col" style="width: 40%">Вложенность</th>
                        <th scope="col" class="text-center">Порядок</th>
                        <th scope="col" class="text-center">Действия</th>
                    </tr>
                </thead>
                <tbody>';
                $db = mysqli_query($GLOBALS['link'], "SELECT `id` FROM `db_structure` ORDER BY `level`, `order` LIMIT $start, $n");
                while($rows = mysqli_fetch_array($db))
                    $return .= $this->formTableLine($rows['id']);
                $return .= '
                </tbody>
            </table>            
        </div>';
        ## Рендер пагинации
        $return .= $this->renderPaginationBlock($n, $page, 'categories');

        return $return;
    }

    ## Одна строка таблицы
    private function formTableLine(int $id): string {
        ## Получаем данные строки
        $db = mysqli_query($GLOBALS['link'], "SELECT `id`, `title`, `alias`, `image`, `level`, `order` FROM `db_structure` WHERE `id` = '$id'");
        if(mysqli_num_rows($db) < 1)
            return '';

        $row = mysqli_fetch_array($db);
        ## Рендерим строку
        $return = '
        <tr>
            <th scope="row">'.$row['id'].'</th>
            <td class="text-center">';
                if(strlen($row['image']) > 2) 
                    $return .= '<img src="https://oborussia.ru/uploads/images/categories/'.$row['image'].'" width="60">';
            $return .= '
            </td>
            <td>'.$row['title'].'<br><small>[ '.$row['alias'].' ]</small></td>
            <td><small>'.$this->returnNesting($row['level']).'</small></td>
            <td class="text-center">'.$row['order'].'</td>
            <td class="text-center">
            <a href="?p=categories&eid='.$row['id'].'" title="Редактировать"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
                <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325"/>
            </svg></a>
            <a href="?p=categories&did='.$row['id'].'&page='.$this->returnPage().'" onclick="return confirm(\'Вы уверены, что хотите удалить эту Категорию?\')" title="Удалить"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
                <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8z"/>
            </svg></a>
            </td>
        </tr>';

        return $return;
    }

    ## Определяем текущую страницу
    private function returnPage(): int {
        $page = 1;
        if(isset($_GET['page']))
            return intval($this->clearString($_GET['page']));

        return $page;
    }

}

/**
 * Класс, который рендерит форму добавления Категории
 * 
 * Форма добавления - базовая вёрстка,
 * подключение сторонних функций для 
 * интерфейса формы
 */
class AddCategoryForm extends Categories {

    ## Основная функция рендеринга формы
    public function returnForm(): string {
        ## Начинаем рендерить форму добавления Категории
        $return = '
        <div class="inside">
            '.$this->formBreadcrumbs('addPage').'
            '.$this->formDopNavigation().'
            <h1>Добавление категории</h1>
            <p class="lead">В данном разделе вы можете создать Категорию каталога.</p>
            <form action="" method="POST" name="addNews" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-8">
                        <label for="title" class="form-label">Название категории*</label>
                        <input type="text" name="title" id="title" class="form-control" placeholder="Введите название категории" maxlength="55"><br>
                        <label for="alias" class="form-label">ЧПУ категории</label>
                        <div class="input-group mb-3"><input type="text" class="form-control" name="alias" id="alias" placeholder="ЧПУ категории (формируется автоматически)" readonly></div><br>
                        <label for="catDescription" class="form-label">Описание категории</label>
                        <textarea class="form-control" placeholder="Введите описание категории" id="catDescription" name="description" style="height: 100px"></textarea>
                        <div id="catDescriptionHelpBlock" class="form-text">Рекомендуемая длина для описания - 1 предложение.</div><br>
                        <label class="form-label">Оформление</label><br>
                        <div class="accordion" id="accordionExample">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingOne">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">Изображение категории</button>
                                </h2>
                                <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <label for="image" class="form-label">Изображение категории для сайта</label>
                                        <input type="file" name="file" id="image" class="form-control">
                                        <div id="imageHelpBlock" class="form-text">Размер изображений на сайте: 258 x 258 пикселей. Размер на главной странице каталога: 416 x 260 пикселей.</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="date" class="form-label">Вложенность*</label>
                        <select name="level" id="level" class="form-select form-select-sm">'.$this->catalogStructure(0, 0).'</select><br>
                        <label for="number" class="form-label">Порядковый номер</label>
                        <input type="number" name="number" id="number" class="form-control" placeholder="Введите порядковый номер"><br>
                        <input type="submit" name="newCategory" id="newCategory" value="Создать" class="btn btn-primary btn-lg">
                    </div>
                </div>
            </form>
        </div>';

        return $return;
    }

}

/**
 * Класс, отвечающий за сохранение данных в БД
 * 
 * Получает данные с формы добавления
 * Категории и помещает их в БД,
 * файл с изображением ложится на сервер
 */
class AddCategoryToDB extends Categories {

    ## Заносим данные в БД
    public function addToDataBase(): int {
        ## Получаем данные с формы
        $title = $this->clearString($_POST['title']);
        $alias = $this->clearString($_POST['alias']);
        $description = $this->clearString($_POST['description']);
        $level = $this->clearString($_POST['level']);
        $number = $this->clearString($_POST['number']);
        ## Обрабатываем картинку
        $files = $_FILES;
        foreach($files as $file)
            if(move_uploaded_file( $file['tmp_name'], $_SERVER['DOCUMENT_ROOT'].'/uploads/images/categories/'.$alias.'.jpg'))
                $image = $alias.'.jpg';
        ## Добавляем в базу
        $db = mysqli_query($GLOBALS['link'], "INSERT INTO `db_structure` (`title`, `alias`, `image`, `description`, `level`, `order`) VALUES ('$title', '$alias', '$image', '$description', '$level', '$number')");
        ## Получаем данные для редиректа
        $db = mysqli_query($GLOBALS['link'], "SELECT `id` FROM `db_structure` WHERE `title` = '$title' AND `level` = '$level'");
        if(mysqli_num_rows($db) > 0):
            $row = mysqli_fetch_array($db);
            return $row['id'];
        endif;

        return 0;        
    }

}

/**
 * Класс, отвечающий за редактирование Категории
 * 
 * Возвращает форму редактирования Категории
 * с данными указанной Категории
 * и предвыбранной вложенностью
 */
class EditCategoryForm extends Categories {

    ## Возвращаем форму редактирования Категории
    function returnForm(int $id): string {
        $return = '';
        $db = mysqli_query($GLOBALS['link'], "SELECT * FROM `db_structure` WHERE `id` = '$id'");
        $row = mysqli_fetch_array($db);
        $return = '
        <div class="inside">
            '.$this->formBreadcrumbs('editPage').'
            '.$this->formDopNavigation().'            
            <h1>Редактирование категории</h1>
            <p class="lead">В данном разделе вы можете отредактировать Категорию каталога.</p>
            '.$this->returnAlert().'
            <form action="" method="POST" name="addNews">
                <div class="row">
                    <div class="col-md-8">
                        <label for="title" class="form-label">Название категории*</label>
                        <input type="text" name="title" id="title" class="form-control" placeholder="Введите название категории" maxlength="55" value="'.$row['title'].'"><br>
                        <label for="alias" class="form-label">ЧПУ категории</label>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" id="alias" placeholder="ЧПУ категории (формируется автоматически)" value="'.$row['alias'].'" readonly>
                        </div><br>
                        <label for="catDescription" class="form-label">Описание категории</label>
                        <textarea class="form-control" placeholder="Введите описание категории" id="catDescription" name="description" style="height: 100px">'.$row['description'].'</textarea>
                        <div id="catDescriptionHelpBlock" class="form-text">Рекомендуемая длина для описания - 1 предложение.</div><br>
                        <label class="form-label">Оформление</label><br>
                        <div class="accordion" id="accordionExample">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingOne">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">Изображение категории</button>
                                </h2>
                                <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">';
                                        if(strlen($row['image']) > 1)
                                            $return .= '<img src="https://oborussia.ru/uploads/images/categories/'.$row['image'].'"><br>';
                                        $return .= '
                                        <label for="image" class="form-label">Изображение категории для сайта</label>
                                        <input type="file" name="image" id="image" class="form-control" multiple>
                                        <div id="galleryHelpBlock" class="form-text">Размер изображений на сайте: 258 x 258 пикселей. Размер на главной странице каталога: 416 x 260 пикселей.</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="date" class="form-label">Вложенность*</label>
                        <select name="level" id="level" class="form-select form-select-sm">
                            '.$this->catalogStructure(0, 0, $row['level']).'
                        </select><br>
                        <label for="number" class="form-label">Порядковый номер</label>
                        <input type="number" name="number" id="number" class="form-control" placeholder="Введите порядковый номер" value="'.$row['order'].'"><br>
                        <input type="suubmit" name="editCategory" id="editCategory" value="Сохранить" class="btn btn-primary btn-lg">
                    </div>
                </div>
            </form>
        </div>';

        return $return;
    }

    private function returnAlert(): string {
        $return = '';
        if( (isset($_GET['d'])) AND ($_GET['d'] == 'y') )
            $return .= '<div class="alert alert-primary" role="alert">Спасибо, категория добавлена!</div>';
        if( (isset($_GET['d'])) AND ($_GET['d'] == 'ey') )
            $return .= '<div class="alert alert-primary" role="alert">Спасибо, категория отредактирована!</div>';
        if( (isset($_GET['d'])) AND ($_GET['d'] == 'n') )
            $return .= '<div class="alert alert-danger" role="alert">К сожалению, редактирование не удалось!</div>';

        return $return;
    }

}

class StatTable extends Categories {

    public function returnTable(): string {
        $return = '
        <div class="inside">
            '.$this->formBreadcrumbs('statPage').'
            '.$this->formDopNavigation().'            
            <h1>Статистика раздела</h1>
            <p class="lead">В данном разделе вы можете посмотреть статистику по Категориям каталога.</p>
            <div class="row">
                <div class="col-md-3 statLeft">
                    <h3>Общие сведения</h3>
                    <p><b>Всего категорий:</b> <span class="right">'.$this->countCategories().'</span></p>
                    <p><b>Товаров в категориях:</b> <span class="right">'.$this->countProducts().'</span></p>
                </div>
                <div class="col-md-9">
                    <h3>Наполненность категорий</h3>
                    <link rel="stylesheet" href="//cdn.jsdelivr.net/chartist.js/latest/chartist.min.css">
                    <script src="//cdn.jsdelivr.net/chartist.js/latest/chartist.min.js"></script>
                    <div class="graph">
                        <div class="ct-chart ct-chart-pie"></div>
                    </div>
                </div>
            </div>';

        
        $return .= '
        </div>
        <script>
        var defaultOptions = {
            width: undefined,
            height: undefined,
            chartPadding: 5,
            classNames: {
                chartPie: "ct-chart-pie",
                chartDonut: "ct-chart-donut",
                series: "ct-series",
                slicePie: "ct-slice-pie",
                sliceDonut: "ct-slice-donut",
                sliceDonutSolid: "ct-slice-donut-solid",
                label: "ct-label"
            },
            startAngle: 0,
            total: '.$this->countCategories().',
            donut: false,
            donutSolid: false,
            donutWidth: 60,
            showLabel: true,
            labelOffset: 0,
            labelPosition: "inside",
            labelInterpolationFnc: Chartist.noop,
            labelDirection: "neutral",
            reverseData: false,
            ignoreEmptyValues: false
        };

        function Pie(query, data, options, responsiveOptions) {
            Chartist.Pie.super.constructor.call(this, query, data, defaultOptions, Chartist.extend({}, defaultOptions, options), responsiveOptions);
        }

        new Chartist.Pie(".ct-chart", {
            series: [{
                value: 20,
                name: "Series 1",
                meta: "Meta One"
            }, {
                value: 10,
                name: "Series 2",
                meta: "Meta Two"
            }, {
                value: 70,
                name: "Series 3",
                meta: "Meta Three"
            }]
        }, {
            donut: false,
            startAngle: 0,
            total: '.$this->countCategories().'
        });
        </script>';

        return $return;
    }

    private function countCategories(): int {
        $db = mysqli_query($GLOBALS['link'], "SELECT COUNT(*) as count FROM `db_structure`");
        $row = mysqli_fetch_assoc($db);

        return $row['count'];
    }

    private function countProducts(): int {
        $db = mysqli_query($GLOBALS['link'], "SELECT COUNT(*) as count FROM `db_objects`");
        $row = mysqli_fetch_assoc($db);

        return $row['count'];
    }

}

class LogsTable extends Categories {

    public function returnTable(): string {
        $return = '
        <div class="inside">
            '.$this->formBreadcrumbs('logsPage').'
            '.$this->formDopNavigation().'            
            <h1>Логи раздела</h1>
            <p class="lead">В данном разделе вы можете посмотреть, какие последние изменения были внесены.</p>
            <div class="row">
                <div class="col-md-10">
                    <div class="logLines">';
                    $logs = new Logger();
                    $return .= $logs->returnLines('categories').'
                    </div>
                </div>
                <div class="col-md-2">
                    <button class="btn btn-danger" id="clearLogs">Очистить логи раздела</button>
                </div>
            </div>';

        $return .= '
        </div>';

        return $return;
    }

}