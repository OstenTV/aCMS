<?php

function Alert( string $type, string $message, string $error_code = null) {
    $error_code = htmlentities($error_code, ENT_QUOTES, 'UTF-8');
    $message = htmlentities($message, ENT_QUOTES, 'UTF-8');

    switch ($type)
    {
        case 'error':
            $alert = '
                <section class="bg-danger">
                    <div class="container">
                        <h2>'.$message.'</h2>
                        <h4><a href="?view=error_code_lookup&error_code='.$error_code.'">'.$error_code.'</a></h4>
                        <h6>Click the error code above to read more about this error.</h6>
                    </div>
                </section>
            ';
            break;
        ;

        case 'warning':
            $alert = '
                <section class="bg-warning">
                    <div class="container">
                        <h2>'.$message.'</h2>
                    </div>
                </section>
            ';
            break;
        ;

    	default:
            $alert = '
                <section class="bg-danger">
                    <div class="container">
                        <h2>Yeah, sorry. This warning type doesn\'t exist. Please contact the site administrator.</h2>
                    </div>
                </section>
            ';
            break;
        ;
    }
    return $alert;
}

?>