<?php

$query = 'SELECT value FROM config WHERE ID = 1';
$response = @mysqli_query($dbc, $query);

$result = mysqli_fetch_assoc($response);
if (!$response || $result['value'] == 'true') {
    die('<h1>The website has been temporarily locked.</h1><h2>Please try again later. . .</h2>');
}

?>