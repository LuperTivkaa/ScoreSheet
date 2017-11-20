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

    var recordid = $(this).data('recordid');
    var classid = $(this).data('classid');
    var scores = $(this).data('scores');

    $('#edit-scores').val(scores);
    $('#record-id').val(recordid);
    $('#studclassid').val(classid);
    $('#modal-list').empty();
    $('#modal-error').empty();
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

$('#mystudentclass').on('change', function() {
    var id = $("#mystudentclass option:selected").val();
    $.post("staffSubjectByClass.php", { id: id }, function(data) {
        $("#mystudentsubject").html(data);
    });
});
//END LOAD SUBJECT BASED ON CLASS

//edit exams scores
$("#edit-exam").on('click', function(e) {
    if (confirm("Do you really want to edit?") == true) {
        e.preventDefault();
        $('#edit-exam').text("Editing...").prop("disabled", true);
        var myclass = $("#mystudentclass option:selected").val();
        var subject = $("#mystudentsubject option:selected").val();
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
                //var modal = $('#myModal');
                //modal.css('display', 'none');
                reloadSubjectScores(myclass, subject);
                $("#modal_error").addClass("error");
                $("#modal_error").html(data);
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
        var myclass = $("#mystudentclass option:selected").val();
        var subject = $("#mystudentsubject option:selected").val();
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
                //var modal = $('#myModal');
                //modal.css('display', 'none');
                reloadCaScores(myclass, subject);
                $("#modal_error").addClass("error");
                $("#modal_error").html(data);
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

//Functioanlity for traits modal
//Show affective traits div on button click
$('#mydefault').on('click', function(e) {
    e.preventDefault();
    var affective = $('.affective-domain-div');
    var mycomments = $('.comments-div');
    mycomments.hide();
    $('#modal-list').empty();
    $('#modal_error').empty();
    affective.show();
    $(this).removeClass("custom-btn").addClass("active-trait");
    $('#nondefault').removeClass('custom-btn active-trait').addClass('custom-btn');
    $('#studcomments').removeClass('custom-btn active-trait').addClass('custom-btn');
    $('#attendancediv').removeClass('custom-btn active-trait').addClass('custom-btn');
    var psychomotor = $('.psychomotor-domain-div');
    psychomotor.hide();

});
//Show comments div on button click
$('#studcomments').on('click', function(e) {
    e.preventDefault();
    //$('#comment-id').val("");
    var affective = $('.affective-domain-div');
    var psychomotor = $('.psychomotor-domain-div');
    var mycomments = $('.comments-div');
    var att = $('.attendance-div');
    $('#modal-list').empty();
    $('#modal_error').empty();
    $('#comment-id').val("");
    $('#nondefault').removeClass('custom-btn active-trait').addClass('custom-btn');
    $('#mydefault').removeClass('custom-btn active-trait').addClass('custom-btn');
    $('#attendancediv').removeClass('custom-btn active-trait').addClass('custom-btn');
    psychomotor.hide();
    affective.hide();
    att.hide();
    mycomments.show();
    $(this).removeClass("custom-btn").addClass("active-trait");

});
//Show attendance div
$('#attendancediv').on('click', function(e) {
    e.preventDefault();
    //$('#comment-id').val("");
    var affective = $('.affective-domain-div');
    var psychomotor = $('.psychomotor-domain-div');
    var mycomments = $('.comments-div');
    var attendance = $('.attendance-div');
    $('#modal-list').empty();
    $('#modal_error').empty();
    $('#comment-id').val("");
    $('#nondefault').removeClass('custom-btn active-trait').addClass('custom-btn');
    $('#mydefault').removeClass('custom-btn active-trait').addClass('custom-btn');
    $('#studcomments').removeClass('custom-btn active-trait').addClass('custom-btn');
    psychomotor.hide();
    affective.hide();
    mycomments.hide();
    attendance.show();
    $(this).removeClass("custom-btn").addClass("active-trait");

});
//end attendance div
//Show psychomotor div on button click
$('#nondefault').on('click', function(e) {
    e.preventDefault();
    var affective = $('.affective-domain-div');
    var mycomments = $('.comments-div');
    var psychomotor = $('.psychomotor-domain-div');
    var attend = $('.attendance-div');
    $('#modal-list').empty();
    $('#modal_error').empty();


    $('#mydefault').removeClass('custom-btn active-trait').addClass('custom-btn');
    $('#studcomments').removeClass('custom-btn active-trait').addClass('custom-btn');
    $('#attendancediv').removeClass('custom-btn active-trait').addClass('custom-btn');

    mycomments.hide();
    affective.hide();
    attend.hide();
    psychomotor.show();
    $(this).removeClass("custom-btn").addClass("active-trait");

});

//Add traits functionality 
//Handle affective domain
$("#add-affective-domain").on('click', function(e) {
    e.preventDefault();
    $('#add-affective-domain').text("Adding your selection please wait...").prop("disabled", true);
    var domain = $("#affective-domain option:selected").val();
    var grading = $("#affective-grading option:selected").val();
    var studentid = $("#record-id").val();
    addAffectiveDomain(domain, grading, studentid);

});

//call back function to add new affective domain
function addAffectiveDomain(mydomain, grading, studentid) {
    $.ajax({
        url: 'addAffectiveDomain.php',
        type: 'POST',
        data: { mydomain: mydomain, grading: grading, studentid: studentid },
        success: function(response) {
            var data = $.trim(response);
            if (data === "ok") {
                $('#add-affective-domain').text("Affective Domain").prop("disabled", false);
                //call a reload function here
                loadAffectiveTraits(studentid);
                $("#modal_error").removeClass("error").empty();
            } else {
                $('#add-affective-domain').text("Affective Domain").prop("disabled", false);
                $("#modal_error").addClass("error");
                $("#modal_error").html(data);
            }
        },
    });
}
//end functionality to handle affective domain

//Add number of days student attended school
$("#add-attendance").on('click', function(e) {
    e.preventDefault();
    $('#add-attendance').text("Adding  please wait...").prop("disabled", true);
    var days = $("#days").val();
    var studentid = $("#record-id").val();
    var classid = $("#studclassid").val();
    //var classid = $(this).data('classid');
    //alert(days + studentid + classid);
    daysAttended(classid, days, studentid);

});

//call back function to add number of days student attended school
function daysAttended(classid, days, studentid) {
    $.ajax({
        url: 'addAttendance.php',
        type: 'POST',
        data: { classid: classid, days: days, studentid: studentid },
        success: function(response) {
            var data = $.trim(response);
            if (data === "ok") {
                $('#add-attendance').text("Add Attendance").prop("disabled", false);
                $("#modal_error").addClass("info");
                $("#modal_error").text("Number of days attended school added");
                //$("#modal_error").removeClass("error").empty();
            } else {
                $('#add-attendance').text("Add Attendance").prop("disabled", false);
                $("#modal_error").addClass("error");
                $("#modal_error").html(data);
            }
        },
    });
}


//End number of days student attended school


//functionality to handle psychomotor skills
$("#add-psycho-skills").on('click', function(e) {
    e.preventDefault();
    $('#add-psycho-skills').text("Adding your selection please wait...").prop("disabled", true);
    var domain = $("#psycho-skills option:selected").val();
    var grading = $("#psycho-grading option:selected").val();
    var studentid = $("#record-id").val();
    addPsychomotorSkills(domain, grading, studentid);

});

//call back function to add new psychomotor skills
function addPsychomotorSkills(mydomain, grading, studentid) {
    $.ajax({
        url: 'addPsychomotorSkills.php',
        type: 'POST',
        data: { mydomain: mydomain, grading: grading, studentid: studentid },
        success: function(response) {
            var data = $.trim(response);
            if (data === "ok") {
                $('#add-psycho-skills').text("Psychomotor Skills").prop("disabled", false);
                //call a reload function here
                reloadPsychoSkills(studentid);
            } else {
                $('#add-psycho-skills').text("Psychomotor Skills").prop("disabled", false);
                $("#modal_error").addClass("error");
                $("#modal_error").html(data);
            }
        },
    });
}
//RELOAD AFFECTIVE DOMAIN TRAITS ADDED
function loadAffectiveTraits(studentid) {
    $.ajax({
        url: 'reloadAffectiveTraits.php',
        type: 'POST',
        data: { studentid: studentid },
        success: function(response) {
            $("#modal-list").html(response);
        },
    });
}
//END RELOAD AFFAECTIVE DOMAIN

//RELOAD PSYCHOMOTOR DOMAIN SKILLS
function reloadPsychoSkills(studentid) {
    $.ajax({
        url: 'reloadPsychomotorSkills.php',
        type: 'POST',
        data: { studentid: studentid },
        success: function(response) {
            $("#modal-list").html(response);
        },
    });
}
//END RELOAD PSYCHOMOTOR SKILLS

//REMOVE AFFECTIVE DOMAIN
$("#modal-list").on('click', '#remove-trait', function(e) {
    e.preventDefault();

    if (confirm("Are you sure you want to rmove item. This action can not be reversed!") == true) {
        $('#remove-trait').prop("disabled", true);
        var id = $(this).data('id');
        var examid = $("#record-id").val();
        deleteAffectiveSkills(id, examid);
    } else {
        $('#remove-trait').prop("disabled", false);
    }

});
//call back for delete affective skilss
function deleteAffectiveSkills(id, recordid) {
    $.ajax({
        url: 'deleteAffectiveSkills.php',
        type: 'POST',
        data: { id: id },
        success: function(response) {
            var data = $.trim(response);
            if (data === "ok") {
                //call a reload function here
                loadAffectiveTraits(recordid);
            } else {
                $('#remove-trait').prop("disabled", false);
                $("#modal_error").addClass("error");
                $("#modal_error").html(data);
            }
        },
    });
}
//end

//Remove psychomotor skills
$("#modal-list").on('click', '#remove-psycho-trait', function(e) {
    e.preventDefault();

    if (confirm("Are you sure you want to rmove item. This action can not be reversed!") == true) {
        $('#remove-psycho-trait').prop("disabled", true);
        var id = $(this).data('id');
        var examid = $("#record-id").val();
        alert(examid);
        deletePsychoSkills(id, examid);
    } else {
        $('#remove-psycho-trait').prop("disabled", false);
    }

});
//call back for delete affective skilss
function deletePsychoSkills(id, recordid) {
    $.ajax({
        url: 'deletePsychomotorSkills.php',
        type: 'POST',
        data: { id: id },
        success: function(response) {
            var data = $.trim(response);
            if (data === "ok") {
                //call a reload function here
                reloadPsychoSkills(recordid);
            } else {
                $('#remove-psycho-trait').prop("disabled", false);
                $("#modal_error").addClass("error");
                $("#modal_error").html(data);
            }
        },
    });
}

//remove staff subjecct taught
$("#new-content").on('click', '#removesubjecttaught', function(e) {
    e.preventDefault();

    if (confirm("Are you sure you want to remove item. This action can not be reversed!") == true) {
        $('#removesubjecttaught').text('Removing...').prop("disabled", true);
        var id = $(this).data('recordid');
        //var examid = $("#record-id").val();
        deleteStaffSubject(id);
    } else {
        $('#removsubjeecttaught').text('Remove').prop("disabled", false);
    }

});
//call back for delete affective skilss
function deleteStaffSubject(id) {
    $.ajax({
        url: 'deleteStaffSubject.php',
        type: 'POST',
        data: { id: id },
        success: function(response) {
            var data = $.trim(response);
            if (data === "ok") {
                //call a reload function here
                reloadStaffSubject();
            } else {
                $('#removesubjecttaught').tex('Remove').prop("disabled", false);
                $("#my-info").addClass("error");
                $("#my-info").html(data);
            }
        },
    });
}
//end remove staff subject taught

//Reload Staff Subjects
function reloadStaffSubject() {
    $.ajax({
        url: 'subjectTeachers.php',
        type: 'POST',
        data: {},
        success: function(response) {
            $("#new-content").html(response);

        },
    });
}



//end reload staff subjects

//Count characters in a comment text area
$('#comment-id').keyup(function() {
    var maxLength = 50;
    var textlen = maxLength - $(this).val().length;
    if (textlen >= 0) {
        $('#textRemaining').text(textlen);
        $('#add-comments').prop("disabled", false);
    } else {
        $('#textRemaining').text(textlen);
        $('#add-comments').prop("disabled", true);
    }
});

//Add Admin Comments
//ADD STAFF COMMENTS
$("#admin-comments").on('click', function(e) {
    e.preventDefault();
    $('#admin-comments').text('Adding Comment...').prop("disabled", true);
    //var id = $(this).data('id');
    var studentid = $("#record-id").val();
    var staffcomment = $("#comment-id").val();
    //alert(examrecordid + staffcomment);
    adminComment(studentid, staffcomment);
});
//call back for delete affective skilss
function adminComment(studentid, staffcomment) {
    $.ajax({
        url: 'addAdminComment.php',
        type: 'POST',
        data: { studentid: studentid, staffcomment: staffcomment },
        success: function(response) {
            var data = $.trim(response);
            if (data === "ok") {
                //call a reload function here
                //reloadPsychoSkills(recordid);
                $('#admin-comments').text('Add Comment').prop("disabled", false);
                $("#modal_error").addClass("info");
                $("#modal_error").text("Comments added");
            } else {
                $('#admin-comments').text('Add Comment').prop("disabled", false);
                $("#modal_error").addClass("error");
                $("#modal_error").html(data);
            }
        },
    });
}

//Add Admin comments

//ADD STAFF COMMENTS
$("#add-comments").on('click', function(e) {
    e.preventDefault();
    $('#add-comments').text('Adding Comment...').prop("disabled", true);
    //var id = $(this).data('id');
    var studentid = $("#record-id").val();
    var staffcomment = $("#comment-id").val();
    //alert(examrecordid + staffcomment);
    staffComment(studentid, staffcomment);
});
//call back for delete affective skilss
function staffComment(studentid, staffcomment) {
    $.ajax({
        url: 'addStaffComment.php',
        type: 'POST',
        data: { studentid: studentid, staffcomment: staffcomment },
        success: function(response) {
            var data = $.trim(response);
            if (data === "ok") {
                //call a reload function here
                //reloadPsychoSkills(recordid);
                $('#add-comments').text('Add Comment').prop("disabled", false);
                $("#modal_error").addClass("info");
                $("#modal_error").text("Comments added");
            } else {
                $('#add-comments').text('Add Comment').prop("disabled", false);
                $("#modal_error").addClass("error");
                $("#modal_error").html(data);
            }
        },
    });
}

//Show staff (class teacher) comments summary
$("#new-content").on('click', '#comments-summary', function(e) {
    e.preventDefault();
    $('#comments-summary').text('Please wait...').prop("disabled", true);
    //var id = $(this).data('id');
    var myclass = $("#s-class option:selected").val();
    var session = $("#s-session option:selected").val();
    var term = $("#s-term option:selected").val();
    //alert(myclass + session + term);

    staffSummaryComments(myclass, session, term);
});
//call back for class teacher comments
function staffSummaryComments(myclass, session, term) {
    $.ajax({
        url: 'commentSummary.php',
        type: 'POST',
        data: { myclass: myclass, session: session, term: term },
        success: function(response) {
            var data = $.trim(response);
            if (data === "ok") {
                //call a reload function here
                //reloadPsychoSkills(recordid);
                $('#comments-summary').text('Show Result Comment').prop("disabled", false);
                //$("#modal_error").addClass("info");
                //$("#modal_error").text("Comments added");
                $("#new-content").html(data);
            } else {
                //$('#add-comments').text('Add Comment').prop("disabled", true);
                $('#comments-summary').text('Show Result Comment').prop("disabled", false);
                //$("#modal_error").addClass("error");
                $("#new-content").html(data);
            }
        },
    });
}
//Publish Result functionality
/**
 * This function is to publish result
 * Admin can only see result when published by the class teacher
 */
//publish result for Head Teacher by class teacher
$("#new-content").on('click', '#publish-result', function(e) {
    e.preventDefault();
    $('#publish-result').text('Publishing...').prop("disabled", true);
    //var id = $(this).data('id');
    var myclass = $("#studentclass option:selected").val();
    var session = $("#session option:selected").val();
    var term = $("#term option:selected").val();

    publishResult(myclass, session, term);
});
//call back for delete affective skilss
function publishResult(myclass, session, term) {
    $.ajax({
        url: 'finalResultPublish.php',
        type: 'POST',
        data: { myclass: myclass, session: session, term: term },
        success: function(response) {
            var data = $.trim(response);
            if (data === "ok") {
                //call a reload function here
                //reloadPsychoSkills(recordid);
                $('#publish-result').text('Publish Result').prop("disabled", false);
                $("#my-info").addClass("info");
                $("#my-info").text("Result Published");
            } else {
                //$('#add-comments').text('Add Comment').prop("disabled", true);
                $('#publish-result').text('Publish Result').prop("disabled", false);
                $("#my-info").addClass("error");
                $("#my-info").html(data);
            }
        },
    });
}


//Display result for approval 
$("#new-content").on('click', '#result-approval', function(e) {
    e.preventDefault();
    $('#result-approval').text('Please wait...').prop("disabled", true);
    //var id = $(this).data('id');
    var myclass = $("#s-class option:selected").val();
    var session = $("#s-session option:selected").val();
    var term = $("#s-term option:selected").val();
    //alert(myclass + session + term);

    summaryComments(myclass, session, term);
});
//call back for result approval
function summaryComments(myclass, session, term) {
    $.ajax({
        url: 'displayFinalComments.php',
        type: 'POST',
        data: { myclass: myclass, session: session, term: term },
        success: function(response) {
            var data = $.trim(response);
            if (data === "ok") {
                //call a reload function here
                //reloadPsychoSkills(recordid);
                $('#result-approval').text('Result Approval').prop("disabled", false);
                //$("#modal_error").addClass("info");
                //$("#modal_error").text("Comments added");
                $("#new-content").html(data);
            } else {
                //$('#add-comments').text('Add Comment').prop("disabled", true);
                $('#result-approval').text('Result Approval').prop("disabled", false);
                //$("#modal_error").addClass("error");
                $("#new-content").html(data);
            }
        },
    });
}
//end display result for approval

//Code to approve result by admin
$("#new-content").on('click', '#approve', function(e) {
    e.preventDefault();
    var mybutton = $(this);
    //var approveID = $(this).attr('id');
    // var Approval = $(this).text('Undo Approval');
    // var changedClass = $(this).removeClass('not-approvedBtn').addClass('approvedBtn');
    //var approveClass = $(this).attr('class');
    var studentid = $(this).data('recordid');

    $(this).text('Please wait...');

    adminApproveResult(studentid, mybutton);
});
//call back for approving result
function adminApproveResult(studentid, mybutton) {
    $.ajax({
        url: 'adminApproveResult.php',
        type: 'POST',
        data: { studentid: studentid },
        success: function(response) {
            var data = $.trim(response);
            if (data === "ok") {

                mybutton.attr('id', 'disapprove');
                //alert(id);
                //$(this).attr('id', 'disapprove');
                mybutton.text('Undo Approval');
                mybutton.removeClass('not-approvedBtn').addClass('approvedBtn');
            } else {
                mybutton.text('Approve');
                $("#info").addClass("error");
                $("#info").html(data);
            }
        },
    });
}
//End code to approve

//Code to disapprove result

$("#new-content").on('click', '#disapprove', function(e) {
    e.preventDefault();
    var mybutton = $(this);

    var studentid = $(this).data('recordid');
    $(this).text('Please wait...');
    adminDisapproveResult(studentid, mybutton);
});
//call back for disapproving result
function adminDisapproveResult(studentid, mybutton) {
    $.ajax({
        url: 'adminUnapproveResult.php',
        type: 'POST',
        data: { studentid: studentid },
        success: function(response) {
            var data = $.trim(response);
            if (data === "ok") {

                mybutton.attr('id', 'approve');
                //alert(id);
                //$(this).attr('id', 'disapprove');
                mybutton.text('Approve');
                mybutton.removeClass('approvedBtn').addClass('not-approvedBtn');
            } else {

                mybutton.text('Undo Approval');
                $("#info").addClass("error");
                $("#info").html(data);
            }
        },
    });
}
//end code to disapprove result

/**
 * The code block below active and deactivate Sch_terms
 */

//Code to activate sch term
$("#new-content").on('click', '#activate', function(e) {
    e.preventDefault();
    var mybutton = $(this);

    var termid = $(this).data('recordid');

    $(this).text('Please wait...');

    activateTerm(termid, mybutton);
});
//call back for activating term
function activateTerm(termid, mybutton) {
    $.ajax({
        url: 'activateTerm.php',
        type: 'POST',
        data: { termid: termid },
        success: function(response) {
            var data = $.trim(response);
            if (data === "ok") {

                mybutton.attr('id', 'deactivate');
                //alert(id);
                //$(this).attr('id', 'disapprove');
                mybutton.text('Deactivate');
                mybutton.removeClass('not-approvedBtn').addClass('approvedBtn');
            } else {
                mybutton.text('Activate');
                $("#my-info").addClass("error");
                $("#my-info").html(data);
            }
        },
    });
}
//End code to activate sch term

//Code to deactivate term
$("#new-content").on('click', '#deactivate', function(e) {
    e.preventDefault();
    var mybutton = $(this);

    var termid = $(this).data('recordid');
    $(this).text('Please wait...');
    deactivateTerm(termid, mybutton);
});
//call back for disapproving result
function deactivateTerm(termid, mybutton) {
    $.ajax({
        url: 'deactivateTerm.php',
        type: 'POST',
        data: { termid: termid },
        success: function(response) {
            var data = $.trim(response);
            if (data === "ok") {

                mybutton.attr('id', 'activate');
                //alert(id);
                //$(this).attr('id', 'disapprove');
                mybutton.text('Activate');
                mybutton.removeClass('approvedBtn').addClass('not-approvedBtn');
            } else {

                mybutton.text('Deactivate');
                $("#my-info").addClass("error");
                $("#my-info").html(data);
            }
        },
    });
}

//end code to deactivate term

//=================================================================================
/**
 * Code to approve/activate staff 
 */
//Code to activate staff user
$("#new-content").on('click', '#staffOn', function(e) {
    e.preventDefault();
    var mybutton = $(this);

    var staffuserid = $(this).data('recordid');

    $(this).text('Please wait...');

    approveStaffUser(staffuserid, mybutton);
});
//call back for activating staff user
function approveStaffUser(userid, mybutton) {
    $.ajax({
        url: 'approveStaffUser.php',
        type: 'POST',
        data: { userid: userid },
        success: function(response) {
            var data = $.trim(response);
            if (data === "ok") {

                mybutton.attr('id', 'staffOff');
                //alert(id);
                //$(this).attr('id', 'disapprove');
                mybutton.text('Deactivate');
                mybutton.removeClass('not-approvedBtn').addClass('approvedBtn');
            } else {
                mybutton.text('Activate');
                $("#my-info").addClass("error");
                $("#my-info").html(data);
            }
        },
    });
}
//End code to activate Staff user

//code to un approve staff user
$("#new-content").on('click', '#staffOff', function(e) {
    e.preventDefault();
    var mybutton = $(this);

    var staffuserid = $(this).data('recordid');
    $(this).text('Please wait...');
    unapproveStaffUser(staffuserid, mybutton);
});
//call back for disapproving result
function unapproveStaffUser(userid, mybutton) {
    $.ajax({
        url: 'unapproveStaffUser.php',
        type: 'POST',
        data: { userid: userid },
        success: function(response) {
            var data = $.trim(response);
            if (data === "ok") {

                mybutton.attr('id', 'staffOn');
                //alert(id);
                //$(this).attr('id', 'disapprove');
                mybutton.text('Activate');
                mybutton.removeClass('approvedBtn').addClass('not-approvedBtn');
            } else {

                mybutton.text('Deactivate');
                $("#my-info").addClass("error");
                $("#my-info").html(data);
            }
        },
    });
}

//end code to deactivate term




//==================================================================================

/**
 * The code block below activate/deactivate sessions
 * 
 */

//Code to activate sessions
$("#new-content").on('click', '#on', function(e) {
    e.preventDefault();
    var mybutton = $(this);

    var sessionid = $(this).data('recordid');

    $(this).text('Please wait...');

    activateSess(sessionid, mybutton);
});
//call back for activating sessions
function activateSess(sessionid, mybutton) {
    $.ajax({
        url: 'activateSession.php',
        type: 'POST',
        data: { sessionid: sessionid },
        success: function(response) {
            var data = $.trim(response);
            if (data === "ok") {

                mybutton.attr('id', 'off');
                //alert(id);
                //$(this).attr('id', 'disapprove');
                mybutton.text('Deactivate');
                mybutton.removeClass('not-approvedBtn').addClass('approvedBtn');
            } else {
                mybutton.text('Activate');
                $("#my-info").addClass("error");
                $("#my-info").html(data);
            }
        },
    });
}
//End code to activate sch session

/**
 * Code block below is to activate or deactivate admission number settings
 */

//Activate admission settings
$("#new-content").on('click', '#prefixOn', function(e) {
    e.preventDefault();
    var mybutton = $(this);

    var settingid = $(this).data('recordid');

    $(this).text('Please wait...');

    activateAdmissionSetting(settingid, mybutton);
});
//call back for admission settings
function activateAdmissionSetting(settingid, mybutton) {
    $.ajax({
        url: 'activateAdmNoSettings.php',
        type: 'POST',
        data: { settingid: settingid },
        success: function(response) {
            var data = $.trim(response);
            if (data === "ok") {

                mybutton.attr('id', 'prefixOff');
                //alert(id);
                //$(this).attr('id', 'disapprove');
                mybutton.text('Deactivate');
                mybutton.removeClass('not-approvedBtn').addClass('approvedBtn');
            } else {
                mybutton.text('Activate');
                $("#my-info").addClass("error");
                $("#my-info").html(data);
            }
        },
    });
}
//End code to activate admission setting

//Code to deactivate setting
$("#new-content").on('click', '#prefixOff', function(e) {
    e.preventDefault();
    var mybutton = $(this);

    var settingid = $(this).data('recordid');
    $(this).text('Please wait...');
    deactivateSetting(settingid, mybutton);
});
//call back for deactivating setting
function deactivateSetting(settingid, mybutton) {
    $.ajax({
        url: 'deactivateAdmNoSettings.php',
        type: 'POST',
        data: { settingid: settingid },
        success: function(response) {
            var data = $.trim(response);
            if (data === "ok") {

                mybutton.attr('id', 'prefixOn');
                mybutton.text('Activate');
                mybutton.removeClass('approvedBtn').addClass('not-approvedBtn');
            } else {

                mybutton.text('Deactivate');
                $("#my-info").addClass("error");
                $("#my-info").html(data);
            }
        },
    });
}
//End activate admission settings



//Code to deactivate session
$("#new-content").on('click', '#off', function(e) {
    e.preventDefault();
    var mybutton = $(this);

    var sessionid = $(this).data('recordid');
    $(this).text('Please wait...');
    deactivateSess(sessionid, mybutton);
});
//call back for deactivating session
function deactivateSess(sessionid, mybutton) {
    $.ajax({
        url: 'deactivateSession.php',
        type: 'POST',
        data: { sessionid: sessionid },
        success: function(response) {
            var data = $.trim(response);
            if (data === "ok") {

                mybutton.attr('id', 'on');
                //alert(id);
                //$(this).attr('id', 'disapprove');
                mybutton.text('Activate');
                mybutton.removeClass('approvedBtn').addClass('not-approvedBtn');
            } else {

                mybutton.text('Deactivate');
                $("#my-info").addClass("error");
                $("#my-info").html(data);
            }
        },
    });
}
//
//==========================================================================================
/**
 * Code to show Client view staff user modal
 */
$('#new-content').on('click', '#viewStaffUser', function(e) {
    e.preventDefault();

    var userid = $(this).data('recordid');
    // //var editValue = $(this).data('value');
    //alert(userid);

    // ///$('#item-value').val(editValue);
    // $('#record-id').val(recordid);

    $('#modal-list').empty();
    $('#modal-error').empty();
    var modalid = $('#myModal');

    modalid.css('display', 'block');
    viewStaffUser(userid);
});

//function to fetch and display user profile
function viewStaffUser(userid) {
    $.ajax({
            url: 'viewStaffUser.php',
            type: 'POST',
            data: { userid: userid },
            dataType: 'html'
        })
        .done(function(data) {
            //console.log(data);
            //$('#published-result').text("Show Result").prop("disabled", false);
            $('.viewStaff-div').html(data); // load here 
        })
        .fail(function(data) {
            $('#my_info').html(data);
            //$('#modal-loader').hide();
        });
}
//End View User modal functionality
//======================================================================

/**
 * CODE TO SHOW ACADEMIC SETTINGS MANAGEMENT  AND MODAL
 */
//Edit exam  modal js
$('#new-content').on('click', '#editModal', function(e) {
    e.preventDefault();
    //$("#modal_error").empty();

    var recordid = $(this).data('recordid');
    var editValue = $(this).data('value');
    var staffID = $(this).data('staffid');
    //alert(editValue + recordid);

    $('#item-value').val(editValue);
    $('#record-id').val(recordid);
    $('#staffID').val(staffID);

    $('#modal-list').empty();
    $('#modal_error').empty();
    var modalid = $('#myModal');
    modalid.css('display', 'block');
});
//Show edit term div
$('#new-content').on('click', '.term-div', function(e) {
    //show term editable div on button click

    var itemvalue = $('#item-value').val();

    $('#editterm').val(itemvalue);
    $('.term-div').show();
    $('.session-div').hide();
    $('.subject-div').hide();
    $('.class-div').hide();
    $('.prefix-div').hide();
    $('.staffsubjects-div').hide();
});
//Show session-div
$('#new-content').on('click', '.session-div', function(e) {
    var itemvalue = $('#item-value').val();
    $('#editsession').val(itemvalue);
    $('.session-div').show();
    $('.term-div').hide();
    $('.subject-div').hide();
    $('.class-div').hide();
    $('.prefix-div').hide();
    $('.staffsubjects-div').hide();
});
//Show staffsubjects-div
$('#new-content').on('click', '.staffsubjects-div', function(e) {
    //show value to be edited
    //var itemvalue = $('#item-value').val();
    //$('#editsession').val(itemvalue);
    $('.staffsubjects-div').show();
    $('.session-div').hide();
    $('.term-div').hide();
    $('.subject-div').hide();
    $('.class-div').hide();
    $('.prefix-div').hide();
});
//Show subject-div
$('#new-content').on('click', '.subject-div', function(e) {
    var itemvalue = $('#item-value').val();
    $('#editsubject').val(itemvalue);
    $('.subject-div').show();
    $('.term-div').hide();
    $('.session-div').hide();
    $('.class-div').hide();
    $('.prefix-div').hide();
    $('.staffsubjects-div').hide();
});
//Show class-div
$('#new-content').on('click', '.class-div', function(e) {
    var itemvalue = $('#item-value').val();
    $('#editclass').val(itemvalue);
    $('.class-div').show();
    $('.term-div').hide();
    $('.session-div').hide();
    $('.subject-div').hide();
    $('.prefix-div').hide();
    $('.staffsubjects-div').hide();
});

//Show Prefix Settings
$('#new-content').on('click', '.prefix-div', function(e) {
    var itemvalue = $('#item-value').val();
    $('#editprefix').val(itemvalue);
    $('.prefix-div').show();
    $('.class-div').hide();
    $('.term-div').hide();
    $('.session-div').hide();
    $('.subject-div').hide();
    $('.staffsubjects-div').hide();
});

/**
 * Code block to handle edit functionalities for academic management settings
 */

//Funtion to handle edit term
$('#edit-term').on('click', function(e) {
    e.preventDefault();
    //$("#modal_error").empty();
    var mybutton = $(this);
    var termid = $('#record-id').val();
    var term = $('#editterm').val();

    //var termid = $(this).data('recordid');
    $('#edit-term').text('Updating...').prop('disable', true);
    editSchTerm(termid, term);
});
//call back for editing term
function editSchTerm(termid, term) {
    $.ajax({
        url: 'editSchTerm.php',
        type: 'POST',
        data: { termid: termid, term: term },
        success: function(response) {
            var data = $.trim(response);
            if (data === "ok") {
                $('#edit-term').text('Update Term').prop('disable', false);
                $('#editterm').val("");
                $("#modal_error").addClass("info");
                $("#modal_error").text("Term updated");
            } else {
                $('#edit-term').text('Update Term').prop('disable', false);
                $("#modal_error").addClass("error");
                $("#modal_error").html(data);
            }
        },
    });
}
//End function call back to edit term


//Function to edit subject
$('#edit-subject').on('click', function(e) {
    e.preventDefault();
    //$("#modal_error").empty();
    var subjectid = $('#record-id').val();
    var subject = $('#editsubject').val();

    //var termid = $(this).data('recordid');
    $('#edit-subject').text('Updating...').prop('disable', true);
    editSchSubject(subjectid, subject);
});
//call back for edit subject
function editSchSubject(subjectid, subject) {
    $.ajax({
        url: 'editSchSubject.php',
        type: 'POST',
        data: { subjectid: subjectid, subject: subject },
        success: function(response) {
            var data = $.trim(response);
            if (data === "ok") {
                $('#edit-subject').text('Update Subject').prop('disable', false);
                $('#editsubject').val("");
                $("#modal_error").addClass("info");
                $("#modal_error").text("Subject updated");
            } else {
                $('#edit-subject').text('Update Term').prop('disable', false);
                $("#modal_error").addClass("error");
                $("#modal_error").html(data);
            }
        },
    });
}
//end subject to edit subject

//Function to edit sessions

$('#edit-session').on('click', function(e) {
    e.preventDefault();
    //$("#modal_error").empty();
    var sessionid = $('#record-id').val();
    var session = $('#editsession').val();

    //var termid = $(this).data('recordid');
    $('#edit-session').text('Updating...').prop('disable', true);
    editSchSession(sessionid, session);
});
//call back for edit subject
function editSchSession(sessionid, session) {
    $.ajax({
        url: 'editSchSession.php',
        type: 'POST',
        data: { sessionid: sessionid, session: session },
        success: function(response) {
            var data = $.trim(response);
            if (data === "ok") {
                $('#edit-session').text('Update Session').prop('disable', false);
                $('#editsession').val("");
                $("#modal_error").addClass("info");
                $("#modal_error").text("Session updated");
            } else {
                $('#edit-session').text('Update Session').prop('disable', false);
                $("#modal_error").addClass("error");
                $("#modal_error").html(data);
            }
        },
    });
}
//end function to edit sessions


//Function to edit classes
$('#edit-class').on('click', function(e) {
    e.preventDefault();
    //$("#modal_error").empty();
    var classid = $('#record-id').val();
    var schclass = $('#editclass').val();

    //var termid = $(this).data('recordid');
    $('#edit-class').text('Updating...').prop('disable', true);
    editSchClass(classid, schclass);
});
//call back for edit class
function editSchClass(classid, schclass) {
    $.ajax({
        url: 'editSchClass.php',
        type: 'POST',
        data: { classid: classid, schclass: schclass },
        success: function(response) {
            var data = $.trim(response);
            if (data === "ok") {
                $('#edit-class').text('Update Class').prop('disable', false);
                $('#editclass').val("");
                $("#modal_error").addClass("info");
                $("#modal_error").text("Class updated successfully");
            } else {
                $('#edit-class').text('Update Class').prop('disable', false);
                $("#modal_error").addClass("error");
                $("#modal_error").html(data);
            }
        },
    });
}
//end function to edit classes

//Function to edit prefix settings
$('#edit-prefix').on('click', function(e) {
    e.preventDefault();
    //$("#modal_error").empty();
    var prefixid = $('#record-id').val();
    var prefix = $('#editprefix').val();
    //alert(prefixid + prefix);

    //var termid = $(this).data('recordid');
    $('#edit-prefix').text('Updating...').prop('disable', true);
    editSchPrefix(prefixid, prefix);
});
//call back for edit prefix
function editSchPrefix(prefixid, prefix) {
    $.ajax({
        url: 'editSchPrefix.php',
        type: 'POST',
        data: { prefixid: prefixid, prefix: prefix },
        success: function(response) {
            var data = $.trim(response);
            if (data === "ok") {
                $('#edit-prefix').text('Update Prefix').prop('disable', false);
                $('#editprefix').val("");
                $("#modal_error").addClass("info");
                $("#modal_error").text("Update of prefix settings successful");
                //$("#modal_error").empty();
            } else {
                $('#edit-prefix').text('Update Prfeix').prop('disable', false);
                $("#modal_error").addClass("error");
                $("#modal_error").html(data);
            }
        },
    });
}
//End function to edit prefix settings
//===========================================================================================================

//PROMOTION CDE BLOCK
//load promotion settings page
$('#new-content').on('click', '#loadClassSettings', function(evt) {
    evt.preventDefault();
    // $("#my-info").empty();
    // $('#student-search-result').empty();
    var url = $(this).attr('href');
    $('#promotionSettings').load(url);
});
//end load promotion settings page

//===========================================================================================================
//Code to promote student
$("#new-content").on('click', '#promote', function(e) {
    e.preventDefault();
    var mybutton = $(this);
    var promotedClass = $("#promotedclass option:selected").val();
    var promotedSess = $("#promotedsession option:selected").val();
    var recordid = $(this).data('recordid');
    var studentid = $(this).data('studentid');

    $(this).text('Please wait...');

    promote(recordid, promotedClass, promotedSess, studentid, mybutton);
});
//call back for promoting student
function promote(recordid, promotedClass, promotedSess, studentid, mybutton) {
    $.ajax({
        url: 'promoteStudent.php',
        type: 'POST',
        data: { recordid: recordid, promotedClass: promotedClass, promotedSess: promotedSess, studentid: studentid },
        success: function(response) {
            var data = $.trim(response);
            if (data === "ok") {

                mybutton.attr('id', 'unpromote');
                //alert(id);
                //$(this).attr('id', 'disapprove');
                mybutton.text('Unpromote');
                mybutton.removeClass('not-approvedBtn').addClass('approvedBtn');
            } else {
                mybutton.text('Promote');
                $("#my-info").addClass("error");
                $("#my-info").html(data);
            }
        },
    });
}
//end code to promoting student

//===========
//code block to unpromote student
$("#new-content").on('click', '#unpromote', function(e) {
    e.preventDefault();
    var mybutton = $(this);
    //alert("unpromote click");
    var promotedClass = $("#promotedclass option:selected").val();
    var promotedSess = $("#promotedsession option:selected").val();
    var recordid = $(this).data('recordid');
    var studentid = $(this).data('studentid');
    $(this).text('Please wait...');
    unpromote(recordid, promotedClass, promotedSess, studentid, mybutton);
});
//call back for unpromoting student
function unpromote(recordid, promotedClass, promotedSess, studentid, mybutton) {
    $.ajax({
        url: 'unpromoteStudent.php',
        type: 'POST',
        data: { recordid: recordid, promotedClass: promotedClass, promotedSess: promotedSess, studentid: studentid },
        success: function(response) {
            var data = $.trim(response);
            if (data === "ok") {

                mybutton.attr('id', 'promote');
                //alert(id);
                //$(this).attr('id', 'disapprove');
                mybutton.text('Promote');
                mybutton.removeClass('approvedBtn').addClass('not-approvedBtn');
            } else {

                mybutton.text('Unpromote');
                $("#my-info").addClass("error");
                $("#my-info").html(data);
            }
        },
    });
}
//end code to unpromote student