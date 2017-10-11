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