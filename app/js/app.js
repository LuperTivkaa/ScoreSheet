///////////////////////////////////////////////////////////////////////////////////////////

////load the content of a particuluar url that is clicked on
$('.nav-link').on('click', function(evt) {
    evt.preventDefault();
    $("#my-info").empty();
    let url = $(this).attr('href');
    $('#new-content').load(url);
    // //console.log(url);
});
//////////////////////////////////////////////////////////////////////////////////////////////

$(function() {
    $("#datepicker").datepicker();
});

//BIRTHDAYS METHOD
//TODO: THIS CODE IS NOT COMPLETE YET

$('.birthdays').on('click', function(evt) {
    evt.preventDefault();
    let url = $(this).attr('href');
    //alert(url);
    $('#new-content').load(url, function() {
        // put the set interval function or code here
        // $("#new-content").on('click', '#ID-BUTTON', function(e){
        // on click of the send Message BUTTON, get the ID OF THE USER AND PASS INTO THE SEND MESSAGE FUNCTION
        //       e.preventDefault();
        //       //var id = $('#ID OF user ID element').attr('value');
        //       sendMessage(id);
    });

    // });
});
//end getbirthdays ////NOT COMPLETE

//GET ALL STUDENTS
$('.all-students').on('click', function(evt) {
    evt.preventDefault();
    let url = $(this).attr('href');
    getallStudents(url);
});
//get all students
function getallStudents(url) {
    //get inserted records from the database
    jQuery.getJSON(url, function(response) {
        if (typeof response === 'object') {
            var profileHTML = '<ul class="inst-profile">';
            $.each(response, function(index, profile) {
                // if(profile.inst_logo === ""){
                //     var logo = "Logo not uploaded!";
                // }
                // else{
                //     logo = profile.inst_logo;
                // }
                //generate HTML to display added information
                profileHTML += '<li> ' + profile.fullname + ' </li>';
                //  profileHTML+= '<li>' + profile.category_name + ' </li>';
                //  profileHTML+= '<li><strong>COUNTRY OF LOCATION: </strong> ' + profile.nationality + ' </li>';
                //  profileHTML+= '<li><strong>STATE OF LOCATION:</strong> ' + profile.state_name + ' </li>';
                //  profileHTML+= '<li><strong>LGA of Location:</strong> ' + profile.lga + ' </li>';
                //  profileHTML+= '<li><strong>CITY: </strong> ' + profile.city_name + ' </li>';
                //  profileHTML+= '<li><strong>INSTITUTION ADDRESS:</strong> ' + profile.inst_add + ' </li>';
                //  profileHTML+= '<li><strong>INSTITUTION MOBILE: </strong> ' + profile.inst_mobile + ' </li>';
                // profileHTML+= '<li><strong>INSTITUTION LOGO:</strong> ' + ' <img  class="headerImage mr-3" src="'+logo+'" height="40" width="40"></li>';
            });
            profileHTML += '</ul>';
            $('#new-content').html(profileHTML);
        } else {
            $('#new-content').html(response);
        }

    });

}
//end of get all students
////////////////////////////////////////////////////

//Get Staff Records
$('.my-staff').on('click', function(evt) {
        evt.preventDefault();
        let url = $(this).attr('href');
        //alert(url);
        // $('#new-content').load(url, function() {
        //    $("#new-content").on('click', '#staff-account', function(e){
        //       e.preventDefault();
        //       //var jsURL = $('#input').attr('value');
        //       getMyStaff(url);
        //    });

        // });
        //console.log(url);
        getMyStaff(url);
    })
    //get staff function
