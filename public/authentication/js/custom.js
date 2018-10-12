function printErrorMsg (msg) {
    $(".print-error-msg").find("ul").html('');
    $(".print-error-msg").css('display','block');
    $.each( msg, function( key, value ) {
        $(".print-error-msg").find("ul").append('<li>'+value+'</li>');
    });
}

// Sortable Components + Groups

$(function  () {

    $( "#component-list" ).sortable({
        update:function(event, ui) {

            var result = [];
            var index = 0;

            $( "#component-list li" ).map(function(index) {
                var id = ($(this).data("id"));
                var position = index;
                result[index] = {'id': id, 'position': position};
                index++ ;
            })
            .get();
            var secure_token = $('#token').val();
            var formData = new FormData();
            var result_array = JSON.stringify(result);
            formData.append("results", result_array);
            formData.append("_token", secure_token);
            var request = new XMLHttpRequest();
            request.open("POST", "/admin/components-update");
            request.setRequestHeader("X-Requested-With", "XMLHttpRequest");
            request.send(formData);
            request.onreadystatechange=function(){
                if (request.readyState==4 && request.status==200){
                    var data = JSON.parse(request.responseText);
                    if($.isEmptyObject(data.error)){
                        if(data.warning){
                            toastr.warning(data.warning);
                        } else {
                            toastr.success(data.success);
                        }
                    }else{
                        toastr.warning(data.warning);
                    }
                }
            };
        }
    });
    $( "#component-list" ).disableSelection();


    $( "#component-group-list" ).sortable({
        update:function(event, ui) {

            var result = [];
            var index = 0;

            $( "#component-group-list li" ).map(function(index) {
                var id = ($(this).data("id"));
                var position = index;
                result[index] = {'id': id, 'position': position};
                index++ ;
            })
                .get();
            var secure_token = $('#token').val();
            var formData = new FormData();
            var result_array = JSON.stringify(result);
            formData.append("results", result_array);
            formData.append("_token", secure_token);
            var request = new XMLHttpRequest();
            request.open("POST", "/admin/components-groups-update");
            request.setRequestHeader("X-Requested-With", "XMLHttpRequest");
            request.send(formData);
            request.onreadystatechange=function(){
                if (request.readyState==4 && request.status==200){
                    var data = JSON.parse(request.responseText);
                    if($.isEmptyObject(data.error)){
                        if(data.warning){
                            toastr.warning(data.warning);
                        } else {
                            toastr.success(data.success);
                        }
                    }else{
                        toastr.warning(data.warning);
                    }
                }
            };
        }
    });
    $("#component-group-list").disableSelection();

    $( "#links-group-list" ).sortable({
        update:function(event, ui) {

            var result = [];
            var index = 0;

            $( "#links-group-list li" ).map(function(index) {
                var id = ($(this).data("id"));
                var position = index;
                result[index] = {'id': id, 'position': position};
                index++ ;
            })
                .get();
            var secure_token = $('#token').val();
            var formData = new FormData();
            var result_array = JSON.stringify(result);
            formData.append("results", result_array);
            formData.append("_token", secure_token);
            var request = new XMLHttpRequest();
            request.open("POST", "/admin/footer-links-update");
            request.setRequestHeader("X-Requested-With", "XMLHttpRequest");
            request.send(formData);
            request.onreadystatechange=function(){
                if (request.readyState==4 && request.status==200){
                    var data = JSON.parse(request.responseText);
                    if($.isEmptyObject(data.error)){
                        if(data.warning){
                            toastr.warning(data.warning);
                        } else {
                            toastr.success(data.success);
                        }
                    }else{
                        toastr.warning(data.warning);
                    }
                }
            };
        }
    });
    $("#links-group-list").disableSelection();

});

// Alocate ID
$(document).on("click", ".js--add-value-id", function () {
    get_the_id_value = $(this).data('id');
});

$(document).on("click", ".js--add-value-id-update-id-incident", function () {
    get_the_id_value = $(this).data('id');
    get_the_incident_id_value = $(this).data('incident-id');
});

// Components Groups

$(document).on("click", "#myModal-Component-Group-edit .close, #myModal-Component-Group-add .close, .js--close-modal-component-groups", function(e)
{
    $('#myModal-Component-Group-edit').remove();
    $('#myModal-Component-Group-add').remove();
    $('.modal-backdrop').remove();
    $('.sidebar-mini').removeClass('modal-open');

});


$(document).on("click", ".add-component-groups", function(e)
{
    e.preventDefault();

    $.ajax({
        type: "GET",
        url: "/admin/components/groups/new",
        dataType: 'html',
        success: function (view) {
            $('#myModal-Component-Group-edit').remove();
            if( $('#myModal-Component-Group-add').length > 0 )
            {
                $('#myModal-Component-Group-add').remove();
            }
            $('body').append(view);
            $('#myModal-Component-Group-add').modal('show');
        },
        error: function (data) {
            //Error message here
        }
    });

});


$("body").delegate('.add-component-groups-store', 'click',function(e){
    e.preventDefault();
    var formData = new FormData();

    var _token = $("input[name='_token']").val();
    var component_groups_name = $("input[name='component_groups_name']").val();
    var visibility_group = $("#visibility_group").val();
    var status = $("#status").val();

    formData.append("_token", _token);
    formData.append("component_groups_name", component_groups_name);
    formData.append("visibility_group",visibility_group);
    formData.append("status", status);

    var request = new XMLHttpRequest();
    request.open("POST", "/admin/components/groups/new");
    request.setRequestHeader("X-Requested-With", "XMLHttpRequest");
    request.send(formData);
    request.onreadystatechange=function(){
        if (request.readyState==4 && request.status==200){
            var data = JSON.parse(request.responseText);
            if($.isEmptyObject(data.error)){
                toastr.success(data.success);
                $('#myModal-Component-Group-add').modal('toggle');
                $('#myModal-Component-Group-add').remove();
                $('.modal-backdrop').remove();
                $('.sidebar-mini').removeClass('modal-open');
                var check_count_component_groups = data.check_count_component_groups;
                if(check_count_component_groups > 0){
                    $('.no-component-groups').removeClass('show').addClass('hide');
                }
                $("#component-group-list").append($('<li data-id="' + data.id + '" class="component-group component-group-' + data.id + '"><div class="sortable-button-left"><h4><i class="ion ion-drag"></i> <span class="component-group-name-' + data.id + '">' + data.component_groups_name + '</span></h4></div><div class="sortable-button-right"><a href="#" data-id="' + data.id + '" data-toggle="modal"  data-target="#myModal-Component-Group-edit" class="js--component-group-edit btn bg-navy btn-flat margin">Edit</a><a href="#" data-id="' + data.id + '" data-toggle="modal"  data-target="#myModal-Component-Group-delete" class="js--component-group-delete js--add-value-id btn bg-red btn-flat margin">Delete</a></div></li>'));


            }else{
                printErrorMsg(data.error);
                $("#myModal-Component-Group-add").scrollTop( 0 );
            }
        }
    }

});


$(document).on("click", ".js--component-group-edit", function(e){
    e.preventDefault();

    $.ajax({
        type: "GET",
        url: "/admin/components/groups/" + $(this).data('id') + "/edit",
        dataType: 'html',
        success: function (view) {
            $('#myModal-Component-Group-add').remove();
            $('#myModal-Component-Group-edit').remove();
            $('.modal-backdrop').remove();
            if( $('#myModal-Component-Group-edit').length > 0 )
            {
                $('#myModal-Component-Group-edit').remove();
            }
            $('body').append(view);
            $('#myModal-Component-Group-edit').modal('show');
        },
        error: function (data) {
            //Error message here
        }
    });

});

$("body").delegate('.js--ajax-form-component-groups-update', 'click',function(e){
    e.preventDefault();
    var formData = new FormData();
    var _token = $("input[name='_token']").val();
    var component_groups_name = $("input[name='component_groups_name']").val();
    var visibility_group = $("#visibility_group").val();
    var status = $("#status").val();

    formData.append("_token", _token);
    formData.append("component_groups_name", component_groups_name);
    formData.append("visibility_group", visibility_group);
    formData.append("status", status);
    var request = new XMLHttpRequest();
    request.open("POST", "/admin/components/groups/"  + $(this).data('id') +  "/update");
    request.setRequestHeader("X-Requested-With", "XMLHttpRequest");
    request.send(formData);

    request.onreadystatechange=function(){
        if (request.readyState==4 && request.status==200){
            var data = JSON.parse(request.responseText);
            if($.isEmptyObject(data.error)){
                if(status == 1){
                    $(".component-group-" + data.id).removeClass('div-disabled');
                } else {
                    $(".component-group-" + data.id).addClass('div-disabled');
                }
                $('.modal-backdrop').remove();
                $(".component-group-name-" + data.id).html(component_groups_name);
                $('#myModal-Component-Group-edit').modal('toggle');
                $('#myModal-Component-Group-edit').remove();
                $('.sidebar-mini').removeClass('modal-open');
                toastr.success(data.success);
            }else{
                printErrorMsg(data.error);
            }
        }
    }
});

$('#myModal-Component-Group-delete').on('click', '#confirm-delete', function() {
    $.ajax({
        type: 'get',
        url: "/admin/components/groups/"  + get_the_id_value +  "/delete",
        data: {
            '_token': $('input[name=_token]').val(),
            'id': get_the_id_value,
        },
        success: function(data) {
                    $(".component-group-" + get_the_id_value).remove();
                    var check_count_component_groups = data.check_count_component_groups;
                    if(check_count_component_groups == 0){
                        $('.no-component-groups').removeClass('hide').addClass('show');
                    }
                    $('#myModal-Component-Group-delete').modal('toggle');
                    $('#myModal-Component-Group-delete').hide();
                    toastr.success(data.success);
        },
        error: function (data) {
            var data2 = JSON.parse(data.responseText);
            $('#myModal-Component-Group-delete').modal('toggle');
            $('#myModal-Component-Group-delete').hide();
            toastr.warning(data2.warning);
        }
    });
});

// Components

$(document).on("click", "#myModal-Component-edit .close, #myModal-Component-add .close, .js--close-modal-component", function(e)
{
    $('#myModal-Component-edit').remove();
    $('#myModal-Component-add').remove();
    $('.modal-backdrop').remove();
    $('.sidebar-mini').removeClass('modal-open');
    $('#myModal-Component-edit').removeClass('fade');
    $('#myModal-Component-add').removeClass('fade');

});


$(document).on("click", ".add-component", function(e)
{
    e.preventDefault();

    $.ajax({
        type: "GET",
        url: "/admin/components/new",
        dataType: 'html',
        success: function (view) {
                if( $('#myModal-Component-add').length > 0 )
                {
                    $('#myModal-Component-add').remove();
                }
                $('body').append(view);
                $('#myModal-Component-add').modal('show');

        },
        error: function (data) {
            var data2 = JSON.parse(data.responseText);
            toastr.warning(data2.warning);
        }
    });

});


