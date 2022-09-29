<?php

if (session_status() === PHP_SESSION_NONE)
    session_start();

spl_autoload_register(function ($class) {
    if (is_file($class . '.php')) {
        require_once($class . '.php');
    }
});

use Csrf\Csrf;

if (!Csrf::verify('example')) {
    // return 405 http status code
    header($_SERVER['SERVER_PROTOCOL'] . ' 405 Method Not Allowed');
    exit;
}
if (isset($_REQUEST['name'], $_REQUEST['lastname'])) {
    $name = $_REQUEST['name'];
    $lastname = $_REQUEST['lastname'];
    echo "Name: $name, Lastname: $lastname";

}