<?php

session_start();

require_once 'app/config/bootstrap.php';

$config = array_merge(
    require 'app/config/params.php',
    require 'app/config/local.php'
);

(new \core\App($config))->run();
