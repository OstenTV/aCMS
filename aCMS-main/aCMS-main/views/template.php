<!DOCTYPE html>
<html lang="en">
<head>
    <?php
    $meta = array(
        'title' => 'title',
        'description' => 'Description',
        'keywords' => 'words',
        'index' => false,
        'follow' => false
    );

    include("modules/head.php");
    ?>
</head>
<body>
    <?php
    include("modules/navbar.php");
    ?>

    <section>
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