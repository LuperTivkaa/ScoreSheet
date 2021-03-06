//new client sign up
$('#new-signup-btn').on('click', function() {
    $(this).text("Creating account, please wait...").prop("disabled", true);
    let user_name = $("#username").val();
    let email = $("#signup-email").val();
    let password = $("#signup-pass").val();
    $.post("inst_signup.php", { user_name: user_name, email: email, password: password }).done(newClient);

});
// new client signup call back function
function newClient(result) {

    var data = $.trim(result);
    if (data === "ok") {
        $("#new-signup-btn").text("Sign Up!").prop("disabled", false);
        //reidrect to the client login page
        $("#client-signup").addClass("success-msg");
        $("#client-signup").html('Your account has been created successfully, login now to continue!');
        //window.location.replace("clients/login.php");
    } else {
        //alert("me");
        $("#new-signup-btn").text("Sign Up!").prop("disabled", false);
        $("#client-signup").addClass("error");
        $("#client-signup").html(data);
    }
}
// end of new client signup function



//User login     
$('#sch_login_Btn').on('click', function() {
    $(this).text("Please wait ...").prop("disabled", true);
    let email = $("#email").val();
    let password = $("#password").val();
    $.post("user_login.php", { email: email, password: password }).done(Userlogin_call);
});

// user login call back
function Userlogin_call(result) {

    var data = $.trim(result);
    if (data === "ok") {
        $("#sch_login_Btn").text("Log Me In").prop("disabled", false);
        window.location.replace("myapp/index.php");
    } else {
        $("#sch_login_Btn").text("Log Me In").prop("disabled", false);
        $("#output").addClass("error");
        $("#output").html(data);
    }
}

//new client login
//User login     
$('#client-btn').on('click', function() {
    $(this).text("Please wait....").prop("disabled", true);
    let email = $("#email").val();
    let password = $("#password").val();
    $.post("clientLogin.php", { email: email, password: password }).done(clientLogin_call);
});

// user login call back
function clientLogin_call(result) {

    var data = $.trim(result);
    if (data === "ok") {
        $("#client-btn").text("Client Login").prop("disabled", false);
        window.location.replace("Clients/schoolProfile.php");
    } else {
        $("#client-btn").text("Client Login").prop("disabled", false);
        $("#client-login").addClass("error");
        $("#client-login").html(data);
    }
}

//////////////////////////////////////////////

//MODIFY FUNCTION USE JSON DATA FROM USER LOGIN FUNCTION IN PHP

$("#sch_login_Btn").on('click', function() {
    $('#sch_login_Btn').text("Please wait...").prop("disabled", true);
    var email = $("#email").val();
    var password = $("#password").val();
    $.post("user_login.php", { email: email, password: password }).done(userLogin);

});


function userLogin(response) {
    var obj = JSON.parse(response);
    //console.log(typeof obj);
    //console.log(obj);
    if (typeof obj === "object") {
        console.log(obj);
        $.each(obj, function(index, profile) {
            //GET THE ROLE ID OF THE USER
            //var my_role = profile.roleID;
            //console.log(profile.roleID);
            // CHECK THE ROLE ID TO REDIRECT AS APPROPRAITE
            if (profile.roleID == 1 || profile.roleID == 2) {

                //console.log(profile.roleID);
                // check and redirect to the staff tutor module
                window.location.replace("stafftutor/index.php");
            } else if (profile.roleID == 3 || profile.roleID == 4) {

                // check and redirect to the admin module
                window.location.replace("admin/index.php");
            } else {
                // undefined role, contact your school administrator
                $('#error-info').html("Sorry role undefined, check with the admin");
            }
        });

    } // end type check
    else {
        $('#error-info').html(response);
    }
}
// END OF SCHOOL LOGIN