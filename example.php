<?php
if (session_status() === PHP_SESSION_NONE)
    session_start();
spl_autoload_register(function ($class) {
    if (is_file($class . '.php')) {
        require_once($class . '.php');
    }
});

use Csrf\Csrf;

?>
<form id="example-form" method="post">
    <?= Csrf::createInput('example', 60);//1min     ?>
    <input type="text" name="name" value="Gokhan">
    <input type="text" name="lastname" value="Kurtulus">
    <input type="submit" value="Send">
</form>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<script>
    let exampleForm = $("#example-form");
    exampleForm.submit(function (event) {
        event.preventDefault();
        let formData = new FormData(this);
        $.ajax({
            url: "simple-ajax.php",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            cache: false,
            async: true,
            success: function (response) {
                console.log("success:", response);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log("error:", textStatus, errorThrown);
            },
            timeout: 10000
        }).done(function (data) {
            //console.log("done:", data)
        });
    });
</script>