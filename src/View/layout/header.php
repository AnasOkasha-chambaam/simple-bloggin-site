<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?></title>
    <link rel="stylesheet" href="/css/style.css">
</head>

<body>
    <nav>
        <div class="container">
            <a href="/" class="logo">Simple Blog</a>
            <div class="nav-links">
                <?php if(isset($_SESSION['user_id'])) : ?>
                <a href="/entity/create">Create Post</a>
                <a href="/auth/logout">Logout</a>
                <?php else : ?>
                <a href="/auth/login">Login</a>
                <a href="/auth/signup">Sign up</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>
    <div class="container">
        <?php echo $content; ?>
    </div>
</body>

</html>