$("body").delegate('.add-component-store', 'click',function(e){
    e.preventDefault();
    var formData = new FormData();

    var _token = $("input[name='_token']").val();
    var component_name = $("input[name='component_name']").val();
    var component_groups_id = $("#component_groups_id").val();
    var component_statuses_id = $("#component_statuses_id").val();
    var component_description = $("#component_description").val();
    var status = $("#status").val();

    formData.append("_token", _token);
    formData.append("component_name", component_name);
    formData.append("component_groups_id",component_groups_id);
    formData.append("component_statuses_id",component_statuses_id);
    formData.append("component_description",component_description);
    formData.append("status", status);

    var request = new XMLHttpRequest();
    request.open("POST", "/admin/components/new");
    request.setRequestHeader("X-Requested-With", "XMLHttpRequest");
    request.send(formData);
    request.onreadystatechange=function(){
        if (request.readyState==4 && request.status==200){
            var data = JSON.parse(request.responseText);
            if($.isEmptyObject(data.error)){
                toastr.success(data.success);
                $('#myModal-Component-add').modal('toggle');
                $('#myModal-Component-add').remove();
                $('.modal-backdrop').remove();
                $('.sidebar-mini').removeClass('modal-open');
                if (data.status_data == 0){
                    var status_no = 'div-disabled';
                } else {
                    var status_no = '';
                }
                var check_count_components_list = data.check_count_components_list;
                if(check_count_components_list > 0){
                    $('.no-components').removeClass('show').addClass('hide');
                }
                $("#component-list").append($('<li data-id="' + data.id + '" class="components-list2 component-' + data.id  + ' ' + status_no +'"><div class="sortable-button-left"><h4><i class="ion ion-drag"></i> <span class="component-name-' + data.id + '">' + data.component_name + '</span></h4><span>Belong to the Group ' + data.component_group_name + '</span></div><div class="sortable-button-right"><a href="#" data-id="' + data.id + '" data-toggle="modal"  data-target="#myModal-Component-edit" class="js--component-edit btn bg-navy btn-flat margin">Edit</a><a href="#" data-id="' + data.id + '" data-toggle="modal"  data-target="#myModal-Component-delete" class="js--component-delete js--add-value-id btn bg-red btn-flat margin">Delete</a></div></li>'));


            }else{
                printErrorMsg(data.error);
                $("#myModal-Component-add").scrollTop( 0 );
            }
        }
    }

});

$(document).on("click", ".js--component-edit", function(e){
    e.preventDefault();

    $.ajax({
        type: "GET",
        url: "/admin/components/" + $(this).data('id') + "/edit",
        dataType: 'html',
        success: function (view) {
            $('#myModal-Component-edit').remove();
            $('.modal-backdrop').remove();
            if( $('#myModal-Component-edit').length > 0 )
            {
                $('#myModal-Component-edit').remove();
            }
            $('body').append(view);
            $('#myModal-Component-edit').modal('show');
        },
        error: function (data) {
            //Error message here
        }
    });

});

$("body").delegate('.js--ajax-form-component-update', 'click',function(e){
    e.preventDefault();
    var formData = new FormData();
    var _token = $("input[name='_token']").val();
    var component_name = $("input[name='component_name']").val();
    var component_groups_id = $("#component_groups_id").val();
    var component_statuses_id = $("#component_statuses_id").val();
    var component_description = $("#component_description").val();
    var status = $("#status").val();

    formData.append("_token", _token);
    formData.append("component_name", component_name);
    formData.append("component_groups_id",component_groups_id);
    formData.append("component_statuses_id",component_statuses_id);
    formData.append("component_description",component_description);
    formData.append("status", status);
    var request = new XMLHttpRequest();
    request.open("POST", "/admin/components/"  + $(this).data('id') +  "/update");
    request.setRequestHeader("X-Requested-With", "XMLHttpRequest");
    request.send(formData);

    request.onreadystatechange=function(){
        if (request.readyState==4 && request.status==200){
            var data = JSON.parse(request.responseText);
            if($.isEmptyObject(data.error)){
                if(status == 1){
                    $(".component-" + data.id).removeClass('div-disabled');
                } else {
                    $(".component-" + data.id).addClass('div-disabled');
                }
                $('.modal-backdrop').remove();
                $(".component-name-" + data.id).html(component_name);
                $(".component-group-name-belong-" + data.id).html(data.component_group_name);
                $('#myModal-Component-edit').modal('toggle');
                $('#myModal-Component-edit').remove();
                $('.modal-backdrop').remove();
                $('.sidebar-mini').removeClass('modal-open');
                toastr.success(data.success);
            }else{
                printErrorMsg(data.error);
            }
        }
    }
});

$('#myModal-Component-delete').on('click', '#confirm-delete', function() {
    $.ajax({
        type: 'get',
        url: "/admin/components/"  + get_the_id_value +  "/delete",
        data: {
            '_token': $('input[name=_token]').val(),
            'id': get_the_id_value,
        },
        success: function(data) {
                var check_count_components_list = data.check_count_components_list;
                if(check_count_components_list == 0){
                    $('.no-components').removeClass('hide').addClass('show');
                }
                $(".component-" + get_the_id_value).remove();
                $('#myModal-Component-delete').modal('toggle');
                $('#myModal-Component-delete').hide();
                toastr.success(data.success);
        },
        error: function (data) {
            var data2 = JSON.parse(data.responseText);
            $('#myModal-Component-delete').modal('toggle');
            $('#myModal-Component-delete').hide();
            toastr.warning(data2.warning);
        }
    });
});

// Incidents Template

$(document).on("click", "#myModalIncidentTemplate-add .close, #myModalIncidentTemplate-edit .close, .js--close-modal-incident-template", function(e)
{
    $('#myModalIncidentTemplate-edit').remove();
    $('#myModalIncidentTemplate-add').remove();
    $('.modal-backdrop').remove();
    $('.sidebar-mini').removeClass('modal-open');
    $('#myModalIncidentTemplate-add').removeClass('fade');
    $('#myModalIncidentTemplate-edit').removeClass('fade');

});

$(document).on("click", ".add-incident-template", function(e)
{
    e.preventDefault();

    $.ajax({
        type: "GET",
        url: "/admin/templates/new",
        dataType: 'html',
        success: function (view) {
            if( $('#myModalIncidentTemplate-add').length > 0 )
            {
                $('#myModalIncidentTemplate-add').remove();
            }
            $('body').append(view);
            $('#myModalIncidentTemplate-add').modal('show');
        },
        error: function (data) {
            //Error message here
        }
    });

});

$("body").delegate('.add-incident-template-store', 'click',function(e){
    e.preventDefault();
    var formData = new FormData();

    var _token = $("input[name='_token']").val();
    var incident_template_title = $("input[name='incident_template_title']").val();
    var incident_template_body = $("#incident_template_body").val();

    formData.append("_token", _token);
    formData.append("incident_template_title", incident_template_title);
    formData.append("incident_template_body",incident_template_body);

    var request = new XMLHttpRequest();
    request.open("POST", "/admin/templates/new");
    request.setRequestHeader("X-Requested-With", "XMLHttpRequest");
    request.send(formData);
    request.onreadystatechange=function(){
        if (request.readyState==4 && request.status==200){
            var data = JSON.parse(request.responseText);
            if($.isEmptyObject(data.error)){
                toastr.success(data.success);
                $('#myModalIncidentTemplate-add').modal('toggle');
                $('#myModalIncidentTemplate-add').remove();
                $('.modal-backdrop').remove();
                $('.sidebar-mini').removeClass('modal-open');
                var check_count_incident_templates = data.check_count_incident_templates;
                if(check_count_incident_templates > 0){
                    $('.no-templates').removeClass('show').addClass('hide');
                }
                var tr = '<tr id="templates-list" class="template-number-' + data.id +'">' +
                '<td width="2%"><div>' + data.id + '</div></td>' +
                '<td class="incident-template-title-'+ data.id +'" width="80%"><div>' + data.incident_template_title + '</div></td>' +
                '<td width="15%" class="center"><div>' +
                '<a href="#" data-id="' + data.id + '" data-toggle="modal"  data-target="#myModalIncidentTemplate-edit" class="js--incident-template-edit btn bg-navy btn-xs margin">Edit</a>' +
                '<a href="#" data-id="' + data.id + '" data-toggle="modal"  data-target="#myModalIncidentTemplate-delete" class="js--incident-template-delete js--add-value-id btn bg-red btn-xs margin">Delete</a>' +
                '</div></td>' +
                '</tr>';
                $('.top-table').after(tr);

            }else{
                printErrorMsg(data.error);
                $("#myModalIncidentTemplate-add").scrollTop( 0 );
            }
        }
    }

});

$(document).on("click", ".js--incident-template-edit", function(e){
    e.preventDefault();

    $.ajax({
        type: "GET",
        url: "/admin/templates/" + $(this).data('id') + "/edit",
        dataType: 'html',
        success: function (view) {
            $('#myModalIncidentTemplate-edit').remove();
            $('.modal-backdrop').remove();
            if( $('#myModalIncidentTemplate-edit').length > 0 )
            {
                $('#myModalIncidentTemplate-edit').remove();
            }
            $('body').append(view);
            $('#myModalIncidentTemplate-edit').modal('show');
        },
        error: function (data) {
            //Error message here
        }
    });

});

$("body").delegate('.js--ajax-form-incident-template-update', 'click',function(e){
    e.preventDefault();
    var formData = new FormData();
    var _token = $("input[name='_token']").val();
    var incident_template_title = $("input[name='incident_template_title']").val();
    var incident_template_body = $("#incident_template_body").val();

    formData.append("_token", _token);
    formData.append("incident_template_title", incident_template_title);
    formData.append("incident_template_body", incident_template_body);

    var request = new XMLHttpRequest();
    request.open("POST", "/admin/templates/"  + $(this).data('id') +  "/update");
    request.setRequestHeader("X-Requested-With", "XMLHttpRequest");
    request.send(formData);

    request.onreadystatechange=function(){
        if (request.readyState==4 && request.status==200){
            var data = JSON.parse(request.responseText);
            if($.isEmptyObject(data.error)){
                $('.modal-backdrop').remove();
                $(".incident-template-title-" + data.id).html(incident_template_title);
                $('#myModalIncidentTemplate-edit').modal('toggle');
                $('#myModalIncidentTemplate-edit').remove();
                $('.modal-backdrop').remove();
                $('.sidebar-mini').removeClass('modal-open');
                toastr.success(data.success);
            }else{
                printErrorMsg(data.error);
            }
        }
    }
});

