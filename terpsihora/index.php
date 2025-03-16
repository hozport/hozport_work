<?php
session_start();

function clearString($string) {
    $string = trim($string);
    $string = stripslashes($string);
    $string = str_replace("'", "&#8217;", $string);

    return $string;
}

if(isset($_GET['exit'])) {
    $exit = clearString($_GET['exit']);
    if($exit == 'y'){
        unset($_SESSION['global_admin']);
        header("Location: index.php"); 
        exit;
    }
}

if( (isset($_SESSION['global_admin'])) AND (base64_decode($_SESSION['global_admin']) == '6yh54k6yhi5utv89r90egfregkjdfshgfr40u9t75v073') ) {
    
include($_SERVER['DOCUMENT_ROOT'].'/engine/classes/db.php');
mysqli_select_db($GLOBALS['link'], "obo6855747_tempdb");

include("classes/admin_standard.class.php");
include("classes/interfaces.class.php");
$p = '';
if(isset($_GET['p']))
    $p = $_GET['p'];
$content_class = new AdminInterface;
$content = $content_class->returnContent($p);

?>
<!doctype html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>БД ОБО Беттерманн</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="plugins/trumbowyg.min.css">
    <link rel="stylesheet" href="style/admin.css">
    <script src="//ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js" type="text/javascript"></script>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark topMenu"> 
        <div class="col col-lg-2">
            <a class="navbar-brand padding-left" href="index.php" style="margin: 0 auto">
                <img src="/terpsihora/style/footerLogo.svg" alt="" width="60"  class="d-inline-block align-text-top margin-right"> :: DB
            </a>
        </div>
        <div class="col col-lg-8">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarText">
                <ul class="navbar-nav me-auto mb-3 mb-lg-0">
                    <li class="nav-item"><a class="nav-link active" aria-current="page" href="?">Главная</a></li>
                    <li class="nav-item"><a class="nav-link" href="?p=categories">Структура</a></li>
                    <li class="nav-item"><a class="nav-link" href="?p=products">Продукты</a></li>
                    <li class="nav-item"><a class="nav-link" href="?p=techs">Характеристики</a></li>
                    <li class="nav-item"><a class="nav-link" href="?p=mass">Массовые действия</a></li>
                </ul>
            </div>
        </div>
        <div class="col col-lg-2">
            <form class="d-flex padding-right">
                <input class="form-control me-2" type="search" placeholder="Поиск" aria-label="search">
                <button class="btn btn-outline-success" type="submit">Поиск</button>
                <a href="?exit=y" title="Выйти" class="exitA"><svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" fill="currentColor" class="bi bi-door-closed" viewBox="0 0 16 16"><path d="M3 2a1 1 0 0 1 1-1h8a1 1 0 0 1 1 1v13h1.5a.5.5 0 0 1 0 1h-13a.5.5 0 0 1 0-1H3zm1 13h8V2H4z"/>  <path d="M9 9a1 1 0 1 0 2 0 1 1 0 0 0-2 0"/></svg></a>
            </form>
        </div>
    </nav>
    <div class="container-fluid">
        <div class="row">
            <div class="col-2 aside">
                <ul class="nav flex-column">
                    
                    <h5>База данных</h5>
                    <div class="hiddenBlock active">
                    <li class="nav-item"><a class="nav-link<?php
                    if($p == 'categories') echo ' active';
                    ?>" href="?p=categories"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" class="bi bi-diagram-3" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M6 3.5A1.5 1.5 0 0 1 7.5 2h1A1.5 1.5 0 0 1 10 3.5v1A1.5 1.5 0 0 1 8.5 6v1H14a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-1 0V8h-5v.5a.5.5 0 0 1-1 0V8h-5v.5a.5.5 0 0 1-1 0v-1A.5.5 0 0 1 2 7h5.5V6A1.5 1.5 0 0 1 6 4.5zM8.5 5a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5zM0 11.5A1.5 1.5 0 0 1 1.5 10h1A1.5 1.5 0 0 1 4 11.5v1A1.5 1.5 0 0 1 2.5 14h-1A1.5 1.5 0 0 1 0 12.5zm1.5-.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5zm4.5.5A1.5 1.5 0 0 1 7.5 10h1a1.5 1.5 0 0 1 1.5 1.5v1A1.5 1.5 0 0 1 8.5 14h-1A1.5 1.5 0 0 1 6 12.5zm1.5-.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5zm4.5.5a1.5 1.5 0 0 1 1.5-1.5h1a1.5 1.5 0 0 1 1.5 1.5v1a1.5 1.5 0 0 1-1.5 1.5h-1a1.5 1.5 0 0 1-1.5-1.5zm1.5-.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5z"/></svg>&nbsp;&nbsp;Структура</a></li>
                    <li class="nav-item"><a class="nav-link<?php
                    if($p == 'products') echo ' active';
                    ?>" href="?p=products"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" class="bi bi-basket" viewBox="0 0 16 16"><path d="M5.757 1.071a.5.5 0 0 1 .172.686L3.383 6h9.234L10.07 1.757a.5.5 0 1 1 .858-.514L13.783 6H15a1 1 0 0 1 1 1v1a1 1 0 0 1-1 1v4.5a2.5 2.5 0 0 1-2.5 2.5h-9A2.5 2.5 0 0 1 1 13.5V9a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h1.217L5.07 1.243a.5.5 0 0 1 .686-.172zM2 9v4.5A1.5 1.5 0 0 0 3.5 15h9a1.5 1.5 0 0 0 1.5-1.5V9zM1 7v1h14V7zm3 3a.5.5 0 0 1 .5.5v3a.5.5 0 0 1-1 0v-3A.5.5 0 0 1 4 10m2 0a.5.5 0 0 1 .5.5v3a.5.5 0 0 1-1 0v-3A.5.5 0 0 1 6 10m2 0a.5.5 0 0 1 .5.5v3a.5.5 0 0 1-1 0v-3A.5.5 0 0 1 8 10m2 0a.5.5 0 0 1 .5.5v3a.5.5 0 0 1-1 0v-3a.5.5 0 0 1 .5-.5m2 0a.5.5 0 0 1 .5.5v3a.5.5 0 0 1-1 0v-3a.5.5 0 0 1 .5-.5"/></svg>&nbsp;&nbsp;Продукты</a></li>
                    <li class="nav-item"><a class="nav-link<?php
                    if($p == 'techs') echo ' active';
                    ?>" href="?p=techs"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" class="bi bi-list-columns" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M0 .5A.5.5 0 0 1 .5 0h9a.5.5 0 0 1 0 1h-9A.5.5 0 0 1 0 .5m13 0a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5m-13 2A.5.5 0 0 1 .5 2h8a.5.5 0 0 1 0 1h-8a.5.5 0 0 1-.5-.5m13 0a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5m-13 2A.5.5 0 0 1 .5 4h10a.5.5 0 0 1 0 1H.5a.5.5 0 0 1-.5-.5m13 0a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5m-13 2A.5.5 0 0 1 .5 6h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5m13 0a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5m-13 2A.5.5 0 0 1 .5 8h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5m13 0a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5m-13 2a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5m13 0a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5m-13 2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5m13 0a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5m-13 2a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H.5a.5.5 0 0 1-.5-.5m13 0a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5"/></svg>&nbsp;&nbsp;Характеристики</a></li>
                    <p><br></p>
                    </div>
                    <h5 open="alls" class="openBar">Массовые действия</h5>
                    <div class="hiddenBlock" var="alls">
                    <li class="nav-item"><a class="nav-link<?php
                    if($p == 'mass') echo ' active';
                    ?>" aria-current="page" href="?p=mass"><svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor" class="bi bi-database" viewBox="0 0 16 16"><path d="M4.318 2.687C5.234 2.271 6.536 2 8 2s2.766.27 3.682.687C12.644 3.125 13 3.627 13 4c0 .374-.356.875-1.318 1.313C10.766 5.729 9.464 6 8 6s-2.766-.27-3.682-.687C3.356 4.875 3 4.373 3 4c0-.374.356-.875 1.318-1.313M13 5.698V7c0 .374-.356.875-1.318 1.313C10.766 8.729 9.464 9 8 9s-2.766-.27-3.682-.687C3.356 7.875 3 7.373 3 7V5.698c.271.202.58.378.904.525C4.978 6.711 6.427 7 8 7s3.022-.289 4.096-.777A5 5 0 0 0 13 5.698M14 4c0-1.007-.875-1.755-1.904-2.223C11.022 1.289 9.573 1 8 1s-3.022.289-4.096.777C2.875 2.245 2 2.993 2 4v9c0 1.007.875 1.755 1.904 2.223C4.978 15.71 6.427 16 8 16s3.022-.289 4.096-.777C13.125 14.755 14 14.007 14 13zm-1 4.698V10c0 .374-.356.875-1.318 1.313C10.766 11.729 9.464 12 8 12s-2.766-.27-3.682-.687C3.356 10.875 3 10.373 3 10V8.698c.271.202.58.378.904.525C4.978 9.71 6.427 10 8 10s3.022-.289 4.096-.777A5 5 0 0 0 13 8.698m0 3V13c0 .374-.356.875-1.318 1.313C10.766 14.729 9.464 15 8 15s-2.766-.27-3.682-.687C3.356 13.875 3 13.373 3 13v-1.302c.271.202.58.378.904.525C4.978 12.71 6.427 13 8 13s3.022-.289 4.096-.777c.324-.147.633-.323.904-.525"/></svg>&nbsp;&nbsp;Обновление БД</a></li>
                    <p><br></p>
                    </div>
                </ul>
            </div>
            <div class="col-10 centerBar">
                <?php echo $content; ?>                
            </div>
        </div>
    </div>




<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script src="plugins/trumbowyg.min.js"></script>
<script src="/terpsihora/classes/main.js" type="text/javascript"></script>
<script>
    $.trumbowyg.svgPath = 'ui/icons.svg';
    $("#description").trumbowyg({
        btns: [
            ['viewHTML'],
            ['undo', 'redo'], 
            ['formatting'],
            ['strong', 'em', 'del'], 
            ['link'],
            ['justifyLeft', 'justifyCenter', 'justifyRight', 'justifyFull'],
            ['unorderedList', 'orderedList'],
            ['insertImage']
        ],
        autogrow: true,
        removeformatPasted: true,
        threshold: 15
    });
</script>
</body>

<?php

} else {

    $spec = '';

    if(isset($_POST['forUserName'])) {
        $username = clearString($_POST['forUserName']);
        $userpassword = base64_encode(clearString($_POST['forPassWord']).'4ro8iyod8fz)&!sfsdfx!');

        if( (strlen($username) > 4) AND (strlen($username) < 20) AND (strlen($_POST['forPassWord']) > 5) AND (strlen($_POST['forPassWord']) < 20) ) {

            //5jh6g5!=6l3 4ro8iyod8fz)&!sfsdfx!
            $realpassword = base64_encode('5jh6g5!=6l34ro8iyod8fz)&!sfsdfx!');
            if( ($username == 'admin') AND ($userpassword == $realpassword) ) {
                
                $_SESSION['global_admin'] = base64_encode('6yh54k6yhi5utv89r90egfregkjdfshgfr40u9t75v073');
                header("Location: index.php"); 
                exit;

            } else {
                $spec = '<div class="alert alert-danger" role="alert">Вход не удался.</div>';
            }

        } else {
            $spec = '<div class="alert alert-danger" role="alert">Вход не удался.</div>';
        }
    }

?>
<!doctype html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Некая загадочная страница ОБО Беттерманн</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="//ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</head>
<body style="background: #f2f2f2">
    <div class="container">
        <div class="row" style="margin-top: 15%">
            <div class="col-md-4"></div>
            <div class="col-md-4">
                <form name="strangeForm" action="" method="POST">
                    <div class="mb-3">
                        <label for="forUserName" class="form-label">Имя пользователя</label>
                        <input type="username" name="forUserName" class="form-control" id="forUserName" placeholder="Введите имя пользователя..." required>
                    </div>
                    <div class="mb-3">
                        <label for="forPassWord" class="form-label">Пароль</label>
                        <input type="password" name="forPassWord" class="form-control" id="forPassWord" placeholder="Введите пароль..." required>
                    </div>                    
                    <?php echo $spec; ?>
                    <button type="submit" class="btn btn-primary">Вход</button>
                </form>
            </div>
            <div class="col-md-4"></div>
        </div>
    </div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
<?php
}