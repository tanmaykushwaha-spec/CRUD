<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Information</title>
    <meta name="csrf-name" content="<?=  csrf_token() ?>">
    <meta name="csrf-hash" content="<?=  csrf_hash() ?>">
    <style>
        .success-message {
            display: inline-block;
            color: green;
            background-color: #e8f5e9;
            border: 1px solid #a5d6a7;
            border-radius: 4px;
            padding: 10px 14px;
            transition: opacity 400ms ease;
        }

        .success-message.is-hidden {
            opacity: 0;
        }

        .action-button {
            display: inline-block;
            padding: 2px 6px;
            border: 1px solid #767676;
            border-radius: 2px;
            background-color: #efefef;
            color: #000;
            font: inherit;
            text-decoration: none;
            cursor: pointer;
        }

        @media (prefers-reduced-motion: reduce) {
            .success-message {
                transition: none;
            }
        }
    </style>
</head>
<body>
    <h2>User Information</h2>

    <div id="ajax-message" role="alert" aria-live="polite"></div>

    <?php if ($message = session()->getFlashdata('success')): ?>
        <p id="success-message" class="success-message" role="status" aria-live="polite">
        <?= esc($message) ?>
        </p>
    <?php endif; ?>

    <p>
        <a class="action-button" href="<?= site_url('users/new') ?>">Add</a>
        <a class="action-button" href="<?= site_url('logout') ?>">Logout</a>
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
                            <a class="action-button" href="<?= site_url('users/edit/' . $user['id']) ?>">Edit</a>
                            <button type="button"
                                    class="action-button delete-btn"
                                    data-id="<?= esc($user['id']) ?>">
                                Delete
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    
    <script>
        $(document).ready(function () {

            $('.delete-btn').on('click', function () {

                // Get the ID from the clicked Delete button.
                let userId = $(this).data('id');

                // Ask for confirmation before deleting.
                if (!confirm('Are you sure you want to delete this user?')) {
                    return;
                }

                // Read the current CSRF token.
                let csrfName = $('meta[name="csrf-name"]').attr('content');
                let csrfHash = $('meta[name="csrf-hash"]').attr('content');

                // Prepare the AJAX request data.
                let requestData = {};
                requestData[csrfName] = csrfHash;

                // Send the request to CodeIgniter.
                $.ajax({
                    url: "<?= site_url('users/delete/') ?>" + userId,
                    type: "POST",
                    data: requestData,

                    success: function (response) {

                        if (response.csrfHash) {
                            $('meta[name="csrf-hash"]').attr('content', response.csrfHash);
                        }

                        if (response.status === 'success') {
                            window.location.reload();

                        } else {

                            $('#ajax-message')
                                .css('color', 'red')
                                .text(response.message);
                        }
                    },

                    error: function (xhr) {

                        if (xhr.responseJSON && xhr.responseJSON.csrfHash) {
                            $('meta[name="csrf-hash"]').attr('content', xhr.responseJSON.csrfHash);
                        }

                        let message = 'Something went wrong. Please try again.';

                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            message = xhr.responseJSON.message;
                        }

                        $('#ajax-message')
                            .css('color', 'red')
                            .text(message);
                    }
                });

            });

        });
    </script>


    <script>
        const successMessage = document.getElementById('success-message');

        if (successMessage) {
            window.setTimeout(() => {
                successMessage.classList.add('is-hidden');
                window.setTimeout(() => successMessage.remove(), 400);
            }, 3000);
        }
    </script>
</body>
</html>