function getMyStaff(url) {
    //get inserted records from the database
    jQuery.getJSON(url, function(response) {
        if (typeof response === 'object') {
            var profileHTML = '<ul class="inst-profile">';
            $.each(response, function(index, profile) {
                // if(profile.inst_logo === ""){
                //     var logo = "Logo not uploaded!";
                // }
                // else{
                //     logo = profile.inst_logo;
                // }
                //generate HTML to display added information
                profileHTML += '<li> ' + profile.fullname + ' </li>';
                //  profileHTML+= '<li>' + profile.category_name + ' </li>';
                //  profileHTML+= '<li><strong>COUNTRY OF LOCATION: </strong> ' + profile.nationality + ' </li>';
                //  profileHTML+= '<li><strong>STATE OF LOCATION:</strong> ' + profile.state_name + ' </li>';
                //  profileHTML+= '<li><strong>LGA of Location:</strong> ' + profile.lga + ' </li>';
                //  profileHTML+= '<li><strong>CITY: </strong> ' + profile.city_name + ' </li>';
                //  profileHTML+= '<li><strong>INSTITUTION ADDRESS:</strong> ' + profile.inst_add + ' </li>';
                //  profileHTML+= '<li><strong>INSTITUTION MOBILE: </strong> ' + profile.inst_mobile + ' </li>';
                // profileHTML+= '<li><strong>INSTITUTION LOGO:</strong> ' + ' <img  class="headerImage mr-3" src="'+logo+'" height="40" width="40"></li>';
            });
            profileHTML += '</ul>';
            $('#new-content').html(profileHTML);
        } else {
            $('#new-content').html(response);
        }

    });

}
//End Get Staff Records


//////////////////////////////////

//add new Staff usable
$('.new-emplyee').on('click', function(evt) {
        evt.preventDefault();
        let url = $(this).attr('href');
        $('#new-content').load(url, function() {
            $("#new-content").on('click', '#staff-account', function(e) {
                e.preventDefault();
                $('#staff-account').text("Please wait....").prop("disabled", true);
                var pass = $("#my-pass").val();
                var username = $("#username").val();
                var role = $("#role option:selected").val();
                //var jsURL = $('#input').attr('value');
                submit(username, pass, role);
            });

        });
        // console.log(url);
    })
    //function to add new staff call back
function submit(user, pass, role) {
    $.ajax({
        url: 'addNewStaff.php',
        type: 'POST',
        data: { username: user, pass: pass, role: role },
        success: function(response) {
            var data = $.trim(response);
            if (data === "ok") {
                $('#staff-account').text("Create Staff").prop("disabled", false);
                $("#my-info").addClass("info");
                $("#my-info").html("Staff added successfully");
            } else {
                //alert("me")
                $('#staff-account').text("Create Staff").prop("disabled", false);
                $("#my-info").addClass("error");;
                $("#my-info").html(data);
            }
        },
        //alert(user+pass+role);
    })
} //end new staff

//add new subject
$('.new-subject').on('click', function(evt) {
        evt.preventDefault();
        let url = $(this).attr('href');
        $('#new-content').load(url, function() {
            $("#new-content").on('click', '#add-subject', function(e) {
                e.preventDefault();
                $('#add-subject').text("Please wait....").prop("disabled", true);
                var staff = $("#staff option:selected").val();
                var subj_class = $("#class option:selected").val();
                var subj = $("#subject option:selected").val();
                createSubject(staff, subj_class, subj);
            });
        });
        //console.log(url);

    })
    //function to add new subject call back
function createSubject(staff, subj_class, subj) {
    $.ajax({
        url: 'addStaffSubject.php',
        type: 'POST',
        data: { staff: staff, subj_class: subj_class, subj: subj },
        success: function(response) {
            var data = $.trim(response);
            if (data === "ok") {
                $('#add-subject').text("Add Subject").prop("disabled", false);
                $("#my-info").addClass("info");
                $("#my-info").html("Subject added successfully");
            } else {
                //alert("me")
                $('#add-subject').text("Add Subject").prop("disabled", false);
                $("#my-info").addClass("error");;
                $("#my-info").html(data);
            }
        },
        //alert(user+pass+role);
    })
}
//end add new subbject

// new institution profile
$('#sch-profile-btn').on('click', function() {
    //$(this).text("Submitting, please wait...").prop("disabled", true);
    let inst_name = $("#institution_name").val();
    let inst_category = $("#institution_category").val();
    let nation = $("#nation").val();
    let state = $("#state").val();
    let lg = $("#lg").val();
    let city = $("#city").val();
    let address = $("#address").val();
    let mobile = $("#mobile").val();
    $.post("addSchoolProfile.php", {
        inst_name: inst_name,
        inst_category: inst_category,
        nation: nation,
        state: state,
        lg: lg,
        city: city,
        address: address,
        mobile: mobile
    }).done(createInst);
});
//institution profile call back function
function createInst(response) {
    $("#register").modal("hide");
    //get inserted records from the database

    var data = $.trim(response);
    if (data === "ok") {
        window.location.replace("uploadLogo.php");
    } else {
        //alert("me")
        $("#profile-info").addClass("error");;
        $("#profile-info").html(data);
    }

}
// end code to create institution profile