$('#myModalIncidentTemplate-delete').on('click', '#confirm-delete', function() {
    $.ajax({
        type: 'get',
        url: "/admin/templates/"  + get_the_id_value +  "/delete",
        data: {
            '_token': $('input[name=_token]').val(),
            'id': get_the_id_value,
        },
        success: function(data) {
            if(data.success){
                var check_count_incident_templates = data.check_count_incident_templates;
                if(check_count_incident_templates == 0){
                    $('.no-templates').removeClass('hide').addClass('show');
                }
                $(".template-number-" + get_the_id_value).remove();
                $('#myModalIncidentTemplate-delete').modal('toggle');
                $('#myModalIncidentTemplate-delete').hide();
                toastr.success(data.success);
            } else {
                $('#myModalIncidentTemplate-delete').modal('toggle');
                $('#myModalIncidentTemplate-delete').hide();
                toastr.warning(data.warning);
            }
        }
    });
});

// Schedule

$(document).on("click", "#myModal-Schedule-edit .close, #myModal-Schedule-add .close, .js--close-modal-schedule", function(e)
{
    $('#myModal-Schedule-edit').remove();
    $('#myModal-Schedule-add').remove();
    $('.datetimepicker').remove();
    $('.modal-backdrop').remove();
    $('.sidebar-mini').removeClass('modal-open');

});


$(document).on("click", ".add-schedule", function(e)
{
    e.preventDefault();

    $.ajax({
        type: "GET",
        url: "/admin/schedule/new",
        dataType: 'html',
        success: function (view) {
            $('#myModal-Schedule-edit').remove();
            $('.datetimepicker').remove();
            if( $('#myModal-Schedule-add').length > 0 )
            {
                $('#myModal-Schedule-add').remove();
            }
            $('body').append(view);
            $('#myModal-Schedule-add').modal('show');
        },
        error: function (data) {
            var data2 = JSON.parse(data.responseText);
            toastr.warning(data2.warning);
        }
    });

});

//https://www.malot.fr/bootstrap-datetimepicker/demo.php

$("body").delegate('.add-schedule-store', 'click',function(e){
    e.preventDefault();
    var formData = new FormData();

    var _token = $("input[name='_token']").val();
    var scheduled_title = $("input[name='scheduled_title']").val();
    var components_id = $("#components_id").val();
    var scheduled_description = $("#scheduled_description").val();
    var scheduled_start = $("#scheduled_start").val();
    var scheduled_end = $("#scheduled_end").val();
    var archived = $("#archived").val();

    formData.append("_token", _token);
    formData.append("scheduled_title", scheduled_title);
    formData.append("components_id", components_id);
    formData.append("scheduled_description", scheduled_description);
    formData.append("scheduled_start", scheduled_start);
    formData.append("scheduled_end", scheduled_end);
    formData.append("archived", archived);

    var request = new XMLHttpRequest();
    request.open("POST", "/admin/schedule/new");
    request.setRequestHeader("X-Requested-With", "XMLHttpRequest");
    request.send(formData);
    request.onreadystatechange=function(){
        if (request.readyState==4 && request.status==200){
            var data = JSON.parse(request.responseText);
            if($.isEmptyObject(data.error)){
                toastr.success(data.success);
                $('#myModal-Schedule-add').modal('toggle');
                $('#myModal-Schedule-add').remove();
                $('.datetimepicker').remove();
                $('.modal-backdrop').remove();
                $('.sidebar-mini').removeClass('modal-open');
                if (data.archived == 1){
                    var archived = 'div-disabled';
                } else {
                    var archived = '';
                }
                $("#schedule-list li:eq(0)").before($('<li data-id="' + data.id + '" class="schedules-list2 schedule-' + data.id + ' ' + archived +'"><div class="sortable-button-left"><h4><span class="glyphicon glyphicon-cloud-download padding-right-20"></span> <span class="schedule-name-' + data.id + '"><strong>' + data.scheduled_title + '</strong>  <span class="scheduled_date_time">(from ' + scheduled_start + ' to ' + scheduled_end + ')</span></span></h4></div><div class="sortable-button-right"><a href="#" data-id="' + data.id + '" data-toggle="modal"  data-target="#myModal-Schedule-edit" class="js--schedule-edit btn bg-navy btn-flat btn-xs margin">Edit</a><a href="#" data-id="' + data.id + '" data-toggle="modal"  data-target="#myModal-Schedule-delete" class="js--schedule-delete js--add-value-id btn bg-red btn-flat btn-xs margin">Delete</a></div></li>'));
                var check_count_schedule = data.check_count_schedule;
                if(check_count_schedule > 0){
                    $('.no-schedule').removeClass('show').addClass('hide');
                }

            }else{
                printErrorMsg(data.error);
                $("#myModal-Schedule-add").scrollTop( 0 );
            }
        }
    }

});

$(document).on("click", ".js--schedule-edit", function(e){
    e.preventDefault();

    $.ajax({
        type: "GET",
        url: "/admin/schedule/" + $(this).data('id') + "/edit",
        dataType: 'html',
        success: function (view) {
            $('#myModal-schedule-edit').remove();
            $('.modal-backdrop').remove();
            if( $('#myModal-schedule-edit').length > 0 )
            {
                $('#myModal-schedule-edit').remove();
            }
            $('body').append(view);
            $('#myModal-schedule-edit').modal('show');
        },
        error: function (data) {
            toastr.warning(data.warning);
        }
    });

});

$("body").delegate('.add-schedule-update', 'click',function(e){
    e.preventDefault();
    var formData = new FormData();
    var _token = $("input[name='_token']").val();
    var scheduled_title = $("input[name='scheduled_title']").val();
    var components_id = $("#components_id").val();
    var scheduled_description = $("#scheduled_description").val();
    var scheduled_start = $("#scheduled_start").val();
    var scheduled_end = $("#scheduled_end").val();
    var archived = $("#archived").val();

    formData.append("_token", _token);
    formData.append("scheduled_title", scheduled_title);
    formData.append("components_id", components_id);
    formData.append("scheduled_description",scheduled_description);
    formData.append("scheduled_start",scheduled_start);
    formData.append("scheduled_end",scheduled_end);
    formData.append("archived", archived);
    var request = new XMLHttpRequest();
    request.open("POST", "/admin/schedule/"  + $(this).data('id') +  "/update");
    request.setRequestHeader("X-Requested-With", "XMLHttpRequest");
    request.send(formData);

    request.onreadystatechange=function(){
        if (request.readyState==4 && request.status==200){
            var data = JSON.parse(request.responseText);
            if($.isEmptyObject(data.error)){
                if(data.archived == 0){
                    $(".schedule-" + data.id).removeClass('div-disabled');
                } else {
                    $(".schedule-" + data.id).addClass('div-disabled');
                }
                $('.modal-backdrop').remove();
                $(".schedule-name-" + data.id).html('<strong>' + scheduled_title + '</strong><span class="scheduled_date_time"> (from ' + scheduled_start + ' to ' + scheduled_end +')</span>');
                $('#myModal-schedule-edit').modal('toggle');
                $('#myModal-schedule-edit').remove();
                $('.modal-backdrop').remove();
                $('.datetimepicker').remove();
                $('.sidebar-mini').removeClass('modal-open');
                toastr.success(data.success);
            }else{
                printErrorMsg(data.error);
            }
        }
    }
});

$('#myModal-Schedule-delete').on('click', '#confirm-delete', function() {
    $.ajax({
        type: 'get',
        url: "/admin/schedule/"  + get_the_id_value +  "/delete",
        data: {
            '_token': $('input[name=_token]').val(),
            'id': get_the_id_value,
        },
        success: function(data) {
            if(data.success){
                var check_count_schedule = data.check_count_schedule;
                if(check_count_schedule == 0){
                    $('.no-schedule').removeClass('hide').addClass('show');
                }
                $(".schedule-" + get_the_id_value).remove();
                $('#myModal-Schedule-delete').modal('toggle');
                $('#myModal-Schedule-delete').hide();
                toastr.success(data.success);
            } else {
                $('#myModal-Schedule-delete').modal('toggle');
                $('#myModal-Schedule-delete').hide();
                toastr.warning(data.warning);
            }
        },
        error: function (data) {
            toastr.warning(data.warning);
        }
    });
});

// Incidents

$(document).on("click", "#myModal-Incidents-add .close, #myModal-Incidents-edit .close, .js--close-modal-incident-add", function(e)
{
    $('#myModal-Incidents-add').remove();
    $('#myModal-Incidents-edit').remove();
    $('.modal-backdrop').remove();
    $('.sidebar-mini').removeClass('modal-open');
    $('#myModal-Incidents-add').removeClass('fade');
    $('#myModal-Incidents-edit').removeClass('fade');

});

$(document).on("click", ".add-incidents", function(e)
{
    e.preventDefault();

    $.ajax({
        type: "GET",
        url: "/admin/incidents/new",
        dataType: 'html',
        success: function (view) {
            if( $('#myModal-Incidents-add').length > 0 )
            {
                $('#myModal-Incidents-add').remove();
            }
            $('#myModal-Incidents-edit').remove();
            $('body').append(view);
            $('#myModal-Incidents-add').modal('show');
        },
        error: function (data) {
            var data2 = JSON.parse(data.responseText);
            toastr.warning(data2.warning);
        }
    });

});

$(document).on('change', '#incident_template_select',function(e){
    e.preventDefault();
    var incident_template_id = this.value;


    if(incident_template_id > 0) {

        var formData = {
            id: incident_template_id
        };
        $.ajax({
            type: "GET",
            url: "/admin/incidents/new/" + incident_template_id + "/template",
            dataType: 'json',
            data: formData,
            cache: false,
            success: function (data) {
                if (data.error) {
                    printErrorMsg(data.error);
                } else {
                    $('#incident_title').val(data.incident_template_title);
                    CKEDITOR.instances.incidents_description.setData(data.incident_template_body);
                }
            },
            error: function (data) {
                printErrorMsg(data.error);
                $("#myModal-Incidents-add").scrollTop(0);
            }
        });

    }

});

