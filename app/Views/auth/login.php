<?php

/** @var string $title */
/** @var array<string, string> $errors */

?>

<?= $this->extend('layout') ?>

<?= $this->section('content') ?>

<div class="form-shell auth-shell">
    <section class="form-intro">
        <span class="eyebrow">
            Secure access
        </span>

        <h1>Welcome Back</h1>

        <p>
            Log in to BINIPOS to manage customer and user
            accounts.
        </p>
    </section>

    <section class="form-card login-card">
        <div class="form-card-heading">
            <span
                class="step-icon"
                aria-hidden="true"
            >
                &#128274;
            </span>

            <div>
                <h2>Account Login</h2>

                <p>
                    Enter your username and password.
                </p>
            </div>
        </div>

        <?php if (! empty($errors)): ?>
            <div class="alert error" role="alert">
                <strong>
                    Please correct the following:
                </strong>

                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?= esc($error) ?></li>
                    <?php endforeach ?>
                </ul>
            </div>
        <?php endif ?>

        <form
            class="account-form"
            method="post"
            action="<?= site_url('login') ?>"
        >
            <?= csrf_field() ?>

            <div class="field">
                <label for="username">
                    Username <span>*</span>
                </label>

                <input
                    id="username"
                    name="username"
                    type="text"
                    maxlength="50"
                    required
                    autofocus
                    autocomplete="username"
                    value="<?= esc(old('username')) ?>"
                >
            </div>

            <div class="field">
                <label for="password">
                    Password <span>*</span>
                </label>

                <input
                    id="password"
                    name="password"
                    type="password"
                    maxlength="255"
                    required
                    autocomplete="current-password"
                >

                <small>
                    Enter the password assigned to your account.
                </small>
            </div>

            <div class="form-actions">
                <a
                    class="button button-secondary"
                    href="<?= site_url('/') ?>"
                >
                    Back to Home
                </a>

                <button class="button" type="submit">
                    Log In
                </button>
            </div>
        </form>
    </section>
</div>

<?= $this->endSection() ?>