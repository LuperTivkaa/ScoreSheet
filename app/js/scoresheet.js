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
//get birthdays NOT Complete

$('.birthdays').on('click', function(evt) {
    evt.preventDefault();
    var url = $(this).attr('href');
    //alert(url);
    $('#new-content').load(url, function() {});
});
//end getbirthdays ////NOT Complete

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
//============================
//REMOVE THIS SNIPPET. NO LONGER IN USE
//load all institutional subjects
// $("#new-content").on('click', '.reload-class', function(e) {
//     $.get("allClasses.php", function(data) {
//         $("#class-list").html(data);
//     });
// });
//end of add load all institutional subjects
//==================================================

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
//=======================================================
//THIS SECTION OF THE CODE IS NO LONGER IN USE
//=======================================================
// //create Class description
// $("#new-content").on('click', '#assign-desc', function(e) {
//     e.preventDefault();
//     $('#assign-desc').prop("disabled", true);
//     var class_id = $('#class-list option:selected').val();
//     var description = $('#class-desc option:selected').val();
//     classDescription(description, class_id);
// });

// //call back to assign class description
// function classDescription(description, class_id) {
//     $.ajax({
//         url: 'assignClassArm.php',
//         type: 'POST',
//         data: { class_descr: description, class_id: class_id },
//         success: function(response) {
//             var data = $.trim(response);
//             if (data === "ok") {
//                 $('#assign-desc').prop("disabled", false);
//                 $("#my-info").addClass("info");
//                 $("#my-info").html("Class arm created successfully");
//             } else {
//                 //alert("me")
//                 $('#assign-desc').prop("disabled", false);
//                 $("#my-info").addClass("error");
//                 $("#my-info").html(data);
//             }
//         },
//     })
// }
// // End assign block

// ///end of class escription
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
/* When the user clicks on the button,
toggle between hiding and showing the dropdown content */
//=============================
//TO DO: USE THIS DESIGN FOR THE ACTUAL IMPLEMENTATION
//=======
$('.dropbtn').on('click', function(evt) {
    //THIS IS Jquery's solution to the drop down menu
    //TODO: FIX THE BEHAVIOUR OF THE MENU ON NOT CLOSING ON CLICKING ANOTHER ONE PREVIOUS TO IT
    //CHECK BEFORE FIX
    evt.preventDefault();
    $('#myDropdown').removeClass('show');
    $(this).next().addClass('show');

});
//========================
//plain javascript dropd down script
// function myFunction() {
//     document.getElementById("myDropdown").classList.toggle("show");
// }

// Close the dropdown menu if the user clicks outside of it
window.onclick = function(event) {
    if (!event.target.matches('.dropbtn')) {
        //var dropdowns = document.getElementsByClassName("dropdown-content");
        var dropdowns = $('.dropdown-content');
        var i;
        for (i = 0; i < dropdowns.length; i++) {
            var openDropdown = dropdowns[i];
            if (openDropdown.classList.contains('show')) {
                openDropdown.classList.remove('show');
            }
        }
    }
};


//Page scroll functionality

$(window).scroll(function() {
    if ($(document).height() <= $(window).scrollTop() + $(window).height()) {
        loadmore();
    }
});

function loadmore() {
    var val = $("#row_no").val();
    $.ajax({
        type: 'post',
        url: 'get_results.php',
        data: {
            getresult: val
        },
        success: function(response) {
            $('class tr:last').append(response);
            $("#row_no").value = Number(val) + 10;
        }
    });
}

//modal setup test
// $('#new-content').on('click', 'examModal', function(evt) {
//     evt.preventDefault();
//     var modal_id = $(this).attr('data-target');
//     console.log(modal_id);
//     $(modal_id).on('show.bs.modal', function(event) {
//         //var button = $(event.relatedTarget) // Button that triggered the modal
//         //var recipient = button.data('whatever') // Extract info from data-* attributes
//         // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
//         // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
//         //var modal = $(this)
//         // modal.find('.modal-title').text('New message to ' + recipient)
//         //modal.find('.modal-body input').val(recipient)
//     });


// })

//Edit exam  modal js
$('#new-content').on('click', '#newbtn', function(e) {
    e.preventDefault();
    // var myclass = $(this).data('classid');
    // var session = $(this).data('sessionid');
    // var subject = $(this).data('subjectid');
    // var term = $(this).data('term');
    var recordid = $(this).data('recordid');
    var scores = $(this).data('scores');

    $('#edit-scores').val(scores);
    $('#record-id').val(recordid);

    var modalid = $('#myModal');
    modalid.css('display', 'block');
});


$('.closex').on('click', function(evt) {
    evt.preventDefault();
    var modalid = $('#myModal');
    modalid.css('display', 'none');
});