$("body").delegate('.add-incidents-store', 'click',function(e){
    e.preventDefault();
    var formData = new FormData();

    var _token = $("input[name='_token']").val();
    var incident_title = $("input[name='incident_title']").val();

    var components_id = $("#components_id").val();
    // var components_id = new Array();
    //
    // $('#components_id :selected').each(function(i, selected) {
    //     components_id[i] = $(selected).val();
    // });

    var incident_statuses_id = $("#incident_statuses_id").val();
    var component_statuses_id = $("#component_statuses_id").val();
    var incidents_status = $("#incidents_status").val();
    var incidents_description = $("#incidents_description").val();

    formData.append("_token", _token);
    formData.append("incident_title", incident_title);
    formData.append("components_id", components_id);
    formData.append("incident_statuses_id", incident_statuses_id);
    formData.append("component_statuses_id", component_statuses_id);
    formData.append("incidents_status", incidents_status);
    formData.append("incidents_description", incidents_description);

    var request = new XMLHttpRequest();
    request.open("POST", "/admin/incidents/new");
    request.setRequestHeader("X-Requested-With", "XMLHttpRequest");
    request.send(formData);
    request.onreadystatechange=function(){
        if (request.readyState==4 && request.status==200){
            var data = JSON.parse(request.responseText);
            if($.isEmptyObject(data.error)){
                toastr.success(data.success);
                $('#myModal-Incidents-add').modal('toggle');
                $('#myModal-Incidents-add').remove();
                $('.modal-backdrop').remove();
                $('.sidebar-mini').removeClass('modal-open');
                var incidents_count = data.incidents_count;
                if(incidents_count > 0){
                    $('.no-incidents-index').removeClass('show').addClass('hide');
                }

                var incident_status_cass = '';
                var incidents_status = '';

                switch (parseInt(data.incident_statuses_id)) {
                    case 1:
                       incident_status_cass = 'label-warning';
                        break;
                    case 2:
                        incident_status_cass = 'label-primary';
                        break;
                    case 3:
                        incident_status_cass = 'label-primary';
                        break;
                    case 4:
                        incident_status_cass = 'label-success';
                        break;
                    case 5:
                        incident_status_cass = 'label-primary';
                        break;
                }

                switch (parseInt(data.incidents_status)) {
                    case 0:
                        incidents_status = 'Hidden';
                        break;
                    case 1:
                        incidents_status = 'Published';
                        break;
                }


                var tr = '<tr id="incidents-list" class="incidents-number-' + data.id +'">' +
                    '<td class="center" width="5%"><div class="padding-10">' + data.id + '</div></td>' +
                    '<td class="incidents-title-'+ data.id +'" width="20%"><div class="padding-10">'+ data.incident_title +'</div></td>' +
                    '<td class="center incident-component-name" width="15%"><div class="padding-10">'+ data.component_name +'</div></td>' +
                    '<td class="center" width="15%"><div class="padding-10"><span class="label '+ incident_status_cass +'">'+ data.incident_status_name +'</span></div></td>' +
                    '<td class="center" width="10%"><div class="padding-10">'+ data.incident_date_update +'</div></td>' +
                    '<td class="center" width="10%"><div class="padding-10">'+ incidents_status +'</div></td>' +
                    '<td width="25%" class="center">' +
                    '<a href="/admin/incidents/' + data.id + '/update-index" class="btn btn-success btn-xs margin">Update Incident</a>' +
                    '<a href="#" data-id="' + data.id + '" data-toggle="modal"  data-target="#myModal-Incidents-view" class="js--incidents-view btn bg-purple btn-xs margin">View</a>' +
                    '<a href="#" data-id="' + data.id + '" data-toggle="modal"  data-target="#myModal-Incidents-edit" class="js--incidents-edit btn bg-navy btn-xs margin">Edit</a>' +
                    '<a href="#" data-id="' + data.id + '" data-toggle="modal"  data-target="#myModal-Incidents-delete" class="js--incidents-delete js--add-value-id btn bg-red btn-xs margin">Delete</a>' +
                    '</td>' +
                    '</tr>';
                $('.top-table').after(tr);

            }else{
                printErrorMsg(data.error);
                $("#myModal-Incidents-add").scrollTop( 0 );
            }
        }
    }

});

$(document).on("click", ".js--incidents-edit", function(e){
    e.preventDefault();

    $.ajax({
        type: "GET",
        url: "/admin/incidents/" + $(this).data('id') + "/edit",
        dataType: 'html',
        success: function (view) {
            $('#myModal-Incidents-edit').remove();
            $('.modal-backdrop').remove();
            if( $('#myModal-Incidents-edit').length > 0 )
            {
                $('#myModal-Incidents-add').remove();
                $('#myModal-Incidents-edit').remove();
            }
            $('#myModal-Incidents-add').remove();
            $('body').append(view);
            $('#myModal-Incidents-edit').modal('show');
        },
        error: function (data) {
            //Error message here
        }
    });

});

$("body").delegate('.add-incidents-update', 'click',function(e){
    e.preventDefault();
    var formData = new FormData();
    var _token = $("input[name='_token']").val();
    var incident_title = $("input[name='incident_title']").val();
    var components_id = $("#components_id").val();
    var incident_statuses_id = $("#incident_statuses_id").val();
    var component_statuses_id = $("#component_statuses_id").val();
    var incidents_status = $("#incidents_status").val();

    formData.append("_token", _token);
    formData.append("incident_title", incident_title);
    formData.append("components_id", components_id);
    formData.append("incident_statuses_id", incident_statuses_id);
    formData.append("component_statuses_id", component_statuses_id);
    formData.append("incidents_status", incidents_status);

    var request = new XMLHttpRequest();
    request.open("POST", "/admin/incidents/"  + $(this).data('id') +  "/update");
    request.setRequestHeader("X-Requested-With", "XMLHttpRequest");
    request.send(formData);

    request.onreadystatechange=function(){
        if (request.readyState==4 && request.status==200){
            var data = JSON.parse(request.responseText);
            if($.isEmptyObject(data.error)){
                $('.modal-backdrop').remove();

                var incident_status_cass = '';
                var incidents_status = '';


                switch (parseInt(data.incident_statuses_id)) {
                    case 1:
                        incident_status_cass = 'label-warning';
                        break;
                    case 2:
                        incident_status_cass = 'label-primary';
                        break;
                    case 3:
                        incident_status_cass = 'label-primary';
                        break;
                    case 4:
                        incident_status_cass = 'label-success';
                        break;
                    case 5:
                        incident_status_cass = 'label-primary';
                        break;
                }

                switch (parseInt(data.incidents_status)) {
                    case 0:
                        incidents_status = 'Hidden';
                        break;
                    case 1:
                        incidents_status = 'Published';
                        break;
                }

                var tr = '<tr id="incidents-list" class="incidents-number-' + data.id +'">' +
                    '<td class="center" width="5%"><div class="padding-10">' + data.id + '</div></td>' +
                    '<td class="incidents-title-'+ data.id +'" width="20%"><div class="padding-10">'+ data.incident_title +'</div></td>' +
                    '<td class="center incident-component-name" width="15%"><div class="padding-10">'+ data.component_name +'</div></td>' +
                    '<td class="center" width="15%"><div class="padding-10"><span class="label '+ incident_status_cass +'">'+ data.incident_status_name +'</span></div></td>' +
                    '<td class="center" width="10%"><div class="padding-10">'+ data.incident_date_update +'</div></td>' +
                    '<td class="center" width="10%"><div class="padding-10">'+ incidents_status +'</div></td>' +
                    '<td width="25%" class="center">' +
                    '<a href="/admin/incidents/' + data.id + '/update-index" class="btn btn-success btn-xs margin">Update Incident</a>' +
                    '<a href="#" data-id="' + data.id + '" data-toggle="modal"  data-target="#myModal-Incidents-view" class="js--incidents-view btn bg-purple btn-xs margin">View</a>' +
                    '<a href="#" data-id="' + data.id + '" data-toggle="modal"  data-target="#myModal-Incidents-edit" class="js--incidents-edit btn bg-navy btn-xs margin">Edit</a>' +
                    '<a href="#" data-id="' + data.id + '" data-toggle="modal"  data-target="#myModal-Incidents-delete" class="js--incidents-delete js--add-value-id btn bg-red btn-xs margin">Delete</a>' +
                    '</td>' +
                    '</tr>';
                $('.incidents-number-'+ data.id).replaceWith(tr);

                $('#myModal-Incidents-edit').modal('toggle');
                $('#myModal-Incidents-edit').remove();
                $('.modal-backdrop').remove();
                $('.datetimepicker').remove();
                $('.sidebar-mini').removeClass('modal-open');
                toastr.success(data.success);
            }else{
                printErrorMsg(data.error);
            }
        }
        if (request.readyState==4 && request.status==405){
            var data2 = JSON.parse(request.responseText);
            toastr.warning(data2.warning);
        }
    }
});

$('#myModal-Incidents-delete').on('click', '#confirm-delete', function() {
    $.ajax({
        type: 'get',
        url: "/admin/incidents/"  + get_the_id_value +  "/delete",
        data: {
            '_token': $('input[name=_token]').val(),
            'id': get_the_id_value,
        },
        success: function(data) {
            if(data.success){
                var check_count_incidents_list = data.check_count_incidents_list;
                if(check_count_incidents_list == 0){
                    $('.no-incidents-index').removeClass('hide').addClass('show');
                }
                $(".incidents-number-" + get_the_id_value).remove();
                $('#myModal-Incidents-delete').modal('toggle');
                $('#myModal-Incidents-delete').hide();
                toastr.success(data.success);
            } else {
                $('#myModal-Incidents-delete').modal('toggle');
                $('#myModal-Incidents-delete').hide();
                toastr.warning(data.warning);
            }
        }
    });
});

$(document).on("click", "#myModal-Incidents-view .close", function(e)
{
    $('#myModal-Incidents-view').remove();
    $('.modal-backdrop').remove();
    $('.sidebar-mini').removeClass('modal-open');
    $('#myModal-Incidents-edit').removeClass('fade');

});

$(document).on("click", ".js--incidents-view", function(e)
{
    e.preventDefault();

    $.ajax({
        type: "GET",
        url: "/admin/incidents/" + $(this).data('id') +  "/update-view",
        dataType: 'html',
        success: function (view) {
            $('#myModal-Incidents-edit').remove();
            $('.modal-backdrop').remove();
            if( $('#myModal-Incidents-view').length > 0 )
            {
                $('#myModal-Incidents-view').remove();
            }
            $('body').append(view);
            $('#myModal-Incidents-view').modal('show');
        },
        error: function (data) {
            //Error message here
        }
    });

});


$(document).on("click", "#myModal-Incidents-update-new .close, .js--close-modal-incident-updates", function(e)
{
    $('#myModal-Incidents-update-new').remove();
    $('.modal-backdrop').remove();
    $('.sidebar-mini').removeClass('modal-open');
    $('#myModal-Incidents-update-new').removeClass('fade');

});

$(document).on("click", ".add-incidents-update-new", function(e){
    e.preventDefault();

    $.ajax({
        type: "GET",
        url: "/admin/incidents/" + $(this).data('id') + "/update-create",
        dataType: 'html',
        success: function (view) {
            $('#myModal-Incidents-update-edit').remove();
            $('.modal-backdrop').remove();
            if( $('#myModal-Incidents-update-new').length > 0 )
            {
                $('#myModal-Incidents-update-new').remove();
            }
            $('body').append(view);
            $('#myModal-Incidents-update-new').modal('show');
        },
        error: function (view) {
            var data2 = JSON.parse(view.responseText);
            toastr.warning(data2.warning);
        }
    });

});

