<?php

use core\T;
use core\App;
?>

<h1><?= T::t('HOME_PAGE')?></h1>

<p><?= T::t('FOR_LOOK_INFORMATION')?> <a href="<?= App::$root ?>user/create"><?= T::t('SIGN_UP')?></a></p>
<p><?= T::t('WELCOME')?> <a href="<?= App::$root ?>site/login"><?= T::t('SIGN_IN')?></a></p>
