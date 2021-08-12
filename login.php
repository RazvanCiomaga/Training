<?php

require_once 'config.php';
require_once 'common.php';

$pageTitle = translate('Log In');

require_once 'header.php';
?>
    <h1><?= sanitize(translate('Log In Here')) ?></h1>
    <form method="POST" action="products.php">
        <label for="user"><?= sanitize(translate('Username:')) ?></label><br/>
        <input type="text" name="username" id="user" /><br/><br/>

        <label for="user"><?= sanitize(translate('Password:')) ?></label><br/>
        <input type="password" name="password" id="pass"/><br/>
        <?php if(!empty($_SESSION['loginErr'])): ?>
            <p style="color: red;"><?= sanitize($_SESSION['loginErr']) ?></p>
        <?php endif; ?><br/>

        <button type="submit" name="login"><?= sanitize(translate('Log In')) ?></button><br/>
    </form>
<?php require_once 'footer.php'; ?>
