<?php

class Logger {

    public function returnLines(string $type): string {
        mysqli_select_db($GLOBALS['link'], "obo6855747_logger");
        $return = '';
        $db = mysqli_query($GLOBALS['link'], "SELECT * FROM `logger_table` WHERE `log_type` = '$type' ORDER BY `time` DESC");
        while($rows = mysqli_fetch_array($db))
            $return .= '
            <div class="oneLine"><b>'.date('d.m.y H:i', strtotime($rows['time'])).':</b> '.$rows['log_text'].'</div>';
        mysqli_select_db($GLOBALS['link'], "obo6855747_tempdb");

        return $return;
    }

}

class Listener extends Logger {

    public function listenForAction(string $actionDescription, string $type): bool {
        mysqli_select_db($GLOBALS['link'], "obo6855747_logger");
        $db = mysqli_query($GLOBALS['link'], "INSERT INTO `logger_table` (`log_text`, `log_type`) VALUES ('$actionDescription', '$type')");
        mysqli_select_db($GLOBALS['link'], "obo6855747_tempdb");

        return true;
    }

}