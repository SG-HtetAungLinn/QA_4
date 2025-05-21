$(document).ready(function () {
    let errorMsg = $("#errorMsg");
    let username_error = $("#username-error");
    let password_error = $("#password-error");
    errorMsg.hide().empty();
    $("#login_form").on("submit", function (e) {
        e.preventDefault();
        username_error.empty();
        password_error.empty();
        const username = $("#username").val().trim();
        const password = $("#password").val().trim();
        errorMsg.hide().empty();
        $("#username").removeClass('is-invalid');
        $("#password").removeClass('is-invalid');
        let hasError = false;
        if (username === "") {
            $("#username").addClass('is-invalid');
            username_error.append(`<strong>Please Enter Username</strong><br/>`);
            hasError = true;
        }
        if (password === "") {
            $("#password").addClass('is-invalid');
            password_error.append(`<strong>Please Enter Password</strong><br/>`);
            hasError = true;
        }
        if (hasError) {
            setTimeout(() => {
                $("#username").removeClass('is-invalid');
                $("#password").removeClass('is-invalid');
                username_error.empty();
                password_error.empty()
            }, 3000);
        } else {
            $.ajax({
                url: 'app/login.php',
                method: 'POST',
                data: { username, password },
                dataType: "json",
                success: function (response) {
                    if (response.success) {
                        window.location.href = "index.php";
                    } else {
                        errorMsg.append(`<strong>${response.message}</strong><br/>`);
                        errorMsg.show();
                        $("#username").addClass('is-invalid');
                        $("#password").addClass('is-invalid');
                    }
                },
            })
        }
    });
});