// $(window).on('click', function(event) {
//     event.preventDefault();
//     var modalid = $('#myModal');
//     if ($(this) == modalid) {
//     modalid.css('display', 'none');
//     }
// });
// var span = document.getElementsByClassName("close")[0];
// // When the user clicks on <span> (x), close the modal
// span.onclick = function() {
//     modal.style.display = "none";
// }

//EXAM EDIT ROUTINES

//LOAD SUBJECT BASED ON SELECTION OF CLASS

$('#edit-class').on('change', function() {
    var id = $("#edit-class option:selected").val();
    $.post("staffSubjectByClass.php", { id: id }, function(data) {
        $("#edit-subject").html(data);
    });
});
//END LOAD SUBJECT BASED ON CLASS

//edit exams scores
$("#edit-exam").on('click', function(e) {
    if (confirm("Do you really want to edit?") == true) {
        e.preventDefault();
        $('#edit-exam').text("Editing...").prop("disabled", true);
        var myclass = $("#edit-class option:selected").val();
        var subject = $("#edit-subject option:selected").val();
        var scores = $("#edit-scores").val();
        var recordid = $("#record-id").val();
        editExamScores(myclass, subject, scores, recordid);
    } else {
        $('#edit-exam').text("Edit Scores").prop("disabled", false);
    }
});

//call back function to add new continous assessment scores
function editExamScores(myclass, subject, scores, recordid) {
    $.ajax({
        url: 'editExamScores.php',
        type: 'POST',
        data: { myclass: myclass, subject: subject, scores: scores, examid: recordid },
        success: function(response) {
            var data = $.trim(response);
            if (data === "ok") {
                $('#edit-exam').text("Edit Scores").prop("disabled", false);
                var modalid = $('#myModal');
                modalid.css('display', 'none');
                $("#my-info").addClass("info");
                //call a reload function here
                reloadSubjectScores(myclass, subject);
                $("#my-info").html("Exam scores edited successfully");
            } else {
                $('#edit-exam').text("Edit Scores").prop("disabled", false);
                var modal = $('#myModal');
                modal.css('display', 'none');
                reloadSubjectScores(myclass, subject);
                $("#my-info").addClass("error");
                $("#my-info").html(data);
            }
        },
    });
}
//End function to edit exam scores

//Function to reload subject scores
function reloadSubjectScores(myclass, subject) {
    $.ajax({
        url: 'loadSubjectScores.php',
        type: 'POST',
        data: { myclass: myclass, subject: subject },
        success: function(response) {
            $("#new-content").html(response);

        },
    });

}
//end function to reload exam subjects

//EDIT CA FUNCTIONALITY

//edit exams scores
$("#edit-ca").on('click', function(e) {
    if (confirm("Do you really want to edit?") == true) {
        e.preventDefault();
        $('#edit-ca').text("Editing...").prop("disabled", true);
        var myclass = $("#edit-class option:selected").val();
        var subject = $("#edit-subject option:selected").val();
        var scores = $("#edit-scores").val();
        var recordid = $("#record-id").val();
        editca(myclass, subject, scores, recordid);
    } else {
        $('#edit-ca').text("Edit Scores").prop("disabled", false);
    }
});

//call back function to add new continous assessment scores
function editca(myclass, subject, scores, recordid) {
    $.ajax({
        url: 'editCaScores.php',
        type: 'POST',
        data: { myclass: myclass, subject: subject, scores: scores, caid: recordid },
        success: function(response) {
            var data = $.trim(response);
            if (data === "ok") {
                $('#edit-ca').text("Edit Scores").prop("disabled", false);
                var modalid = $('#myModal');
                modalid.css('display', 'none');
                $("#my-info").addClass("info");
                //call a reload function here
                reloadCaScores(myclass, subject);
                $("#my-info").html("Assessment scores edited successfully");
            } else {
                $('#edit-ca').text("Edit Scores").prop("disabled", false);
                var modal = $('#myModal');
                modal.css('display', 'none');
                reloadCaScores(myclass, subject);
                $("#my-info").addClass("error");
                $("#my-info").html(data);
            }
        },
    });
}
//funtion to reload CA scores after edit
function reloadCaScores(myclass, subject) {
    $.ajax({
        url: 'reloadCaScores.php',
        type: 'POST',
        data: { myclass: myclass, subject: subject },
        success: function(response) {
            $("#new-content").html(response);

        },
    });

}


// end CA Scores after edit
//add Session code
$("#new-content").on('click', '#add-session', function(e) {
    e.preventDefault();
    $('#add-session').prop("disabled", true);
    var session = $("#session").val();
    //var username = $("#username").val();
    //var role =  $("#role option:selected").val();
    //var jsURL = $('#input').attr('value');
    addSession(session);
});

