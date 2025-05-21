<?php
require "./app/check_auth.php";
require "./app/common.php";

$question_id = $_GET['question_id'] ?? '';
$module = $_GET['module'] ?? '';

if (empty($question_id) || empty($module)) {
    header("Location: index.php");
    exit;
}

$question = getQuestionById($question_id);
if (!$question) {
    header("Location: index.php");
    exit;
}

$module_data = getModuleByCode($module);
$title = "Answer Question";
$base_url = "./";

require "./layouts/header.php";
?>

<div class="container my-4">
    <div class="card mx-auto shadow-sm" style="max-width: 500px; border-radius: 20px;">
        <h3 class="text-center mt-4 text-theme"><?= $module_data['name'] ?? $module ?></h3>
        <form class="p-4" id="answer_form">
            <input type="hidden" name="question_id" value="<?= $question_id ?>">
            <input type="hidden" name="module" value="<?= $module ?>">
            <div class="mb-3">
                <div class="w-auto">Ask By: <b><?= $question['student_id'] ?></b></div>
                <label for="current_question" class="form-label fw-bold">Title</label>
                <div class="p-2 border bg-light" id="current_question" style="border-radius: 5px;">
                    <?= $question['title'] ?>
                </div>
                <label for="current_question" class="form-label fw-bold">Content</label>
                <div class="p-2 border bg-light" id="current_question" style="border-radius: 5px;">
                    <?= $question['content'] ?>
                </div>
            </div>
            <hr class="border-3">
            <div class="mb-3">
                <label for="answer" class="form-label fw-bold">Enter Your Answer</label>
                <textarea class="form-control" name="answer" id="answer" rows="3" required placeholder="Enter Your Answer" style="resize: none;"></textarea>
                <small id="answer_error" class="text-danger" style="display: none;"></small>
            </div>
            <div class="form-group row mt-4 justify-content-evenly">
                <div class="w-25">
                    <a href="question_list.php?module=<?= $module ?>" class="btn btn-secondary">Cancel</a>
                </div>
                <div class="w-25">
                    <button type="submit" class="btn btn-primary btn-theme w-100 mb-2">Submit</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script src="./js/answer_form.js"></script>
<?php require "./layouts/footer.php" ?>