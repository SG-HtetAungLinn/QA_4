$(document).ready(function () {
    let searchTimeout;
    const searchInput = $("#searchInput");
    const searchButton = $("#searchButton");
    const answerFilter = $("#answerFilter");

    function loadQuestions(module, search = "", filter = "all") {
        $.ajax({
            url: "app/get_question.php",
            method: "POST",
            data: {
                module: module,
                search: search,
            },
            dataType: "json",
            success: function (response) {
                $('#sort-search').show()
                if (response.success) {
                    $("#question_list").html("");
                    let questionHtml;
                    // sorting vote count and answer
                    const questions = Array.isArray(response.result)
                        ? response.result
                        : [];
                    // Apply answer filter
                    let filteredQuestions = questions;
                    if (filter !== "all") {
                        filteredQuestions = questions.filter((question) => {
                            if (filter === "answered") {
                                return question.answers.length > 0;
                            } else if (filter === "unanswered") {
                                return question.answers.length === 0;
                            }
                            return true;
                        });
                    }

                    const sortedQuestions = filteredQuestions.sort((a, b) => {
                        return b.votes.length - a.votes.length;
                    });
                    if (sortedQuestions.length > 0) {
                        sortedQuestions.forEach((item) => {
                            const hasVoted = item.votes.includes($("#current_user").val());
                            const userRole = $("#user_role").val();
                            const currentUser = $("#current_user").val();
                            // check has answer in question
                            const hasAnswered = item.answers.some((answer) => answer.staff_id === $("#current_user").val());
                            // check show Answer Button condition
                            const showAnswerButton = userRole === "staff" && !hasAnswered;
                            // check vote Button condition
                            const showVoteButton = userRole === "student" && item.answers.length === 0;
                            // question status condition
                            const showStatus = item.answers.length > 0;
                            // check if current user is the question owner
                            const isQuestionOwner = item.student_id === currentUser;
                            questionHtml = `
                                        <div class="row justify-content-center my-4">
                                            <div class="col-lg-12 col-sm-10 col-md-8">
                                                <div class="card" style="box-shadow: 2px 2px 5px black;">
                                                    <div class="card-header">
                                                        <div class="d-flex justify-content-between align-items-start">
                                                            <div>
                                                            <h5 class="card-title mb-0">${item.student_id}</h5>
                                                            </div>
                                                            <div class="text-end d-flex">
                                                            <small class="text-muted d-block pe-3">${timeAgo(item.created_at)}</small>
                                                            <span class="badge mt-1 ${showStatus ? 'bg-success' : 'bg-warning'}">
                                                                ${showStatus ? `Answered` : `Pending`}
                                                            </span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="card-body" style="max-height: 150px; overflow-y: auto;">
                                                        <h4>${item.title}</h4>
                                                        <p>${item.content}</p>
                                                        ${answerHtml(item.answers) ? "<hr/><h5>Answers:</h5>" + answerHtml(item.answers) : ""}
                                                    </div>
                                                    <div class="card-footer">
                                                        <div class="d-flex justify-content-between">
                                                            <div class="d-flex gap-2">
                                                                ${showVoteButton ? `<form action="vote.php" method="POST">
                                                                                        <input type="hidden" name="question_id" value="${item.id}" />
                                                                                        <input type="hidden" name="module" value="${module}" />
                                                                                        <button type="submit" class="btn btn-sm ${hasVoted ? "btn-danger" : "btn-primary"}">${hasVoted ? "Unvote" : "Vote"}</button>
                                                                                    </form>` : ""}
                                                                ${showAnswerButton ? `<a href="answer_form.php?question_id=${item.id}&module=${module}" class="btn btn-sm btn-primary btn-theme">Answer</a>` : ""}
                                                                ${isQuestionOwner ? `<button class="btn btn-sm btn-danger delete-question" data-question-id="${item.id}">Delete</button>` : ""}
                                                            </div>
                                                            <div>
                                                                Vote Count: <b class="badge text-bg-success">${item.votes.length}</b>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                `;
                            $("#question_list").append(questionHtml);
                        });
                    } else if (response.searchData) {
                        questionHtml = `<div class="d-block align-items-center">
                                            <p class="text-center mt-5 no_question_text">Oops!</p>
                                            <p class="text-center fs-2">Sorry There is no question for this module.</p>
                                            <div class="no_question_button">
                                                <a href="question_list.php?module=${module}" class="btn btn-primary">Go Back</a>
                                               <a class="btn btn-primary btn-theme" href="question_form.php?module=${module}">Ask Question</a>
                                            </div>
                                        </div>`;
                        $("#question_list").append(questionHtml);
                    } else {
                        questionHtml = `<div class="d-block align-items-center">
                                            <p class="text-center mt-5 no_question_text">Oops!</p>
                                            <p class="text-center fs-2">Sorry There is no question for this module.</p>
                                            <div class="no_question_button">
                                                <a href="./index.php" class="btn btn-primary">Go Back</a>
                                               <a class="btn btn-primary btn-theme" href="question_form.php?module=${module}">Ask Question</a>
                                            </div>
                                        </div>`;
                        $("#question_list").append(questionHtml);
                    }
                }
            },
            error: handleAjaxError,
        });
    }

    function timeAgo(dateStr) {
        const now = new Date();
        const then = new Date(dateStr);
        const diff = Math.floor((now - then) / 1000); // seconds

        if (diff < 60) return `${diff} seconds ago`;
        if (diff < 3600) return `${Math.floor(diff / 60)} minutes ago`;
        if (diff < 86400) return `${Math.floor(diff / 3600)} hours ago`;
        if (diff < 604800) return `${Math.floor(diff / 86400)} days ago`;

        return then.toLocaleDateString(); // fallback for older dates
    }
    // Handle filter change
    answerFilter.on("change", function () {
        loadQuestions(
            $("#module_code").val(),
            searchInput.val().trim(),
            $(this).val()
        );
    });

    // Handle search input
    searchInput.on("input", function () {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            loadQuestions(
                $("#module_code").val(),
                $(this).val().trim(),
                answerFilter.val()
            );
        }, 300);
    });

    // Handle search button click
    searchButton.on("click", function () {
        loadQuestions(
            $("#module_code").val(),
            searchInput.val().trim(),
            answerFilter.val()
        );
    });

    // Handle Enter key in search input
    searchInput.on("keypress", function (e) {
        if (e.which === 13) {
            loadQuestions(
                $("#module_code").val(),
                $(this).val().trim(),
                answerFilter.val()
            );
        }
    });

    function answerHtml(answer) {
        let answerHtml = "";
        answer.forEach((item) => {
            answerHtml += `<div class="mb-2 py-3 px-1 shadow-sm rounded">
                                <h4>${item.staff_id}</h4>
                                <p class="mb-0 ps-3">${item.answer}</p>
                            </div>`;
        });
        return answerHtml;
    }

    // Initial load Data
    loadQuestions($("#module_code").val());

    // Vote
    $(document).on("submit", 'form[action="vote.php"]', function (e) {
        e.preventDefault();
        const form = $(this);
        const question_id = form.find('input[name="question_id"]').val();
        const module = form.find('input[name="module"]').val();
        $.ajax({
            url: "app/vote.php",
            method: "POST",
            data: {
                question_id,
            },
            dataType: "json",
            success: function (response) {
                if (response.success) {
                    loadQuestions(
                        module,
                        searchInput.val().trim(),
                        answerFilter.val()
                    );
                    handleAjaxSuccess(response);
                } else {
                    showAlert(
                        response.message || "Failed to update vote",
                        "danger"
                    );
                }
            },
            error: handleAjaxError,
        });
    });

    // Delete Question
    $(document).on("click", ".delete-question", function () {
        if (confirm("Are you sure you want to delete this question?")) {
            const questionId = $(this).data("question-id");
            const module = $("#module_code").val();
            $.ajax({
                url: "app/delete_question.php",
                method: "POST",
                data: {
                    question_id: questionId,
                },
                dataType: "json",
                success: function (response) {
                    if (response.success) {
                        loadQuestions(
                            module,
                            searchInput.val().trim(),
                            answerFilter.val()
                        );
                        handleAjaxSuccess(response);
                    } else {
                        showAlert(
                            response.message || "Failed to delete question",
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
        alertDiv.innerHTML = `${message} <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>`;
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
