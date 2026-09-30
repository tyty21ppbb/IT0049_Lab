<?php

/** @var string|null $title */

$pageTitle = $title ?? 'BINIPOS';
$currentPath = service('uri')->getPath();

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1"
    >

    <meta
        name="description"
        content="BINIPOS customer and user account management system"
    >

    <title><?= esc($pageTitle) ?> | BINIPOS</title>
<link
    rel="stylesheet"
    href="<?= base_url('css/style.css') ?>"
>

</head>

<body>
    <header class="site-header">
        <div class="container nav-wrap">
            <a
                class="brand"
                href="<?= site_url('/') ?>"
                aria-label="BINIPOS home"
            >
                BINIPOS
            </a>

            <nav aria-label="Main navigation">
                <a
                    href="<?= site_url('/') ?>"
                    class="<?= $currentPath === '' ? 'active' : '' ?>"
                >
                    Home
                </a>

                <a
                    href="<?= site_url('about') ?>"
                    class="<?= str_starts_with(
                        $currentPath,
                        'about'
                    ) ? 'active' : '' ?>"
                >
                    About
                </a>

                <a
                    href="<?= site_url('customers') ?>"
                    class="<?= str_starts_with(
                        $currentPath,
                        'customers'
                    ) ? 'active' : '' ?>"
                >
                    Customers
                </a>

                <a
                    href="<?= site_url('users') ?>"
                    class="<?= str_starts_with(
                        $currentPath,
                        'users'
                    ) ? 'active' : '' ?>"
                >
                    Users
                </a>
            </nav>
        </div>
    </header>

    <main class="container">
        <?= $this->renderSection('content') ?>
    </main>

    <footer class="site-footer">
        <div class="container">
            <span>
                &copy; <?= date('Y') ?> BINIPOS
            </span>

            <span>
                Customer and user account management system
            </span>
        </div>
    </footer>
</body>
</html>