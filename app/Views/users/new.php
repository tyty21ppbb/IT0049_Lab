<?php
/** @var string $title */
?>

<?= $this->extend('layout') ?>

<?= $this->section('content') ?>

<div class="form-shell">
    <section class="form-intro">
        <span class="eyebrow">User management</span>
        <h1>New User</h1>

        <p>
            Create a unique account for a member of your POS team.
        </p>

        <a class="back-link" href="<?= site_url('users') ?>">
            &larr; Back to users
        </a>
    </section>

    <section class="form-card">
        <div class="form-card-heading">
            <span class="step-icon">+</span>

            <div>
                <h2>User details</h2>
                <p>Both fields are required.</p>
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
            method="post"
            action="<?= site_url('users') ?>"
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
                    placeholder="e.g. cashier03"
                    value="<?= esc(old('username')) ?>"
                >

                <small>This must be unique.</small>
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
                    placeholder="e.g. Juan Dela Cruz"
                    value="<?= esc(old('full_name')) ?>"
                >
            </div>

            <div class="form-actions">
                <a
                    class="button button-secondary"
                    href="<?= site_url('users') ?>"
                >
                    Cancel
                </a>

                <button class="button" type="submit">
                    Create User
                </button>
            </div>
        </form>
    </section>
</div>

<?= $this->endSection() ?>