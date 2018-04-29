<?php

session_start();
isset($_SESSION['count']) ?: $_SESSION['count'] = 0;

require_once 'app/config/bootstrap.php';

$config = array_merge(
    require 'app/config/params.php',
    require 'app/config/local.php'
);

(new \core\App($config))->run();
