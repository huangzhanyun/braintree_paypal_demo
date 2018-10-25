<?php
session_start();

define('ROOT_PATH', dirname(dirname(__FILE__)) . '/');
define('LIB_PATH', ROOT_PATH  . 'libs/');
$config = include  ROOT_PATH . 'config.php';
require_once ROOT_PATH . 'includes/functions.php';
require_once ROOT_PATH .'libs/smarty/Smarty.class.php';
require_once LIB_PATH . 'braintree-php-3.35.0/lib/autoload.php';

$smarty = new Smarty();
$smarty->compile_dir = ROOT_PATH . 'compile_cache';
$smarty->template_dir = ROOT_PATH . 'templates';
$smarty->left_delimiter = '{{';
$smarty->right_delimiter = '}}';

$gateway = new Braintree_Gateway($config);
