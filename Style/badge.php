<?php

function generateBadge($text, $color_template) {
    $background_col = "";
    $text_col = "";
    $tail_col = "";

    switch ($color_template) {
        case "gold":
            $background_col = "#ffe476";
            $text_col = "#765e00";
            $tail_col = "#dbbd43";
            break;
        case "silver":
            $background_col = "#d6d6d6";
            $text_col = "#3f3f3f";
            $tail_col = "#a8a8a8";
            break;
        case "bronze":
            $background_col = "#d6945e";
            $text_col = "#44210d";
            $tail_col = "#8B4A22";
            break;
    }

    return "<div class='badge_sponsor' style='background:$background_col'>
    <div class='badge_sponsor_content' style='color:$text_col'>$text</div>
    <div class='badge_sponsor_tail' style='border-top-color:$tail_col'></div>
    </div>";
}
?>

<style>
    .badge_sponsor{
        padding: 4px 15px 2px;
        position: absolute;
        left: -10px;
        top: 5px;
    }

    .badge_sponsor_content{
        font-family: Consolas,Monaco,Lucida Console,Liberation Mono,DejaVu Sans Mono,Bitstream Vera Sans Mono,Courier New,monospace,sans-serif;
        text-transform: uppercase;
        font-size: .75em;
        font-weight: 700;
    }

    .badge_sponsor_tail{
        content: "";
        position: absolute;
        display: block;
        border-style: solid;
        border-color: transparent transparent transparent transparent;
        bottom: -9px;
        left: 0;
        border-width: 9px 0 0 9px;
    }
</style>


<div style=" position:relative; padding: 10px; border: black 1px solid; margin: 10px;" >
    adasdasds<br>
    adasdasds<br>
    adasdasds<br>
    <?= generateBadge("Sponsored", "gold") ?>
</div>

<div style=" position:relative; padding: 10px; border: black 1px solid; margin: 10px;" >
    adasdasds<br>
    adasdasds<br>
    adasdasds<br>
    <?= generateBadge("Sponsored", "silver") ?>
</div>

<div style=" position:relative; padding: 10px; border: black 1px solid; margin: 10px;" >
    adasdasds<br>
    adasdasds<br>
    adasdasds<br>
    <?= generateBadge("Sponsored", "bronze") ?>
</div>
