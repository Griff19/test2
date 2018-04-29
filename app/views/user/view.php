<?php
use core\T;

/**
 * @var $user models\User
 */
?>
<h1><?= T::t('PAGE_PROFILE') ?> "<?= $user->login ?>"</h1>
<div class="img-conteiner">
    <img class="img-profile" src="/app/<?= $user->link_file ?>" alt="<?= $user->snp ?>"/>
</div>
<div>
    <p><?= T::t('FULL_NAME')?>: <?= $user->snp ?></p>
    <p><?= T::t('USR_EMAIL')?>: <?= $user->email ?></p>
    <p><?= T::t('ADD_INFO')?>: <?= $user->memo ?></p>
</div>
