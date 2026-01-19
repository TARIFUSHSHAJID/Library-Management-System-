<?php

function db_connect()
{
    static $conn = null;

    if ($conn === null) {
        $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS);
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        $dbSelected = mysqli_select_db($conn, DB_NAME);
        if (!$dbSelected) {
            die("Database " . DB_NAME . " not found. Please import database.sql");
        }

        $GLOBALS['conn'] = $conn;
    }

    return $conn;
}

function db_query($sql, $params = [], $types = '')
{
    $conn = db_connect();

    $stmt = mysqli_prepare($conn, $sql);
    if (!$stmt) {
        die("Query preparation failed: " . mysqli_error($conn) . " SQL: " . $sql);
    }

    if (!empty($params)) {
        if ($types === '') {
            $types = '';
            foreach ($params as $param) {
                if (is_int($param)) {
                    $types .= 'i';
                } elseif (is_double($param)) {
                    $types .= 'd';
                } else {
                    $types .= 's';
                }
            }
        }

        mysqli_stmt_bind_param($stmt, $types, ...$params);
    }

    if (!mysqli_stmt_execute($stmt)) {
        die("Query execution failed: " . mysqli_stmt_error($stmt));
    }

    $result = mysqli_stmt_get_result($stmt);

    if ($result === false) {
        if (strtoupper(substr(trim($sql), 0, 6)) === 'INSERT') {
            $id = mysqli_insert_id($conn);
            mysqli_stmt_close($stmt);
            return $id;
        }

        $affected = mysqli_stmt_affected_rows($stmt);
        mysqli_stmt_close($stmt);
        return $affected;
    }

    $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
    mysqli_stmt_close($stmt);
    return $rows;
}

function db_fetch_one($sql, $params = [], $types = '')
{
    $rows = db_query($sql, $params, $types);
    if ($rows) {
        return $rows[0];
    }

    return null;
}
