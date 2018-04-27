<?php
/**
 * Login form
 */
use core\T;

?>

<h2> <?= T::t('ENTER_LOGIN_AND_PASSWORD')?> </h2>

<form action="/site/login" method="post">
    <label> <?= T::t('USR_LOGIN')?>: </label><br/>
    <input name="login" type="text" size="15" maxlength="15"><br/>
    
    <label> <?= T::t('USR_PASS')?>: </label><br/>
    <input name="password" type="password" size="15" maxlength="15"><br/><br/>
    
    <input type="submit" value="<?= T::t('LINK_SIGN_IN')?>"><br/><br/>
</form>

<p>
    <?= T::t('OR_YOU_CAN')?>
    <a href="/user/create"><?= T::t('REGISTER')?></a>
    <?= T::t('IN_THE_SYSTEM')?>
</p>