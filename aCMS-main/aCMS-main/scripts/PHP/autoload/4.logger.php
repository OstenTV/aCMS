<?php

// Log what page is shown.
function LogVisit() {

    // Decide if host is allowed to log.
    switch ($_SERVER['HTTP_HOST'])
    {
        case 'ostentv':
            return;
        ;
        case 'test.ostentv.dk':
            return;
        ;
        case 'localhost':
            return;
        ;
        case 'localhost:36003':
            return;
        ;
    	default:
            break;
        ;
    }

    global $dbc;

    // Escape all veriables.
    $HTTP_HOST = @mysqli_real_escape_string($dbc, $_SERVER['HTTP_HOST']);
    $REQUEST_URL = @mysqli_real_escape_string($dbc, $_SERVER['REQUEST_URI']);
    $REMOTE_ADDR = @mysqli_real_escape_string($dbc, $_SERVER['REMOTE_ADDR']);

    // Insert into database.
    $query = 'INSERT INTO visitors (ID, REMOTE_ADDR, HTTP_HOST, REQUEST_URI, REQUEST_TIME) VALUES (NULL, ?, ?, ?, ?)';
    $stmt = @mysqli_prepare($dbc, $query);
    @mysqli_stmt_bind_param($stmt, 'ssss', $REMOTE_ADDR, $HTTP_HOST, $REQUEST_URL, time());
    @mysqli_stmt_execute($stmt);
}

// Log an error.
function LogError($error_code) {
    global $dbc;

    // Escape all veriables.
    $REMOTE_ADDR = @mysqli_real_escape_string($dbc, $_SERVER['REMOTE_ADDR']);
    $HTTP_HOST = @mysqli_real_escape_string($dbc, $_SERVER['HTTP_HOST']);
    $REQUEST_URL = @mysqli_real_escape_string($dbc, $_SERVER['REQUEST_URI']);
    $error_code = @mysqli_real_escape_string($dbc, $error_code);

    // Insert into database.
    $query = 'INSERT INTO errors (ID, IP_ADDR, HTTP_HOST, REQUEST_URL, ERROR_CODE, REQUEST_TIME) VALUES (NULL, ?, ?, ?, ?, ?)';
    $stmt = @mysqli_prepare($dbc, $query);
    @mysqli_stmt_bind_param($stmt, 'sssss', $REMOTE_ADDR, $HTTP_HOST, $REQUEST_URL, $error_code , time());
    @mysqli_stmt_execute($stmt);
}

?>