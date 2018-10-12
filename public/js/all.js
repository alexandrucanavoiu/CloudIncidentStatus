function printErrorMsg (msg) {
    $(".print-error-msg").find("ul").html('');
    $(".print-error-msg").css('display','block');
    $.each( msg, function( key, value ) {
        $(".print-error-msg").find("ul").append('<li>'+value+'</li>');
    });
}


$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();
});

$(document).on("click", "#myModal-Subscribe-new .close, #myModal-Subscribe-cancel .close, .js--close-modal-Subscribe-new, .js--close-modal-Subscribe-cancel", function(e)
{
    $('#myModal-Subscribe-new').remove();
    $('#myModal-Subscribe-cancel').remove();
    $('.modal-backdrop').remove();
    $("body").css("padding-right","");
    $('body').removeClass('modal-open');
    $('.sidebar-mini').removeClass('modal-open');
});


$('#myModal-Subscribe-new').modal({backdrop: 'static', keyboard: false});


$(document).on("click", ".subscribe-new", function()
{

    $.ajax({
        type: "GET",
        url: "/subscribe",
        dataType: 'html',
        async: false,
        success: function (view) {
                $('#myModal-Subscribe-new').remove();
                $('body').append(view);
                $('#myModal-Subscribe-new').modal('show');

        },
        error: function (data) {
            var data2 = JSON.parse(data.responseText);
            swal({
                type: data2.type,
                title: data2.title,
                text: data2.message
            });
        }
    });

});

$("body").delegate('.subscribe-new-store', 'click',function(e){
    e.preventDefault();
    var formData = new FormData();

    var _token = $("input[name='_token']").val();
    var email = $("input[name='email']").val();

    formData.append("_token", _token);
    formData.append("email", email);

    var request = new XMLHttpRequest();
    request.open("POST", "/subscribe");
    request.setRequestHeader("X-Requested-With", "XMLHttpRequest");
    request.send(formData);
    request.onreadystatechange=function(){
        if (request.readyState==4 && request.status==200){
            var data = JSON.parse(request.responseText);
            if($.isEmptyObject(data.error)){
                $('#myModal-Subscribe-new').modal('toggle');
                $('#myModal-Subscribe-new').remove();
                $('.modal-backdrop').remove();
                $('.sidebar-mini').removeClass('modal-open');

                window.location = "/subscribe/" + data.code;

            }else{
                printErrorMsg(data.error);
                $("#myModal-Subscribe-new").scrollTop( 0 );
            }
        }
    }

});

$(document).on("click", ".subscribe-cancel", function(e)
{
    e.preventDefault();
    $.ajax({
        type: "GET",
        url: "/subscribe/" + $(this).data('code') + "/cancel",
        dataType: 'html',
        success: function (view) {
            if( $('#myModal-Subscribe-cancel').length > 0 )
            {
                $('#myModal-Subscribe-cancel').remove();
            }
            $('body').append(view);
            $('#myModal-Subscribe-cancel').modal('show');
            $('body').removeClass('modal-open');
            $("body").css("padding-right","");
        },
        error: function (data) {
            //Error message here
        }
    });

});

$("body").delegate('.subscribe-cancel-confirm', 'click',function(e){
    e.preventDefault();
    var formData = new FormData();
    var _token = $("input[name='_token']").val();
    var code = $(this).data('code');


    formData.append("_token", _token);
    formData.append("code", code);
    var request = new XMLHttpRequest();
    request.open("POST", "/subscribe/"  + $(this).data('code') +  "/cancel");
    request.setRequestHeader("X-Requested-With", "XMLHttpRequest");
    request.send(formData);

    request.onreadystatechange=function(){
        if (request.readyState==4 && request.status==200){
            var data = JSON.parse(request.responseText);
            if($.isEmptyObject(data.error)){

                $('#myModal-Subscribe-cancel').modal('toggle');
                $('#myModal-Subscribe-cancel').remove();
                $('.modal-backdrop').remove();
                $('.datetimepicker').remove();
                $('.sidebar-mini').removeClass('modal-open');

                swal({
                    type: data.type,
                    title: data.title,
                    text: data.message
                });

            }else{
                printErrorMsg(data.error);
            }
        }
    }
});