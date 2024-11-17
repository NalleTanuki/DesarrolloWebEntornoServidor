<?php
    setcookieI('nueva_cookie', "valor", time() + 3600 * 24);
    echo $_COOKIES["nueva_cookie"];
?>