<?php
/** @var string $title */
/** @var array<int, array{full_name: string, email: string, phone: string}> $customers */
?>

<?= view('templates/header', ['title' => $title]) ?>

<h1>Customer Accounts</h1>

<p><b>CUSTOMERS</b></p>

<table>
    <thead>
        <tr>
            <th>Full Name</th>
            <th>Email</th>
            <th>Phone</th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($customers as $customer): ?>
            <tr>
                <td><?= esc($customer['full_name']) ?></td>
                <td><?= esc($customer['email']) ?></td>
                <td><?= esc($customer['phone']) ?></td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>

<?= view('templates/footer') ?>