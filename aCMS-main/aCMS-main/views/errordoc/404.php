<!DOCTYPE html>
<html lang="en">
<head>
    <?php
    $meta = array(
        'title' => '404 Page Not Found',
        'description' => 'The page u were looking for went missing. Did your cat step on your keyboard, while you were typing?',
        'keywords' => '403, page, not, found',
        'index' => false,
        'follow' => false
    );

    include("modules/head.php");

    header('HTTP/1.1 404 Not Found');
    ?>
</head>
<body>
    <?php
    include("modules/navbar.php");
    ?>

    <section class="bg-secondary">
        <div class="container">
            <h1><?php echo $meta['title']; ?></h1>
            <p><?php echo $meta['description']; ?></p>
        </div>
    </section>
    <section>
        <div class="container">
            <img class="img-fluid" src="/content/images/cat.png" />
        </div>
    </section>

    <?php
    include("modules/footer.php");
    ?>
</body>
</html>