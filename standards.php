

/**
 * Function returns Back button (up to high level)
 * 
 * @access protected
 * @param string $url_array Array of url' parts
 * @return string
 */
protected function formBackLink(array $url_array): string {
    ## Update Array and form url
    array_pop($url_array);
    if(count($url_array) < 1)
        $back_address = '/';
    else 
        $back_address = '/'.implode('/', $back_array).'/';

    ## Render button
    $content = '<div class="btnPrev"><a href="'.$back_address.'">Back</a></div>';

    return $content;
}

/**
 * Clear string function
 * 
 * @access protected
 * @param string $string String for cleaning
 * @return string
 */
protected function clearString(string $string): string {
    $string = trim($string);
    $string = stripslashes($string);
    $string = str_replace("'", "&#8217;", $string);

    return $string;
}    
