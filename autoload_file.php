<?php

// called in root plugin

$dir = dirname(__FILE__) . "/scripts/";
//error_log($dir);
//$user = wp_get_current_user();
//$userid = $user->user_login;
if ($handle = opendir($dir)) {
    while (false !== ($entry = readdir($handle))) {
        $tmpext = explode(".", $entry);
        $ext = $tmpext[count($tmpext) - 1];
        if ($entry != "." && $entry != ".." && $entry != "inc.php" && $entry != "font" && $entry != "adodb" && $entry != "pages" && $ext == "php") {
            $a = $dir . $entry;
            include_once $dir . $entry;
        }
    }
    closedir($handle);
}