<?php

require "./app/check_auth.php";
require "./app/common.php";

$title = "Modules List";
require "./layouts/header.php";
?>
<div class="container">
    <div class="row">
        <div class="col-lg-6 col-sm-12 d-flex flex-column justify-content-center p-3">
            <h1 class="mt-5" style="font-family: Oswald , sans-serif;">
                The Future of
            </h1>
            <h1 class="" style="font-family: Oswald , sans-serif;">
                Learning
            </h1>
            <p class="mt-3 pt-3">Unlock your potential wiht LIVERPOOL JOHN MOORES UNIVERSITY. Our Platform provides high-quality eduication and empowers learners of all background to success.</p>
        </div>
        <div class="col-lg-6 col-sm-12 text-center">
            <img src="./img/home-img.avif" alt="Home page image" style="width:300px; height:300px; border-radius:50%;" class="mt-5 img-fluid">
        </div>
    </div>
    <div class="row mt-3" id="module_list">
    </div>
</div>
<script src="./js/modules.js"></script>
<?php
require "./layouts/footer.php"
?>