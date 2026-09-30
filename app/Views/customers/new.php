<?php
/** @var string $title */
?>

<?= $this->extend('layout') ?>

<?= $this->section('content') ?>

<div class="form-shell">
    <section class="form-intro">
        <span class="eyebrow">Customer management</span>
        <h1>New Customer</h1>

        <p>
            Create a customer account for faster and more accurate
            transactions.
        </p>

        <a class="back-link" href="<?= site_url('customers') ?>">
            &larr; Back to customers
        </a>
    </section>

    <section class="form-card">
        <div class="form-card-heading">
            <span class="step-icon">+</span>

            <div>
                <h2>Customer details</h2>
                <p>Fields marked with * are required.</p>
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
            action="<?= site_url('customers') ?>"
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
                    placeholder="e.g. Juan Dela Cruz"
                    value="<?= esc(old('full_name')) ?>"
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
                    placeholder="name@example.com"
                    value="<?= esc(old('email')) ?>"
                >
            </div>

            <div class="field">
                <label for="phone">
                    Phone Number <small>Optional</small>
                </label>

                <input
                    id="phone"
                    name="phone"
                    type="tel"
                    maxlength="20"
                    autocomplete="tel"
                    placeholder="09XX-XXX-XXXX"
                    value="<?= esc(old('phone')) ?>"
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
                    Create Customer
                </button>
            </div>
        </form>
    </section>
</div>

<?= $this->endSection() ?>