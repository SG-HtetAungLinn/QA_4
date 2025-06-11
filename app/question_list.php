<?php

require "./check_auth.php";
require "./common.php";

$title = "Question List";
$module_code = $_GET['module'] ?? '';
$module_data = getModuleByCode($module_code);
if (empty($module_code)) {
    header("Location: index.php?error=Module Not Found");
    exit;
}
require "./layouts/header.php";
?>
<div class="container-fluid">
    <input type="hidden" id="module-code" value="">
    <div class="row justify-content-center align-items-start mt-3">
        <div class="col-md-4">
            <h1 class="text-center text-theme my-3"><?= $module_data['name'] ?></h1>
            <div class=" d-none d-md-block text-center">
                <img src="../img/source.gif" alt="student" class="img-fluid mt-5">
            </div>
        </div>
        <div class="col-lg-6 col-md-6">
            <div class="row mb-4 mt-4" id="sort-search">
                <div class="col-sm-4 col-lg-4 mb-3">
                    <select class="form-select" id="answerFilter">
                        <option value="all">All Questions</option>
                        <option value="answered">With Answers</option>
                        <option value="unanswered">Without Answers</option>
                    </select>
                </div>
                <div class="col-sm-5 col-lg-5 mb-3">
                    <div class="input-group">
                        <input type="search" id="searchInput" class="form-control" placeholder="Search questions, answers, or users...">
                        <button class="btn btn-outline-secondary" type="button" id="searchButton">
                            <i class="fas fa-search"></i> Search
                        </button>
                    </div>
                </div>
                <?php if ($_SESSION['user']['role'] == 'student') { ?>
                    <div class="col-sm-3 col-lg-3 mb-3 text-end">
                        <a class="btn btn-primary btn-theme" href="question_form.php?module=<?= $module_code ?>">Ask Question</a>
                    </div>
                <?php } ?>
            </div>
            <div id="question_list" class="" style="height: 75vh; overflow-y: auto; overflow-x: hidden;">
            </div>
            <input type="hidden" id="module_code" value="<?= $module_code ?>">
            <input type="hidden" id="current_user" value="<?= $_SESSION['user']['username'] ?>">
            <input type="hidden" id="user_role" value="<?= $_SESSION['user']['role'] ?>">
        </div>
    </div>
</div>

<script src="../js/question.js"></script>
<?php
require "./layouts/footer.php"
?>