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
    <link rel="icon" type="image/png" href="<?= App::$config['template'] ?>/favicon.ico" />
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
        $items[] = ['item' => [T::t('LINK_HOME') => '/site/index', 'title' => T::t('HOME_PAGE')]];
        $items[] = ['item' => [T::t('LINK_SIGN_IN') => '/site/login', 'visible' => !User::isLogin()]];
        $items[] = ['item' => [T::t('LINK_SIGN_UP') => '/user/create', 'visible' => !User::isLogin()]];
        if (User::isLogin())
            $items[] = ['item' => [T::t('LINK_PROFILE') . ' ('.App::user()->login.')' => '/user/view']];
        $items[] = ['item' => [T::t('LINK_EXIT') => '/site/logout', 'visible' => User::isLogin()]];
        $items[] = ['item' => [T::t('CH_LANGUAGE') => '/translator/ch-lang?target=' . App::getUrl(), 'title' => T::t('CH_LANG_TITLE')]];
        
        $menu->menu($items);
    ?>
	</div>
	
	<div class="container content">
	<?= Alert::getFlash() ?>
	<?= $content ?>
	</div>
    
    <div class="container footer">
        <p>
        2018 &copy; Gredasov Ivan <br />
        <a href="mailto:griff19@mail.ru">griff19@mail.ru</a> <br />
        <a href="https://github.com/Griff19">https://github.com/Griff19</a> <br />
        </p>
    </div>
    <?= Asset::addJs(Asset::BODY)?>
    
</body>
</html>