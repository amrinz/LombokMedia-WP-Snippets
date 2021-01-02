<?php
/**
 *  @WordPress temporary change theme (by request)
 *  Usage: To change theme, simply add query to the current URL, ?theme=mytheme  
 */
add_filter('template', 'temporary_change_theme');
add_filter('option_template', 'temporary_change_theme');
add_filter('option_stylesheet', 'temporary_change_theme');
 
function temporary_change_theme( $theme ) {
    if(isset($_GET['theme']) AND !empty($_GET['theme'])) {
        $theme = trim($_GET['theme']);
    }
    return $theme;
}