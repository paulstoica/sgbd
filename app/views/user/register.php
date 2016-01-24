
<!DOCTYPE html>
<head>
    <title>Register</title>
</head>
<body>
<div class="register-form">
    <h3>Register</h3>
    <?php if(isset($error) && $error): ?>
        <div class="error">
            <?php echo $error ?>
        </div>
    <?php endif?>
    <form action="<?php echo\App\Project::getUrl('user/register') ?>" method="post">
        <div class="control">
            <input type="text" name="name" value="" placeholder="Name">
        </div>
        <div class="control">
            <input type="text" name="email" value="" placeholder="Email">
        </div>
        <div class="control">
            <input type="password" name="password" value="" placeholder="Password">
        </div>
        <div class="control">
            <input type="password" name="repassword" value="" placeholder="Confirm password">
        </div>
        <input type="submit" value="Register">
    </form>
</div>
</body>
</html>