$("body").delegate('.add-incidents-update-new-store', 'click',function(e){
    e.preventDefault();
    var formData = new FormData();

    var _token = $("input[name='_token']").val();
    var incident_statuses_id = $("#incident_statuses_id").val();
    var component_statuses_id = $("#component_statuses_id").val();
    var incidents_status = $("#incidents_status").val();
    var incidents_description = $("#incidents_description").val();

    formData.append("_token", _token);
    formData.append("incident_statuses_id", incident_statuses_id);
    formData.append("component_statuses_id", component_statuses_id);
    formData.append("incidents_status", incidents_status);
    formData.append("incidents_description", incidents_description);

    var request = new XMLHttpRequest();
    request.open("POST", "/admin/incidents/"  + $(this).data('id') +  "/update-store");
    request.setRequestHeader("X-Requested-With", "XMLHttpRequest");
    request.send(formData);
    request.onreadystatechange=function(){
        if (request.readyState==4 && request.status==200){
            var data = JSON.parse(request.responseText);
            if($.isEmptyObject(data.error)){
                toastr.success(data.success);
                $('#myModal-Incidents-update-new').modal('toggle');
                $('#myModal-Incidents-update-new').remove();
                $('.modal-backdrop').remove();
                $('.sidebar-mini').removeClass('modal-open');

                var incident_status_cass = '';
                var status_incident_info = '';

                    switch (parseInt(data.component_statuses_id)) {
                        case 1:
                            $('.background-change-component').removeClass("bg-yellow").removeClass("bg-red").addClass("bg-green");
                            var progress_bar = '<div class="progress-bar progress-bar-component-status" style="width: 100%"></div>';
                            $(".progress-bar-component-status").replaceWith(progress_bar);
                            break;
                        case 2:
                            $('.background-change-component').removeClass("bg-green").removeClass("bg-red").addClass("bg-yellow");
                            var progress_bar = '<div class="progress-bar progress-bar-component-status" style="width: 75%"></div>';
                            $(".progress-bar-component-status").replaceWith(progress_bar);
                            break;
                        case 3:
                            $('.background-change-component').removeClass("bg-green").removeClass("bg-red").addClass("bg-yellow");
                            var progress_bar = '<div class="progress-bar progress-bar-component-status" style="width: 50%"></div>';
                            $(".progress-bar-component-status").replaceWith(progress_bar);
                            break;
                        case 4:
                            $('.background-change-component').removeClass("bg-yellow").removeClass("bg-green").addClass("bg-red");
                            var progress_bar = '<div class="progress-bar progress-bar-component-status" style="width: 25%"></div>';
                            $(".progress-bar-component-status").replaceWith(progress_bar);
                            break;
                    }


                    switch (parseInt(data.incident_statuses_id)) {
                        case 1:
                            incident_status_cass = 'label-warning';
                            $('.background-change-incident-status').removeClass("bg-green").removeClass("bg-blue").addClass("bg-yellow");
                            var progress_bar = '<div class="progress-bar progress-bar-tichet-status" style="width: 25%"></div>';
                            $(".progress-bar-tichet-status").replaceWith(progress_bar);
                            break;
                        case 2:
                            incident_status_cass = 'label-primary';
                            $('.background-change-incident-status').removeClass("bg-green").removeClass("bg-yellow").addClass("bg-blue");
                            var progress_bar = '<div class="progress-bar progress-bar-tichet-status" style="width: 50%"></div>';
                            $(".progress-bar-tichet-status").replaceWith(progress_bar);
                            break;
                        case 3:
                            incident_status_cass = 'label-primary';
                            $('.background-change-incident-status').removeClass("bg-yellow").removeClass("bg-green").addClass("bg-blue");
                            var progress_bar = '<div class="progress-bar progress-bar-tichet-status" style="width: 75%"></div>';
                            $(".progress-bar-tichet-status").replaceWith(progress_bar);
                            break;
                        case 4:
                            incident_status_cass = 'label-success';
                            $('.background-change-incident-status').removeClass("bg-yellow").removeClass("bg-blue").addClass("bg-green");
                            var progress_bar = '<div class="progress-bar progress-bar-tichet-status" style="width: 100%"></div>';
                            $(".progress-bar-tichet-status").replaceWith(progress_bar);
                            break;
                        case 5:
                            incident_status_cass = 'label-primary';
                            break;
                    }

                    var incident_name_changed = "Status: " + data.incident_status_name;
                    $(".incident-status-name").html(incident_name_changed);

                    var component_status_update = "Status: " + data.component_status_update;
                    $(".component-status-name").html(component_status_update);

                var tr = '<tr id="incidents-list" class="incidents-number-' + data.id +'">' +
                    '<td class="center" width="5%"><div class="padding-10">' + data.id +'</div></td>' +
                    '<td class="incidents-title-' + data.id +'" width="30%"><div class="padding-10">'+ data.incidents_description +'</div></td>' +
                    '<td class="center" width="15%"><div class="padding-10"><span class="label '+ incident_status_cass +'">'+ data.incident_status_name +'</span></div></td>' +
                    '<td class="center" width="10%"><div class="padding-10">'+ data.incident_date_update +'</div></td>' +
                    '<td width="15%" class="center">' +
                    '<a href="#" data-incident-id="' + data.incident_id +'" data-id="' + data.id +'" data-toggle="modal"  data-target="#myModal-Incidents-update-edit" class="js--incidents-update-edit btn bg-navy btn-xs margin">Edit</a>' +
                    '<a href="#" data-incident-id="' + data.incident_id +'" data-id="' + data.id +'" data-toggle="modal"  data-target="#myModal-Incidents-update-delete" class="js--incidents-update-delete js--add-value-id-update-id-incident btn bg-red btn-xs margin">Delete</a>' +
                    '</td>' +
                    '</tr>';
                $('.top-table').after(tr);

            }else{
                printErrorMsg(data.error);
                $("#myModal-Incidents-update-new").scrollTop( 0 );
            }
        }
        if (request.readyState==4 && request.status==405){
            var data2 = JSON.parse(request.responseText);
            toastr.warning(data2.warning);
        }
    }


});

$(document).on("click", "#myModal-Incidents-update-new .close, #myModal-Incidents-update-edit .close, .js--close-modal-incident-updates ", function(e)
{
    $('#myModal-Incidents-update-edit').remove();
    $('#myModal-Incidents-update-new').remove();
    $('.modal-backdrop').remove();
    $('.sidebar-mini').removeClass('modal-open');
    $('#myModal-Incidents-update-new').removeClass('fade');
    $('#myModal-Incidents-update-edit').removeClass('fade');

});

$(document).on("click", ".js--incidents-update-edit", function(e){
    e.preventDefault();

    $.ajax({
        type: "GET",
        url: "/admin/incidents/" + $(this).data('incident-id') +"/update-index/" + $(this).data('id') + "/edit",
        dataType: 'html',
        success: function (view) {
            $('#myModal-Incidents-update-edit').remove();
            $('.modal-backdrop').remove();
            if( $('#myModal-Incidents-update-edit').length > 0 )
            {
                $('#myModal-Incidents-update-add').remove();
                $('#myModal-Incidents-update-edit').remove();
            }
            $('#myModal-Incidents-update-add').remove();
            $('body').append(view);
            $('#myModal-Incidents-update-edit').modal('show');
        },
        error: function (view) {
            var data2 = JSON.parse(view.responseText);
            toastr.warning(data2.warning);
        }
    });

});

