<?php

class DbException extends Exception { }

function query_db($mysqli, $sql) {
    if (!$result = $mysqli->query($sql)) {
        throw new DbException("Cannot query DB. Errno: {$mysqli->errno}. Err: {$mysqli->error}.");
    }
    return $result;
}

function get_court_id($mysqli, $court) {
    $sql = "SELECT id FROM courts WHERE name LIKE '{$court}%'";
    $result = query_db($mysqli, $sql);
    if ($result->num_rows === 0) {
        throw new DbException("Court {$court} is unknown");
    }
    $court_id = $result->fetch_object()->id;
    $result->close();
    return $court_id;
}

function get_upload_id($mysqli, $court_id, $mode, $doc_type) {
    $sql = "SELECT id FROM uploads WHERE upload_date = '" . date("Ymd") . "' AND 
        court_type = '{$doc_type}' AND court_id = '{$court_id}' AND mode = '{$mode}'";
    $result = query_db($mysqli, $sql);
    if ($result->num_rows === 0) {
        $sql = "INSERT INTO uploads(upload_date,court_id,court_type,mode) VALUES('" . date("Ymd") . "',{$court_id},'{$doc_type}','{$mode}')";
        $result->close();
        query_db($mysqli, $sql);
        return get_upload_id($mysqli, $court_id, $mode, $doc_type);
    }
    else {
        $upload_id = $result->fetch_object()->id;
        $result->close();
        return $upload_id;
    }
}

function update_file_info($mysqli, $upload_id, $files) {
    foreach ($files as $f) {
        $sql = "INSERT INTO files(upload_id,name) VALUES({$upload_id},'{$f}')";
        query_db($mysqli, $sql);
    }
}

function update_stat($court, $doc_type, $mode, $files) {
    $mysqli = new mysqli("localhost", "appeal", "Selkit2", "appealstat");
    $mysqli->set_charset("utf8");
    try {
        $court_id = get_court_id($mysqli, $court); 
        $upload_id = get_upload_id($mysqli, $court_id, $mode, $doc_type);
        update_file_info($mysqli, $upload_id, $files);
    } catch (Exception $e) {
        error_log($e->getMessage());
    }
}

?>