//function to add new staff call back
function addSession(session) {
    $.ajax({
        url: 'addSession.php',
        type: 'POST',
        data: { session: session },
        success: function(response) {
            var data = $.trim(response);
            if (data === "ok") {
                $('#add-session').prop("disabled", false);
                $("#my-info").addClass("info");
                $("#my-info").html("Session added successfully, you can continue adding.");
                $("#session").val("");
            } else {
                //alert("me")
                $('#add-session').prop("disabled", false);
                $("#my-info").addClass("error");
                $("#my-info").html(data);
            }
        },
        //alert(user+pass+role);
    });
} //end new session code


//add Fee Item
$("#new-content").on('click', '#term-fee-items', function(e) {
    e.preventDefault();
    $('#term-fee-items').prop("disabled", true);
    var item = $("#item").val();
    var amount = $("#amount").val();
    var amtwrds = $("#amount-words").val();
    var term = $("#term option:selected").val();
    var session = $("#session option:selected").val();
    //var jsURL = $('#input').attr('value');
    addFeeItem(item, amount, amtwrds, term, session);
});
//function to add fee Items
function addFeeItem(item, amount, amtwrds, term, session) {
    $.ajax({
        url: 'addFeeItems.php',
        type: 'POST',
        data: { item: item, amount: amount, amtwrds: amtwrds, term: term, session: session },
        success: function(response) {
            var data = $.trim(response);
            if (data === "ok") {
                $('#term-fee-items').prop("disabled", false);
                $("#my-info").addClass("info");
                $("#my-info").html("Fee Item added successfully, you can continue adding.");
            } else {
                //alert("me")
                $('#term-fee-items').prop("disabled", false);
                $("#my-info").addClass("error");
                $("#my-info").html(data);
            }
        },
        //alert(user+pass+role);
    });
} //end add fee item


//add academic term
$("#new-content").on('click', '#add-term', function(e) {
    e.preventDefault();
    $('#add-term').prop("disabled", true);
    var term = $("#term").val();
    addTerm(term);
});

//function to add fee Items
function addTerm(term) {
    $.ajax({
        url: 'addTerm.php',
        type: 'POST',
        data: { term: term },
        success: function(response) {
            var data = $.trim(response);
            if (data === "ok") {
                $('#add-term').prop("disabled", false);
                $("#my-info").addClass("info");
                $("#my-info").html("Academic term added successfully.");
                $("#term").val("");
            } else {
                //alert("me")
                $('#add-term').prop("disabled", false);
                $("#my-info").addClass("error");
                $("#my-info").html(data);
            }
        },
        //alert(user+pass+role);
    });
} //end new term

//Retrieve all added session and display them on the page
$('.my-session').on('click', function(evt) {
    evt.preventDefault();
    var url = $(this).attr('href');
    getAddedSession(url);
});
//get session function
function getAddedSession(url) {
    //get inserted records from the database
    jQuery.getJSON(url, function(response) {
        if (typeof response === 'object') {
            var profileHTML = '<h5 class="right-menu-header">Available Sessions</h5>';
            profileHTML += '<ul>';
            $.each(response, function(index, profile) {
                //generate HTML to display added information
                profileHTML += '<li> ' + profile.session + ' </li>';
            });
            profileHTML += '</ul>';
            $('#new-content').html(profileHTML);
        } else {
            $('#new-content').html(response);
        }

    });

} //End Get Session added
///DEPRECATED

//Retrieve all  added fee items
// $('.added-fee-item').on('click', function(evt) {
//         evt.preventDefault();
//         var url = $(this).attr('href');

//         getAddedFeeItem(url);
//     })
//     //get fee items
// function getAddedFeeItem(url) {
//     //get inserted records from the database
//     jQuery.getJSON(url, function(response) {
//         if (typeof response === 'object') {
//             var profileHTML = '<h5 class="top-header">Available Fee Items</h5>';
//             profileHTML += '<ul>';
//             $.each(response, function(index, profile) {

//                 //generate HTML to display added information
//                 profileHTML += '<li class="display-list"> ' + profile.name + '-' + profile.amt + '-' + profile.myt + '-' + profile.S + '</li>';
//             });
//             profileHTML += '</ul>';
//             $('#new-content').html(profileHTML);
//         } else {
//             $('#new-content').html(response);
//         }

//     });

// } //End Get added Fee item

///////////////////////////////////////////////////////////////////////////////////////////////
//add new Student
$("#new-content").on('click', '#new-student-btn', function(e) {
    e.preventDefault();
    $('#new-student-btn').prop("disabled", true);
    var surname = $("#surname").val();
    var firstname = $("#firstname").val();
    var lastname = $("#lastname").val();
    var religion = $("#religion").val();
    var nation = $("#nation").val();
    var state = $("#state").val();
    var lg = $("#lg").val();
    var city = $("#city").val();
    var add1 = $("#address1").val();
    var add2 = $("#address2").val();
    var mail = $("#mail").val();
    var mobile = $("#mobile").val();
    var sex = $("#sex").val();
    var dob = $("#datepicker").val();
    var blood_group = $("#blood-group").val();
    var class_adm = $("#class-admitted").val();
    var arm = $("#arm").val();
    var session = $("#session").val();
    var adm_type = $("#adm-type").val();
    newStudent(surname, firstname, lastname, religion, nation, state,
        lg, city, add1, add2, mail, mobile, sex, dob,
        blood_group, class_adm, arm, session, adm_type);
});

