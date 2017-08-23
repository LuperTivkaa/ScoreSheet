//  $(function() {
//      $("#datepicker").datepicker();
// //  });

////load the content of a particuluar url that is clicked on
$('.load-url').on('click', function(evt) {
    evt.preventDefault();
    $("#my-info").empty();
    $('#student-search-result').empty();
    var url = $(this).attr('href');
    $('#new-content').load(url);
});

//get birthdays NOT COMPvarE

$('.birthdays').on('click', function(evt) {
    evt.preventDefault();
    var url = $(this).attr('href');
    //alert(url);
    $('#new-content').load(url, function() {});
});
//end getbirthdays ////NOT COMPvarE

//get all students
$('.all-students').on('click', function(evt) {
    evt.preventDefault();
    var url = $(this).attr('href');
    getallStudents(url);
});
//get all students
function getallStudents(url) {
    //get inserted records from the database
    jQuery.getJSON(url, function(response) {
        if (typeof response === 'object') {
            var profileHTML = '<ul>';
            $.each(response, function(index, profile) {

                profileHTML += '<li class="display-list"> ' + profile.fullname + ' </li>';
                //  profileHTML+= '<li>' + profile.category_name + ' </li>';
                //</li>';
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
        $("#my-info").empty();
        $('#student-search-result').empty();
        var url = $(this).attr('href');

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
                //</li>';
            });
            profileHTML += '</ul>';
            $('#new-content').html(profileHTML);
        } else {
            $('#new-content').html(response);
        }

    });

}
//End Get Staff Records

//add new Staff
$("#new-content").on('click', '#staff-account', function(e) {
    e.preventDefault();
    $('#staff-account').text("Please wait....").prop("disabled", true);
    var email = $("#email").val();
    var pass = $("#my-pass").val();
    var username = $("#username").val();
    var role = $("#role option:selected").val();
    //var jsURL = $('#input').attr('value');
    submit(email, username, pass, role);
});

//function to add new staff call back
function submit(email, user, pass, role) {
    $.ajax({
        url: 'addNewStaff.php',
        type: 'POST',
        data: { email: email, username: user, pass: pass, role: role },
        success: function(response) {
            var data = $.trim(response);
            if (data === "ok") {
                $('#staff-account').text("Create Staff").prop("disabled", false);
                $("#email").val("");
                $("#my-pass").val("");
                $("#username").val("");
                $("#my-info").addClass("info");
                $("#my-info").html("Staff added successfully");
            } else {
                //alert("me")
                $('#staff-account').text("Create Staff").prop("disabled", false);
                $("#my-info").addClass("error");
                $("#my-info").html(data);
            }
        },
        //alert(user+pass+role);
    });
} //end new staff

//load all institutional subjects
$("#new-content").on('click', '.reload', function(e) {
    $.get("allSchoolSubjects.php", function(data) {
        $("#subject-list").html(data);
    });
});
//end of add load all institutional subjects
//load all institutional subjects
$("#new-content").on('click', '.reload-class', function(e) {
    $.get("allClasses.php", function(data) {
        $("#class-list").html(data);
    });
});
//end of add load all institutional subjects

//load all new students without parents
$("#new-content").on('click', '.load-new-student', function(e) {
    $.get("newStudentParent.php", function(data) {
        $("#student").html(data);
    });
});

//end  of all new students
//=========================================================================
//CREATE NEW SCHOOL SUBJECT

$("#new-content").on('click', '#add-new-subject', function(e) {
    e.preventDefault();
    $('#add-new-subject').prop("disabled", true);
    var subjectName = $('#subject').val();
    newSubject(subjectName);
});
//end create new school subject
//add new subject callback function
function newSubject(subj) {
    $.ajax({
        url: 'addSubject.php',
        type: 'POST',
        data: { subj: subj },
        success: function(response) {
            var data = $.trim(response);
            if (data === "ok") {
                $('#add-new-subject').prop("disabled", false);
                $("#my-info").addClass("info");
                $('#subject').val("");
                $("#my-info").html("Subject added successfully");
            } else {
                //alert("me")
                $('#add-new-subject').prop("disabled", false);
                $("#my-info").addClass("error");
                $("#my-info").html(data);
            }
        },
    });
}
//end add new subject call back
//END CREATE NEW SCHOOL SUBJECT
//=================================================================================


//=========================================================================
//CREATE NEW SCHOOL CLASS

$("#new-content").on('click', '#add-new-class', function(e) {
    e.preventDefault();
    $('#add-new-class').prop("disabled", true);
    var myclass = $('#class-name').val();
    newClass(myclass);
});
//end create new class
//add new class callback function
function newClass(myclass) {
    $.ajax({
        url: 'addClass.php',
        type: 'POST',
        data: { myclass: myclass },
        success: function(response) {
            var data = $.trim(response);
            if (data === "ok") {
                $('#add-new-class').prop("disabled", false);
                $("#my-info").addClass("info");
                $("#my-info").html("Class added successfully");
            } else {
                //alert("me")
                $('#add-new-class').prop("disabled", false);
                $("#my-info").addClass("error");
                $("#my-info").html(data);
            }
        },
    });
}
//END CREATE NEW SCHOOL CLASS

