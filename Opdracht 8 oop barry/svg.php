<?php

function diceSVG($value, $color = "black") {

    $positions = [
        1 => [[50, 50]],
        2 => [[30, 30], [70, 70]],
        3 => [[30, 30], [50, 50], [70, 70]],
        4 => [[30, 30], [30, 70], [70, 30], [70, 70]],
        5 => [[30, 30], [30, 70], [50, 50], [70, 30], [70, 70]],
        6 => [[30, 30], [30, 50], [30, 70], [70, 30], [70, 50], [70, 70]],
    ];

    $svg = "<svg width='70' height='70' viewBox='0 0 100 100'
             style='margin:5px; border: 2px solid #000;'>";

    $svg .= "<rect width='100' height='100' fill='white' />";

    foreach ($positions[$value] as $p) {
        $svg .= "<circle cx='{$p[0]}' cy='{$p[1]}' r='10' fill='{$color}' />";
    }

    $svg .= "</svg>";

    return $svg;
}
