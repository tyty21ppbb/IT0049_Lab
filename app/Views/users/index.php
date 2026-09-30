<?php
/** @var string $title */
/** @var array<int, array<string, mixed>> $users */
?>

<?= $this->extend('layout') ?>

<?= $this->section('content') ?>

<section class="page-heading heading-row">
    <div>
        <p class="eyebrow">Staff</p>
        <h1>User Accounts</h1>

        <p>
            <?= count($users) ?>
            user records retrieved from the database.
        </p>
    </div>

    <a class="button" href="<?= site_url('users/new') ?>">
        + New User
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
                <th>Avatar</th>
                <th>Username</th>
                <th>Full Name</th>
                <th>Action</th>
            </tr>
        </thead>

        <tbody>
            <?php if ($users === []): ?>
                <tr>
                    <td colspan="4" class="empty-state">
                        No users yet. Create your first user.
                    </td>
                </tr>
            <?php endif ?>

            <?php foreach ($users as $user): ?>
                <?php
                $avatarPath = ! empty($user['avatar'])
                    ? 'uploads/avatars/' . $user['avatar']
                    : 'images/avatar-placeholder.svg';
                ?>

                <tr>
                    <td>
                        <img
                            class="avatar"
                            src="<?= base_url($avatarPath) ?>"
                            alt="Avatar of <?= esc($user['full_name']) ?>"
                        >
                    </td>

                    <td>
                        <code><?= esc($user['username']) ?></code>
                    </td>

                    <td><?= esc($user['full_name']) ?></td>

                    <td>
                        <a
                            class="button button-small"
                            href="<?= site_url(
                                'users/' . $user['id'] . '/edit'
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