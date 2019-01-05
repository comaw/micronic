<?php
/**
 * Created by PhpStorm.
 * User: comaw
 * Date: 05.01.2019
 * Time: 18:03
 */

use core\App;

/** @var $content string */

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="List of tasks">
    <meta name="author" content="php-shaman">
    <link rel="icon" href="/favicon.png">
    <title>List of tasks</title>
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <link href="/css/sticky-footer-navbar.css" rel="stylesheet">
</head>
<body>
<header>
    <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
        <a class="navbar-brand" href="/">List of tasks</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="/" title="Dashboard">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/home/create" title="Create task">Create task</a>
                </li>
                <?php if ($user = App::init()->auth->getUserAuth()) { ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/user/logout" title="Logout">Logout (<?=$user['username']?>)</a>
                    </li>
                <?php } else { ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/user/login" title="Sign In">Sign In</a>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </nav>
</header>

<!-- Begin page content -->
<main role="main" class="container">
    <?=$content?>
</main>
<footer class="footer">
    <div class="container">
        <span class="text-muted">(C)2019 php-shaman </span>
    </div>
</footer>
<script src="/js/jquery-3.2.1.slim.min.js"></script>
<script src="/js/popper.min.js"></script>
<script src="/js/bootstrap.min.js"></script>
<script src="/js/home.js"></script>
</body>
</html>