//create Class description
$("#new-content").on('click', '#assign-desc', function(e) {
    e.preventDefault();
    $('#assign-desc').prop("disabled", true);
    var class_id = $('#class-list option:selected').val();
    var description = $('#class-desc option:selected').val();
    classDescription(description, class_id);
});

//call back to assign class description
function classDescription(description, class_id) {
    $.ajax({
        url: 'assignClassArm.php',
        type: 'POST',
        data: { class_descr: description, class_id: class_id },
        success: function(response) {
            var data = $.trim(response);
            if (data === "ok") {
                $('#assign-desc').prop("disabled", false);
                $("#my-info").addClass("info");
                $("#my-info").html("Class arm created successfully");
            } else {
                //alert("me")
                $('#assign-desc').prop("disabled", false);
                $("#my-info").addClass("error");
                $("#my-info").html(data);
            }
        },
    })
}
// End assign block

///end of class escription
//=================================================================================

//==================================================================================
//Assign subject block
/** Code snippet to assign subject to a class
 * Select added subjec and also selec class and add
 */
//==================================================================================

//Assign subject to clas
$("#new-content").on('click', '#assign-subject', function(e) {
    e.preventDefault();
    $('#assign-subject').prop("disabled", true);
    var subj = $('#subject-list option:selected').val();
    var classid = $('#class option:selected').val();
    assignSubject(subj, classid);
});

//call back for assign subject to class
function assignSubject(subjectName, classid) {
    $.ajax({
        url: 'assignSubjectToClass.php',
        type: 'POST',
        data: { subjectName: subjectName, classid: classid },
        success: function(response) {
            var data = $.trim(response);
            if (data === "ok") {
                $('#assign-subject').prop("disabled", false);
                $("#my-info").addClass("info");
                $("#my-info").html("Subject assigned successfully");
            } else {
                //alert("me")
                $('#assign-subject').prop("disabled", false);
                $("#my-info").addClass("error");
                $("#my-info").html(data);
            }
        },
    })
}
// End assign block

//add subject taught by  staff

$("#new-content").on('click', '#add-subject', function(e) {
    e.preventDefault();
    $('#add-subject').prop("disabled", true);
    var staff = $("#staff option:selected").val();
    var class_id = $("#class option:selected").val();
    var subj = $("#subject option:selected").val();
    createSubject(staff, class_id, subj);
});

//function to add new subject call back
function createSubject(staff, class_id, subj) {
    $.ajax({
        url: 'addStaffSubject.php',
        type: 'POST',
        data: { staff: staff, class_id: class_id, subj: subj },
        success: function(response) {
            var data = $.trim(response);
            if (data === "ok") {
                $('#add-subject').prop("disabled", false);
                $("#my-info").addClass("info");
                $("#my-info").html("Subject added successfully");
            } else {
                //alert("me")
                $('#add-subject').prop("disabled", false);
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
    var inst_name = $("#institution_name").val();
    var inst_category = $("#institution_category").val();
    var nation = $("#nation").val();
    var state = $("#state").val();
    var lg = $("#lg").val();
    var city = $("#city").val();
    var address = $("#address").val();
    var mobile = $("#mobile").val();
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

            //generate HTML to display added information
            profileHTML += '<li> ' + profile.institution_name + ' </li>';
            profileHTML += '<li>' + profile.category_name + ' </li>';
            //</li>';
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

// //LIST CLASS ARM BASED ON CLASS SELECTED
// $("#new-content").on('change', '#class-admitted', function(e) {
//     var id = $("#class-admitted option:selected").val();
//     //var id = $("#state option:selected").val();
//     $.post("listClassArm.php", { id: id }, function(data) {
//         $("#arm").html(data);
//     });
// });

//load states on selection of subjects
$('#new-content').on('change', '#nation', function() {
    var id = $("#nation option:selected").val();
    $.post("listStates.php", { id: id }, function(data) {
        $("#state").html(data);
    });
});
//load lga on state selection
$('#new-content').on('change', '#state', function() {
    var id = $("#state option:selected").val();
    $.post("listLga.php", { id: id }, function(data) {
        $("#lg").html(data);
    });
});

//load city
$('#new-content').on('change', '#lg', function() {
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
//STUDENT SEARCH FUNCTIONALITY
$("#new-content").on('click', '#search-btn', function(e) {
    e.preventDefault();
    $('#search-btn').text("Searching...").prop("disabled", true);
    var searchvar = $('#searchitem').val();
    console.log(searchvar);
    studentGeneralSearch(searchvar);
});
//end create new school subject
//add new subject callback function
function studentGeneralSearch(searchvar) {
    $.ajax({
        url: 'student-search-result.php',
        type: 'POST',
        data: { searchvar: searchvar },
        success: function(response) {
            //var data = $.trim(response);
            if (response === undefined) {
                $('#search-btn').text("Search Student").prop("disabled", false);
                $("#my-info").addClass("error");
                $('#my-info').html(response);
            } else {
                $('#search-btn').text("Search Student").prop("disabled", false);
                $('#student-search-result').html(response);
            }
        },
    });
}