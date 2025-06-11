<?php

require "./app/check_auth.php";
require "./app/common.php";
if ($authentication) {
    header("Refresh: 0; url=app/modules.php");
}