$("body").delegate('.add-incidents-update-edit-update', 'click',function(e){
    e.preventDefault();
    var formData = new FormData();

    var _token = $("input[name='_token']").val();
    var incident_statuses_id = $("#incident_statuses_id").val();
    var component_statuses_id = $("#component_statuses_id").val();
    var incidents_status = $("#incidents_status").val();
    var incidents_description = $("#incidents_description").val();

    formData.append("_token", _token);
    formData.append("incident_statuses_id", incident_statuses_id);
    formData.append("component_statuses_id", component_statuses_id);
    formData.append("incidents_status", incidents_status);
    formData.append("incidents_description", incidents_description);

    var request = new XMLHttpRequest();
    request.open("POST", "/admin/incidents/" + $(this).data('incident-id') +"/update-index/" + $(this).data('id') + "/update");
    request.setRequestHeader("X-Requested-With", "XMLHttpRequest");
    request.send(formData);
    request.onreadystatechange=function(){
        if (request.readyState==4 && request.status==200){
            var data = JSON.parse(request.responseText);
            if($.isEmptyObject(data.error)){
                toastr.success(data.success);
                $('#myModal-Incidents-update-edit').modal('toggle');
                $('#myModal-Incidents-update-edit').remove();
                $('.modal-backdrop').remove();
                $('.sidebar-mini').removeClass('modal-open');

                var incident_status_cass = '';
                var progress_bar = '';

                if(data.last_id_incident_updated == 1) {

                switch (parseInt(data.component_statuses_id)) {
                    case 1:
                        $('.background-change-component').removeClass("bg-yellow").removeClass("bg-red").addClass("bg-green");
                        var progress_bar = '<div class="progress-bar progress-bar-component-status" style="width: 100%"></div>';
                        $(".progress-bar-component-status").replaceWith(progress_bar);
                        break;
                    case 2:
                        $('.background-change-component').removeClass("bg-green").removeClass("bg-red").addClass("bg-yellow");
                        var progress_bar = '<div class="progress-bar progress-bar-component-status" style="width: 75%"></div>';
                        $(".progress-bar-component-status").replaceWith(progress_bar);
                        break;
                    case 3:
                        $('.background-change-component').removeClass("bg-green").removeClass("bg-red").addClass("bg-yellow");
                        var progress_bar = '<div class="progress-bar progress-bar-component-status" style="width: 50%"></div>';
                        $(".progress-bar-component-status").replaceWith(progress_bar);
                        break;
                    case 4:
                        $('.background-change-component').removeClass("bg-yellow").removeClass("bg-green").addClass("bg-red");
                        var progress_bar = '<div class="progress-bar progress-bar-component-status" style="width: 25%"></div>';
                        $(".progress-bar-component-status").replaceWith(progress_bar);
                        break;
                }


                switch (parseInt(data.incident_statuses_id)) {
                    case 1:
                        incident_status_cass = 'label-warning';
                        $('.background-change-incident-status').removeClass("bg-green").removeClass("bg-blue").addClass("bg-yellow");
                        var progress_bar = '<div class="progress-bar progress-bar-tichet-status" style="width: 25%"></div>';
                        $(".progress-bar-tichet-status").replaceWith(progress_bar);
                        break;
                    case 2:
                        incident_status_cass = 'label-primary';
                        $('.background-change-incident-status').removeClass("bg-green").removeClass("bg-yellow").addClass("bg-blue");
                        var progress_bar = '<div class="progress-bar progress-bar-tichet-status" style="width: 50%"></div>';
                        $(".progress-bar-tichet-status").replaceWith(progress_bar);
                        break;
                    case 3:
                        incident_status_cass = 'label-primary';
                        $('.background-change-incident-status').removeClass("bg-yellow").removeClass("bg-green").addClass("bg-blue");
                        var progress_bar = '<div class="progress-bar progress-bar-tichet-status" style="width: 75%"></div>';
                        $(".progress-bar-tichet-status").replaceWith(progress_bar);
                        break;
                    case 4:
                        incident_status_cass = 'label-success';
                        $('.background-change-incident-status').removeClass("bg-yellow").removeClass("bg-blue").addClass("bg-green");
                        var progress_bar = '<div class="progress-bar progress-bar-tichet-status" style="width: 100%"></div>';
                        $(".progress-bar-tichet-status").replaceWith(progress_bar);
                        break;
                    case 5:
                        $('.background-change-incident-status').removeClass("bg-yellow").removeClass("bg-blue").removeClass("bg-green").addClass(data.last_incident_status);
                        incident_status_cass = 'label-primary';
                        var progress_bar = '<div class="progress-bar progress-bar-tichet-status" style="width: ' + data.last_incident_status_progress +' "></div>';
                        $(".progress-bar-tichet-status").replaceWith(progress_bar);
                        break;
                }

                var incident_name_changed = "Status: "+ data.incident_status_name;
                $(".incident-status-name").html(incident_name_changed);

                var component_status_update = "Status: "+ data.component_status_update;
                $(".component-status-name").html(component_status_update);

            } else {

                switch (parseInt(data.incident_statuses_id)) {
                    case 1:
                        incident_status_cass = 'label-warning';
                        break;
                    case 2:
                        incident_status_cass = 'label-primary';
                        break;
                    case 3:
                        incident_status_cass = 'label-primary';
                        break;
                    case 4:
                        incident_status_cass = 'label-success';
                        break;
                    case 5:
                        incident_status_cass = 'label-primary';
                        break;
                }

            }

                var tr = '<tr id="incidents-list" class="incidents-number-' + data.id +'">' +
                    '<td class="center" width="5%"><div class="padding-10">' + data.id +'</div></td>' +
                    '<td class="incidents-title-' + data.id +'" width="30%"><div class="padding-10">'+ data.incidents_description +'</div></td>' +
                    '<td class="center" width="15%"><div class="padding-10"><span class="label '+ incident_status_cass +'">'+ data.incident_status_name +'</span></div></td>' +
                    '<td class="center" width="10%"><div class="padding-10">'+ data.incident_date_update +'</div></td>' +
                    '<td width="15%" class="center">' +
                    '<a href="#" data-incident-id="' + data.incident_id +'" data-id="' + data.id +'" data-toggle="modal"  data-target="#myModal-Incidents-update-edit" class="js--incidents-update-edit btn bg-navy btn-xs margin">Edit</a>' +
                    '<a href="#" data-incident-id="' + data.incident_id +'" data-id="' + data.id +'" data-toggle="modal"  data-target="#myModal-Incidents-update-delete" class="js--incidents-update-delete js--add-value-id-update-id-incident btn bg-red btn-xs margin">Delete</a>' +
                    '</td>' +
                    '</tr>';
                $('.incidents-number-'+ data.id).replaceWith(tr);


            }else{
                printErrorMsg(data.error);
                $("#myModal-Incidents-update-edit").scrollTop( 0 );
            }
        }
        if (request.readyState==4 && request.status==405){
            var data2 = JSON.parse(request.responseText);
            toastr.warning(data2.warning);
        }
    }

});

$('#myModal-Incidents-update-delete').on('click', '#confirm-delete', function() {
    $.ajax({
        type: 'get',
        url: "/admin/incidents/" + get_the_incident_id_value + "/update-index/" + get_the_id_value  +"/delete",
        data: {
            '_token': $('input[name=_token]').val(),
            'id': get_the_id_value,
            'incident-id': get_the_incident_id_value
        },
        success: function(data) {
            if(data.success){
                $(".incidents-number-" + get_the_id_value).remove();

                $.ajax({
                    type: 'get',
                    url: "/admin/incidents/" + get_the_incident_id_value + "/update-index/" + get_the_id_value  +"/delete-recheck",
                    data: {
                        '_token': $('input[name=_token]').val(),
                        'id': get_the_id_value,
                        'incident-id': get_the_incident_id_value
                    },
                    success: function(view) {
                        if(data.success){
                            var incident_status_cass = '';
                            var progress_bar = '';

                            switch (parseInt(view.component_statuses_id)) {
                                case 1:
                                    $('.background-change-component').removeClass("bg-yellow").removeClass("bg-red").addClass("bg-green");
                                    var progress_bar = '<div class="progress-bar progress-bar-component-status" style="width: 100%"></div>';
                                    $(".progress-bar-component-status").replaceWith(progress_bar);
                                    break;
                                case 2:
                                    $('.background-change-component').removeClass("bg-green").removeClass("bg-red").addClass("bg-yellow");
                                    var progress_bar = '<div class="progress-bar progress-bar-component-status" style="width: 75%"></div>';
                                    $(".progress-bar-component-status").replaceWith(progress_bar);
                                    break;
                                case 3:
                                    $('.background-change-component').removeClass("bg-green").removeClass("bg-red").addClass("bg-yellow");
                                    var progress_bar = '<div class="progress-bar progress-bar-component-status" style="width: 50%"></div>';
                                    $(".progress-bar-component-status").replaceWith(progress_bar);
                                    break;
                                case 4:
                                    $('.background-change-component').removeClass("bg-yellow").removeClass("bg-green").addClass("bg-red");
                                    var progress_bar = '<div class="progress-bar progress-bar-component-status" style="width: 25%"></div>';
                                    $(".progress-bar-component-status").replaceWith(progress_bar);
                                    break;
                            }


                            switch (parseInt(view.incident_statuses_id)) {
                                case 1:
                                    incident_status_cass = 'label-warning';
                                    $('.background-change-incident-status').removeClass("bg-green").removeClass("bg-blue").addClass("bg-yellow");
                                    var progress_bar = '<div class="progress-bar progress-bar-tichet-status" style="width: 25%"></div>';
                                    $(".progress-bar-tichet-status").replaceWith(progress_bar);

                                    break;
                                case 2:
                                    incident_status_cass = 'label-primary';
                                    $('.background-change-incident-status').removeClass("bg-green").removeClass("bg-blue").addClass("bg-yellow");
                                    var progress_bar = '<div class="progress-bar progress-bar-tichet-status" style="width: 50%"></div>';
                                    $(".progress-bar-tichet-status").replaceWith(progress_bar);
                                    break;
                                case 3:
                                    incident_status_cass = 'label-primary';
                                    $('.background-change-incident-status').removeClass("bg-yellow").removeClass("bg-green").addClass("bg-blue");
                                    var progress_bar = '<div class="progress-bar progress-bar-tichet-status" style="width: 75%"></div>';
                                    $(".progress-bar-tichet-status").replaceWith(progress_bar);
                                    break;
                                case 4:
                                    incident_status_cass = 'label-success';
                                    $('.background-change-incident-status').removeClass("bg-yellow").removeClass("bg-blue").addClass("bg-green");
                                    var progress_bar = '<div class="progress-bar progress-bar-tichet-status" style="width: 100%"></div>';
                                    $(".progress-bar-tichet-status").replaceWith(progress_bar);
                                    break;
                                case 5:
                                    $('.background-change-incident-status').removeClass("bg-yellow").removeClass("bg-blue").removeClass("bg-green").addClass(view.last_incident_status);
                                    incident_status_cass = 'label-primary';
                                    var progress_bar = '<div class="progress-bar progress-bar-tichet-status" style="width: ' + view.last_incident_status_progress +' "></div>';
                                    $(".progress-bar-tichet-status").replaceWith(progress_bar);
                                    break;
                            }


                            var incident_name_changed = "Status: "+ view.incident_status_name;
                            $(".incident-status-name").html(incident_name_changed);

                            var component_status_update = "Status: "+ view.component_status_update;
                            $(".component-status-name").html(component_status_update);
                        } else {
                        }
                    }
                });

                $('#myModal-Incidents-update-delete').modal('toggle');
                $('#myModal-Incidents-update-delete').hide();
                toastr.success(data.success);
            } else {
                $('#myModal-Incidents-update-delete').modal('toggle');
                $('#myModal-Incidents-update-delete').hide();
                toastr.warning(data.warning);
            }
        }
    });
});

// Users

$(document).on("click", "#myModal-Users-add .close, #myModal-Users-edit .close, .js--close-modal-users-edit, .js--close-modal-users-add", function(e)
{
    $('#myModal-Users-edit').remove();
    $('#myModal-Users-add').remove();
    $('.modal-backdrop').remove();
    $('.sidebar-mini').removeClass('modal-open');
    $('#myModal-Users-edit').removeClass('fade');
    $('#myModal-Users-add').removeClass('fade');

});

$(document).on("click", ".add-users", function(e)
{
    e.preventDefault();

    $.ajax({
        type: "GET",
        url: "/admin/users/new",
        dataType: 'html',
        success: function (view) {
            if( $('#myModal-Users-add').length > 0 )
            {
                $('#myModal-Users-add').remove();
            }
            $('#myModal-Users-edit').remove();
            $('body').append(view);
            $('#myModal-Users-add').modal('show');
        },
        error: function (data) {
            var data2 = JSON.parse(data.responseText);
            toastr.warning(data2.warning);
        }
    });

});

