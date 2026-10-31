
<?php
$errors = session()->getFlashdata('validation_errors') ?? [];
$saveError = session()->getFlashdata('error');

$user = $user ?? [];
$isEdit = $isEdit ?? false;

$formAction = $isEdit  
     ? site_url('users/update/' . $user['id'])
     : site_url('users/create');

$pageTitle = $isEdit ? 'Edit User' : 'Add User';
$submitText = $isEdit ? 'Update' : 'Submit';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Add User</title>

    <style>
        .field {
            margin-bottom: 14px;
        }

        input, select, textarea {
            padding: 7px;
            width: 280px;
            max-width: 95%;
            box-sizing: border-box;
        }

        .invalid {
            border: 2px solid red;
        }

        .error {
            color: red;
            display: block;
            font-size: 14px;
        }
    </style>
</head>
<body>

    <h2><?=  esc($pageTitle) ?></h2>

    <?php if ($saveError): ?>
        <p class="error"><?= esc($saveError) ?></p>
    <?php endif; ?>

    <form action="<?= $formAction ?>" method="post">
        <?= csrf_field() ?>

        <div class="field">
            <label for="name">Name</label><br>
            <input type="text" id="name" name="name"
                   value="<?= esc(old('name') ?? ($user['name'] ?? '')) ?>"
                   class="<?= isset($errors['name']) ? 'invalid' : '' ?>"
                   required>
            <span class="error"><?= esc($errors['name'] ?? '') ?></span>
        </div>

        <div class="field">
            <label for="email">Email</label><br>
            <input type="text" id="email" name="email"
                   value="<?= esc(old('email') ?? ($user['email'] ?? '')) ?>"
                   class="<?= isset($errors['email']) ? 'invalid' : '' ?>"
                   required>
            <span class="error"><?= esc($errors['email'] ?? '') ?></span>
        </div>

        <div class="field">
            <label for="password">Password</label><br>

            <input type="password" id="password" name="password"
                   class="<?= isset($errors['password']) ? 'invalid' : '' ?>"
                   autocomplete="new-password"
                   <?= $isEdit ? '' : 'required' ?>>

            <span class="error"><?= esc($errors['password'] ?? '') ?></span>

            <small>
                <?= $isEdit
                    ? 'Leave blank to keep the existing password. Enter a new one to change it.'
                    : 'At least 8 characters, including an uppercase letter and a special character.' ?>
            </small>
        </div>

        <div class="field">
            <label for="phone_no">Phone Number</label><br>
            <input type="tel" id="phone_no" name="phone_no"
                   value="<?= esc(old('phone_no') ?? ($user['phone_no'] ?? '')) ?>"
                   class="<?= isset($errors['phone_no']) ? 'invalid' : '' ?>"
                   required>
            <span class="error"><?= esc($errors['phone_no'] ?? '') ?></span>
        </div>

        <div class="field">
            <label for="address">Address</label><br>
            <textarea id="address" name="address" required
                      class="<?= isset($errors['address']) ? 'invalid' : '' ?>"><?= esc(old('address') ?? ($user['address']  ?? '')) ?></textarea>
            <span class="error"><?= esc($errors['address']  ?? '') ?></span>
        </div>

        <div class="field">
            <label for="age">Age</label><br>
            <input type="number" id="age" name="age" min="1" step="1"
                   value="<?= esc(old('age') ?? ($user['age']?? '')) ?>"
                   class="<?= isset($errors['age']) ? 'invalid' : '' ?>"
                   required>
            <span class="error"><?= esc($errors['age'] ?? '') ?></span>
        </div>

        <div class="field">
            <label for="nationality">Nationality</label><br>
            <input type="text" id="nationality" name="nationality"
                   value="<?= esc(old('nationality') ?? ($user['nationality']) ?? '') ?>"
                   class="<?= isset($errors['nationality']) ? 'invalid' : '' ?>"
                   required>
            <span class="error"><?= esc($errors['nationality'] ?? '') ?></span>
        </div>

        <div class="field">
            <label for="blood_group">Blood Group</label><br>
            <select id="blood_group" name="blood_group"
                    class="<?= isset($errors['blood_group']) ? 'invalid' : '' ?>"
                    required>
                <option value="">Select blood group</option>
                <?php foreach (['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'] as $group): ?>
                    <option value="<?= esc($group) ?>"
                        <?= old('blood_group', $user['blood_group'] ?? '') === $group ? 'selected' : '' ?>>
                        <?= esc($group) ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <span class="error"><?= esc($errors['blood_group'] ?? '') ?></span>
        </div>

        <button type="submit"><?= esc($submitText) ?></button>
        <a href="<?= site_url('userinfo') ?>">Cancel</a>
    </form>

</body>
</html>
