const base_url = $('#base_url').val();
const X_API_KEY = $('#X_API_KEY').val();
const auth_username = $('#auth_username').val();
const auth_password = $('#auth_password').val();

$('.numeric_validation').keypress(function(event){
    if(event.which != 8 && isNaN(String.fromCharCode(event.which))){
        event.preventDefault();
    }
});

$('#get_otp').click(function(){
    let phone = $('#phone').val();
    if(phone == '')
    {
        $('#phone').addClass('border border-danger');
        $('#phone').focus();
        return false;
    }
    else
    {
        $.ajax({
            type:"POST",
            url: base_url+"api/authentication/login",
            data:{phone:phone},
            headers: {"X-API-KEY": X_API_KEY},
            beforeSend: function (xhr) {
                xhr.setRequestHeader ("Authorization", "Basic " + btoa(auth_username + ":" + auth_password));
            },
            success: function(response) {
                if(response.status){
                    $('#session_details').val(response.data);
                    $('#phone_text').html('+91 '+phone);
                    $('#phone').removeClass('border border-danger');
                    $('#phone_screen').addClass('d-none');
                    $('#otp_screen').removeClass('d-none');
                }
            },
            error: function(e) {
                alert(e.responseJSON);
                return false;
            },
            dataType:"JSON",
            contentType: "application/json"
        });
    }
});

$('#login').click(function(){
    let phone = $('#phone').val();
    let session_details = $('#session_details').val();
    let otp = $('#otp').val();

    if(otp == '')
    {
        $('#otp').addClass('border border-danger');
        $('#otp').focus();
        return false;
    }
    else
    {
        $.ajax({
            type:"POST",
            url: base_url+"api/authentication/login",
            data:{phone:phone,otp:otp,session_details:session_details},
            headers: {"X-API-KEY": X_API_KEY},
            beforeSend: function (xhr) {
                xhr.setRequestHeader ("Authorization", "Basic " + btoa(auth_username + ":" + auth_password));
            },
            success: function(response) {
                if(response.status){
                    if(response.data.role == 2)
                    {
                        location.href = base_url;
                    }
                    else
                    {
                        location.href = base_url+'admin/master';
                    }
                }
            },
            error: function(e) {
                alert(e.responseJSON);
                return false;
            },
            dataType:"JSON",
            contentType: "application/json"
        });
    }
});

$('#upload_document').click(function(){
    let name = $('#doc_name').val();
    let id = $('#id').val();
    let img_url = document.getElementById("document");

    if(name == '')
    {
        $('#doc_name').addClass('border border-danger');
        $('#doc_name').focus();
        return false;
    }
    else
    {
        file = img_url.files[0];
        var img_html = '';
        if(file != undefined){
            formData= new FormData();
            formData.append("document", file);
            formData.append("id", id);
            formData.append("name", name);

            $.ajax({
                type:"POST",
                url: base_url+"api/authentication/upload",
                data: formData,
                processData: false,
                contentType: false,
                headers: {"X-API-KEY": X_API_KEY},
                beforeSend: function (xhr) {
                    xhr.setRequestHeader ("Authorization", "Basic " + btoa(auth_username + ":" + auth_password));
                },
                success: function(response) {
                    location.href = base_url;
                },
                error: function(e) {
                    alert(e.responseJSON);
                    return false;
                },
                dataType:"JSON",
                contentType: "application/json"
            });
        }
    }
});

$('#register_user').click(function(){
    let first_name = $('#first_name').val();
    let last_name = $('#last_name').val();
    let email = $('#email').val();
    let phone = $('#phone').val();

    if(first_name=='' && last_name =='' && email == '' && phone == '' && phone.length != 10)
    {
        alert('All fields required!');
        return false;
    }
    else
    {
        $.ajax({
            type:"POST",
            url: base_url+"api/authentication/registration",
            data:{first_name:first_name,last_name:last_name, email:email,phone:phone},
            headers: {"X-API-KEY": X_API_KEY},
            beforeSend: function (xhr) {
                xhr.setRequestHeader ("Authorization", "Basic " + btoa(auth_username + ":" + auth_password));
            },
            success: function(response) {
                console.log(response);
                if(response.status){
                    location.href = base_url+'admin/master';
                }
            },
            error: function(e) {
                alert(e.responseJSON);
                return false;
            },
            dataType:"JSON",
            contentType: "application/json"
        });
    }
});