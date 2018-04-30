<?php
/**
 * Created by PhpStorm.
 * User: Gredasow Iwan (Griff19)
 * Date: 28.04.2018
 * Time: 16:02
 */

require_once __DIR__ . '/app/zcore/Db.php';


use core\Db;


echo 'Initialize the application? (y - Yes, n - No): ';
$s = fgets(STDIN, 255);

if (trim($s) == "y") {
    echo "Creating the necessary directories...\n";
    if (!file_exists(__DIR__ . '/app/img'))
        mkdir(__DIR__ . '/app/img/', 0755);
    
    if (!file_exists(__DIR__ . '/app/config/local.php')) {
        copy(__DIR__ . '/app/config/common/local.php', __DIR__ . '/app/config/local.php');
        echo "Please specify the settings for connecting to the database in the config/local.php file. See README.md\n";
        exit();
    }
    chmod('index.php', 0644);
    chmod(__DIR__, 0755);
    echo "Create Users table...\n";
    try {
        $db = new Db;
        if ($db->errors) {
            echo 'DB Error! ' . $db->errors . "\n";
            exit();
        }
    } catch (\Exception $e) {
        echo 'Error: '. $e->getMessage() . "\n";
        exit();
    }
    
    $db->connection->query("CREATE TABLE IF NOT EXISTS `users` (
          `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
          `user_token` varchar(255) NOT NULL,
          `login` varchar(255) NOT NULL,
          `pass` varchar(255) NOT NULL,
          `email` varchar(255) DEFAULT NULL,
          `snp` varchar(255) NOT NULL,
          `link_file` varchar(255) DEFAULT NULL,
          `memo` text,
          PRIMARY KEY (`id`),
          UNIQUE KEY `login` (`login`)
    	) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;");
    
    echo 'Done.' . "\n";
} else {
    echo 'Action canceled by user.';
}

