<nav>
    <ul>
        <li><a href="/">Home</a></li>
        <?php if(isset($_SESSION['user'])) : ?>
        <li><a href="/entity/create">New Post</a></li>
        <li><a href="/auth/logout">Logout</a></li>
        <?php else : ?>
        <li><a href="/auth/login">Login</a></li>
        <li><a href="/auth/signup">Sign Up</a></li>
        <?php endif; ?>
    </ul>
</nav>