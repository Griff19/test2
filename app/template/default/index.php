<?php
use core\Asset;
use core\App;
use core\Alert;
use core\T;
use core\Menu;
use models\User;
/** @var $content string - формируется в zcore/Controller.php */
?>

<!DOCTYPE html>
<html lang="ru">
<head>
	<link rel="stylesheet" href="<?= App::$config['template'] ?>/style.min.css">
    <link rel="icon" type="image/png" href="/favicon.ico" />
	<?= Asset::addJs(Asset::HEAD)?>
    <meta charset="utf-8">
	<title><?= T::t('TITLE_TEST')?></title>
</head>
<body>

	<div class="container header">
		<h1 class="title"><?= T::t('TITLE_TEST')?></h1>
	</div>
	<div class="container menu">
        <?php
            $menu = new Menu();
            $menu->menu(
                [
                    ['item' => [T::t('LINK_HOME') => '/site/index', 'title' => T::t('HOME_PAGE')], 'visible' => true],
                    ['item' => [T::t('LINK_SIGN_IN') => '/site/login'], 'visible' => !User::isLogin()],
                    ['item' => [T::t('LINK_SIGN_UP') => '/user/create'], 'visible' => !User::isLogin()],
                    ['item' => [T::t('LINK_PROFILE') => '/user/view'], 'visible' => User::isLogin()],
                    ['item' => [T::t('LINK_EXIT') => '/site/logout'], 'visible' => User::isLogin()],
                    ['item' => [
                        T::t('CH_LANGUAGE') => '/translator/ch-lang?target=' . App::getUrl(),
                        'title' => T::t('CH_LANG_TITLE'),
                        ], 'visible' => true],
                ]
            );
        ?>
	</div>
	
	<div class="container content">
	<?= Alert::getFlash() ?>
	<?= $content ?>
	
	</div>
    <div class="container footer">
    
    </div>
    <?= Asset::addJs(Asset::BODY)?>
    
</body>
</html>