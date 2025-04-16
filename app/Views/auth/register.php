<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
</head>
<body>
    <h2>User Registration</h2>

    <?php if ($error = \App\Core\Session::flash('error')): ?>
        <p style="color: red;"><?= e($error) ?></p>
    <?php endif; ?>

    <?php if ($success = \App\Core\Session::flash('success')): ?>
        <p style="color: green;"><?= e($success) ?></p>
    <?php endif; ?>

    <form method="POST" action="/register">
        <label>Username:</label><br>
        <input type="hidden" value="<?= e($csrf_token) ?>">
        <input type="text" name="username" required><br><br>

        <label>Email:</label><br>
        <input type="email" name="email" required><br><br>

        <label>Password:</label><br>
        <input type="password" name="password" required><br><br>

        <label>Confirm Password:</label><br>
        <input type="password" name="confirm_password" required><br><br>

        <button type="submit">Register</button>
    </form>
</body>
</html>
