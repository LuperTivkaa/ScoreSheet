 $(function() {
     $("#datepicker").datepicker();
 });

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
 });
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
 //Remove staff subject taught



 //load all new students without parents
 $("#new-content").on('click', '.load-new-student', function(e) {
     $.get("newStudentParent.php", function(data) {
         $("#student").html(data);
     });
 });

 //end  of all new students
 $("#new-content").on('click', '.load-new-guardian', function(e) {
     $.get("newStudentGuardian.php", function(data) {
         $("#student").html(data);
     });
 });
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
     var category = $("#class-category option:selected").val();
     newClass(myclass, category);
 });
 //end create new class
 //add new class callback function
 function newClass(myclass, category) {
     $.ajax({
         url: 'addClass.php',
         type: 'POST',
         data: { myclass: myclass, category: category },
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
 //============================================================================================
 //Create New Affective Skills settings for school
 $("#new-content").on('click', '#new-affectiveSkills', function(e) {
     e.preventDefault();
     $('#new-affectiveSkills').prop("disabled", true);
     var affectiveskill = $('#affective-skill-item').val();
     //var category = $("#class-category option:selected").val();
     newAffective(affectiveskill);
 });
 //end create new class
 //add new class callback function
 function newAffective(skillitem) {
     $.ajax({
         url: 'addAffectiveSkills.php',
         type: 'POST',
         data: { skillitem: skillitem },
         success: function(response) {
             var data = $.trim(response);
             if (data === "ok") {
                 $('#new-affectiveSkills').prop("disabled", false);
                 $("#my-info").addClass("info");
                 $("#my-info").html("Affective skill added successfully");
                 $('#affective-skill-item').val("");
                 reloadAffectiveDomain();
             } else {
                 //alert("me")
                 $('#new-affectiveSkills').prop("disabled", false);
                 $("#my-info").addClass("error");
                 $("#my-info").html(data);
             }
         },
     });
 }
 //End create New Affective Skills settings for school

 //Reload added affective skills setting added
 function reloadAffectiveDomain() {
     $.ajax({
         url: 'reloadAffectiveDomain.php',
         type: 'POST',
         data: {},
         success: function(response) {
             $("#reload-skills").html(response);
         },
     });
 }
 //end reload affective skills settings

 //Reload added psycho skills setting added
 function reloadPsychoDomain() {
     $.ajax({
         url: 'reloadPsychoDomain.php',
         type: 'POST',
         data: {},
         success: function(response) {
             $("#reload-skills").html(response);
         },
     });
 }
 //end reload psycho skills settings added

 //create school settings for psychomotor skills
 $("#new-content").on('click', '#new-psychoSkills', function(e) {
     e.preventDefault();
     $('#new-psychoSkills').prop("disabled", true);
     var psychoskill = $('#psycho-skill-item').val();
     //var category = $("#class-category option:selected").val();
     newPsycho(psychoskill);
 });
 //end create new class
 //add new class callback function
 function newPsycho(skillitem) {
     $.ajax({
         url: 'addPsychoSkills.php',
         type: 'POST',
         data: { skillitem: skillitem },
         success: function(response) {
             var data = $.trim(response);
             if (data === "ok") {
                 $('#new-psychoSkills').prop("disabled", false);
                 $("#my-info").addClass("info");
                 $("#my-info").html("Psychomotor skill added successfully");
                 $('#psycho-skill-item').val("");
                 reloadPsychoDomain();
             } else {
                 //alert("me")
                 $('#new-psychoSkills').prop("disabled", false);
                 $("#my-info").addClass("error");
                 $("#my-info").html(data);
             }
         },
     });
 }

 //end create school settings for psychomotor skills

 //REMOVE AFFECTIVE SCHOOL SETTINGS
 $("#new-content").on('click', '#remove-domain', function(e) {
     e.preventDefault();

     if (confirm("Are you sure you want to remove item. This action can not be reversed!") == true) {
         $('#remove-domain').prop("disabled", true);
         var id = $(this).data('id');
         //var examid = $("#record-id").val();
         deleteAffectiveSettings(id);
     } else {
         $('#remove-domain').prop("disabled", false);
     }

 });
 //call back for delete affective skill settings
 function deleteAffectiveSettings(id) {
     $.ajax({
         url: 'deleteAffectiveSettings.php',
         type: 'POST',
         data: { id: id },
         success: function(response) {
             var data = $.trim(response);
             if (data === "ok") {
                 //call a reload function here
                 reloadAffectiveDomain();
             } else {
                 $('#remove-domain').prop("disabled", false);
                 $("#reload-skills").addClass("error");
                 $("#reload-skills").html(data);
             }
         },
     });
 }
 //END REMOVE SCHOOL SETTINGS

 //REMOVE PSYCHO SCHOOL SETTINGS
 $("#new-content").on('click', '#remove-psycho', function(e) {
     e.preventDefault();

     if (confirm("Are you sure you want to remove item. This action can not be reversed!") == true) {
         $('#remove-psycho').prop("disabled", true);
         var id = $(this).data('id');
         //var examid = $("#record-id").val();
         deletePsychoSettings(id);
     } else {
         $('#remove-psycho').prop("disabled", false);
     }

 });
 //call back for delete affective skill settings
 function deletePsychoSettings(id) {
     $.ajax({
         url: 'deletePsychoSettings.php',
         type: 'POST',
         data: { id: id },
         success: function(response) {
             var data = $.trim(response);
             if (data === "ok") {
                 //call a reload function here
                 reloadPsychoDomain();
             } else {
                 $('#remove-psycho').prop("disabled", false);
                 $("#reload-skills").addClass("error");
                 $("#reload-skills").html(data);
             }
         },
     });
 }
 //REMOVE PSYCHO SCHOOL SETTINGS

 //=======================================================
 //ADD CLASS CATEGORY

 // //create Class category
 $("#new-content").on('click', '#class-category-btn', function(e) {
     e.preventDefault();
     $('#class-category-btn').prop("disabled", true);
     var category = $('#class-category').val();
     //var description = $('#class-desc option:selected').val();
     classCategory(category);
 });

 //call back to assign class description
 function classCategory(category) {
     $.ajax({
         url: 'addClassCategory.php',
         type: 'POST',
         data: { category: category },
         success: function(response) {
             var data = $.trim(response);
             if (data === "ok") {
                 $('#class-category-btn').prop("disabled", false);
                 $("#my-info").addClass("info");
                 $("#my-info").html("Class category added");
             } else {
                 //alert("me")
                 $('#class-category-btn').prop("disabled", false);
                 $("#my-info").addClass("error");
                 $("#my-info").html(data);
             }
         },
     });
 }

 // ///end of class CATEGORY
 //=================================================================================

 //===============================================================================
 //CREATE CA AND EXAM MAX SCORES


 //Create CA max score
 $("#new-content").on('click', '#ca-max-score', function(e) {
     e.preventDefault();
     $('#ca-max-score').prop("disabled", true);
     var maxscore = $('#ca-score').val();
     var category = $('#caclass-category option:selected').val();
     caMaxScore(maxscore, category);
 });

 //call back to create ca max score
 function caMaxScore(maxscore, category) {
     $.ajax({
         url: 'addcaMaxScore.php',
         type: 'POST',
         data: { maxscore: maxscore, category: category },
         success: function(response) {
             var data = $.trim(response);
             if (data === "ok") {
                 $('#ca-max-score').prop("disabled", false);
                 $("#my-info").addClass("info");
                 $("#my-info").html("CA Max Scores added");
             } else {
                 //alert("me")
                 $('#ca-max-score').prop("disabled", false);
                 $("#my-info").addClass("error");
                 $("#my-info").html(data);
             }
         },
     });
 }
 //end create ca max score


 //create Max exam scores
 $("#new-content").on('click', '#exam-max-score', function(e) {
     e.preventDefault();
     $('#exam-max-score').prop("disabled", true);
     var maxscore = $('#exam-score').val();
     var category = $('#examclass-category option:selected').val();
     examMaxScore(maxscore, category);
 });

 //call back to create exam max score
 function examMaxScore(maxscore, category) {
     $.ajax({
         url: 'addexamMaxScore.php',
         type: 'POST',
         data: { maxscore: maxscore, category: category },
         success: function(response) {
             var data = $.trim(response);
             if (data === "ok") {
                 $('#exam-max-score').prop("disabled", false);
                 $("#my-info").addClass("info");
                 $("#my-info").html("Exam Max Scores added");
             } else {
                 //alert("me")
                 $('#exam-max-score').prop("disabled", false);
                 $("#my-info").addClass("error");
                 $("#my-info").html(data);
             }
         },
     });
 }

 //end create Max exam scores

 //==================================================================================
 //Assign subject block
 /** Code snippet to assign subject to a class
  * Select added subjec and also selec class and add
  */
 //==================================================================================

 //Assign subject to class category
 $("#new-content").on('click', '#assign-subject', function(e) {
     e.preventDefault();
     $('#assign-subject').prop("disabled", true);
     var subj = $('#subject-list option:selected').val();
     var categoryid = $('#class-category option:selected').val();
     assignSubject(subj, categoryid);
 });

 //call back for assign subject to class class category
 function assignSubject(subjectid, category) {
     $.ajax({
         url: 'assignSubjectToClass.php',
         type: 'POST',
         data: { subjectid: subjectid, category: category },
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
     });
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
                 $("#my-info").addClass("error");
                 $("#my-info").html(data);
             }
         },
         //alert(user+pass+role);
     });
 }
 //end add new subbject
 //=============================================================
 //EDIT CLASS TEACHER
 $("#edit-class-teacher").on('click', function(e) {
     e.preventDefault();
     $('#edit-class-teacher').prop("disabled", true);
     //var staff = $("#staff option:selected").val();
     var class_id = $("#school-class option:selected").val();
     //var subj = $("#sch-subject option:selected").val();
     var recordid = $("#record-id").val();
     var staffID = $("#staffID").val();
     //alert(class_id + subj);
     editClassTeacher(staffID, recordid, class_id);
 });

 //function to edit class
 function editClassTeacher(staffid, recordid, class_id) {
     $.ajax({
         url: 'editClassTeacher.php',
         type: 'POST',
         data: { staffid: staffid, recordid: recordid, class_id: class_id },
         success: function(response) {
             var data = $.trim(response);
             if (data === "ok") {
                 $('#edit-class-teacher').prop("disabled", false);
                 $("#modal_error").addClass("info");
                 $("#modal_error").html("Record edited successfully");
                 reloadClassTeachers();
             } else {
                 //alert("me")
                 $('#edit-class-teacher').prop("disabled", false);
                 $("#modal_error").addClass("error");
                 $("#modal_error").html(data);
             }
         },
         //alert(user+pass+role);
     });
 }
 //EDIT CLASS TEACHER




 // EDIT SUBJECT TAUGHT BY STAFF
 $("#edit-staff-subject").on('click', function(e) {
     e.preventDefault();
     $('#edit-staff-subject').prop("disabled", true);
     //var staff = $("#staff option:selected").val();
     var class_id = $("#sch-class option:selected").val();
     var subj = $("#sch-subject option:selected").val();
     var recordid = $("#record-id").val();
     var staffID = $("#staffID").val();
     //alert(class_id + subj);
     editStaffSubject(staffID, recordid, class_id, subj);
 });

 //function to add new subject call back
 function editStaffSubject(staffid, recordid, class_id, subj) {
     $.ajax({
         url: 'editStaffSubject.php',
         type: 'POST',
         data: { staffid: staffid, recordid: recordid, class_id: class_id, subj: subj },
         success: function(response) {
             var data = $.trim(response);
             if (data === "ok") {
                 $('#edit-staff-subject').prop("disabled", false);
                 $("#modal_error").addClass("info");
                 $("#modal_error").html("Record edited successfully");
                 reloadStaffSubject();
             } else {
                 //alert("me")
                 $('#edit-staff-subject').prop("disabled", false);
                 $("#modal_error").addClass("error");
                 $("#modal_error").html(data);
             }
         },
         //alert(user+pass+role);
     });
 }
 //END SUBJECT TAUGHT BY STAFF


 // // new institution profile
 // $("#new-content").on('click', '#sch-profile-btn', function() {
 //     $('#sch-profile-btn').text("Creating...").prop("disabled", true);
 //     var inst_name = $("#institution_name").val();
 //     var inst_category = $("#institution_category").val();
 //     var nation = $("#nation").val();
 //     var state = $("#state").val();
 //     var lg = $("#lg").val();
 //     var city = $("#city").val();
 //     var webAdd = $("#webAdd").val();
 //     var email = $("#Email").val();
 //     var streetAdd = $("#streetAdd").val();
 //     var mailAdd = $("#mailAdd").val();
 //     var mobile = $("#mobile").val();
 //     $.post("addSchoolProfile.php", {
 //         inst_name: inst_name,
 //         inst_category: inst_category,
 //         nation: nation,
 //         state: state,
 //         lg: lg,
 //         city: city,
 //         webAdd: webAdd,
 //         email: email,
 //         streetAdd: streetAdd,
 //         mailAdd: mailAdd,
 //         mobile: mobile
 //     }).done(createInst);
 // });

 //Refactored new school profile code
 $("#new-content").on('click', '#sch-profile-btn', function(e) {
     e.preventDefault();
     $('#sch-profile-btn').text("Creating...").prop("disabled", true);
     var inst_name = $("#institution_name").val();
     var inst_category = $("#institution_category").val();
     var nation = $("#nation").val();
     var state = $("#state").val();
     var lg = $("#lg").val();
     var city = $("#city").val();
     var webAdd = $("#webAdd").val();
     var email = $("#Email").val();
     var streetAdd = $("#streetAdd").val();
     var mailAdd = $("#mailAdd").val();
     var mobile = $("#mobile").val();
     //alert(inst_name)
     newSchoolProfile(inst_name, inst_category, nation, state, lg, city, webAdd, email, streetAdd, mailAdd, mobile);
 });
 //call back function for new school profile
 function newSchoolProfile(schname, category, nation, state, lg, city, web, email, streetAdd, mailadd, mobile) {
     $.ajax({
         url: 'addSchoolProfile.php',
         type: 'POST',
         data: { schname: schname, category: category, nation: nation, state: state, lg: lg, city: city, web: web, email: email, streetAdd: streetAdd, mailadd: mailadd, mobile: mobile },
         success: function(response) {
             var data = $.trim(response);
             if (data === "ok") {
                 $("#my-info").addClass("info");
                 $("#my-info").text("School Profile Created Successfully");
                 $('#sch-profile-btn').text("Add School Profile").prop("disabled", false);
             } else {
                 $("#my-info").addClass("error");
                 $("#my-info").html(data);
                 $('#sch-profile-btn').text("Add School Profile").prop("disabled", false);
             }
         },
     });
 }
 ///end new school profile code

 //institution profile call back function
 // function createInst(response) {

 //     var data = $.trim(response);
 //     if (data === "ok") {
 //         $("#my-info").addClass("info");
 //         $("#my-info").text("School Profile Created Successfully");
 //         $('#sch-profile-btn').text("Add School Profile").prop("disabled", false);
 //         // window.location.replace("uploadLogo.php");
 //     } else {
 //         //alert("me")
 //         $("#profile-info").addClass("error");
 //         $("#profile-info").html(data);
 //         $('#sch-profile-btn').text("Add School Profile").prop("disabled", false);
 //     }

 // }
 // // end code to create institution profile

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


 //FETCH AND POPULATE STUDENT RECORDS
 $('#new-content').on('click', '#my-stud-edit', function(e) {
     e.preventDefault();

     var recordid = $(this).data('recordid');

     var url = "studentEditProfile.php";
     jQuery.getJSON(url, { studid: recordid }, function(response) {


         $.each(response, function(index, profile) {

             //generate HTML to display added information
             $('#surname').val(profile.Surname);
             $('#firstname').val(profile.FirstName);
             $('#lastname').val(profile.LastName);
             $('#address2').val(profile.HomeAdd);
             $('#address1').val(profile.ContactAdd);
             $('#mail').val(profile.Mail);
             $('#mobile').val(profile.Mobile);
             $('#studno').val(recordid);
             // profileHTML += '<li> ' + profile.institution_name + ' </li>';
             // profileHTML += '<li>' + profile.category_name + ' </li>';
             // //</li>';
         });

     });

 });
 //END FETCH AND POPULATE STUDENT RECORDS

 //student edit functionality
 $("#stud-nation").on('change', function() {
     var id = $("#stud-nation option:selected").val();
     $.post("listStates.php", { id: id }, function(data) {
         $("#stud-state").html(data);
     });
 });

 $('#stud-state').on('change', function() {
     var id = $("#stud-state option:selected").val();
     $.post("listLga.php", { id: id }, function(data) {
         $("#stud-lg").html(data);
     });
 });

 $('#stud-lg').on('change', function() {
     var id = $("#stud-lg option:selected").val();
     $.post("listCity.php", { id: id }, function(data) {
         $("#stud-city").html(data);
     });
 });

 //load subjects on selection of class
 $("#new-content").on('change', '#class', function() {
     var id = $("#class option:selected").val();
     //alert("its me");
     $.post("listSubjects.php", { id: id }, function(data) {
         $("#subject").html(data);
     });
 });


 ///load subjects for selection of subjects for staff subject edit
 $("#sch-class").on('change', function() {
     var id = $("#sch-class option:selected").val();
     $.post("listSubjects.php", { id: id }, function(data) {
         $("#sch-subject").html(data);
     });
 });
 //end subject for selection of subjects for staff subject edit

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

 //Phot preview code
 function filePreview(input) {
     if (input.files && input.files[0]) {
         var reader = new FileReader();
         reader.onload = function(e) {
             $('#uploadForm + img').remove();
             $('#uploadForm').after('<img src="' + e.target.result + '" width="450" height="300"/>');
         };
         reader.readAsDataURL(input.files[0]);
     }
 }
 //end photo preview code
 ///===================================================================================

 //Upload Student Passport
 $('#student-file').on('change', function(e) {
     e.preventDefault();
     var fd = new FormData();
     var file_data = $('input[type="file"]')[0].files; // for multiple files
     for (var i = 0; i < file_data.length; i++) {
         fd.append("file_" + i, file_data[i]);
     }
     var other_data = $('form').serializeArray();
     $.each(other_data, function(key, input) {
         fd.append(input.name, input.value);
     });
     //var form = $('form').get(0);
     $.ajax({
         url: 'studentPhotoProcess.php',
         type: "POST",
         data: fd,
         contentType: false,
         cache: false,
         processData: false,
         beforeSend: function() {
             //$("#preview").fadeOut();
             $("#err").text('processing...').fadeOut();
         },
         success: function(data) {
             console.log(data);
             if (data == 'ok') {
                 // invalid file format.
                 //$("#err").html("Invalid File !").fadeIn();
                 $("#err").html("Upload successful");
                 //console.log("ok");
                 //include a function to reload image in the logo section
             } else {
                 // view uploaded file.
                 $("#preview-img").html(data).fadeIn();
                 $("#form")[0].reset();
                 //console.log("else");
             }
         },
         error: function(e) {
             $("#err").html(e).fadeIn();
             //console.log("error");
         }
     });
 });

 //Upload student passport


 //Upload staff picture

 $("#new-content").on('change', '#staff-file', function(e) {
     e.preventDefault();
     var form = $('form').get(0);
     $.ajax({
         url: "staffPictureProcess.php",
         type: "POST",
         data: new FormData(form),
         contentType: false,
         cache: false,
         processData: false,
         beforeSend: function() {
             //$("#preview").fadeOut();
             $("#err").text('processing...').fadeOut();
         },
         success: function(data) {
             if (data == 'ok') {
                 // invalid file format.
                 //$("#err").html("Invalid File !").fadeIn();
                 $("#err").html("Upload successful");
                 //console.log("ok");
                 //include a function to reload image in the logo section
             } else {
                 // view uploaded file.
                 $("#preview-img").html(data).fadeIn();
                 $("#form")[0].reset();
                 //console.log("else");
             }
         },
         error: function(e) {
             $("#err").html(e).fadeIn();
             //console.log("error");
         }
     });
 });
 //end upload staff picture

 ///////////////////////////////////////////////////////////

 // logo upload
 $("#new-content").on('change', '#logo-file', function(e) {
     e.preventDefault();
     var form = $('form').get(0);
     $.ajax({
         url: "schoolLogoProcess.php",
         type: "POST",
         data: new FormData(form),
         contentType: false,
         cache: false,
         processData: false,
         beforeSend: function() {
             //$("#preview").fadeOut();
             $("#err").text('processing...').fadeOut();
         },
         success: function(data) {
             if (data == 'ok') {
                 // invalid file format.
                 //$("#err").html("Invalid File !").fadeIn();
                 $("#err").html("Upload successful");
                 //console.log("ok");
                 //include a function to reload image in the logo section
             } else {
                 // view uploaded file.
                 $("#preview-img").html(data).fadeIn();
                 $("#form")[0].reset();
                 //console.log("else");
             }
         },
         error: function(e) {
             $("#err").html(e).fadeIn();
             //console.log("error");
         }
     });
 });
 //end

 //////////////////////////
 //Find student by class
 $("#new-content").on('click', '#studByClassBtn', function(e) {
     e.preventDefault();
     $('#studByClassBtn').text("Searching...").prop("disabled", true);
     var classid = $("#studListclass option:selected").val();
     var session = $("#studsession option:selected").val();
     studByClass(classid, session);
 });
 //end create new school subject
 //add new subject callback function
 function studByClass(classid, session) {
     $.ajax({
         url: 'studByClass.php',
         type: 'POST',
         data: { classid: classid, session: session },
         success: function(response) {
             //var data = $.trim(response);
             if (response === undefined) {
                 $('#studByClassBtn').text("List Student(s)").prop("disabled", false);
                 $("#st-list").addClass("error");
                 $('#st-list').html(response);
             } else {
                 $('#studByClassBtn').text("List Student(s)").prop("disabled", false);
                 $('#st-list').html(response);
             }
         },
     });
 }

 //STUDENT PHOTO UPLOAD MODAL FUNCTIONALITY
 $('#new-content').on('click', '#uploadModal', function(e) {
     e.preventDefault();
     //$("#modal_error").empty();
     var studentid = $(this).data('recordid');
     //var editValue = $(this).data('value');
     //var staffID = $(this).data('staffid');
     //alert(editValue + recordid);

     //$('#item-value').val(editValue);
     $('#record-id').val(studentid);
     //$('#staffID').val(staffID);

     $('#modal-list').empty();
     $('#modal_error').empty();
     var modalid = $('#myModal');
     modalid.css('display', 'block');
 });

 //STUDENT PHOTO UPLOAD MODAL FUNCTIONALITY

 //end find student by class
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
 //create class teacher functionality

 $("#new-content").on('click', '#class-teacher', function(e) {
     e.preventDefault();
     $('#class-teacher').text("Assigning....").prop("disabled", true);
     var staff = $("#staff option:selected").val();
     var myclass = $("#class option:selected").val();
     //var jsURL = $('#input').attr('value');
     createClass(staff, myclass);
 });

 //function to assign class teacher call back
 function createClass(staff, myclass) {
     $.ajax({
         url: 'addClassTeacher.php',
         type: 'POST',
         data: { staff: staff, myclass: myclass },
         success: function(response) {
             var data = $.trim(response);
             if (data === "ok") {
                 $('#class-teacher').text("Assign Class Teacher").prop("disabled", false);
                 $("#my-info").addClass("info");
                 $("#my-info").html("Staff assigned class successfully...");
             } else {
                 $('#class-teacher').text("Assign Class Teacher").prop("disabled", false);
                 $("#my-info").addClass("error");
                 $("#my-info").html(data);
             }
         },
     });
 }

 //end create class teacher functionality

 //