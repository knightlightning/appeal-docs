<?php
include "get_court_dir.php";
$court = $_POST["court"];
$doc_type = $_POST["docType"];
$dir = get_court_dir($court, $doc_type);
$files = `LANG=en_US.UTF8 find {$dir} -type f | sed -re 's/^.*{$court}\/[0-9]{4}\///g' | sort -r`;
if (empty($files)) {
    echo "За текущий год для выбранного суда загрузок не было.";
}
else {
    echo $files;
}
?>
