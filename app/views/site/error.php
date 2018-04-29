<?php
/**
 * @var $header string
 * @var $message string
 * @var $code integer
 */

header("HTTP/1.x". $header);
header("Status: ". $header);
?>

<h1><?= $header ?></h1>
<p><?= $message ?></p>
