/* Ajax  */
$(document).ready(function () {
    $('#ajaxSubmitForm').on('submit', function(e){
        e.preventDefault();
        var url = $(this).attr("action"),
            method = $(this).attr("method"),
            data = $(this).serialize(),
            button = $(this).find("button[type=submit]");
        submitForm(url, method , data, button);
    });
});

function submitForm(url, method , data, button) {
    const textButton = button.html().trim();
    const setting = {
        url,
        type: method,
        data,
        processData:false,
        dataType: 'JSON',
        beforeSend: function () {
            button
                .prop("disabled", !0)
                .html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Đang xử lý...');
        },
        complete: function () {
            button.prop("disabled", !1).html(textButton);
        },

        success:function(data){
            if(data.status == 'error'){
                Swal.fire('Thông Báo',data.message,'error')
              }else{
               Swal.fire('Thông Báo',data.message,'success')
                if (data.redirect) {
                    setTimeout(function(){
                        window.location.href = data.redirect;
                    }, 2000);
                }
            };

        },
    };
    $.ajax(setting);
}