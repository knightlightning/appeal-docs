<?php
function get_court_dir($court, $doc_type, $mode, $include_month = false, $auto_create = false) {
    $year = date("Y");
    $dir = "/srv/" . $mode . (($doc_type == "civil") ? "-tar/" : "-suv/") . $court . "/{$year}/";
    if ($include_month) {
        $dir = "{$dir}" . date("m") . "/";
    }
    if ($auto_create && !is_dir($dir)) {
        mkdir($dir, 0775, true);
    }
    return $dir;
}
?>
