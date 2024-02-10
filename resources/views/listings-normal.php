<h1><?php echo $title; ?></h1>
<?php foreach ($lists as $list) : ?>
    <h2><?php echo $list['id'] . '. ' . $list['title']; ?></h2>
    <p><?php echo $list['description'] ?></p>
<?php endforeach; ?>