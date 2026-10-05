<?php

/** @var string|null $title */

$pageTitle = $title ?? 'BINIPOS';
$currentPath = service('uri')->getPath();

$isLoggedIn = (bool) session()->get('is_logged_in');

$loggedInName = (string) (
    session()->get('full_name')
    ?? session()->get('username')
    ?? ''
);

$successMessage = session()->getFlashdata('success');
$errorMessage = session()->getFlashdata('error');

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
                    class="<?= $currentPath === ''
                        ? 'active'
                        : '' ?>"
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

                <?php if ($isLoggedIn): ?>
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

                    <?php if ($loggedInName !== ''): ?>
                        <span class="nav-user">
                            <?= esc($loggedInName) ?>
                        </span>
                    <?php endif ?>

                    <form
                        class="logout-form"
                        method="post"
                        action="<?= site_url('logout') ?>"
                    >
                        <?= csrf_field() ?>

                        <button
                            class="nav-link-button"
                            type="submit"
                        >
                            Logout
                        </button>
                    </form>
                <?php else: ?>
                    <a
                        href="<?= site_url('login') ?>"
                        class="<?= str_starts_with(
                            $currentPath,
                            'login'
                        ) ? 'active' : '' ?>"
                    >
                        Login
                    </a>

                    <a
                        href="<?= site_url('signup') ?>"
                        class="<?= str_starts_with(
                            $currentPath,
                            'signup'
                        ) ? 'active' : '' ?>"
                    >
                        Sign Up
                    </a>
                <?php endif ?>
            </nav>
        </div>
    </header>

    <main class="container">
        <?php if (! empty($successMessage)): ?>
            <div class="alert success" role="status">
                <?= esc($successMessage) ?>
            </div>
        <?php endif ?>

        <?php if (! empty($errorMessage)): ?>
            <div class="alert error" role="alert">
                <?= esc($errorMessage) ?>
            </div>
        <?php endif ?>

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