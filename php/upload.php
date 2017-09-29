<?php
include "get_court_dir.php";
include "stat-update.php";

putenv("LANG=en_US.UTF8");

$court = $_POST["court"];
if (!isset($court)) {
    return;
}
$mode = $_POST["mode"];
if (!isset($mode)) {
    return;
}
$doc_type = $_POST["docType"];
if (!isset($doc_type)) {
    return;
}

$target_dir = get_court_dir($court, $doc_type, $mode, true, true);

function virus_check(string $f, string &$out) {
    `chmod o+r {$f}`;
    exec("clamdscan {$f} 2>&1", $myout, $exit_code);
    if (array_key_exists(0, $myout)) {
        $out = $myout[0];
    }
    return $exit_code == 0;
}

function copy_file(string $s, string $d, string &$out) {
    exec("mv {$s} '{$d}'", $myout, $exit_code);
    if (array_key_exists(0, $myout)) {
        $out = $myout[0];
    }
    if ($exit_code == 0) {
        `chmod 0644 '{$d}'`;
        $file_type = pathinfo($d, PATHINFO_EXTENSION);
        if (strcasecmp($file_type, "rar") == 0) {
            $path = pathinfo($d, PATHINFO_DIRNAME) . "/" . pathinfo($d, PATHINFO_FILENAME);
            `mkdir {$path}`;
            `/usr/bin/unrar x -r '{$d}' '{$path}'`;
        }
        else if (strcasecmp($file_type, "zip") == 0) {
            $path = pathinfo($d, PATHINFO_DIRNAME) . "/" . pathinfo($d, PATHINFO_FILENAME);
            `mkdir {$path}`;
            `/usr/bin/unzip '{$d}' -d '{$path}'`;
        }
    }
    return $exit_code == 0;
}

$total = count($_FILES["docs"]["name"]);
$files = [];
for ($i=0; $i < $total; $i++) {
    $target_filename = $_FILES["docs"]["name"][$i];
    if ($_FILES["docs"]["error"][$i] != UPLOAD_ERR_OK) {
        echo "Файл \"{$target_filename}\" не может быть загружен.\n";
        continue;
    }
    $target_file = $target_dir . $target_filename;
    if (file_exists($target_file)) {
        echo "Файл \"{$target_filename}\" уже существует.\n";
        continue;
    }
    $source_file = $_FILES["docs"]["tmp_name"][$i];
    $out = "";
    if (!virus_check($source_file, $out)) {
        echo "Файл \"{$target_filename}\" содержит вирус: {$out}.\n";
        continue;
    }
    if (copy_file($source_file, $target_file, $out)) {
        $files[] = $target_file;
        #echo "Файл \"{$target_filename}\" был успешно загружен.\n";
    } else {
        echo "Во время загрузки файла \"{$target_filename}\" произошла неустранимая ошибка. Файл не был загружен.\n";
    }
}
if ($files != null) {
    update_stat($court, $doc_type, $mode, $files);
}
?>
