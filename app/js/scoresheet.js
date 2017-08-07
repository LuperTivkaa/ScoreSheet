 $(function() {
     $("#datepicker").datepicker();
 });

 ////load the content of a particuluar url that is clicked on
 $('.nav-link').on('click', function(evt) {
     evt.preventDefault();
     $("#my-info").empty();
     let url = $(this).attr('href');
     $('#new-content').load(url);
     // //console.log(url);
 });

 //get birthdays NOT COMPLETE

 $('.birthdays').on('click', function(evt) {
     evt.preventDefault();
     let url = $(this).attr('href');
     //alert(url);
     $('#new-content').load(url, function() {});
 });
 //end getbirthdays ////NOT COMPLETE

 //get all students
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
         let url = $(this).attr('href');

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
 $('.new-emplyee').on('click', function(evt) {
         evt.preventDefault();
         let url = $(this).attr('href');
         $('#new-content').load(url, function() {
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

         });
         //console.log(url);   

     })
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
                 $("#my-info").html("Subject added successfully");
             } else {
                 //alert("me")
                 $('#add-new-subject').prop("disabled", false);
                 $("#my-info").addClass("error");
                 $("#my-info").html(data);
             }
         },
     })
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
 $('.new-subject').on('click', function(evt) {
         evt.preventDefault();
         let url = $(this).attr('href');
         $('#new-content').load(url, function() {
             $("#new-content").on('click', '#add-subject', function(e) {
                 e.preventDefault();
                 $('#add-subject').prop("disabled", true);
                 var staff = $("#staff option:selected").val();
                 var class_arm = $("#arm option:selected").val();
                 var subj = $("#subject option:selected").val();
                 createSubject(staff, class_arm, subj);
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
//============================================================
//This section of the code handles client sign up, login and user login
//new client sign up
$('#new-signup-btn').on('click', function() {
    $(this).text("Creating account, please wait...").prop("disabled", true);
    let user_name = $("#username").val();
    let email = $("#signup-email").val();
    let password = $("#signup-pass").val();
    $.post("app/public/inst_signup.php", { user_name: user_name, email: email, password: password }).done(newClient);

});
// new client signup call back function
function newClient(result) {

    var data = $.trim(result);
    if (data === "ok") {
        $("#new-signup-btn").text("Sign Up!").prop("disabled", false);
        //reidrect to the client login page
        $("#client-signup").addClass("success-msg");
        $("#client-signup").html('Your account has been created successfully, login now to continue!');
        //window.location.replace("clients/login.php");
    } else {

        $("#new-signup-btn").text("Sign Up!").prop("disabled", false);
        $("#client-signup").addClass("error");
        $("#client-signup").html(data);
    }
}
// end of new client signup function




//new client login
//User login     
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
        window.location.replace("Clients/schoolProfile.php");
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
    $.post("./user_login.php", { email: email, password: password }).done(userLogin);

});


function userLogin(response) {
    var obj = JSON.parse(response);
    //console.log(typeof obj);
    //console.log(obj);
    if (typeof obj === "object") {
        console.log(obj);
        $.each(obj, function(index, profile) {
            //GET THE ROLE ID OF THE USER
            //var my_role = profile.roleID;
            //console.log(profile.roleID);
            // CHECK THE ROLE ID TO REDIRECT AS APPROPRAITE
            if (profile.roleID == 1 || profile.roleID == 2) {

                //console.log(profile.roleID);
                // check and redirect to the staff tutor module
                window.location.replace("app/staff/index.php");
            } else if (profile.roleID == 3 || profile.roleID == 4) {

                // check and redirect to the admin module
                window.location.replace("app/admin/index.php");
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

//ADMISSION NUMBER SETTINGS
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
    })
} //end add fee item


////////////////////////
//GENERATE NEW NUMBERS
$("#new-content").on('click', '#add-number', function(e) {
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
                $("#my-info").addClass("info");
                $("#my-info").html("Admission numbers generated successfully.");
            } else {
                //alert("me")
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