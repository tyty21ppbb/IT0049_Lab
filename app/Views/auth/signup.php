<?php

/** @var string $title */
/** @var array<string, string> $errors */

?>

<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<div class="form-shell auth-shell">
    <section class="form-intro">
        <span class="eyebrow">BINIPOS</span>

        <h1>Create Account</h1>

        <p>
            Enter your details and choose a secure password
            for your new BINIPOS account.
        </p>

        <a
            class="back-link"
            href="<?= site_url('login') ?>"
        >
            &larr; Already have an account? Log in
        </a>
    </section>

    <section class="form-card">
        <div class="form-card-heading">
            <span class="step-icon">&#128100;</span>

            <div>
                <h2>Sign Up</h2>
                <p>Complete all required fields.</p>
            </div>
        </div>

        <?php if (! empty($errors)): ?>
            <div class="alert error" role="alert">
                <strong>Please correct the following:</strong>

                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?= esc($error) ?></li>
                    <?php endforeach ?>
                </ul>
            </div>
        <?php endif ?>

        <form
            class="account-form"
            action="<?= site_url('signup') ?>"
            method="post"
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
                    autocomplete="username"
                    value="<?= esc(old('username')) ?>"
                >

                <small>The username must be unique.</small>
            </div>

            <div class="field">
                <label for="full_name">
                    Full Name <span>*</span>
                </label>

                <input
                    id="full_name"
                    name="full_name"
                    type="text"
                    maxlength="100"
                    required
                    autocomplete="name"
                    value="<?= esc(old('full_name')) ?>"
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
                    minlength="8"
                    maxlength="255"
                    required
                    autocomplete="new-password"
                >

                <small>Use at least 8 characters.</small>
            </div>

            <div class="field">
                <label for="password_confirm">
                    Confirm Password <span>*</span>
                </label>

                <input
                    id="password_confirm"
                    name="password_confirm"
                    type="password"
                    minlength="8"
                    maxlength="255"
                    required
                    autocomplete="new-password"
                >
            </div>

            <div class="form-actions">
                <a
                    class="button button-secondary"
                    href="<?= site_url('login') ?>"
                >
                    Back to Login
                </a>

                <button class="button" type="submit">
                    Create Account
                </button>
            </div>
        </form>
    </section>
</div>

<?= $this->endSection() ?>