//Reload the content of after interval
setTimeout(function() {
    getInstProfile();
}, 1000); //120000

function getInstProfile() {
    //get inserted records from the database

    var url = "getProfile.php";
    jQuery.getJSON(url, function(response) {

        var profileHTML = '<ul class="inst-profile">';
        $.each(response, function(index, profile) {
            // if(profile.inst_logo === ""){
            //     var logo = "Logo not uploaded!";
            // }
            // else{
            //     logo = profile.inst_logo;
            // }
            //generate HTML to display added information
            profileHTML += '<li> ' + profile.institution_name + ' </li>';
            profileHTML += '<li>' + profile.category_name + ' </li>';
            // profileHTML+= '<li><strong>COUNTRY OF LOCATION: </strong> ' + profile.nationality + ' </li>';
            // profileHTML+= '<li><strong>STATE OF LOCATION:</strong> ' + profile.state_name + ' </li>';
            // profileHTML+= '<li><strong>LGA of Location:</strong> ' + profile.lga + ' </li>';
            // profileHTML+= '<li><strong>CITY: </strong> ' + profile.city_name + ' </li>';
            // profileHTML+= '<li><strong>INSTITUTION ADDRESS:</strong> ' + profile.inst_add + ' </li>';
            // profileHTML+= '<li><strong>INSTITUTION MOBILE: </strong> ' + profile.inst_mobile + ' </li>';
            // profileHTML+= '<li><strong>INSTITUTION LOGO:</strong> ' + ' <img  class="headerImage mr-3" src="'+logo+'" height="40" width="40"></li>';
        });
        profileHTML += '</ul>';
        $('#right-school-profile').html(profileHTML);

    });

}
//end of get institutional profile


//load subjects on selection of class
$("#new-content").on('change', '#class', function() {
    var id = $("#class option:selected").val();
    $.post("listSubjects.php", { id: id }, function(data) {
        $("#subject").html(data);
    });
});



// create ticket
$('#my-ticket').on('click', function() {
    $(this).text("Sending, please wait...").prop("disabled", true);
    let inst_name = $("#title").val();
    let priority = $("#priority").val();
    let notes = $("#notes").val();
    $.post("createTicket.php", {
        title: title,
        priority: priority,
        notes: notes
    }).done(myTicket);
});

//create ticket callback function
function myTicket(result) {

    var data = $.trim(result);
    if (data === "ok") {
        $("#my-ticket").text("Send Ticket").prop("disabled", false);
        $("#info").html(data);
    } else {
        $("#my-ticket").text("Send Ticket").prop("disabled", false);
        $("#info").html(data);
    }
}

//load  states on selection of country
$("#nation").change(function() {
    var id = $("#nation option:selected").val();
    $.post("listStates.php", { id: id }, function(data) {
        $("#state").html(data);
    });
});


//load  lga
$("#state").change(function() {
    var id = $("#state option:selected").val();
    $.post("listLga.php", { id: id }, function(data) {
        $("#lg").html(data);
    });
});


//load  cities
$("#lg").change(function() {
    var id = $("#lg option:selected").val();
    $.post("listCity.php", { id: id }, function(data) {
        $("#city").html(data);
    });
});

//////////////////////////////////////

// Variable to store your files
var files;

// Add events
$('#image-file').on('change', prepareUpload);
$('#image-file').on('change', uploadFiles);
// Grab the files and set them to our variable
function prepareUpload(event) {
    //firing ok
    //console.log('This function is working and firing the first event');
    files = event.target.files;
    //firing ok
    //.log(files);
    //var size  = files[0].size;
    //console.log(size);
}

// Catch the form files
function uploadFiles(event) {
    //firing ok
    // console.log('Testing the second event handler');
    event.stopPropagation(); // Stop stuff happening
    event.preventDefault(); // Totally stop stuff happening

    // START A LOADING SPINNER HERE

    // Create a formdata object and add the files
    var data = new FormData();
    $.each(files, function(key, value) {
        data.append(key, value);
    });

    $.ajax({
        url: 'processPhoto.php?files',
        type: 'POST',
        data: data,
        cache: false,
        dataType: 'json',
        processData: false, // Don't process the files
        contentType: false, // Set content type to false as jQuery will tell the server its a query string request
    }).done(imageCall);

}

