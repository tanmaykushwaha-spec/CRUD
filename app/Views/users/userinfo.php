<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Information</title>
</head>
<body>
    <h2>User Information</h2>

    <?php if ($message = session()->getFlashdata('success')): ?>
        <p><?= esc($message) ?></p>
    <?php endif; ?>

    <p>
        <a href="<?= site_url('users/new') ?>">Add</a>
        |
        <a href="<?= site_url('logout') ?>">Logout</a>
    </p>

    <table border="1" cellpadding="6" cellspacing="0">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Address</th>
                <th>Age</th>
                <th>Nationality</th>
                <th>Blood Group</th>
                <th>Actions</th>
            </tr>
        </thead>

        <tbody>
            <?php if (empty($users)): ?>
                <tr>
                    <td colspan="9">No users found.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?= esc($user['id']) ?></td>
                        <td><?= esc($user['name']) ?></td>
                        <td><?= esc($user['email']) ?></td>
                        <td><?= esc($user['phone_no']) ?></td>
                        <td><?= esc($user['address']) ?></td>
                        <td><?= esc($user['age']) ?></td>
                        <td><?= esc($user['nationality']) ?></td>
                        <td><?= esc($user['blood_group']) ?></td>
                        <td>
                            <button type="button" disabled>Edit</button>
                            <button type="button" disabled>Delete</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>