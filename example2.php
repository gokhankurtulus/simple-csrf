<?php
if (session_status() === PHP_SESSION_NONE)
    session_start();
spl_autoload_register(function ($class) {
    if (is_file($class . '.php')) {
        require_once($class . '.php');
    }
});
use Csrf\Csrf;


if (!Csrf::getToken('example2'))
    Csrf::newToken('example2', 10);//10secs

Csrf::newToken('example3'); //always creates new token named example3

echo '<pre>';
print_r($_SESSION['tokens']);
echo '</pre>';

$token = Csrf::getToken('example2');
$tokenVal = $token->value ?? null;
if (!Csrf::verify('example2', false, $tokenVal)) {
    echo "Not verified";
} else {
    echo "Verified";
    echo '<pre>';
    print_r($token);
    echo '</pre>';
}