//function to add new student
function newStudent(surname, firstname, lastname, religion, nation, state,
    lg, city, add1, add2, mail, mobile, sex, dob,
    blood_group, class_adm, arm, session, adm_type) {
    $.ajax({
        url: 'addNewStudent.php',
        type: 'POST',
        data: {
            surname: surname,
            firstname: firstname,
            lastname: lastname,
            religion: religion,
            nation: nation,
            state: state,
            lg: lg,
            city: city,
            add1: add1,
            add2: add2,
            mail: mail,
            mobile: mobile,
            sex: sex,
            dob: dob,
            blood_group: blood_group,
            class_adm: class_adm,
            arm: arm,
            session: session,
            adm_type: adm_type
        },
        success: function(response) {
            var data = $.trim(response);
            if (data === "ok") {
                $('#new-student-btn').prop("disabled", false);
                $("#my-info").addClass("info");
                var surname = $("#surname").val();
                $("#firstname").val("");
                $("#lastname").val("");
                $("#state").val("");
                $("#lg").val("");
                $("#city").val("");
                $("#address1").val("");
                $("#address2").val("");
                $("#mail").val("");
                $("#mobile").val("");
                $("#datepicker").val("");
                $("#arm").val("");
                $("#my-info").html("New Student added successfully");
            } else {
                //alert("me")
                $('#new-student-btn').prop("disabled", false);
                $("#my-info").addClass("error");
                $("#my-info").html(data);
            }
        },
        //alert(user+pass+role);
    });
}


///////////////////////

//add new Student parent
$("#new-content").on('click', '#add-parent-info', function(e) {
    e.preventDefault();
    $('#add-parent-info').prop("disabled", true);
    var studid = $("#student").val();
    var sn = $("#surname").val();
    var fn = $("#firstname").val();
    var ln = $("#lastname").val();
    var occup = $("#occupation").val();
    var sex = $("#sex").val();
    var relationship = $("#relationship").val();
    var address = $("#cont_add").val();
    var parentmail = $("#parent-mail").val();
    var mobile = $("#mobile").val();
    var emergency = $("#emergency-contact").val();
    newParent(sn, fn, ln, occup, sex, relationship, address, parentmail, mobile, emergency, studid);
});

//function to add new parent
function newParent(sn, fn, ln, occup, sex, relationship, address, parentmail, mobile, emergency, studid) {
    $.ajax({
        url: 'addNewParent.php',
        type: 'POST',
        data: {
            sn: sn,
            fn: fn,
            ln: ln,
            occup: occup,
            sex: sex,
            relationship: relationship,
            address: address,
            parentmail: parentmail,
            mobile: mobile,
            emergency: emergency,
            studid: studid
        },
        success: function(response) {
            var data = $.trim(response);
            if (data === "ok") {
                $('#add-parent-info').prop("disabled", false);
                $("#my-info").addClass("info");
                var studid = $("#student").val();
                $("#surname").val("");
                $("#firstname").val("");
                $("#lastname").val("");
                $("#occupation").val("");
                $("#cont_add").val("");
                $("#parent-mail").val("");
                $("#mobile").val("");
                $("#emergency-contact").prop("checked", false);
                $("#my-info").html("Parent added successfully");
                $("#student").empty();

            } else {
                //alert("me")
                $('#add-parent-info').prop("disabled", false);
                $("#my-info").addClass("error");
                $("#my-info").html(data);
            }
        },
    });
} //END OF ADD PARENT FOR STUDENT
//load new studens and their unassigned admission numbers on click
$("#new-content").on('click', '.loader', function(e) {
    noAdmissionNumberStud();
    fetchUnassignedNumbers();
});
//load students without admission number
function noAdmissionNumberStud() {
    $.get("loadUnassignedStudents.php", function(data) {
        $("#student").html(data);
    });
}
//load unassigned admission numbers
function fetchUnassignedNumbers() {
    $.get("loadUnassignedNumbers.php", function(data) {
        $("#add-no").html(data);
    });
}

//////////////////////////////////////////////////////////////////////////////////////////////////
//ASSIGN NEW ADMISSION NUMBER
$("#new-content").on('click', '#assign-admission-no', function(e) {
    e.preventDefault();
    $('#assign-admission-no').prop("disabled", true);
    var student_id = $("#student").val();
    var adm_num_id = $("#add-no").val();

    assignNewNumber(student_id, adm_num_id);
});