$("body").delegate('.add-users-store', 'click',function(e){
    e.preventDefault();
    var formData = new FormData();

    var _token = $("input[name='_token']").val();
    var name = $("#users-full-name").val();
    var email = $("#users-email").val();
    var password = $("#users-password").val();
    var confirm_password = $("#users-confirm-password").val();
    var level = $("#level").val();

    formData.append("_token", _token);
    formData.append("name", name);
    formData.append("email", email);
    formData.append("password", password);
    formData.append("confirm_password", confirm_password);
    formData.append("level", level);

    var request = new XMLHttpRequest();
    request.open("POST", "/admin/users/new");
    request.setRequestHeader("X-Requested-With", "XMLHttpRequest");
    request.send(formData);
    request.onreadystatechange=function(){
        if (request.readyState==4 && request.status==200){
            var data = JSON.parse(request.responseText);
            if($.isEmptyObject(data.error)){
                toastr.success(data.success);
                $('#myModal-Users-add').modal('toggle');
                $('#myModal-Users-add').remove();
                $('.modal-backdrop').remove();
                $('.sidebar-mini').removeClass('modal-open');

                var tr =  '<tr id="users-list" class="users-number-' + data.id +'">' +
                    '<td class="center" width="5%"><div class="padding-10">' + data.id +'</div></td>' +
                    '<td class="users-name-' + data.id +'" width="20%"><div class="padding-10">' + data.name +'</div></td>' +
                    '<td class="center users-email" width="15%"><div class="padding-10">' + data.email +'</div></td>' +
                    '<td class="center users-level" width="10%"><div class="padding-10">' + data.level +'</div></td>' +
                    '<td width="25%" class="center">' +
                    '<a href="#" data-id="' + data.id +'" data-toggle="modal"  data-target="#myModal-Users-edit" class="js--users-edit btn bg-navy btn-xs margin">Edit</a>' +
                    '<a href="#" data-id="' + data.id +'" data-toggle="modal"  data-target="#myModal-Users-delete" class="js--users-delete js--add-value-id btn bg-red btn-xs margin">Delete</a>' +
                    '</td>' +
                    '</tr>';
                $('.top-table').after(tr);

            }else{
                printErrorMsg(data.error);
                $("#myModal-Incidents-add").scrollTop( 0 );
            }
        }
    }

});

$(document).on("click", ".js--users-edit", function(e){
    e.preventDefault();

    $.ajax({
        type: "GET",
        url: "/admin/users/" + $(this).data('id') + "/edit",
        dataType: 'html',
        success: function (view) {
            $('#myModal-Users-edit').remove();
            $('.modal-backdrop').remove();
            if( $('#myModal-Users-edit').length > 0 )
            {
                $('#myModal-Users-add').remove();
                $('#myModal-Users-edit').remove();
            }
            $('#myModal-Users-add').remove();
            $('body').append(view);
            $('#myModal-Users-edit').modal('show');
        },
        error: function (data) {
            var data2 = JSON.parse(data.responseText);
            toastr.warning(data2.warning);
        }
    });

});

$("body").delegate('.add-users-update', 'click',function(e){
    e.preventDefault();
    var formData = new FormData();

    var _token = $("input[name='_token']").val();
    var name = $("#users-full-name").val();
    var email = $("#users-email").val();
    var password = $("#users-password").val();
    var confirm_password = $("#users-confirm-password").val();
    var level = $("#level").val();

    formData.append("_token", _token);
    formData.append("name", name);
    formData.append("email", email);
    formData.append("password", password);
    formData.append("confirm_password", confirm_password);
    formData.append("level", level);

    var request = new XMLHttpRequest();
    request.open("POST", "/admin/users/" + $(this).data('id') + "/edit");
    request.setRequestHeader("X-Requested-With", "XMLHttpRequest");
    request.send(formData);
    request.onreadystatechange=function(){
        if (request.readyState==4 && request.status==200){
            var data = JSON.parse(request.responseText);
            if($.isEmptyObject(data.error)){
                $('#myModal-Users-edit').modal('toggle');
                $('#myModal-Users-edit').remove();
                $('.modal-backdrop').remove();
                $('.sidebar-mini').removeClass('modal-open');
                var tr =  '<tr id="users-list" class="users-number-' + data.id +'">' +
                    '<td class="center" width="5%"><div class="padding-10">' + data.id +'</div></td>' +
                    '<td class="users-name-' + data.id +'" width="20%"><div class="padding-10">' + data.name +'</div></td>' +
                    '<td class="center users-email" width="15%"><div class="padding-10">' + data.email +'</div></td>' +
                    '<td class="center users-level" width="10%"><div class="padding-10">' + data.level +'</div></td>' +
                    '<td width="25%" class="center">' +
                    '<a href="#" data-id="' + data.id +'" data-toggle="modal"  data-target="#myModal-Users-edit" class="js--users-edit btn bg-navy btn-xs margin">Edit</a>' +
                    '<a href="#" data-id="' + data.id +'" data-toggle="modal"  data-target="#myModal-Users-delete" class="js--users-delete js--add-value-id btn bg-red btn-xs margin">Delete</a>' +
                    '</td>' +
                    '</tr>';
                $('.users-number-'+ data.id).replaceWith(tr);
                toastr.success(data.success);
            }else{
                printErrorMsg(data.error);
                $("#myModal-Incidents-Edit").scrollTop( 0 );
            }
        }
    }

});

$('#myModal-Users-delete').on('click', '#confirm-delete', function() {
    $.ajax({
        type: 'get',
        url: "/admin/users/"+ get_the_id_value  +"/delete",
        data: {
            '_token': $('input[name=_token]').val(),
            'id': get_the_id_value
        },

        success: function(data) {
            if(data.success){
                $(".users-number-" + get_the_id_value).remove();
                $('#myModal-Users-delete').modal('toggle');
                $('#myModal-Users-delete').hide();
                toastr.success(data.success);
            } else {
                $('#myModal-Users-delete').modal('toggle');
                $('#myModal-Users-delete').hide();
                toastr.warning(data.warning);
            }
        },
        error: function (data) {
            $('#myModal-Users-delete').modal('toggle');
            $('#myModal-Users-delete').hide();
            var data2 = JSON.parse(data.responseText);
            toastr.warning(data2.warning);
        }
    });
});

// Settings

$(document).on("click", "#myModal-Settings-edit .close, .js--close-settings-update", function(e)
{
    $('#myModal-Users-edit').remove();
    $('#myModal-Users-add').remove();
    $('.modal-backdrop').remove();
    $('.sidebar-mini').removeClass('modal-open');
    $('#myModal-Users-edit').removeClass('fade');
    $('#myModal-Users-add').removeClass('fade');

});

$(document).on("click", ".js--settings-edit", function(e){
    e.preventDefault();
    $.ajax({
        type: "GET",
        url: "/admin/settings/edit",
        dataType: 'html',
        success: function (view) {
            $('#myModal-Settings-edit').remove();
            $('.modal-backdrop').remove();
            $('body').append(view);
            $('#myModal-Settings-edit').modal('show');
        },
        error: function (data) {
            var data2 = JSON.parse(data.responseText);
            toastr.warning(data2.warning);
        }
    });

});

$(document).on("click", "#settings-remove-logo", function(e){
    var img =    '<!-- ko stopBinding: true -->' +
    '<div id="settings-logo" class="well settings-logo" data-bind="fileDrag: fileData">' +
    '<div class="form-group row">' +
    '<div class="col-md-6">' +
    '<img style="height: 125px;" class="img-rounded thumb" data-bind="attr: { src: fileData().dataURL }, visible: fileData().dataURL">' +
    '<div data-bind="ifnot: fileData().dataURL">' +
    '<label class="drag-label">Drag file here</label>' +
    '</div>' +
    '</div>' +
    '<div class="col-md-6">' +
    '<input name="settings_logo" id="settings_logo" type="file" data-bind="{"fileInput: fileData, customFileInput: { buttonClass: "btn btn-success", fileNameClass: "disabled form-control", onClear: onClear, }"}" accept="image/*">"' +
    '</div>' +
    '</div>' +
    '</div>' +
    '<!-- /ko -->';
    $('#settings-logo').replaceWith(img);

    if($('#settings_logo')[0] !== undefined){
        <!-- ko template: 'someTemplate' -->
        var element = $('#settings_logo')[0];
        ko.cleanNode(element);
        var viewModel = {};
        viewModel.fileData = ko.observable({
            dataURL: ko.observable()
        });
        viewModel.onClear = function(fileData){
            if(confirm('Are you sure?')){
                fileData.clear && fileData.clear();
            }
        };
        ko.applyBindings(viewModel, document.getElementById('settings-logo'));
        <!-- /ko -->
    }
});

$("body").delegate('.settings-update', 'click',function(e){
    e.preventDefault();
    var formData = new FormData();

    var _token = $("input[name='_token']").val();
    var time_zone_interface = $("#time-zone-interface").val();
    var title_app = $("#title-app").val();
    if($('.custom-file-input-file-name').val()) {
        var settings_logo = $("input[name='settings_logo']").first()[0].files[0];
    }
    var days_of_incidents = $("#days-of-incidents").val();
    var bulk_emails = $("#bulk_emails").val();
    var bulk_emails_sleep = $("#bulk_emails_sleep").val();
    var queue_name_incidents = $("#queue_name_incidents").val();
    var queue_name_maintenance = $("#queue_name_maintenance").val();
    var from_address = $("#from_address").val();
    var from_name = $("#from_name").val();
    var google_analytics_code = $("#google-analytics-code").val();
    var allow_subscribers = $("#allow-subscribers").val();

    formData.append("_token", _token);
    formData.append("time_zone_interface", time_zone_interface);
    formData.append("title_app", title_app);
    formData.append("settings_logo", settings_logo);
    formData.append("days_of_incidents", days_of_incidents);
    formData.append("bulk_emails", bulk_emails);
    formData.append("bulk_emails_sleep", bulk_emails_sleep);
    formData.append("queue_name_incidents", queue_name_incidents);
    formData.append("queue_name_maintenance", queue_name_maintenance);
    formData.append("from_address", from_address);
    formData.append("from_name", from_name);
    formData.append("google_analytics_code", google_analytics_code);
    formData.append("allow_subscribers", allow_subscribers);

    var request = new XMLHttpRequest();
    request.open("POST", "/admin/settings/edit");
    request.setRequestHeader("X-Requested-With", "XMLHttpRequest");
    request.send(formData);
    request.onreadystatechange=function(){
        if (request.readyState==4 && request.status==200){
            var data = JSON.parse(request.responseText);
            if($.isEmptyObject(data.error)){
                $('#myModal-Settings-edit').modal('toggle');
                $('#myModal-Settings-edit').remove();
                $('.modal-backdrop').remove();
                $('.sidebar-mini').removeClass('modal-open');

                console.log(data.google_code);

                if(data.google_code == null){
                    var google_code = "None"
                } else {
                    var google_code = data.google_code;
                }


                if(data.allow_signup == 0){
                    var allow_signup = "No";
                } else {
                    var allow_signup = "Yes";
                }

                var replace_settings = '<div class="box-body box-profile">' +
                '<div class="image-logo"><img src="/images/' + data.logo +'" alt="' + data.site_name +'"></div>' +
                '<br />' +
                '<ul class="list-group list-group-unbordered">' +
                '<li class="list-group-item">' +
                '<b>Site Name</b> <a class="pull-right">' + data.site_name +'</a>' +
                '</li>' +
                '<li class="list-group-item">' +
                '<b>Site Timezone</b> <a class="pull-right">' + data.site_timezone +'</a>' +
                '</li>' +
                '<li class="list-group-item">' +
                '<b>Days of Incidents to show</b> <a class="pull-right">' + data.days_of_incident +'</a>' +
                '</li>' +
                 '<li class="list-group-item">' +
                 '<b>Number of the Emails in a bulk</b> <a class="pull-right">' + data.bulk_emails +'</a>' +
                 '</li>' +
                 '<li class="list-group-item">' +
                 '<b>Job Sleep after sent a Bulk Email</b> <a class="pull-right">' + data.bulk_emails_sleep +'</a>' +
                 '</li>' +
                 '<li class="list-group-item">' +
                 '<b>Queue Name for Incidents</b> <a class="pull-right">' + data.queue_name_incidents +'</a>' +
                 '</li>' +
                 '<li class="list-group-item">' +
                 '<b>Queue Name for Maintenance</b> <a class="pull-right">' + data.queue_name_maintenance +'</a>' +
                 '</li>' +
                 '<li class="list-group-item">' +
                 '<b>(Email) From Address</b> <a class="pull-right">' + data.from_address +'</a>' +
                 '</li>' +
                 '<li class="list-group-item">' +
                 '<b>(Email)From Name</b> <a class="pull-right">' + data.from_name +'</a>' +
                 '</li>' +
                '<li class="list-group-item">' +
                '<b>Google Analytics code</b> <a class="pull-right">' + google_code +'</a>' +
                '</li>' +
                '<li class="list-group-item">' +
                '<b>Site Language</b> <a class="pull-right">English</a>' +
                '</li>' +
                '<li class="list-group-item">' +
                '<b>Allow people to signup to email notifications?</b> <a class="pull-right">' + allow_signup + '</a>' +
                '</li>' +
                '</ul>' +
                '<a href="#" data-toggle="modal"  data-target="#myModal-Settings-edit" class="js--settings-edit js--add-value-id btn btn-primary btn-block">Edit Settings</a>' +
                '</div>';
                $('.box-profile').replaceWith(replace_settings);

                toastr.success(data.success);
            }else{
                printErrorMsg(data.error);
                $("#myModal-Settings-edit").scrollTop( 0 );
            }
        }
    }

});


