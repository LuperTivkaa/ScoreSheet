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
    var studentClass = $("#studclass option:selected").val();
    //var ca_number = $("#ca-no option:selected").val();
    var subject = $("#listsubject option:selected").val();
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
        var myclass = $("#myclass option:selected").val();
        var session = $("#session option:selected").val();
        var term = $("#term option:selected").val();
        postResult(myclass, session, term);
    } else {
        $('#assign-position').text("Assign Subject Position").prop("disabled", false);
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
                $('#submit-result').prop("disabled", false);
                $("#my-info").html("Result summary submittted successfully");
            } else {
                $('#submit-result').text("Assign Subject Position").prop("disabled", false);
                //$("#my-info").addClass("error");
                $("#my-info").html(data);
            }
        },
    });
}