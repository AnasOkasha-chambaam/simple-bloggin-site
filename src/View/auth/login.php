<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Login | Simple Blogging Website</title>
    <link rel="stylesheet" type="text/css" href="/css/styles.css">
</head>

<body>
    <div class="container">
        <div class="form-container">
            <h2>Login</h2>
            <?php if(isset($error_msg)): ?>
            <div class="error-msg"><?php echo $error_msg; ?></div>
            <?php endif; ?>
            <form method="POST" action="/login">
                <label for="username">Username:</label>
                <input type="text" name="username" id="username" required>
                <label for="password">Password:</label>
                <input type="password" name="password" id="password" required>
                <button type="submit">Login</button>
            </form>
            <p>Don't have an account? <a href="/register">Register here</a></p>
        </div>
    </div>
</body>

</html>