////////////////////////////////////////////////////////////////////////////////

// Catch the form files
function uploadLogo(event) {
    //firing ok
    console.log('Testing the second event handler');
    event.stopPropagation(); // Stop stuff happening
    event.preventDefault(); // Totally stop stuff happening

    // START A LOADING SPINNER HERE

    // Create a formdata object and add the files
    var data = new FormData();
    $.each(files, function(key, value) {
        data.append(key, value);
    });

    $.ajax({
        url: 'processLogo.php?files',
        type: 'POST',
        data: data,
        cache: false,
        dataType: 'json',
        processData: false, // Don't process the files
        contentType: false, // Set content type to false as jQuery will tell the server its a query string request
    }).done(imageCall);

}

///////////////////////////////////////
//login call back
function imageCall(result) {

    $("#msg").html(result);

}

///////////////////////////////////////////////////////////

// logo upload

$('#logo-file').on('change', prepareUpload);
$('#logo-file').on('change', uploadLogo);

/////////////////////////

//login call back
function login_call(result) {
    var a = 2;
    var b = 1;
    var c = 2;
    var data = $.trim(result);
    if (data === "successful") {
        window.location.replace("home.php");
    } else {
        //alert("me");
        $("#output").addClass("error");
        $("#output").html(data);
    }
}

//login method
function login() {
    var pin = $("#pinnumber").val();
    var reg = $("#reg").val();
    $.post("login.php", { pin: pin, reg: reg }).done(login_call);
}

//===============================================================================
// Staff academic routines
// =============================================================================
//add new continuous assessment scores
$("#new-content").on('click', '#add-ca', function(e) {
    e.preventDefault();
    $('#add-ca').prop("disabled", true);
    var regno = $("#regno").val();
    var scores = $("#scores").val();
    var studentClass = $("#student-class option:selected").val();
    var class_Arm = $("#arm option:selected").val();
    var subject = $("#list-subject option:selected").val();
    newCa(regno, scores, studentClass, class_Arm, subject);
});
//call back function to add new continous assessment scores
function newCa(regno, scores, studentClass, class_Arm, subject) {
    $.ajax({
        url: 'addCa.php',
        type: 'POST',
        data: { regno: regno, scores: scores, studentClass: studentClass, class_Arm: class_Arm, subject: subject },
        success: function(response) {
            var data = $.trim(response);
            if (data === "ok") {
                $('#add-ca').prop("disabled", false);
                $("#my-info").addClass("info");
                $("#my-info").html("Continous assessment added");
            } else {
                $('#add-ca').prop("disabled", false);
                $("#my-info").addClass("error");;
                $("#my-info").html(data);
            }
        },
    })
} //end add ca method


//============================================================
// ADD TERMINAL EXAMINATION SCORES
//===========================================================

//add new terminal examination scores
$("#new-content").on('click', '#add-exam-scores', function(e) {
    e.preventDefault();
    $('#add-exam-scores').prop("disabled", true);
    var regno = $("#regno").val();
    var scores = $("#scores").val();
    var studentClass = $("#student-class option:selected").val();
    var arm = $("#arm option:selected").val();
    var subject = $("#list-subject option:selected").val();
    newExamScores(regno, scores, studentClass, arm, subject);
});
//call back function to add new continous assessment scores
function newExamScores(regno, scores, studentClass, arm, subject) {
    $.ajax({
        url: 'addTerminalExam.php',
        type: 'POST',
        data: { regno: regno, scores: scores, studentClass: studentClass, class_Arm: arm, subject: subject },
        success: function(response) {
            var data = $.trim(response);
            if (data === "ok") {
                $('#add-exam-scores').prop("disabled", false);
                $("#my-info").addClass("info");
                $("#my-info").html("Examination scores added");
            } else {
                $('#add-exam-scores').prop("disabled", false);
                $("#my-info").addClass("error");;
                $("#my-info").html(data);
            }
        },
    })
} //end add ca method