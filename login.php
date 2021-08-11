<?php

require_once 'config.php';
require_once 'common.php';

$pageTitle = translate('Log In');

if (isset($_POST['login'])) {
    $loginErr = '';

    /**
     * Check if user is valid
     * If not creating an error message
     */
    if ($_POST['username'] === Customer_Username && $_POST['password'] === Customer_Password) {
        $_SESSION['login'] = true;
    } else {
        $loginErr = translate('Invalid username or password');
    }
}

require_once 'header.php';
?>
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

        <a href="products.php"><?= sanitize(translate('Go to products')) ?></a>
    </form>
<?php require_once 'footer.php'; ?>
