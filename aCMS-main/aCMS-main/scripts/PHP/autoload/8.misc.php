<?php

function ConvertUnixTimestamp(int $timestamp) {
    return date('d-m-Y H:i:s', $timestamp);
}

function IsEmpty($str) {
    if ($str == '') {
        return true;
    } else {
        return false;
    }
}

function isDomainAvailible($domain) {
    //check, if a valid url is provided
    if(!filter_var($domain, FILTER_VALIDATE_URL))
    {
        return false;
    }

    //initialize curl
    $curlInit = curl_init($domain);
    curl_setopt($curlInit,CURLOPT_CONNECTTIMEOUT,10);
    curl_setopt($curlInit,CURLOPT_HEADER,true);
    curl_setopt($curlInit,CURLOPT_NOBODY,true);
    curl_setopt($curlInit,CURLOPT_RETURNTRANSFER,true);

    //get answer
    $response = curl_exec($curlInit);

    curl_close($curlInit);

    if ($response) return true;

    return false;
}

// Function to run last
function shutDownFunction() {
    $error = error_get_last();

    // fatal error, E_ERROR === 1
    if ($error['type'] === E_ERROR) {
        LogError('0x0000:0000');
        echo Alert('error', 'A fatal error has occurred while loading this page.', '0x0000:0000');
    }

    global $dbc;
    mysqli_close($dbc);
}
register_shutdown_function('shutDownFunction');

?>