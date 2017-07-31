///////////////////////////////////////////////////////////////////////////////////////////

////load the content of a particuluar url that is clicked on
$('.nav-link').on('click', function(evt) {
    evt.preventDefault();
    $("#my-info").empty();
    let url = $(this).attr('href');
    $('#new-content').load(url);
    // //console.log(url);
});
// })
//////////////////////////////////////////////////////////////////////////////////////////////
//function to display staff
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


//add Session code
$('.new-session').on('click', function(evt) {
        evt.preventDefault();
        let url = $(this).attr('href');
        $('#new-content').load(url, function() {
            $("#new-content").on('click', '#add-session', function(e) {
                e.preventDefault();
                $('#add-session').prop("disabled", true);
                var session = $("#session").val();
                //var username = $("#username").val();
                //var role =  $("#role option:selected").val();
                //var jsURL = $('#input').attr('value');
                addSession(session);
            });

        });
        //console.log(url);   

    })
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
                $("#my-info").addClass("error");;
                $("#my-info").html(data);
            }
        },
        //alert(user+pass+role);
    })
} //end new session code

//add Fee Item
$('.new-fee').on('click', function(evt) {
        evt.preventDefault();
        let url = $(this).attr('href');
        $('#new-content').load(url, function() {
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

        });
        //console.log(url);   

    })
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
                $("#my-info").addClass("error");;
                $("#my-info").html(data);
            }
        },
        //alert(user+pass+role);
    })
} //end add fee item



//add academic term
$('.new-term').on('click', function(evt) {
        evt.preventDefault();
        let url = $(this).attr('href');
        $('#new-content').load(url, function() {
            $("#new-content").on('click', '#add-term', function(e) {
                e.preventDefault();
                $('#add-term').prop("disabled", true);
                var term = $("#term").val();
                addTerm(term);
            });

        });
        //console.log(url);   

    })
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
                $("#my-info").addClass("error");;
                $("#my-info").html(data);
            }
        },
        //alert(user+pass+role);
    })
} //end new term




//Retrieve all added session and display them on the page
$('.my-session').on('click', function(evt) {
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
        getAddedSession(url);
    })
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
                //  profileHTML+= '<li>' + profile.category_name + ' </li>';
                //  profileHTML+= '<li><strong>COUNTRY OF LOCATION: </strong> ' + profile.nationality + ' </li>';
                //  profileHTML+= '<li><strong>STATE OF LOCATION:</strong> ' + profile.state_name + ' </li>';
                //  profileHTML+= '<li><strong>LGA of Location:</strong> ' + profile.lga + ' </li>';
                //  profileHTML+= '<li><strong>CITY: </strong> ' + profile.city_name + ' </li>';
                //  profileHTML+= '<li><strong>INSTITUTION ADDRESS:</strong> ' + profile.inst_add + ' </li>';
                //  profileHTML+= '<li><strong>INSTITUTION MOBILE: </strong> ' + profile.inst_mobile + ' </li>';
                //console.log(response);
            });
            profileHTML += '</ul>';
            $('#new-content').html(profileHTML);
        } else {
            $('#new-content').html(response);
        }

    });

} //End Get Session added


//Retrieve all  added fee items
$('.added-fee-item').on('click', function(evt) {
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
        getAddedFeeItem(url);
    })
    //get fee items
function getAddedFeeItem(url) {
    //get inserted records from the database
    jQuery.getJSON(url, function(response) {
        if (typeof response === 'object') {
            var profileHTML = '<h5 class="right-menu-header">Available Fee Items</h5>';
            profileHTML += '<ul>';
            $.each(response, function(index, profile) {

                //generate HTML to display added information
                profileHTML += '<li> ' + profile.name + '-' + profile.amt + '-' + profile.myt + '-' + profile.S + '</li>';
                //  profileHTML+= '<li>' + profile.category_name + ' </li>';
                //  profileHTML+= '<li><strong>COUNTRY OF LOCATION: </strong> ' + profile.nationality + ' </li>';
                //  profileHTML+= '<li><strong>STATE OF LOCATION:</strong> ' + profile.state_name + ' </li>';
                //  profileHTML+= '<li><strong>LGA of Location:</strong> ' + profile.lga + ' </li>';
                //  profileHTML+= '<li><strong>CITY: </strong> ' + profile.city_name + ' </li>';
                //  profileHTML+= '<li><strong>INSTITUTION ADDRESS:</strong> ' + profile.inst_add + ' </li>';
                //  profileHTML+= '<li><strong>INSTITUTION MOBILE: </strong> ' + profile.inst_mobile + ' </li>';
                //console.log(response);
            });
            profileHTML += '</ul>';
            $('#new-content').html(profileHTML);
        } else {
            $('#new-content').html(response);
        }

    });

} //End Get added Fee item

