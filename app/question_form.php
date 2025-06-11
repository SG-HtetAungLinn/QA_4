<?php
require "./check_auth.php";
require "./common.php";

$module = $_GET['module'] ?? '';
if (empty($module)) {
    header("Location: index.php");
    exit;
}

$module_data = getModuleByCode($module);
if (!$module_data) {
    header("Location: index.php");
    exit;
}

$title = "Ask Question";
$module_name = $module_data['name'];
require "./layouts/header.php";
?>

<div class="container my-5">

    <h1 class="text-center text-theme mb-5"><?= $module_name ?></h1>

    <div class="card mx-auto shadow" style="max-width: 100%; width: 100%; max-width: 550px; border-radius:20px;">
        <h3 class="text-center mt-4 text-theme">Fill the Question Form</h3>
        <form id="question_form" class="p-4">
            <input type="hidden" name="module" value="<?= $module ?>">
            <input type="hidden" name="form_submit" value="1" />

            <div class="mb-3">
                <label for="title" class="form-label">Question Title</label>
                <input type="text" class="form-control" name="title" id="title" value="">
                <small class="text-danger" id="title_error" style="display:none;"></small>
            </div>

            <div class="mb-3">
                <label for="ask_question" class="form-label">Enter Question</label>
                <textarea class="form-control" name="question" id="question"></textarea>
                <small id="question_error" class="text-danger" style="display: none;"></small>
            </div>

            <div class="form-group row mt-4 justify-content-evenly">
                <div class="w-25">
                    <a href="question_list.php?module=<?= $module_data['code'] ?>" class="btn btn-secondary w-100">Cancel</a>
                </div>
                <div class="w-25">
                    <button type="submit" class="btn btn-primary btn-theme w-100 mb-2">Submit</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script src="../js/question_form.js"></script>
<?php require "./layouts/footer.php" ?>