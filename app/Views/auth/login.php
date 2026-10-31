
<?php
$emailError = session()->getFlashdata('email_error');
$passwordError = session()->getFlashdata('password_error');
$loginError = session()->getFlashdata('error');

$authFailed = session()->getFlashdata('auth_failed');
$validationErrors = session()->getFlashdata('validation_errors') ?? [];

$emailError = $emailError ?? ($validationErrors['email'] ?? null);
$passwordError = $passwordError ?? ($validationErrors['password'] ?? null);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>

    <style>
        .field {
            margin-bottom: 16px;
        }

        input {
            padding: 8px;
            border: 1px solid #999;
            border-radius: 4px;
        }

        input.invalid {
            border: 2px solid red;
            outline: none;
        }

        .error {
            color: red;
            font-size: 14px;
            display: block;
            margin-top: 4px;
        }

        .server-error {
            color: red;
        }
    </style>
</head>
<body>

    <h2>Login</h2>

    <?php if ($loginError): ?>
        <p class="server-error" id="login-error">
            <?= esc($loginError) ?>
        </p>
    <?php endif; ?>

    <form id="loginForm"
          action="<?= site_url('login') ?>"
          method="post"
          novalidate>

        <?= csrf_field() ?>

        <div class="field">
            <label for="email">Email</label><br>

            <input
                type="email"
                id="email"
                name="email"
                value="<?= esc(old('email') ?? '') ?>"
                class="<?= ($emailError || $authFailed) ? 'invalid' : '' ?>"
                aria-describedby="emailError"
                autocomplete="username"
            >

            <span class="error" id="emailError">
                <?= esc($emailError ?? ($authFailed ? 'Check your email and password.' : '')) ?>
            </span>
        </div>

        <div class="field">
            <label for="password">Password</label><br>

            <input
                type="password"
                id="password"
                name="password"
                class="<?= ($passwordError || $authFailed) ? 'invalid' : '' ?>"
                aria-describedby="passwordError"
                autocomplete="current-password"
            >

            <span class="error" id="passwordError">
                <?= esc($passwordError ?? ($authFailed ? 'Check your email and password.' : '')) ?>
            </span>
        </div>

        <button type="submit" id="loginButton">Login</button>
    </form>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <script>
        $(function () {
            const $form = $('#loginForm'); 
            const $email = $('#email');
            const $password = $('#password');
            const $button = $('#loginButton');

            function validateEmail() {
                const email = $email.val().trim();
                const valid = email !== ''
                    && $email[0].checkValidity();

                $email.toggleClass('invalid', !valid);

                $('#emailError').text(
                    valid ? '' :
                    (email === '' ? 'Email is required.' :
                    'Enter a valid email address.')
                );

                return valid;
            }

            function validatePassword() {
                const valid = $password.val().length > 0;

                $password.toggleClass('invalid', !valid);

                $('#passwordError').text(
                    valid ? '' : 'Password is required.'
                );

                return valid;
            }

            $email.on('input blur', function () {
                $('#login-error').text('');
                validateEmail();
            });

            $password.on('input', function () {
                $('#login-error').text('');
                validatePassword();
            });

            $form.on('submit', function (event) {
                const emailValid = validateEmail();
                const passwordValid = validatePassword();

                if (!emailValid || !passwordValid) {
                    event.preventDefault();

                    if (!emailValid) {
                        $email.trigger('focus');
                    } else {
                        $password.trigger('focus');
                    }

                    return;
                }

                $button.prop('disabled', true).text('Checking...');
            });
        });
    </script>

</body>
</html>
