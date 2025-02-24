<?php

## Main settings
## Default page
$page = 1;
## Number of smthg in page
$n = 20;
## Actual page
if(isset($_GET['p']))
    $page = clearString($_GET['p']); // *

$start = (intval($page) - 1) * $n;

## Render content block
## Now it's time for take some data
$db = mysqli_query($GLOBALS['link'], "SELECT * FROM `table_name` ORDER BY `id` DESC LIMIT $start, $n");
while($rows = mysqli_fetch_array($db)) {
    /*
        Doing something like rows-cols with miniatures!
    */
}

## Render pagination block
$db = mysqli_query($GLOBALS['link'], "SELECT `id` FROM `table_name`");
$full = ceil(mysqli_num_rows($db) / $n);
for($i = 1;$i <= $full; $i++) {
    ## Return paginator
    echo '
    <a href="?p='.$i.'" class="pagination">
        <button class="list-item'; 
        if($i == $page) 
            $return .= ' active'; 
        echo '">'.$i.'</button>
    </a>';
}

## * Clear String method
function clearString(string $string): string {
    $string = trim($string);
    $string = stripslashes($string);
    $string = str_replace("'", "&#8217;", $string);

    return $string;
}  
