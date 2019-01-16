<?php

if($_POST['loaded']) {
    include('views/preloader/' . $_GET['view'] . '.php');
} else {
    echo '
        <section>
            <div class="container">
                <h2>Loading. Please wait. . .</h2>
                <p>This might take a while.</p>
                <p id="preloader-unusual_loading_time_text"></p>
                <div class="progress">
                    <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div>
                </div>
            </div>
        </section>

        <div id="preloader" style="display: none;"></div>
        <script type="text/javascript" src="/scripts/JS/util/preloader.js"></script>
    ';
}

?>