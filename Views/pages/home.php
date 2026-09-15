<?php
/** @var string $title */
?>

<?= view('templates/header', ['title' => $title]) ?>

<h1>Welcome to BINIPOS</h1>

<p>
    BINIPOS is a basic Point-of-Sale system for managing customer
    and staff account information.
</p>

<h2>Available Pages</h2>

<ul>
    <li><a href="/customers">View Customer Accounts</a></li>
    <li><a href="/users">View User Accounts</a></li>
    <li><a href="/about">Learn About BINIPOS</a></li>
</ul>

<?= view('templates/footer') ?>