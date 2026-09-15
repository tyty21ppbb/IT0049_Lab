<?php
/** @var string $title */
/** @var array<int, array{username: string, full_name: string, role: string}> $users */
?>

<?= view('templates/header', ['title' => $title]) ?>

<h1>User Accounts</h1>

<p><b>STAFF</b></p>

<table>
    <thead>
        <tr>
            <th>Username</th>
            <th>Full Name</th>
            <th>Role</th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($users as $user): ?>
            <tr>
                <td><?= esc($user['username']) ?></td>
                <td><?= esc($user['full_name']) ?></td>
                <td><?= esc($user['role']) ?></td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>

<?= view('templates/footer') ?>