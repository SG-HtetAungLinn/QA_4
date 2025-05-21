$(document).ready(function () {
    const form = $("#answer_form");
    const answerInput = $("#answer");
    const answerError = $("#answer_error");
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
        answerError.text("").hide();
        answerInput.removeClass("is-invalid");

        // form data
        const formData = {
            answer: answerInput.val().trim(),
            question_id: $('input[name="question_id"]').val(),
            module: $('input[name="module"]').val(),
        };

        // Check banned words
        if (checkBannedWords(formData.answer)) {
            answerError
                .text(
                    `The word "${checkBannedWords(
                        formData.answer
                    )}" is not allowed.`
                )
                .show();
            answerInput.addClass("is-invalid");
            showAlert(
                `The word "${checkBannedWords(
                    formData.answer
                )}" is not allowed in the answer.`,
                "danger"
            );
            return;
        }

        // Validate
        let hasError = false;
        if (!formData.answer) {
            answerError.text("Answer is required").show();
            answerInput.addClass("is-invalid");
            hasError = true;
        }

        if (!hasError) {
            // Submit form
            $.ajax({
                url: "app/save_answer.php",
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
                            response.message || "Failed to submit answer",
                            "danger"
                        );
                    }
                },
                error: handleAjaxError,
            });
        }
    });

    // Alert function for success and error messages
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

    // Function to handle AJAX errors
    function handleAjaxError(xhr, status, error) {
        console.error("AJAX Error:", error);
        let errorMessage = "An error occurred. Please try again.";
        const response = JSON.parse(xhr.responseText);
        if (response.message) {
            errorMessage = response.message;
        }
        showAlert(errorMessage, "danger");
    }

    // Function to handle AJAX success
    function handleAjaxSuccess(response) {
        if (response.success) {
            showAlert(response.message || "Operation completed successfully");
        } else {
            showAlert(response.message || "Operation failed", "danger");
        }
    }
});
