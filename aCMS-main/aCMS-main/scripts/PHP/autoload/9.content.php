<?php

function getPageIndex() {

    global $dbc;

    $query = 'SELECT * FROM pageIndex';
    $response = @mysqli_query($dbc, $query);

    if ($response) {
        while ($row = mysqli_fetch_assoc($response)) {
            $pageIndex[] = $row;
        }
        return $pageIndex;
    } else {
        LogError('0x0005:0000');
        echo Alert('error', 'No response from database.', '0x0005:0000');
        exit;
    }

}

function getNavbarContent() {

    if ($pageIndex = getPageIndex()) {

        foreach ($pageIndex as $page) {

            if ($page['inNavbar']) {

                $navbarContent[] = $page;

            }

        }

        return $navbarContent;

    }

}

?>