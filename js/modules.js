$(document).ready(function () {
    $.ajax({
        url: 'app/get_modules.php',
        method: "POST",
        dataType: "json",
        success: function (response) {
            if (response.success) {
                $('#module_list').html('')
                let moduleHtml
                if (response.result.length > 0) {
                    let tutor = $('#tutor').val();
                    let role = $('#role').val();
                    let filterData = response.result
                    if (role === 'staff') {
                        filterData = filterData.filter(item => item.tutor === tutor)
                    }
                    filterData.forEach((item) => {
                        moduleHtml = `
                        <div class="col-md-6 mb-3" >
                            <a href="question_list.php?module=${item.code}" class="text-decoration-none" >
                                <div class="card shadow" style="border-radius:20px;">
                                    <div class="card-body py-5">
                                    <h1 class="text-center"><i class="${item.icon} text-theme"></i></h1>
                                        <div class="text-center mb-3">
                                            <small class="badge bg-theme">${item.code}</small>
                                            <p class="text-center text-theme">${item.tutor}</p>
                                            <h5 class="text-center text-theme">${item.name}</h5>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        `;
                        $('#module_list').append(moduleHtml);
                    })
                } else {
                    moduleHtml = `<h1 class="text-center text-theme">There is no Module</h1>`
                    $('#module_list').append(moduleHtml);
                }
            }
        },
    })
})