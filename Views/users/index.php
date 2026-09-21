<?php
/** @var string $title */
/** @var array<int, array<string, mixed>> $users */
?>

<?= view('templates/header', ['title' => $title]) ?>

<h1>User Accounts</h1>

<p>User records retrieved from the MySQL database.</p>

<table>
    <thead>
        <tr>
            <th>Username</th>
            <th>Full Name</th>
            <th>Created At</th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($users as $user): ?>
            <tr>
                <td><?= esc($user['username']) ?></td>
                <td><?= esc($user['full_name']) ?></td>
                <td><?= esc($user['created_at']) ?></td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>

<?= view('templates/footer') ?>
