<?php

/** @var string $title */
/** @var array<string, mixed> $user */
/** @var array<string, string> $errors */

$hasAvatar = ! empty($user['avatar'])
    && is_file(
        FCPATH
        . 'uploads/avatars/'
        . basename((string) $user['avatar'])
    );

$currentAvatar = $hasAvatar
    ? 'uploads/avatars/'
        . basename((string) $user['avatar'])
    : 'images/avatar-placeholder.svg';

?>

<?= $this->extend('layout') ?>

<?= $this->section('content') ?>

<div class="form-shell">
    <section class="form-intro">
        <span class="eyebrow">
            User management
        </span>

        <h1>Edit User</h1>

        <p>
            Update the account information, optionally change the
            password, or upload a new profile picture.
        </p>

        <a
            class="back-link"
            href="<?= site_url('users') ?>"
        >
            &larr; Back to users
        </a>
    </section>

    <section class="form-card">
        <div class="form-card-heading">
            <span
                class="step-icon"
                aria-hidden="true"
            >
                &#9998;
            </span>

            <div>
                <h2>User details</h2>

                <p>
                    Editing record #<?= esc($user['id']) ?>
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
            enctype="multipart/form-data"
            action="<?= site_url(
                'users/' . $user['id'] . '/update'
            ) ?>"
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
                    value="<?= esc(
                        old(
                            'username',
                            $user['username']
                        )
                    ) ?>"
                >

                <small>
                    The username must be unique.
                </small>
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
                    value="<?= esc(
                        old(
                            'full_name',
                            $user['full_name']
                        )
                    ) ?>"
                >
            </div>

            <div class="field">
                <label for="password">
                    New Password
                </label>

                <input
                    id="password"
                    name="password"
                    type="password"
                    minlength="8"
                    maxlength="255"
                    autocomplete="new-password"
                >

                <small>
                    Leave blank to keep the current password.
                    A new password must contain at least
                    8 characters.
                </small>
            </div>

            <div class="field">
                <label for="password_confirm">
                    Confirm New Password
                </label>

                <input
                    id="password_confirm"
                    name="password_confirm"
                    type="password"
                    minlength="8"
                    maxlength="255"
                    autocomplete="new-password"
                >
            </div>

            <div class="field avatar-field">
                <div class="avatar-preview">
                    <img
                        src="<?= base_url($currentAvatar) ?>"
                        alt="Current avatar of <?= esc(
                            $user['full_name']
                        ) ?>"
                    >
                </div>

                <div>
                    <label for="avatar">
                        Profile Picture
                    </label>

                    <input
                        id="avatar"
                        name="avatar"
                        type="file"
                        accept=".jpg,.jpeg,.png,image/jpeg,image/png"
                    >

                    <small>
                        JPG or PNG only, maximum 2 MB.
                        Leave blank to keep the current picture.
                    </small>
                </div>
            </div>

            <div class="form-actions">
                <a
                    class="button button-secondary"
                    href="<?= site_url('users') ?>"
                >
                    Cancel
                </a>

                <button class="button" type="submit">
                    Save Changes
                </button>
            </div>
        </form>
    </section>
</div>

<?= $this->endSection() ?>