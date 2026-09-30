<?php

/** @var string $title */
/** @var array<string, mixed> $customer */
/** @var array<string, string> $errors */

?>

<?= $this->extend('layout') ?>

<?= $this->section('content') ?>

<div class="form-shell">
    <section class="form-intro">
        <span class="eyebrow">Customer management</span>

        <h1>Edit Customer</h1>

        <p>
            Review and update the customer's contact information.
        </p>

        <a
            class="back-link"
            href="<?= site_url('customers') ?>"
        >
            &larr; Back to customers
        </a>
    </section>

    <section class="form-card">
        <div class="form-card-heading">
            <span class="step-icon">&#9998;</span>

            <div>
                <h2>Customer details</h2>

                <p>
                    Editing record #<?= esc($customer['id']) ?>
                </p>
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
            action="<?= site_url(
                'customers/' . $customer['id'] . '/update'
            ) ?>"
        >
            <?= csrf_field() ?>

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
                            $customer['full_name']
                        )
                    ) ?>"
                >
            </div>

            <div class="field">
                <label for="email">
                    Email Address <span>*</span>
                </label>

                <input
                    id="email"
                    name="email"
                    type="email"
                    maxlength="100"
                    required
                    autocomplete="email"
                    value="<?= esc(
                        old(
                            'email',
                            $customer['email']
                        )
                    ) ?>"
                >
            </div>

            <div class="field">
                <label for="phone">
                    Phone Number
                    <small>Optional</small>
                </label>

                <input
                    id="phone"
                    name="phone"
                    type="tel"
                    maxlength="20"
                    autocomplete="tel"
                    value="<?= esc(
                        old(
                            'phone',
                            $customer['phone'] ?? ''
                        )
                    ) ?>"
                >
            </div>

            <div class="form-actions">
                <a
                    class="button button-secondary"
                    href="<?= site_url('customers') ?>"
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