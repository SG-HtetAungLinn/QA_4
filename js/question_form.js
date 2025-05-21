$(document).ready(function () {
    const form = $("#question_form");
    const titleInput = $("#title");
    const questionInput = $("#question");
    const titleError = $("#title_error");
    const questionError = $("#question_error");
    const bannedWords = ["XXXTEST", "YYYTEST", "ZZZTEST"];
    function checkBannedWords(text) {
        for (const word of bannedWords) {
            if (text.toUpperCase().includes(word)) {
                return word;
            }
        }
        return false;
    }
    form.on("submit", function (e) {
        e.preventDefault();
        // Reset errors
        titleError.text("").hide();
        questionError.text("").hide();
        titleInput.removeClass("is-invalid");
        questionInput.removeClass("is-invalid");
        // form data
        const formData = {
            title: titleInput.val().trim(),
            question: questionInput.val().trim(),
            module: $('input[name="module"]').val(),
            form_submit: 1,
        };
        // Check banned words
        if (checkBannedWords(formData.title)) {
            titleError
                .text(
                    `The word "${checkBannedWords(
                        formData.title
                    )}" is not allowed.`
                )
                .show();
            titleInput.addClass("is-invalid");
            showAlert(
                `The word "${checkBannedWords(
                    formData.title
                )}" is not allowed in the title.`,
                "danger"
            );
            return;
        }
        if (checkBannedWords(formData.question)) {
            questionError
                .text(
                    `The word "${checkBannedWords(
                        formData.question
                    )}" is not allowed.`
                )
                .show();
            questionInput.addClass("is-invalid");
            showAlert(
                `The word "${checkBannedWords(
                    formData.question
                )}" is not allowed in the question.`,
                "danger"
            );
            return;
        }
        // Validate
        let hasError = false;
        if (!formData.title) {
            titleError.text("Title is required").show();
            titleInput.addClass("is-invalid");
            hasError = true;
        }
        if (!formData.question) {
            questionError.text("Question is required").show();
            questionInput.addClass("is-invalid");
            hasError = true;
        }
        if (!hasError) {
            $.ajax({
                url: "app/save_question.php",
                method: "POST",
                data: formData,
                dataType: "json",
                success: function (response) {
                    if (response.success) {
                        handleAjaxSuccess(response);
                        window.location.href =
                            "question_list.php?module=" + formData.module;
                    } else {
                        showAlert(
                            response.message || "Failed to submit question",
                            "danger"
                        );
                    }
                },
                error: handleAjaxError,
            });
        }
    });
    // Alert success and error messages
    function showAlert(message, type = "success") {
        const alertDiv = document.createElement("div");
        alertDiv.className = `alert alert-${type} alert-dismissible fade show position-fixed top-0 end-0 translate-middle-x mt-5`;
        alertDiv.style.zIndex = "9999";
        alertDiv.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    `;
        document.body.appendChild(alertDiv);
        setTimeout(() => {
            alertDiv.remove();
        }, 3000);
    }
    // Handle AJAX errors
    function handleAjaxError(xhr, status, error) {
        console.error("AJAX Error:", error);
        let errorMessage = "An error occurred. Please try again.";
        const response = JSON.parse(xhr.responseText);
        if (response.message) {
            errorMessage = response.message;
        }
        showAlert(errorMessage, "danger");
    }
    // Handle AJAX success
    function handleAjaxSuccess(response) {
        if (response.success) {
            showAlert(response.message || "Operation completed successfully");
        } else {
            showAlert(response.message || "Operation failed", "danger");
        }
    }
});
