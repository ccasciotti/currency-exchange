<?php

// fix encoding issue while running text on different host with different locale configuration
setlocale(LC_ALL, "en_US.UTF-8");

if (file_exists($file = __DIR__ . '/../vendor/autoload.php')) {
    require_once $file;
} else {
    die('Unable to find autoload.php file, please use composer to load dependencies:

wget http://getcomposer.org/composer.phar
php composer.phar install

Visit http://getcomposer.org/ for more information.

');
}