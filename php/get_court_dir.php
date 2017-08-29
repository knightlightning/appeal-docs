<?php
function get_court_dir($court, $doc_type, $include_month = false, $auto_create = false) {
    $tar_dir = "/srv/appeal-tar/";
    $suv_dir = "/srv/appeal-suv/";
    $year = date("Y");
    $dir = (($doc_type == "civil") ? $tar_dir : $suv_dir) . $court . "/{$year}/";
    if ($include_month) {
        $dir = "{$dir}" . date("m") . "/";
    }
    if ($auto_create && !is_dir($dir)) {
        mkdir($dir, 0775, true);
    }
    return $dir;
}
?>
