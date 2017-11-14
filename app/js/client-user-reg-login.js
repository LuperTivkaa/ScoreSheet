//============================================================
//This section of the code handles client sign up, login and user login
//new client sign up
// $('#new-signup-btn').on('click', function() {
//     $(this).text("Creating account, please wait...").prop("disabled", true);
//     var user_name = $("#username").val();
//     var email = $("#signup-email").val();
//     var password = $("#signup-pass").val();
//     console.log(user_name + email + password);
//     $.post("app/public/inst_signup.php", { user_name: user_name, email: email, password: password }).done(newClient);

// });
// // new client signup call back function
// function newClient(result) {

//     var data = $.trim(result);
//     if (data === "ok") {
//         $("#new-signup-btn").text("Sign Up!").prop("disabled", false);
//         $("#username").val("");
//         $("#signup-email").val("");
//         $("#signup-pass").val("");
//         //reidrect to the client login page
//         $("#client-signup").addClass("success-msg");
//         $("#client-signup").html('Your account has been created successfully, login now to continue!');
//         //window.location.replace("clients/login.php");
//     } else {

//         $("#new-signup-btn").text("Sign Up!").prop("disabled", false);
//         $("#client-signup").addClass("error");
//         $("#client-signup").html(data);
//     }
// }
// // end of new client signup function

//===============================================================================================================
//NEW CLIENT SIGNUP
$("#new-signup-btn").on('click', function(e) {
    e.preventDefault();
    //alert("Me too");
    $('#new-signup-btn').text("Creating account, please wait...").prop("disabled", true);
    var user_name = $("#username").val();
    var email = $("#signup-email").val();
    var password = $("#signup-pass").val();


    clientSign(user_name, email, password);

});

//call back function to add number of days student attended school
function clientSign(user, mail, pass) {
    $.ajax({
        url: 'app/public/inst_signup.php',
        type: 'POST',
        data: { user: user, mail: mail, pass: pass },
        success: function(response) {
            var data = $.trim(response);
            if (data === "ok") {
                $("#new-signup-btn").text("Sign Up!").prop("disabled", false);
                $("#username").val("");
                $("#signup-email").val("");
                $("#signup-pass").val("");
                //reidrect to the client login page
                $("#client-signup").addClass("success-msg");
                $("#client-signup").html('Your account has been created successfully, login now to continue!');
            } else {
                $("#new-signup-btn").text("Sign Up!").prop("disabled", false);
                $("#client-signup").addClass("error");
                $("#client-signup").html(data);
            }
        },
    });
}

//END NEW CLIENT SIGN UP
//===============================================================================================================

//==============================================================================================================
//CREATE NEW ROOT ACCOUNT
$("#root_Btn").on('click', function(e) {
    e.preventDefault();
    //alert("Me too");
    $('#root_Btn').text("Creating account, please wait...").prop("disabled", true);
    var email = $("#email").val();
    var username = $("#username").val();
    var pass = $("#password").val();
    rootAccount(email, username, pass);

});

//call baack for root account
function rootAccount(email, username, pass) {
    $.ajax({
        url: './rootAccessSignup.php',
        type: 'POST',
        data: { email: email, username: username, pass: pass },
        success: function(response) {
            var data = $.trim(response);
            if (data === "ok") {
                $("#root_Btn").text('Create Root Account').prop("disabled", false);
                window.location.replace("./school_login.php");
                // $("#client-signup").addClass("success-msg");
                // $("#client-signup").html('Your account has been created successfully, login now to continue!');
            } else {
                $("#root_Btn").text('Create Root Account').prop("disabled", false);
                $("#error-info").addClass("error");
                $("#error-info").html(data);
            }
        },
    });
}

//END CREATE NEW ROOT ACCOUNT
//===============================================================================================================


//Root account code

//========================
// $('#root_Btn').on('click', function(e) {
//     e.preventDefault();
//     $('#root_Btn').text('Processing...').prop("disabled", true);
//     var email = $("#email").val();
//     var username = $("#username").val();
//     var pass = $("#password").val();
//     $.post("./rootAccessSignup.php", { email: email, username: username, pass: pass }).done(rootAccount);
// });

// // user login call back
// function rootAccount(result) {

//     var data = $.trim(result);
//     if (data === "ok") {
//         $("#root_Btn").prop("disabled", false);
//         window.location.replace("./school_login.php");
//     } else {
//         $("#root_Btn").prop("disabled", false);
//         $("#error-info").addClass("error");
//         $("#error-info").html(data);
//     }
// }
// //===================



///end root account code




//new client login
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
        window.location.replace("app/public/root_pass.php");
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
            if (profile.roleID == 1) {

                //console.log(profile.roleID);
                // check and redirect to the staff tutor module
                window.location.replace("../staff/index.php");
            } else if (profile.roleID == 2) {
                // check and redirect to the admin module
                window.location.replace("../admin/index.php");
            } else if (profile.roleID == 3) {
                window.location.replace("../client/index.php");
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