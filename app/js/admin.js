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


//EDIT STUDENT INFORMATION

$("#edit-student-btn").on('click', function(e) {
    e.preventDefault();
    $('#edit-student-btn').text('Saving...').prop("disabled", true);
    var surname = $("#surname").val();
    var firstname = $("#firstname").val();
    var studid = $("#studid").val();
    var lastname = $("#lastname").val();
    var religion = $("#religion").val();
    var nation = $("#stud-nation").val();
    var state = $("#stud-state").val();
    var lg = $("#stud-lg").val();
    var city = $("#stud-city").val();
    var add1 = $("#address1").val();
    var add2 = $("#address2").val();
    var mail = $("#mail").val();
    var mobile = $("#mobile").val();
    var sex = $("#sex").val();
    var dob = $("#datepicker").val();
    var blood_group = $("#blood-group").val();
    var class_adm = $("#class-admitted").val();
    //var arm = $("#arm").val();
    var session = $("#session").val();
    var adm_type = $("#adm-type").val();
    editStudent(studid, surname, firstname, lastname, religion, nation, state,
        lg, city, add1, add2, mail, mobile, sex, dob,
        blood_group, class_adm, session, adm_type);
});

//function to add new student
function editStudent(studid, surname, firstname, lastname, religion, nation, state,
    lg, city, add1, add2, mail, mobile, sex, dob,
    blood_group, class_adm, session, adm_type) {
    $.ajax({
        url: 'editStudent.php',
        type: 'POST',
        data: {
            studid: studid,
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
            session: session,
            adm_type: adm_type
        },
        success: function(response) {
            var data = $.trim(response);
            if (data === "ok") {
                $('#edit-student-btn').text('Save Changes').prop("disabled", false);
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
                $("#my-info").html(" Student Updated Successfully");
            } else {
                //alert("me")
                $('#edit-student-btn').text('Save Changes').prop("disabled", false);
                $("#my-info").addClass("error");
                $("#my-info").html(data);
            }
        },
        //alert(user+pass+role);
    });
}





//END EDIT STUDENT INFORMATION



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
    //var arm = $("#arm").val();
    var session = $("#session").val();
    var adm_type = $("#adm-type").val();
    newStudent(surname, firstname, lastname, religion, nation, state,
        lg, city, add1, add2, mail, mobile, sex, dob,
        blood_group, class_adm, session, adm_type);
});

//function to add new student
function newStudent(surname, firstname, lastname, religion, nation, state,
    lg, city, add1, add2, mail, mobile, sex, dob,
    blood_group, class_adm, session, adm_type) {
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

//Add student guardian

$("#new-content").on('click', '#add-guardian-info', function(e) {
    e.preventDefault();
    $('#add-guardian-info').prop("disabled", true);
    var studid = $("#student").val();
    var sn = $("#surname").val();
    var fn = $("#firstname").val();
    var ln = $("#lastname").val();
    var occup = $("#occupation").val();
    var sex = $("#sex").val();
    var relationship = $("#relationship").val();
    var address = $("#cont-add").val();
    var parentmail = $("#parent-mail").val();
    var mobile = $("#mobile").val();
    var emergency = $("#emergency-contact").val();
    newGuardian(sn, fn, ln, occup, sex, relationship, address, parentmail, mobile, emergency, studid);
});

//function to add new parent
function newGuardian(sn, fn, ln, occup, sex, relationship, address, parentmail, mobile, emergency, studid) {
    $.ajax({
        url: 'addGuardian.php',
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
                $('#add-guardian-info').prop("disabled", false);
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
                $("#my-info").text("Guardian added successfully");
                $("#student").empty();

            } else {
                //alert("me")
                $('#add-guardian-info').prop("disabled", false);
                $("#my-info").addClass("error");
                $("#my-info").html(data);
            }
        },
    });
}


//end add student guardian

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
    var address = $("#cont-add").val();
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
    $.ajax({
        url: 'loadUnassignedStudents.php',
        type: 'POST',
        data: {},
        success: function(response) {
            $("#student").html(response);
        },
    });
}
// function noAdmissionNumberStud() {
//     $.get("loadUnassignedStudents.php", function(data) {
//         $("#student").html(data);
//     });
// }
//load unassigned admission numbers
function fetchUnassignedNumbers() {
    $.ajax({
        url: 'loadUnassignedNumbers.php',
        type: 'POST',
        data: {},
        success: function(response) {
            $("#add-no").html(response);
        },
    });
}
// function fetchUnassignedNumbers() {
//     $.get("loadUnassignedNumbers.php", function(data) {
//         $("#add-no").html(data);
//     });
// }

//////////////////////////////////////////////////////////////////////////////////////////////////
//ASSIGN NEW ADMISSION NUMBER
$("#new-content").on('click', '#assign-admission-no', function(e) {
    e.preventDefault();
    $('#assign-admission-no').prop("disabled", true);
    var student_id = $("#student").val();
    var adm_num_id = $("#add-no").val();
    // console.log(student_id + adm_num_id);
    // alert(student_id + adm_num_id);

    NewNumber(student_id, adm_num_id);
});

//function to assign new admission number to a student
function NewNumber(studid, admno) {
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