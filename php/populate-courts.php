<?php
    $f = fopen("resources/data/courts", "r");
    if ($f) {
    while (($c = fgets($f)) !== false) {
    $short_name = explode(" ", $c);
    echo "<option value=\"$short_name[0]\">" . $c . "</option>\n";
    }
    fclose($f);
    }
    else {
    echo "Cannot populate courts list";
    }
?>
