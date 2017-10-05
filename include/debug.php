<?php

function X($x) {
    echo "<pre>";
    print_r($x);
    echo "</pre>";
}

function xLog($mes) {
    X("[" . date("H:i:s") . "] $mes");
}
