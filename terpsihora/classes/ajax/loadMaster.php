<?php

$files = $_FILES;
foreach($files as $file)
    if(move_uploaded_file( $file['tmp_name'], $_SERVER['DOCUMENT_ROOT'].'/terpsihora/reloader/master.csv'))
        echo '/terpsihora/reloader/master.csv';
    else
        echo 'Не удалось загрузить файл!';

include($_SERVER['DOCUMENT_ROOT'].'/terpsihora/reloader/master.php');