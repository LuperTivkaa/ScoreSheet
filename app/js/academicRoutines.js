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
    //alert(myclass + session + term);
    traitsRecords(myclass, session, term);
});

function traitsRecords(studentclass, session, term) {
    $.ajax({
            url: 'fetchTraits.php',
            type: 'POST',
            data: { studentclass: studentclass, session: session, term: term },
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

//fetch published results for admin comments
$("#new-content").on('click', '#published-result', function(e) {
    e.preventDefault();
    $('#fetch-result').text("Fetching...").prop("disabled", true);
    var myclass = $("#studentclass option:selected").val();
    var session = $("#session option:selected").val();
    var term = $("#term option:selected").val();
    //alert(myclass + session + term);
    publishedReslt(myclass, session, term);
});

function publishedReslt(studentclass, session, term) {
    $.ajax({
            url: 'publishedResult.php',
            type: 'POST',
            data: { studentclass: studentclass, session: session, term: term },
            dataType: 'html'
        })
        .done(function(data) {
            //console.log(data);
            $('#published-result').text("Show Result").prop("disabled", false);
            $('#new-content').html(data); // load here 
        })
        .fail(function(data) {
            $('#my-info').html(data);
            //$('#modal-loader').hide();
        });
}

//End published results for admin comments