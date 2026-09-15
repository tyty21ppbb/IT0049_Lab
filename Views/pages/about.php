<?php
/** @var string $title */
?>

<?= view('templates/header', ['title' => $title]) ?>

<h1>About BINIPOS</h1>

<p>
    BINIPOS is a CodeIgniter 4 laboratory project demonstrating
    controllers, routes, views, and static PHP array data.
</p>

<p>
    This version does not use a database. Database integration can be
    introduced in a future version.
</p>

<?= view('templates/footer') ?>