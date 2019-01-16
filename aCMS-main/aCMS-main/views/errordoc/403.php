<!DOCTYPE html>
<html lang="en">
<head>
    <?php
    $meta = array(
        'title' => '403 Forbidden',
        'description' => 'You don\'t have permission to view this page. Did your cat run away with your keys, again?',
        'keywords' => '403, forbidden',
        'index' => false,
        'follow' => false
    );

    include("modules/head.php");

    header('HTTP/1.1 403 Forbidden');
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

    <?php
    include("modules/footer.php");
    ?>
</body>
</html>