//function to assign new admission number to a student
function assignNewNumber(studid, admno) {
    $.ajax({
        url: 'assignNewAdmissionNumber.php',
        type: 'POST',
        data: { studid: studid, admno: admno },
        success: function(response) {
            var data = $.trim(response);
            if (data === "ok") {
                $('#assign-admission-no').prop("disabled", false);
                $("#my-info").addClass("info");
                noAdmissionNumberStud();
                fetchUnassignedNumbers();
                $("#my-info").html("Admission number assigned successfully");
            } else {
                //alert("me")
                $('#assign-admission-no').prop("disabled", false);
                noAdmissionNumberStud();
                fetchUnassignedNumbers();
                $("#my-info").addClass("error");
                $("#my-info").html(data);
            }
        },
    });
}

////////////////////////////////////////////////////

//ADMISSION NUMBER SETTINGS
$("#new-content").on('click', '#add-prefix', function(e) {
    e.preventDefault();
    $('#add-prefix').prop("disabled", true);
    var prefix = $("#prefix").val();
    var seperator = $("#seperator").val();

    addPrefixSettings(prefix, seperator);
});

//function to add prefix settings
function addPrefixSettings(prefix, seperator) {
    $.ajax({
        url: 'addPrefixSettings.php',
        type: 'POST',
        data: { prefix: prefix, seperator: seperator },
        success: function(response) {
            var data = $.trim(response);
            if (data === "ok") {
                $('#add-prefix').prop("disabled", false);
                $("#my-info").addClass("info");
                $("#my-info").html("Prefix settings added successfully.");
            } else {
                //alert("me")
                $('#add-prefix').prop("disabled", false);
                $("#my-info").addClass("error");
                $("#my-info").html(data);
            }
        },
        //alert(user+pass+role);
    });
} //end add fee item


////////////////////////
//GENERATE NEW NUMBERS
$("#new-content").on('click', '#add-numbers', function(e) {
    e.preventDefault();
    $('#add-numbers').prop("disabled", true);
    var range = $("#range").val();
    //var jsURL = $('#input').attr('value');
    addAdmNum(range);
});


//function to add new admission numbers
function addAdmNum(range) {
    $.ajax({
        url: 'addNewAdmissionNumbers.php',
        type: 'POST',
        data: { range: range },
        success: function(response) {
            var data = $.trim(response);
            if (data === "ok") {
                $('#add-numbers').prop("disabled", false);
                $("#range").val("");
                $("#my-info").addClass("info");
                $("#my-info").html(range + " " + "Admission numbers generated successfully.");
            } else {
                //alert("me")
                $('#add-numbers').prop("disabled", false);
                $("#my-info").addClass("error");
                $("#my-info").html(data);
            }
        },
        //alert(user+pass+role);
    });
} //end add new admission numbers

//===========================================================================
/**
 * The code block is to create staff information such as
 * Staff profile
 * staff academic details
 * staff preview
 */
//==============================================================================
//add new Staff profile
$("#new-content").on('click', '#new-staff-btn', function(e) {
    e.preventDefault();
    $('#new-staff-btn').prop("disabled", true);
    var surname = $("#surname").val();
    var firstname = $("#firstname").val();
    var lastname = $("#lastname").val();
    var religion = $("#religion").val();
    var nation = $("#nation").val();
    var state = $("#state").val();
    var lg = $("#lg").val();
    var city = $("#city").val();
    var contactAdd = $("#contactAdd").val();
    var permAdd = $("#permAdd").val();
    var mail = $("#mail").val();
    var mobile = $("#mobile").val();
    var sex = $("#sex").val();
    var dob = $("#datepicker").val();
    var blood_group = $("#blood-group").val();

    staffProfile(surname, firstname, lastname, religion, nation, state,
        lg, city, contactAdd, permAdd, mail, mobile, sex, dob,
        blood_group);
});

//function to add new staff Profile
function staffProfile(surname, firstname, lastname, religion, nation, state,
    lg, city, contactAdd, permAdd, mail, mobile, sex, dob,
    blood_group) {
    $.ajax({
        url: 'addStaffProfile.php',
        type: 'POST',
        data: {
            surname: surname,
            firstname: firstname,
            lastname: lastname,
            religion: religion,
            nation: nation,
            state: state,
            lg: lg,
            city: city,
            contactAdd: contactAdd,
            permAdd: permAdd,
            mail: mail,
            mobile: mobile,
            sex: sex,
            dob: dob,
            blood_group: blood_group,
        },
        success: function(response) {
            var data = $.trim(response);
            if (data === "ok") {
                $('#new-staff-btn').prop("disabled", false);
                $("#my-info").addClass("info");
                var surname = $("#surname").val();
                $("#firstname").val("");
                $("#lastname").val("");
                $("#state").val("");
                $("#lg").val("");
                $("#city").val("");
                $("#contactAdd").val("");
                $("#permAdd").val("");
                $("#mail").val("");
                $("#mobile").val("");
                $("#datepicker").val("");
                $("#my-info").html("New Staff profile added successfully");
            } else {
                //alert("me")
                $('#new-staff-btn').prop("disabled", false);
                $("#my-info").addClass("error");
                $("#my-info").html(data);
            }
        },
        //alert(user+pass+role);
    });
}
//End Staff profile

