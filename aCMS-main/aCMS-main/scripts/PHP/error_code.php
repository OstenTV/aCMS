<?php

function GetErrorCodeInfo($error_code, $max_lookup) {
    global $dbc;

    $error_code = htmlspecialchars($error_code, ENT_QUOTES, 'UTF-8');
    $error_code = mysqli_real_escape_string($dbc, $error_code);
    $error_code = str_replace('%', '\%', $error_code);
    $error_code = str_replace('_', '\_', $error_code);

    $query = 'SELECT error_code, error_description FROM error_codes WHERE error_code like "%' . $error_code . '%" ORDER BY error_code';
    $responce = @mysqli_query($dbc, $query);
    if ($responce) {
        while(($row = mysqli_fetch_assoc($responce)) && ($max_lookup > 0)){
            $max_lookup--;
            $errors[] = $row;
        }
        return $errors;
    } else {
        LogError('0x0002:0000');
        echo Alert('error', 'No response from database.', '0x0002:0000');
        return false;
    }
}

?>