///////////////////////////////////////////////////////////////////////////////////////////////
//add new Student
$('.new-student').on('click', function(evt) {
        evt.preventDefault();
        let url = $(this).attr('href');
        $('#new-content').load(url, function() {
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

        });
        // console.log(url);   

    })
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
                $("#my-info").html("New Student added successfully");
            } else {
                //alert("me")
                $('#new-student-btn').prop("disabled", false);
                $("#my-info").addClass("error");
                $("#my-info").html(data);
            }
        },
        //alert(user+pass+role);
    })
}


///////////////////////

//add new Student parent
$('.new-parent').on('click', function(evt) {
        evt.preventDefault();
        let url = $(this).attr('href');
        $('#new-content').load(url, function() {
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

        });
        // console.log(url);   

    })
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
                $("#surname").val("");
                $("#firstname").val("");
                $("#lastname").val("");
                $("#occupation").val("");
                $("#cont_add").val("");
                $("#parent-mail").val("");
                $("#mobile").val("");
                $("#emergency-contact").val("");
                $('#add-parent-info').prop("disabled", false);
                $("#my-info").addClass("info");
                $("#my-info").html("Parent added successfully");
            } else {
                //alert("me")
                $('#add-parent-info').prop("disabled", false);
                $("#my-info").addClass("error");;
                $("#my-info").html(data);
            }
        },
    })
} //END OF ADD PARENT FOR STUDENT

//////////////////////////////////////////////////////////////////////////////////////////////////
//ASSIGN NEW ADMISSION NUMBER
$('.new-admission-no').on('click', function(evt) {
        evt.preventDefault();
        let url = $(this).attr('href');
        $('#new-content').load(url, function() {
            $("#new-content").on('click', '#assign-admission-no', function(e) {
                e.preventDefault();
                $('#assign-admission-no').prop("disabled", true);
                var student_id = $("#student").val();
                var adm_num_id = $("#add-no").val();

                assignNewNumber(student_id, adm_num_id);
            });

        });
        // console.log(url);   

    })
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
                $("#my-info").html("Admission number assigned successfully");
            } else {
                //alert("me")
                $('#assign-admission-no').prop("disabled", false);
                $("#my-info").addClass("error");;
                $("#my-info").html(data);
            }
        },
    })
}

////////////////////////////////////////////////////

//ADMISSION NUMBER PREFIX SETTINGS
$('.new-numbers').on('click', function(evt) {
        evt.preventDefault();
        let url = $(this).attr('href');
        $('#new-content').load(url, function() {
            $("#new-content").on('click', '#add-prefix', function(e) {
                e.preventDefault();
                $('#add-prefix').prop("disabled", true);
                var prefix = $("#prefix").val();
                var seperator = $("#seperator").val();

                addPrefixSettings(prefix, seperator);
            });

        });
        //console.log(url);   

    })
    //function to add prefix settings
function addPrefixSettings(prefix, seperator) {
    $.ajax({
        url: 'addPrefixSettings.php',
        type: 'POST',
        data: { prefix: prefix, seperator: seperator },
        success: function(response) {
            var data = $.trim(response);
            if (data === "ok") {
                $('#prefix').val("");
                $('#add-prefix').prop("disabled", false);
                $("#my-info").addClass("info");
                $("#my-info").html("Prefix settings added successfully.");
            } else {
                //alert("me")
                $('#prefix').val("");
                $('#add-prefix').prop("disabled", false);
                $("#my-info").addClass("error");
                $("#my-info").html(data);
            }
        },
        //alert(user+pass+role);
    })
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
                $("#range").val("");
                $('#add-numbers').prop("disabled", false);
                $("#my-info").addClass("info");
                $("#my-info").html("Admission numbers generated successfully.");
            } else {
                //alert("me")
                $("#range").val("");
                $('#add-numbers').prop("disabled", false);
                $("#my-info").addClass("error");;
                $("#my-info").html(data);
            }
        },
        //alert(user+pass+role);
    })
} //end add new admission numbers


//LIST CLASS ARM BASED ON CLASS SELECTED
$("#new-content").on('change', '#class-admitted', function(e) {
    var id = $("#class-admitted").val();
    //var id = $("#state option:selected").val();  
    $.post("listClassArm.php", { id: id }, function(data) {
        $("#arm").html(data);
    });
});