<?php

// Check if a specific page is requested. If not, then show the home page.
if (isset($_GET['view']) && $_GET['view'] != '') {

    // Add prefix and suffix to view.
    $view = 'views/' . $_GET['view'] . '.php';

    // Include the page if it exist, or show the 404 page.
    if(file_exists($view)) {
        include($view);
    } else {
        include('views/errordoc/404.php');
    }
} else if (isset($_GET['script'])) {

    // Add prefix and suffix to script.
    $script = 'scripts/PHP/script/' . $_GET['script'] . '.php';

    // Include the script if it exist.
    if(file_exists($script)) {
        include($script);
    }
} else {
    include('views/home.php');
}

?>