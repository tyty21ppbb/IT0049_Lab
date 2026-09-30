<?php
/** @var string $title */
/** @var array<int, array<string, mixed>> $customers */
?>

<?= $this->extend('layout') ?>

<?= $this->section('content') ?>

<section class="page-heading heading-row">
    <div>
        <p class="eyebrow">Accounts</p>
        <h1>Customer Accounts</h1>
        <p>
            <?= count($customers) ?>
            customer records retrieved from the database.
        </p>
    </div>

    <a class="button" href="<?= site_url('customers/new') ?>">
        + New Customer
    </a>
</section>

<?php if (session()->getFlashdata('success')): ?>
    <div class="alert success">
        <?= esc(session()->getFlashdata('success')) ?>
    </div>
<?php endif ?>

<div class="table-wrap">
    <table>
        <thead>
            <tr>
                <th>Full Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Action</th>
            </tr>
        </thead>

        <tbody>
            <?php if ($customers === []): ?>
                <tr>
                    <td colspan="4" class="empty-state">
                        No customers yet. Create your first customer.
                    </td>
                </tr>
            <?php endif ?>

            <?php foreach ($customers as $customer): ?>
                <tr>
                    <td><?= esc($customer['full_name']) ?></td>

                    <td>
                        <a href="mailto:<?= esc($customer['email']) ?>">
                            <?= esc($customer['email']) ?>
                        </a>
                    </td>

                    <td><?= esc($customer['phone'] ?? '') ?></td>

                    <td>
                        <a
                            class="button button-small"
                            href="<?= site_url(
                                'customers/'
                                . $customer['id']
                                . '/edit'
                            ) ?>"
                        >
                            Edit
                        </a>
                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</div>

<?= $this->endSection() ?>