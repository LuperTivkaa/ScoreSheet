//============================================================
//This section of the code handles client sign up, login and user login
//new client sign up
$('#new-signup-btn').on('click', function() {
    $(this).text("Creating account, please wait...").prop("disabled", true);
    var user_name = $("#username").val();
    var email = $("#signup-email").val();
    var password = $("#signup-pass").val();
    $.post("app/public/inst_signup.php", { user_name: user_name, email: email, password: password }).done(newClient);

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

        $("#new-signup-btn").text("Sign Up!").prop("disabled", false);
        $("#client-signup").addClass("error");
        $("#client-signup").html(data);
    }
}
// end of new client signup function




//new client login
//User login     
$('#client-btn').on('click', function() {
    $(this).text("Please wait....").prop("disabled", true);
    var email = $("#email").val();
    var password = $("#password").val();
    $.post("app/public/clientLogin.php", { email: email, password: password }).done(clientLogin_call);
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
    console.log(email);
    console.log(password);
    $.post("./user_login.php", { email: email, password: password }).done(userLogin);


});


function userLogin(response) {
    var obj = JSON.parse(response);
    //console.log(response);
    if (typeof obj === "object") {
        //console.log(obj);
        $.each(obj, function(index, profile) {
            //GET THE ROLE ID OF THE USER
            //var my_role = profile.roleID;
            //console.log(profile.roleID);
            // CHECK THE ROLE ID TO REDIRECT AS APPROPRAITE
            if (profile.roleID == 1 || profile.roleID == 2) {

                //console.log(profile.roleID);
                // check and redirect to the staff tutor module
                window.location.replace("app/staff/index.php");
            } else if (profile.roleID == 3 || profile.roleID == 4) {

                // check and redirect to the admin module
                window.location.replace("../admin/index.php");
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
//==================================================================================
//end section of the code handles client sign up, login and user login
//========================================================