//Staff qualifications
$("#new-content").on('click', '#new-qualification-btn', function(e) {
    e.preventDefault();
    $('#new-qualification-btn').prop("disabled", true);
    var instname = $("#inst-name").val();
    var certname = $("#cert-name").val();
    var yrgrad = $("#yr-grad").val();

    staffQualification(instname, certname, yrgrad);
});

//function to add new student
function staffQualification(instname, certname, yrgrad) {
    $.ajax({
        url: 'addStaffQualification.php',
        type: 'POST',
        data: {
            instname: instname,
            certname: certname,
            yrgrad: yrgrad
        },
        success: function(response) {
            var data = $.trim(response);
            if (data === "ok") {
                $('#new-qualification-btn').prop("disabled", false);
                $("#my-info").addClass("info");
                $("#inst-name").val("");
                $("#cert-name").val("");
                $("#yr-grad").val("");
                $("#my-info").html("New record added!");
            } else {
                //alert("me")
                $('#new-qualification-btn').prop("disabled", false);
                $("#my-info").addClass("error");
                $("#my-info").html(data);
            }
        },
        //alert(user+pass+role);
    });
}
// Find student on entering of name or ID
//===============================================================================
// Staff academic routines
// =============================================================================
//add new continuous assessment scores
$("#new-content").on('click', '#add-ca', function(e) {
    e.preventDefault();
    $('#add-ca').prop("disabled", true);
    var regno = $("#regno").val();
    var scores = $("#scores").val();
    var studentClass = $("#assignmentclass option:selected").val();
    var ca_number = $("#ca-no option:selected").val();
    var subject = $("#listsubject option:selected").val();
    newCa(regno, scores, studentClass, ca_number, subject);
});
//call back function to add new continous assessment scores
function newCa(regno, scores, studentClass, ca_number, subject) {
    $.ajax({
        url: 'addCa.php',
        type: 'POST',
        data: { regno: regno, scores: scores, studentClass: studentClass, ca_number: ca_number, subject: subject },
        success: function(response) {
            var data = $.trim(response);
            if (data === "ok") {
                $('#add-ca').prop("disabled", false);
                $("#my-info").addClass("info");
                $("#regno").val("");
                $("#scores").val("");
                $("#my-info").html("Continous assessment added");
            } else {
                $('#add-ca').prop("disabled", false);
                $("#my-info").addClass("error");
                $("#my-info").html(data);
            }
        },
    });
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
    var studentClass = $("#my-class option:selected").val();
    //var ca_number = $("#ca-no option:selected").val();
    var subject = $("#position-subject option:selected").val();
    newExamScores(regno, scores, studentClass, subject);
});

//call back function to add new continous assessment scores
function newExamScores(regno, scores, studentClass, subject) {
    $.ajax({
        url: 'addTerminalExam.php',
        type: 'POST',
        data: { regno: regno, scores: scores, studentClass: studentClass, subject: subject },
        success: function(response) {
            var data = $.trim(response);
            if (data === "ok") {
                $('#add-exam-scores').prop("disabled", false);
                $("#my-info").addClass("info");
                $("#regno").val("");
                $("#scores").val("");
                $("#my-info").html("Examination scores added");
            } else {
                $('#add-exam-scores').prop("disabled", false);
                $("#my-info").addClass("error");
                $("#my-info").html(data);
            }
        },
    });
} //end add exam method

//PROCESS SCORESHEET

//process scoresheet
$("#new-content").on('click', '#scoresheet', function(e) {
    e.preventDefault();
    $('#scoresheet').prop("disabled", true);
    var subject = $("#position-subject option:selected").val();
    var myclass = $("#my-class option:selected").val();
    var session = $("#session option:selected").val();
    var term = $("#term option:selected").val();

    //alert(subject + myclass + session + term);
    printScoresheet(subject, myclass, session, term);
});

//call back function to add new continous assessment scores
function printScoresheet(subj, myclass, session, term) {
    $.ajax({
        url: 'processScoresheet.php',
        type: 'POST',
        data: { subj: subj, myclass: myclass, session: session, term: term },
        success: function(response) {
            var data = $.trim(response);
            if (data === "ok") {
                $('#scoresheet').prop("disabled", false);
                $("#new-content").html(data);
            } else {
                $('#scoresheet').prop("disabled", false);
                // $("#my-info").addClass("error");
                $("#new-content").html(data);
            }
        },
    });
}
//END SCORESHEE PROCESSING
//Get student details on providing a registration number
$('#new-content').on('keyup', '#regno', function() {
    var id = $("#regno").val();
    $.post("getStudent.php", { id: id }, function(data) {
        $("#user_details").html(data);
    });
});

