<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo $title; ?></title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"
          integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-2.2.3.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.2.8/jquery.form-validator.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"
            integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS"
            crossorigin="anonymous"></script>
</head>
<body>

<nav class="navbar navbar-default">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="/">
                Simple Feedback Form
            </a>
        </div>
        <div class="collapse navbar-collapse">
            <?php if (App::isAdmin()): ?>
                <p class="navbar-text navbar-right"><a href="/auth/logout" class="navbar-link">Exit</a></p>
                <p class="navbar-text navbar-right">Signed in as Admin</p>
            <?php else: ?>
                <p class="navbar-text navbar-right"><a href="/auth" class="navbar-link">Sign in</a></p>
            <?php endif; ?>
        </div>
    </div>
</nav>

<div class="container">

    <?php if (!empty($alerts)): ?>
        <?php foreach ($alerts as $alert): ?>
            <div class="alert alert-<?php echo $alert['type']; ?>" role="alert">
                <?php echo $alert['message']; ?>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>

    <?php echo $content; ?>
</div>

</body>
</html>
