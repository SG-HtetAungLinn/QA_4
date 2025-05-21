<?php
require "./app/check_auth.php";
$title = "About Us";
require "./layouts/header.php";
?>
<div class="header-image">
    <div class="header-title">About Us</div>
</div>

<div class="container">
    <p class="mt-3">Welcome to <strong>OurPlatform</strong> – a platform where learning never stops!</p>

    <h3>What We Do</h3>
    <ul class="">
        <li class="lh-lg"><strong>For Students</strong>: Ask questions any time, from anywhere.</li>
        <li class="lh-lg"><strong>For Teachers</strong>: Answer student questions and provide extra guidance.</li>
        <li class="lh-lg"><strong>Easy Communication</strong>: Simple interface for learning together.</li>
    </ul>

    <h3>Our Vision</h3>
    <p>To create a community where questions are encouraged and every answer helps someone grow.</p>
</div>
<?php
require "./layouts/footer.php";
?>