//LOAD SUBJECT ON SELECTION OF CLASS
$('#new-content').on('change', '#my-class', function() {
    var id = $("#my-class option:selected").val();
    $.post("staffSubjectByClass.php", { id: id }, function(data) {
        $("#position-subject").html(data);
    });
});

//Assign subject position
$("#new-content").on('click', '#assign-position', function(e) {
    e.preventDefault();
    $('#assign-position').text("Processing...").prop("disabled", true);
    var subject = $("#position-subject option:selected").val();
    var myclass = $("#my-class option:selected").val();
    var session = $("#session option:selected").val();
    var term = $("#term option:selected").val();

    subjectPosition(subject, myclass, session, term);
});

//call back function to add new continous assessment scores
function subjectPosition(subj, myclass, session, term) {
    $.ajax({
        url: 'assignSubjectPosition.php',
        type: 'POST',
        data: { subj: subj, myclass: myclass, session: session, term: term },
        success: function(response) {
            var data = $.trim(response);
            if (data === "ok") {
                $('#assign-position').prop("disabled", false);
                $("#new-content").html(data);
            } else {
                $('#assign-position').text("Assign Subject Position").prop("disabled", false);
                // $("#my-info").addClass("error");
                $("#new-content").html(data);
            }
        },
    });
}

//post result
$("#new-content").on('click', '#submit-result', function(e) {
    if (confirm("Be sure that you want to submit your result summary. This action can not be reversed!") == true) {
        e.preventDefault();
        $('#submit-result').text("Submitting...").prop("disabled", true);
        var myclass = $("#my-class option:selected").val();
        var session = $("#session option:selected").val();
        var term = $("#term option:selected").val();
        postResult(myclass, session, term);
    } else {
        $('#submit-result').text("Submit Result").prop("disabled", false);
    }
});

//call back function to add new continous assessment scores
function postResult(myclass, session, term) {
    $.ajax({
        url: 'submitResultSummary.php',
        type: 'POST',
        data: { myclass: myclass, session: session, term: term },
        success: function(response) {
            var data = $.trim(response);
            if (data === "ok") {
                $('#submit-result').text("Submit Result").prop("disabled", false);
                $("#my-info").addClass("info");
                $("#my-info").html("Result summary submittted successfully");
            } else {
                $('#submit-result').text("Submit Result").prop("disabled", false);
                $("#my-info").addClass("error");
                $("#my-info").html(data);
            }
        },
    });
}
//End post result

//End assign class position
$("#new-content").on('click', '#class-position', function(e) {
    if (confirm("Be sure that you want to submit your result summary. This action can not be reversed!") == true) {
        e.preventDefault();
        $('#class-position').text("Assigning...").prop("disabled", true);
        var myclass = $("#my-class option:selected").val();
        var session = $("#session option:selected").val();
        var term = $("#term option:selected").val();
        classPositionAssign(myclass, session, term);
    } else {
        $('#class-position').text("Submit Result").prop("disabled", false);
    }
});

//call back function to add new continous assessment scores
function classPositionAssign(myclass, session, term) {
    $.ajax({
        url: 'assignClassPosition.php',
        type: 'POST',
        data: { myclass: myclass, session: session, term: term },
        success: function(response) {
            var data = $.trim(response);
            if (data === "ok") {
                $('#class-position').text("Assign Class Position").prop("disabled", false);
                $("#my-info").addClass("info");
                $("#my-info").html("Class position assigned successfully");
            } else {
                $('#class-position').text("Assign Class Position").prop("disabled", false);
                $("#my-info").addClass("error");
                $("#my-info").html(data);
            }
        },
    });
}
//End assign class position

//print continous assessment links open link in a new tab
$("#new-content").on('click', '#print-link', function(e) {
    e.preventDefault();

    var a = $(this).attr("href");
    //alert(a);
    window.open(a, '_blank');
});

//search exams
$("#new-content").on('click', '#simple-search', function(e) {
    e.preventDefault();
    $('#simple-search').prop("disabled", true);
    var searchItem = $("#basic-search-item").val();
    examSimpleSearch(searchItem);
});
//exam basic search call back
function examSimpleSearch(searchItem) {
    $.ajax({
            url: 'examBasicSearch.php',
            type: 'POST',
            data: { item: searchItem },
            dataType: 'html'
        })
        .done(function(data) {
            //console.log(data);
            $('#simple-search').prop("disabled", false);
            //$('#new-content').html(''); // blank before load.
            $('#new-content').html(data); // load here
            //$('#modal-loader').hide(); // hide loader  
        })
        .fail(function(data) {
            $('#my-info').html(data);
            //$('#modal-loader').hide();
        });
}
//end basic search


