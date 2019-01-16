<!DOCTYPE html>
<html lang="en">
<head>
    <?php
    $meta = array(
        'title' => null,
        'description' => 'This website gives you information about services I provide, software I make, and much more!',
        'keywords' => 'OstenTV, Osten, Oste, Ostegameren, TheCheeseGameplay, Tobias, Hein, Sindrup',
        'index' => true,
        'follow' => true
    );

    include("modules/head.php");
    ?>
</head>
<body>
    <?php
    include("modules/navbar.php");

    if (isset($_GET['error_code'])) {
        echo Alert('error', 'An error has occurred, and I didn\'t know how to handle it', $_GET['error_code']);
    }
    ?>
    <section>
        <div class="container">
            <h1><?php echo $meta['title']; ?></h1>
            <p><?php echo $meta['description']; ?></p>
        </div>
    </section>
    <section>
        <div class="container">
            <h2>News</h2>
            <div class="row">
                <div class="col">
                    <h4>User system added - 14/06/2018</h4>
                    <p>A new user registration and login system has been added. In order to create an account, you need to have a valid activation code. These codes will be given out randomly. You currently can't do anything with your account but, that will be added in the future.</p>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <h4>New website released - 19/03/2018</h4>
                    <p>This new website has just been put onto the main domain (ostentv.dk). If you find any bugs, please report them on the <a href="/?view=feedback">Feedback</a> page. Thanks :)<br />If you want to see the latest development of this sire, goto <a href="https://test.ostentv.dk">test.ostentv.dk</a>.</p>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <h4>Get is now available - 18/03/2018</h4>
                    <p>Is has never been easier to download Spigot jar files, then with Get. This small batch script allows you to easily select which version you want, and compile it for you using Git bash and BuildTools. <a href="/?view=downloads/get">Read more</a>.</p>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <h4>Auto Backup Program discontinued - 18/03/2018</h4>
                    <p>I'm sad to announce that I am discontinuing Auto Backup Program. <a href="/?view=downloads/abp">Read more</a>.</p>
                </div>
            </div>
        </div>
    </section>

    <?php
    include("modules/footer.php");
    ?>
</body>
</html>