$(document).on("click", "#myModal-Links-edit .close, #myModal-Links-add .close, .js--close-modal-links-update, .js--close-modal-links-add", function(e)
{
    $('#myModal-Links-edit').remove();
    $('#myModal-Links-add').remove();
    $('.modal-backdrop').remove();
    $('.sidebar-mini').removeClass('modal-open');
    $('#myModal-Links-edit').removeClass('fade');
    $('#myModal-Links-add').removeClass('fade');

});

$(document).on("click", ".add-links", function(e)
{
    e.preventDefault();

    $.ajax({
        type: "GET",
        url: "/admin/settings/links/new",
        dataType: 'html',
        success: function (view) {
            $('#myModal-Links-edit').remove();
            if( $('#myModal-Links-add').length > 0 )
            {
                $('#myModal-Links-add').remove();
            }
            $('body').append(view);
            $('#myModal-Links-add').modal('show');
        },
        error: function (data) {
            //Error message here
        }
    });

});

$("body").delegate('.add-links-store', 'click',function(e){
    e.preventDefault();
    var formData = new FormData();

    var _token = $("input[name='_token']").val();
    var footer_title = $("#footer_title").val();
    var footer_url = $("#footer_url").val();
    var target_url = $("#target_url").val();

    formData.append("_token", _token);
    formData.append("footer_title", footer_title);
    formData.append("footer_url", footer_url);
    formData.append("target_url", target_url);

    var request = new XMLHttpRequest();
    request.open("POST", "/admin/settings/links/new");
    request.setRequestHeader("X-Requested-With", "XMLHttpRequest");
    request.send(formData);
    request.onreadystatechange=function(){
        if (request.readyState==4 && request.status==200){
            var data = JSON.parse(request.responseText);
            if($.isEmptyObject(data.error)){
                $('#myModal-Links-add').modal('toggle');
                $('#myModal-Links-add').remove();
                $('.modal-backdrop').remove();
                $('.sidebar-mini').removeClass('modal-open');

                $("#links-group-list").append($('<li data-id="' + data.id + '" class="list-group-item links-group-' + data.id + '"><i class="ion ion-drag"></i> <b>' + data.footer_title + '</b> (' + data.footer_url + ') <a href="#"  data-id="' + data.id + '" data-toggle="modal"  data-target="#myModal-Links-delete" class="js--links-group-delete pull-right js--add-value-id">Delete</a><a href="#" data-id="' + data.id + '" data-toggle="modal"  data-target="#myModal-Links-edit" class="js--links-group-edit pull-right padding-right-20">Edit</a></li>'));

                toastr.success(data.success);
            }else{
                printErrorMsg(data.error);
                $("#myModal-Links-add").scrollTop( 0 );
            }
        }
    }

});

$('#myModal-Links-delete').on('click', '#confirm-delete', function() {
    $.ajax({
        type: 'get',
        url: "/admin/settings/links/"+ get_the_id_value  +"/delete",
        data: {
            '_token': $('input[name=_token]').val(),
            'id': get_the_id_value
        },
        success: function(data) {
            if(data.success){
                $(".links-group-" + get_the_id_value).remove();
                $('#myModal-Links-delete').modal('toggle');
                $('#myModal-Links-delete').hide();
                toastr.success(data.success);
            } else {
                $('#myModal-Links-delete').modal('toggle');
                $('#myModal-Links-delete').hide();
                toastr.warning(data.warning);
            }
        },
        error: function (data) {
            $('#myModal-Links-delete').modal('toggle');
            $('#myModal-Links-delete').hide();
            var data2 = JSON.parse(data.responseText);
            toastr.warning(data2.warning);
        }
    });
});

$(document).on("click", ".js--links-group-edit", function(e){
    e.preventDefault();

    $.ajax({
        type: "GET",
        url: "/admin/settings/links/" + $(this).data('id') +"/edit",
        dataType: 'html',
        success: function (view) {
            $('.modal-backdrop').remove();
            if( $('#myModal-Links-edit').length > 0 )
            {
                $('#myModal-Links-add').remove();
                $('#myModal-Links-edit').remove();
            }
            $('#myModal-Links-add').remove();
            $('body').append(view);
            $('#myModal-Links-edit').modal('show');
        },
        error: function (data) {
            //Error message here
        }
    });

});

$("body").delegate('.add-links-update', 'click',function(e){
    e.preventDefault();
    var formData = new FormData();
    var _token = $("input[name='_token']").val();
    var footer_title = $("input[name='footer_title']").val();
    var footer_url = $("input[name='footer_url']").val();
    var target_url = $("#target_url").val();

    formData.append("_token", _token);
    formData.append("footer_title", footer_title);
    formData.append("footer_url", footer_url);
    formData.append("target_url", target_url);
    var request = new XMLHttpRequest();
    request.open("POST", "/admin/settings/links/"  + $(this).data('id') +  "/update");
    request.setRequestHeader("X-Requested-With", "XMLHttpRequest");
    request.send(formData);

    request.onreadystatechange=function(){
        if (request.readyState==4 && request.status==200){
            var data = JSON.parse(request.responseText);
            if($.isEmptyObject(data.error)){
                $('.modal-backdrop').remove();
                $('#myModal-Links-edit').modal('toggle');
                $('#myModal-Links-edit').remove();
                $('.sidebar-mini').removeClass('modal-open');
                var replace_links = '<li data-id="' + data.id + '" class="list-group-item links-group-' + data.id + '"><i class="ion ion-drag"></i> <b>' + data.footer_title + '</b> (' + data.footer_url + ') <a href="#"  data-id="' + data.id + '" data-toggle="modal"  data-target="#myModal-Links-delete" class="js--links-group-delete pull-right js--add-value-id">Delete</a><a href="#" data-id="' + data.id + '" data-toggle="modal"  data-target="#myModal-Links-edit" class="js--links-group-edit pull-right padding-right-20">Edit</a></li>';
                $('.links-group-'+ data.id).replaceWith(replace_links);
                toastr.success(data.success);
            }else{
                printErrorMsg(data.error);
            }
        }
    }
});

// Subscribe
$('#myModal-Subscribe-delete').on('click', '#confirm-delete', function() {
    $.ajax({
        type: 'get',
        url: "/admin/subscribes/"+ get_the_id_value  +"/delete",
        data: {
            '_token': $('input[name=_token]').val(),
            'id': get_the_id_value
        },

        success: function(data) {
            if(data.success){
                $(".users-number-" + get_the_id_value).remove();
                $('#myModal-Subscribe-delete').modal('toggle');
                $('#myModal-Subscribe-delete').hide();
                toastr.success(data.success);
            } else {
                $('#myModal-Subscribe-delete').modal('toggle');
                $('#myModal-Subscribe-delete').hide();
                toastr.warning(data.warning);
            }
        },
        error: function (data) {
            $('#myModal-Subscribe-delete').modal('toggle');
            $('#myModal-Subscribe-delete').hide();
            var data2 = JSON.parse(data.responseText);
            toastr.warning(data2.warning);
        }
    });
});

$(document).on("click", ".js--FailedJobsPlayLoad-view", function(e){
    e.preventDefault();

    $.ajax({
        type: "GET",
        url: "/admin/failedjobs/" + $(this).data('id') +"/view-playload",
        dataType: 'html',
        success: function (view) {
            $('.modal-backdrop').remove();
            $('#myModal-FailedJobsPlayLoad-view').remove();
            $('#myModal-FailedJobsException-view').remove();
            $('body').append(view);
            $('#myModal-FailedJobsPlayLoad-view').modal('show');
        },
        error: function (data) {
            //Error message here
        }
    });

});

$(document).on("click", ".js--FailedJobsException-view", function(e){
    e.preventDefault();

    $.ajax({
        type: "GET",
        url: "/admin/failedjobs/" + $(this).data('id') +"/view-exception",
        dataType: 'html',
        success: function (view) {
            $('.modal-backdrop').remove();
            $('#myModal-FailedJobsPlayLoad-view').remove();
            $('#myModal-FailedJobsException-view').remove();
            $('body').append(view);
            $('#myModal-FailedJobsException-view').modal('show');
        },
        error: function (data) {
            //Error message here
        }
    });

});

$(document).on("click", "#myModal-FailedJobsPlayLoad-view .close, #myModal-FailedJobsException-view .close, .js--close-modal-failed-view", function(e)
{
    $('#myModal-FailedJobsPlayLoad-view').remove();
    $('#myModal-FailedJobsException-view').remove();
    $('.modal-backdrop').remove();
    $('.sidebar-mini').removeClass('modal-open');
    $('#myModal-FailedJobsPlayLoad-view').removeClass('fade');
    $('#myModal-FailedJobsException-view').removeClass('fade');

});