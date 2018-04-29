<?php
/**
 * Created by PhpStorm.
 * User: Gredasow Iwan (Griff19)
 * Date: 23.04.2018
 * Time: 18:33
 */

use core\T;
use core\Asset;

if (array_key_exists('user', $GLOBALS)) {
    $user = unserialize($GLOBALS['user']);
    unset($GLOBALS['user']);
}
?>
<div>
    <h2><?= T::t('FILL_OUT_FORM')?></h2>
    <form enctype="multipart/form-data" action="/user/create" method="post"
          onsubmit="return validForm();">
        <label for="login"> * <?= T::t('USR_LOGIN')?>: </label><br/>
        <input id="login" name="login" type="text" value="<?= isset($user) ? $user->login : '' ?>" size="20" maxlength="255"
               onblur="validLogin()">
        <div id="err_log" class="error"></div>
        <br/>
        <label for="password"> * <?= T::t('USR_PASS')?>: </label><br/>
        <input id="password" name="password" type="password" size="20" maxlength="255" onblur="validPass1()">
        <div id="err_pass1" class="error"></div>
        <br/>
        <label for="password2"> * <?= T::t('CONFIRM_PASS')?>: </label><br/>
        <input id="password2" name="password2" type="password" size="20" maxlength="255" onblur="validPass2()">
        <div id="err_pass" class="error"></div>
        <br/>
        
        <label for="snp"> * <?= T::t('FULL_NAME')?>:</label><br/>
        <input id="snp" name="snp" type="text" value="<?= isset($user) ? $user->snp : '' ?>" size="40" maxlength="255"
               onblur="validSnp(this.value)"><br/>
        <div id="err_snp" class="error"></div>
        <br/>
        <label for="email"> <?= T::t('USR_EMAIL')?>: </label><br/>
        <input id="email" name="email" type="text" value="<?= isset($user) ? $user->email : '' ?>" size="40" maxlength="255"
               onblur="validEmail()">
        <div id="err_email" class="error"></div>
        <br/>
        
        <input type="hidden" name="MAX_FILE_SIZE" value="3000000" />
        <label for="user_file"><?= T::t('ADD_IMAGE')?>:</label><br/>
        <input id="user_file" name="user_file" type="file" accept="image/jpeg,image/gif,image/png"/><br/><br/>
        <label for="memo"><?= T::t('ABOUT_YOUSELF')?>:</label><br/>
        
        <textarea id="memo" name="memo" rows="3" cols="40"></textarea>
        <div id="err_memo" class="error"></div>
        <br/>
        <input type="submit" value="<?= T::t('SAVE')?>">
    </form>
    <br/>
    <?= T::t('FIELDS_STARS')?>
</div>

<?php Asset::registerJsFile('/app/js/sign_up.min.js', Asset::BODY)?>