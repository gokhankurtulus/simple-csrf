# simple-csrf

Simple SESSION based PHP Class for generate and verify CSRF tokens.
<p>You can use single token on each field or specify expirations for each token.</p>

## Usage

```injectablephp
use Csrf\Csrf;
```

##### Writing Token Input

```html
<form id="example-form" method="post">
    <?= Csrf::createInput('example'); ?>
    <input type="text" name="name">
    <input type="text" name="lastname">
    <input type="submit" value="Send">
</form>
```

##### Verifying Token

```injectablephp
if (!Csrf::verify('example')) {
//Token not verified
//return 405 http status code
//header($_SERVER['SERVER_PROTOCOL'] . ' 405 Method Not Allowed');
//exit;
}
```

### Additional:

##### Create Token

```injectablephp
//If token is already created shows created token, if isn't exist creates new token and shows
Csrf::createInput('example');

//Creates new token, if exist overwrites values to token
//It may corrupt token values, if used uncontrollably
Csrf::newToken('example');
```

##### Get Token

```injectablephp
$token = Csrf::getToken('example'); //return token or null
```

##### See Tokens

```injectablephp
$_SESSION['tokens']
or
$_SESSION['tokens']['example']
```