<?php

require_once 'config.php';
require_once 'common.php';

$pageTitle = 'Log In';

if (isset($_POST['login'])) {
    $loginErr = '';

    if ($_POST['username'] === customerUser && $_POST['password'] === customerPassword) {
        $_SESSION['login'] = true;
    } else {
        $loginErr = 'Invalid username or password';
    }
}

require_once 'header.php';
?>
<body>
    <h1><?= sanitize(translate('Log In Here')) ?></h1>
    <form method="POST" action="login.php">
        <label for="user"><?= sanitize(translate('Username:')) ?></label><br/>
        <input type="text" name="username" id="user" /><br/><br/>
        <label for="user"><?= sanitize(translate('Password:')) ?></label><br/>
        <input type="password" name="password" id="pass"/><br/>
        <?php if(!empty($loginErr)): ?>
            <p style="color: red;"><?= $loginErr ?></p>
        <?php endif; ?><br/>
        <button type="submit" name="login"><?= sanitize(translate('Log In')) ?></button><br/>
        <a href="index.php"><?= sanitize(translate('Go to index')) ?></a>
        <a href="cart.php"><?= sanitize(translate('Go to cart')) ?></a>
    </form>
</body>
<?php require_once 'footer.php'; ?>
