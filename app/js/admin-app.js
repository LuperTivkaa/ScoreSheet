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