//Advanced  exam search
$("#new-content").on('click', '#advanced-search', function(e) {
    e.preventDefault();
    $('#advanced-search').prop("disabled", true);
    //var regno = $("#reg-number").val();
    var myclass = $("#my-class option:selected").val();
    var subject = $("#position-subject option:selected").val();
    var session = $("#exam-session option:selected").val();
    var term = $("#exam-term option:selected").val();
    examAdvancedSearch(myclass, subject, session, term);
});
//Adavanced exam search call back
function examAdvancedSearch(myclass, subject, session, term) {
    $.ajax({
            url: 'examAdvancedSearch.php',
            type: 'POST',
            data: { myclass: myclass, subject: subject, session: session, term: term },
            dataType: 'html'
        })
        .done(function(data) {
            //console.log(data);
            $('#advanced-search').prop("disabled", false);
            //$('#new-content').html(''); // blank before load.
            $('#new-content').html(data); // load here
            //$('#modal-loader').hide(); // hide loader  
        })
        .fail(function(data) {
            $('#my-info').html(data);
            //$('#modal-loader').hide();
        });
}
//remove
//Testing bootstrap modal popup remove
$("#new-content").on('click', '#test', function(e) {
    e.preventDefault();
    var modal_id = $(this).attr('data-target');
    console.log(modal_id);
    //alert('mmmmmmm');
    modal_id.modal('show');
    //modal_id.on('show.bs.modal', function(event) {
    //var button = $(event.relatedTarget) // Button that triggered the modal
    //var recipient = button.data('whatever') // Extract info from data-* attributes
    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
    //var modal = $(this)
    // modal.find('.modal-title').text('New message to ' + recipient)
    //modal.find('.modal-body input').val(recipient)
    //});
});
//
//SEARCH CA FUNCTIONALITY
//search ca
$("#new-content").on('click', '#ca-basic-search', function(e) {
    e.preventDefault();
    $('#ca-basic-search').prop("disabled", true);
    var searchItem = $("#stud-no").val();
    caSimpleSearch(searchItem);
});
//exam basic search call back
function caSimpleSearch(searchItem) {
    $.ajax({
            url: 'CaBasicSearch.php',
            type: 'POST',
            data: { item: searchItem },
            dataType: 'html'
        })
        .done(function(data) {
            //console.log(data);
            $('#ca-basic-search').prop("disabled", false);
            //$('#new-content').html(''); // blank before load.
            $('#new-content').html(data); // load here
            //$('#modal-loader').hide(); // hide loader  
        })
        .fail(function(data) {
            $('#my-info').html(data);
            //$('#modal-loader').hide();
        });
}
//End Basic Search

//Advanced CA Search
$("#new-content").on('click', '#advanced-search-ca', function(e) {
    e.preventDefault();
    $('#advanced-search-ca').prop("disabled", true);
    //var regno = $("#reg-number").val();
    var myclass = $("#my-class option:selected").val();
    var subject = $("#position-subject option:selected").val();
    var session = $("#ca-session option:selected").val();
    var term = $("#ca-term option:selected").val();
    //alert(myclass + subject + session + term);
    caAdvancedSearch(myclass, subject, session, term);
});
//Adavanced exam search call back
function caAdvancedSearch(myclass, subject, session, term) {
    $.ajax({
            url: 'caAdvancedSearch.php',
            type: 'POST',
            data: { myclass: myclass, subject: subject, session: session, term: term },
            dataType: 'html'
        })
        .done(function(data) {
            //console.log(data);
            $('#advanced-search-ca').prop("disabled", false);
            //$('#new-content').html(''); // blank before load.
            $('#new-content').html(data); // load here
            //$('#modal-loader').hide(); // hide loader  
        })
        .fail(function(data) {
            $('#my-info').html(data);
            //$('#modal-loader').hide();
        });
}

//Function to handle students traits

$("#new-content").on('click', '#fetch-result', function(e) {
    e.preventDefault();
    $('#fetch-result').text("Fetching...").prop("disabled", true);
    var myclass = $("#studentclass option:selected").val();
    var session = $("#session option:selected").val();
    var term = $("#term option:selected").val();
    //alert(myclass + subject + session + term);
    traitsRecords(studentclass, session, term);
});

function traitsRecords(studentclass, subject, session, term) {
    $.ajax({
            url: 'fetchTraits.php',
            type: 'POST',
            data: { myclass: myclass, session: session, term: term },
            dataType: 'html'
        })
        .done(function(data) {
            //console.log(data);
            $('#fetch-result').text("Show Result").prop("disabled", false);
            $('#new-content').html(data); // load here 
        })
        .fail(function(data) {
            $('#my-info').html(data);
            //$('#modal-loader').hide();
        });
}