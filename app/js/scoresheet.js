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

//CREATE A NEW ENROLLMENT
$("#new-content").on('click', '#mystud-enroll', function(e) {
    e.preventDefault();
    var mybtn = $(this);

    mybtn.text("Enrolling...").prop("disabled", true);
    var studentid = $(this).data("studentid");
    createStudEnrollment(studentid, mybtn);
});

function createStudEnrollment(studentid, btn) {
    $.ajax({
        url: 'studEnrollment.php',
        type: 'POST',
        data: { studentid: studentid },
        success: function(response) {
            var data = $.trim(response);
            if (data === "ok") {
                btn.text("Enroll").prop("disabled", false);

                reloadNewStudents();
            } else {
                btn.text("Enroll").prop("disabled", false);

                //reloadNewStudents();
                $("#my-info").addClass("error");
                $("#my-info").html(data);
            }
        },
    });
}

//END CREATE NEW ENROLLMENT

//reload newly admitted students
function reloadNewStudents() {
    $.ajax({
        url: 'myEnrollment.php',
        type: 'POST',
        data: {},
        success: function(response) {
            $("#new-content").html(response);

        },
    });
}
//end reload newly admitted students






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
    var attcont = $('.attendance-div');
    psychomotor.hide();
    attcont.hide();

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
        $('#removesubjeecttaught').text('Remove').prop("disabled", false);
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

//REMOVE CLASS TEACHER
$("#new-content").on('click', '#removeclassteacher', function(e) {
    e.preventDefault();

    if (confirm("Are you sure you want to remove item. This action can not be reversed!") == true) {
        $('#removeclassteacher').text('Removing...').prop("disabled", true);
        var id = $(this).data('recordid');
        //var examid = $("#record-id").val();
        deleteClassTeacher(id);
    } else {
        $('#removeclassteacher').text('Remove').prop("disabled", false);
    }

});
//call back for delete affective skilss
function deleteClassTeacher(id) {
    $.ajax({
        url: 'deleteClassTeacher.php',
        type: 'POST',
        data: { id: id },
        success: function(response) {
            var data = $.trim(response);
            if (data === "ok") {
                //call a reload function here
                reloadClassTeachers();
            } else {
                $('#removesubjecttaught').tex('Remove').prop("disabled", false);
                $("#my-info").addClass("error");
                $("#my-info").html(data);
            }
        },
    });
}
//END REMOVE CLASS TEACHER

//RELOAD LIST OF CLASS TEACHERS
function reloadClassTeachers() {
    $.ajax({
        url: 'classTeachers.php',
        type: 'POST',
        data: {},
        success: function(response) {
            $("#new-content").html(response);

        },
    });
}
//END RELOAD LIST OF CLASS TEACHERS


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


//Approve Result 
$("#new-content").on('click', '#result-approval', function(e) {
    e.preventDefault();
    $('#result-approval').text('Please wait...').prop("disabled", true);
    //var id = $(this).data('id');
    var myclass = $("#s-class option:selected").val();
    var session = $("#s-session option:selected").val();
    var term = $("#s-term option:selected").val();

    approveResult(myclass, session, term);
});
//call back for result approval
function approveResult(myclass, session, term) {
    $.ajax({
        url: 'approveResult.php',
        type: 'POST',
        data: { myclass: myclass, session: session, term: term },
        success: function(response) {
            var data = $.trim(response);
            if (data === "ok") {
                $('#result-approval').text('Result Approval').prop("disabled", false);
                $("#my-info").addClass("info");
                $("#my-info").text("Result Approved Successfully");
                //$("#new-content").html(data);
            } else {

                $('#result-approval').text('Result Approval').prop("disabled", false);
                //$("#modal_error").addClass("error");
                $("#my-info").addClass("error");
                $("#my-info").html(data);
                //$("#new-content").html(data);
            }
        },
    });
}
//end display result for approval



//Disapprove result

$("#new-content").on('click', '#reset-result-approval', function(e) {
    e.preventDefault();
    $('#reset-result-approval').text('Please wait...').prop("disabled", true);
    //var id = $(this).data('id');
    var myclass = $("#s-class option:selected").val();
    var session = $("#s-session option:selected").val();
    var term = $("#s-term option:selected").val();

    disapproveResult(myclass, session, term);
});
//call back for result approval
function disapproveResult(myclass, session, term) {
    $.ajax({
        url: 'unApproveResult.php',
        type: 'POST',
        data: { myclass: myclass, session: session, term: term },
        success: function(response) {
            var data = $.trim(response);
            if (data === "ok") {
                $('#reset-result-approval').text('Undo Result Approval').prop("disabled", false);
                $("#my-info").addClass("info");
                $("#my-info").text("Result Unapproved Successfully");
                //$("#new-content").html(data);
            } else {

                $('#reset-result-approval').text('Undo Result Approval').prop("disabled", false);
                //$("#modal_error").addClass("error");
                $("#my-info").addClass("error");
                $("#my-info").html(data);
                //$("#new-content").html(data);
            }
        },
    });
}


//End disapprove result



//Code to approve result by admin
// $("#new-content").on('click', '#approve', function(e) {
//     e.preventDefault();
//     var mybutton = $(this);
//     //var approveID = $(this).attr('id');
//     //var Approval = $(this).text('Undo Approval');
//     //var changedClass = $(this).removeClass('not-approvedBtn').addClass('approvedBtn');
//     //var approveClass = $(this).attr('class');
//     var studentid = $(this).data('recordid');

//     $(this).text('Please wait...');

//     adminApproveResult(studentid, mybutton);
// });
// //call back for approving result
// function adminApproveResult(studentid, mybutton) {
//     $.ajax({
//         url: 'adminApproveResult.php',
//         type: 'POST',
//         data: { studentid: studentid },
//         success: function(response) {
//             var data = $.trim(response);
//             if (data === "ok") {

//                 mybutton.attr('id', 'disapprove');
//                 //alert(id);
//                 //$(this).attr('id', 'disapprove');
//                 mybutton.text('Undo Approval');
//                 mybutton.removeClass('not-approvedBtn').addClass('approvedBtn');
//             } else {
//                 mybutton.text('Approve');
//                 $("#info").addClass("error");
//                 $("#info").html(data);
//             }
//         },
//     });
// }
//End code to approve

//Code to disapprove result

// $("#new-content").on('click', '#disapprove', function(e) {
//     e.preventDefault();
//     var mybutton = $(this);

//     var studentid = $(this).data('recordid');
//     $(this).text('Please wait...');
//     adminDisapproveResult(studentid, mybutton);
// });
// //call back for disapproving result
// function adminDisapproveResult(studentid, mybutton) {
//     $.ajax({
//         url: 'adminUnapproveResult.php',
//         type: 'POST',
//         data: { studentid: studentid },
//         success: function(response) {
//             var data = $.trim(response);
//             if (data === "ok") {

//                 mybutton.attr('id', 'approve');
//                 //alert(id);
//                 //$(this).attr('id', 'disapprove');
//                 mybutton.text('Approve');
//                 mybutton.removeClass('approvedBtn').addClass('not-approvedBtn');
//             } else {

//                 mybutton.text('Undo Approval');
//                 $("#info").addClass("error");
//                 $("#info").html(data);
//             }
//         },
//     });
// }
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
$('#new-content').on('click', '.classteacher-div', function(e) {
    //show term editable div on button click

    //var itemvalue = $('#item-value').val();

    //$('#editterm').val(itemvalue);
    $('.term-div').hide();
    $('.session-div').hide();
    $('.subject-div').hide();
    $('.class-div').hide();
    $('.prefix-div').hide();
    $('.staffsubjects-div').hide();
    $('.classteacher-div').show();
});
//=================
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
    $('.classteacher-div').hide();
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
    $('.classteacher-div').hide();
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
    $('.classteacher-div').hide();
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
    $('.classteacher-div').hide();
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
    $('.classteacher-div').hide();
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


//================================================================================
/**
 * Funtioality to manage enrolled students
 * 
 */
//============================================

//FIND PREVIOUSLY ENROLLED STUDENTS

//Assign subject to class category
$("#new-content").on('click', '#find-enrolled-student', function(e) {
    e.preventDefault();
    $('#find-enrolled-student').prop("disabled", true);
    var prevClass = $('#enroll-class option:selected').val();
    var prevSession = $('#enroll-session option:selected').val();
    prevStudentList(prevClass, prevSession);
});

//call back for assign subject to class class category
function prevStudentList(prevClass, prevSession) {
    $.ajax({
        url: 'prevStudentList.php',
        type: 'POST',
        data: { prevClass: prevClass, prevSession: prevSession },
        success: function(response) {
            //var data = $.trim(response);
            $("#new-content").html(response);
            $('#find-enrolled-student').prop("disabled", false);
        },
    });
}

//DELETE ENROLLED STUDENT
$("#new-content").on('click', '#removeEnrolledStud', function(e) {
    e.preventDefault();

    if (confirm("Are you sure you want to remove item. This action can not be reversed!") == true) {
        $('#removeEnrolledStud').text("Working...").prop("disabled", true);
        var id = $(this).data('recordid');
        //var examid = $("#record-id").val();
        removeEnrolee(id);
    } else {
        $('#removeEnrolledStud').text("Remove").prop("disabled", false);
    }

});
//call back for delete affective skill settings
function removeEnrolee(id) {
    $.ajax({
        url: 'deleteEnrolledStudent.php',
        type: 'POST',
        data: { id: id },
        success: function(response) {
            var data = $.trim(response);
            if (data === "ok") {
                //call a reload function here
                reloadStudentPreview();
            } else {
                $('#removeEnrolledStud').text("Remove").prop("disabled", false);
                $("#my-info").addClass("error");
                $("#my-info").html(data);
            }
        },
    });
}
//END ENROLLED STUDENT

//RELOAD STUDENT PREVIEW

function reloadStudentPreview() {
    $.ajax({
        url: 'currentEnrollment.php',
        type: 'POST',
        data: {},
        success: function(response) {
            $("#new-content").html(response);
        },
    });
}
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
    //alert(scores+regno+studentclass+ca_number+subject);
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

//GET ADMISSION LIST OF STUDENTS BY CLASS

$("#new-content").on('click', '#adm-list', function(e) {
    e.preventDefault();
    $('#adm-list').prop("disabled", true);
    var myclass = $("#class-adm option:selected").val();
    var session = $("#sess-adm option:selected").val();
    admittedList(myclass, session);
});

//call back function to  get admission students by class
function admittedList(myclass, session) {
    $.ajax({
        url: 'getAdmissionList.php',
        type: 'POST',
        data: { myclass: myclass, session: session },
        success: function(response) {
            $('#adm-list').prop("disabled", true);
            $("#new-content").html(response);
        },
    });
}
//GET ADMISSION LIST OF STUDENTS BY CLASS

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

//PROCESS ASSESSMENT SCORESHEET

//View Result summary for print
$("#new-content").on('click', '#print-result', function(e) {
    e.preventDefault();
    $('#print-result').prop("disabled", true);
    var studclass = $("#studclass option:selected").val();
    var session = $("#session option:selected").val();
    var term = $("#term option:selected").val();
    viewResultPrint(studclass, session, term);
});

//call back function to add new continous assessment scores
function viewResultPrint(studclass, session, term) {
    $.ajax({
        url: 'viewResultPrint.php',
        type: 'POST',
        data: { studclass: studclass, session: session, term: term },
        success: function(response) {
            var data = $.trim(response);
            if (data === "ok") {
                $('#print-result').prop("disabled", false);
                $("#new-content").html(data);
            } else {
                $('#print-result').prop("disabled", false);
                // $("#my-info").addClass("error");
                $("#new-content").html(data);
            }
        },
    });
}

//End View Result summary for print

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
//END SCORESHEET PROCESSING


//process class result sheet
$("#new-content").on('click', '#exam-sheet', function(e) {
    e.preventDefault();
    $('#exam-sheet').prop("disabled", true);
    var myclass = $("#exam-class option:selected").val();
    var session = $("#session option:selected").val();
    var term = $("#term option:selected").val();

    //alert(subject + myclass + session + term);
    classResult(myclass, session, term);
});

//call back function to add new continous assessment scores
function classResult(myclass, session, term) {
    $.ajax({
        url: 'processClassResultSheet.php',
        type: 'POST',
        data: { myclass: myclass, session: session, term: term },
        success: function(response) {
            var data = $.trim(response);
            if (data === "ok") {
                $('#exam-sheet').prop("disabled", false);
                $("#new-content").html(data);
            } else {
                $('#exam-sheet').prop("disabled", false);
                // $("#my-info").addClass("error");
                $("#new-content").html(data);
            }
        },
    });
}
//end process class result sheet 


//Get student details on providing a registration number
$('#new-content').on('keyup', '#regno', function() {
    var id = $("#regno").val();
    $.post("getStudent.php", { id: id }, function(data) {
        $("#user_details").html(data);
    });
});


//load students on class change
//this functioanlity is only available to class teachers only

$("#new-content").on('change', '.stud-ca', function() {
    var classid = $(".stud-ca option:selected").val();
    $.post("studentsListClassChange.php", { classid: classid }, function(data) {
        $(".class-student-list").html(data);
    });
});

$("#new-content").on('change', '.stud-exam', function() {
    var classid = $(".stud-exam option:selected").val();
    $.post("studentsListClassChange.php", { classid: classid }, function(data) {
        $(".class-student-list").html(data);
    });
});


//LOAD STAFF SUBJECT ON SELECTION OF CLASS
$('#new-content').on('change', '#my-class', function() {
    var id = $("#my-class option:selected").val();
    $.post("staffSubjectByClass.php", { id: id }, function(data) {
        $("#position-subject").html(data);
    });
});
//END LOAD SRAFF SUBJECT ON SELECTION OF CLASS
//===================================================

$('#new-content').on('change', '#assignmentclass', function() {
    var id = $("#assignmentclass option:selected").val();
    $.post("staffSubjectByClass.php", { id: id }, function(data) {
        $("#listsubject").html(data);
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
                $('#assign-position').text("Assign Subject Position").prop("disabled", false);
                $("#my-info").html("Subject Position Assigned Successfully");
            } else {
                $('#assign-position').text("Assign Subject Position").prop("disabled", false);
                $("#my-info").addClass("error");
                $("#my-info").html(data);
            }
        },
    });
}
//end assign subject position

//code block to reset subject position
$("#new-content").on('click', '#reset-subject-position', function(e) {
    e.preventDefault();
    $('#reset-subject-position').text("Reseting...").prop("disabled", true);
    var subject = $("#position-subject option:selected").val();
    var myclass = $("#my-class option:selected").val();
    var session = $("#session option:selected").val();
    var term = $("#term option:selected").val();

    resetSubjectPosition(subject, myclass, session, term);
});

function resetSubjectPosition(subj, myclass, session, term) {
    $.ajax({
        url: 'resetSubjectPosition.php',
        type: 'POST',
        data: { subj: subj, myclass: myclass, session: session, term: term },
        success: function(response) {
            var data = $.trim(response);
            if (data === "ok") {
                $('#reset-subject-position').text('Reset Subject Position').prop("disabled", false);
                $("#my-info").addClass("info");
                $("#my-info").html("Position Reset successfully");
            } else {
                $('#reset-subject-position').text("Reset Subject Position").prop("disabled", false);
                $("#my-info").addClass("error");
                $("#my-info").html(data);
            }
        },
    });
}
//end code block to reset subject  position


//code to reset submit result
$("#new-content").on('click', '#reset-submit-result', function(e) {
    e.preventDefault();
    $('#reset-submit-result').text("Reseting...").prop("disabled", true);

    var myclass = $("#my-class option:selected").val();
    var session = $("#session option:selected").val();
    var term = $("#term option:selected").val();

    resetResult(myclass, session, term);
});

function resetResult(myclass, session, term) {
    $.ajax({
        url: 'resetSubmittedResult.php',
        type: 'POST',
        data: { myclass: myclass, session: session, term: term },
        success: function(response) {
            var data = $.trim(response);
            if (data === "ok") {
                $('#reset-submit-result').text('Undo Submit Result').prop("disabled", false);
                $("#my-info").addClass("info");
                $("#my-info").html("Submitted Result Reset Successfully");
            } else {
                $('#reset-submit-result').text("Undo Submit Result").prop("disabled", false);
                $("#my-info").addClass("error");
                $("#my-info").html(data);
            }
        },
    });
}
//End code to reset submit result


//RESET CLASS POSITION
$("#new-content").on('click', '#reset-class-position', function(e) {
    e.preventDefault();
    $('#reset-class-position').text("Reseting...").prop("disabled", true);

    var myclass = $("#my-class option:selected").val();
    var session = $("#session option:selected").val();
    var term = $("#term option:selected").val();

    resetClassPosition(myclass, session, term);
});

function resetClassPosition(myclass, session, term) {
    $.ajax({
        url: 'resetClassPosition.php',
        type: 'POST',
        data: { myclass: myclass, session: session, term: term },
        success: function(response) {
            var data = $.trim(response);
            if (data === "ok") {
                $('#reset-class-position').text('Undo Class Position').prop("disabled", false);
                $("#my-info").addClass("info");
                $("#my-info").html("Class Position Reset Successfully");
            } else {
                $('#reset-class-position').text("Undo Class Position").prop("disabled", false);
                $("#my-info").addClass("error");
                $("#my-info").html(data);
            }
        },
    });
}
//END RESET CLASS POSITION


//RESET FINAL PUBLISHED RESULT
$("#new-content").on('click', '#reset-publish-result', function(e) {
    e.preventDefault();
    $('#reset-publish-result').text("Reseting...").prop("disabled", true);

    var myclass = $("#studentclass option:selected").val();
    var session = $("#session option:selected").val();
    var term = $("#term option:selected").val();

    resetPublishedFinalResult(myclass, session, term);
});

function resetPublishedFinalResult(myclass, session, term) {
    $.ajax({
        url: 'resetPublishedResult.php',
        type: 'POST',
        data: { myclass: myclass, session: session, term: term },
        success: function(response) {
            var data = $.trim(response);
            if (data === "ok") {
                $('#reset-publish-result').text('Undo Publish Result').prop("disabled", false);
                $("#my-info").addClass("info");
                $("#my-info").html("Published Result Reset Successfully");
            } else {
                $('#reset-publish-result').text("Undo Publish Result").prop("disabled", false);
                $("#my-info").addClass("error");
                $("#my-info").html(data);
            }
        },
    });
}



//END RESET FINAL PUBLISHED RESULT


//ENROLL NEW STUDENT IN A CLASS
$("#new-content").on('click', '#enroll-student', function(e) {
    e.preventDefault();
    $('#enroll-student').text("Enrolling...").prop("disabled", true);
    var enrollregno = $("#regno").val();
    var myclass = $("#enroll-class option:selected").val();
    var session = $("#enroll-session option:selected").val();
    newEnrollment(enrollregno, myclass, session);
});

//call back function to enroll new student
function newEnrollment(enrollregno, myclass, session) {
    $.ajax({
        url: 'newEnrollment.php',
        type: 'POST',
        data: { enrollregno: enrollregno, myclass: myclass, session: session },
        success: function(response) {
            var data = $.trim(response);
            if (data === "ok") {
                $('#enroll-student').text("Enroll Student").prop("disabled", false);
                loadEnrolledStudents(myclass);
            } else {
                $('#enroll-student').text("Enroll Student").prop("disabled", false);
                $("#my-info").addClass("error");
                $("#my-info").html(data);
            }
        },
    });
}
//END ENROLL NEW STUDENT IN A CLASS

//RELOAD ENROLLED STUDENT

function loadEnrolledStudents(myclass) {
    $.ajax({
        url: 'reloadEnrolledStudents.php',
        type: 'POST',
        data: { myclass: myclass },
        success: function(response) {
            $(".enrolled-stud-list").html(response);
        },
    });
}
//END RELOAD ENROLLED STUDENT

//remove enrolled student
$("#new-content").on('click', '#remove-enrolled-student', function(e) {
    e.preventDefault();

    if (confirm("Are you sure you want to rmove item. This action can not be reversed!") == true) {
        $('#remove-enrolled-student').prop("disabled", true);
        var id = $(this).data('id');
        var myclass = $("#enroll-class").val();
        deleteEnrolledStud(id, myclass);
    } else {
        $('#remove-enrolled-student').prop("disabled", false);
    }

});
//call back for delete affective skilss
function deleteEnrolledStud(id, myclass) {
    $.ajax({
        url: 'deleteEnrolledStudent.php',
        type: 'POST',
        data: { id: id },
        success: function(response) {
            var data = $.trim(response);
            if (data === "ok") {
                //call a reload function here
                loadEnrolledStudents(myclass);
            } else {
                //$('#remove-trait').prop("disabled", false);
                //$("#modal_error").addClass("error");
                $("#my-info").html(data);
            }
        },
    });
}

//remove enrolled student

//class teacher post result for processing i.e assigning class position
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

//Begin assign class position
$("#new-content").on('click', '#class-position', function(e) {
    if (confirm("Be sure that you want to assign class postion. This action can not be reversed!") == true) {
        e.preventDefault();
        $('#class-position').text("Assigning...").prop("disabled", true);
        var myclass = $("#my-class option:selected").val();
        var session = $("#session option:selected").val();
        var term = $("#term option:selected").val();
        classPositionAssign(myclass, session, term);
    } else {
        $('#class-position').text("Assign Class Position").prop("disabled", false);
    }
});

//call back function to add class position
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

//Functionality to fetch result for promotion


$("#new-content").on('click', '#show-summary-result', function(e) {
    e.preventDefault();
    $('#show-summary-result').text("Fetching...").prop("disabled", true);
    var myclass = $("#studentclass option:selected").val();
    var session = $("#session option:selected").val();
    var term = $("#term option:selected").val();
    //alert(myclass + session + term);
    getRecords(myclass, session, term);
});

function getRecords(studentclass, session, term) {
    $.ajax({
            url: 'getExamsRecords.php',
            type: 'POST',
            data: { studentclass: studentclass, session: session, term: term },
            dataType: 'html'
        })
        .done(function(data) {
            //console.log(data);
            $('#show-summary-result').text("Show Result Summary").prop("disabled", false);
            $('#new-content').html(data); // load here 
        })
        .fail(function(data) {
            $('#my-info').html(data);
            //$('#modal-loader').hide();
        });
}



//end functionality to fetch result for


//Function to handle students traits
//Fetch result to add traits by staff
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

//fetch published results for adding admin comments
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

//Add attendance settings
$("#new-content").on('click', '#add-attendance-days', function(e) {
    e.preventDefault();
    $('#add-attendance-days').text("Adding...").prop("disabled", true);
    var daysOpen = $("#daysOpen").val();
    var daysClosed = $("#daysClosed").val();
    var term = $("#term option:selected").val();
    var session = $("#session option:selected").val();
    attendanceSettings(daysOpen, daysClosed, term, session);
});

//call back function to enroll new student
function attendanceSettings(daysOpen, daysClosed, term, session) {
    $.ajax({
        url: 'addAttendanceSettings.php',
        type: 'POST',
        data: { daysOpen: daysOpen, daysClosed: daysClosed, term: term, session: session },
        success: function(response) {
            var data = $.trim(response);
            if (data === "ok") {
                $('#add-attendance-days').text("Add Settings").prop("disabled", false);
                $("#my-info").addClass("info");
                $('#my-info').text("Settings created successfully");
            } else {
                $('#add-attendance-days').text("Add Settings").prop("disabled", false);
                $("#my-info").addClass("error");
                $("#my-info").html(data);
            }
        },
    });
}
//end add attendance settings

//Add resumption date settings
//Add attendance settings
$("#new-content").on('click', '#next-term', function(e) {
    e.preventDefault();
    $('#next-term').text("Adding...").prop("disabled", true);
    var date = $("#r-date").val();
    //var term = $("#term option:selected").val();
    //var session = $("#session option:selected").val();
    nexttermbegins(date);
});

//call back function to enroll new student
function nexttermbegins(date) {
    $.ajax({
        url: 'addResumptionSettings.php',
        type: 'POST',
        data: { date: date },
        success: function(response) {
            var data = $.trim(response);
            if (data === "ok") {
                $('#next-term').text("Add Resumption Date").prop("disabled", false);
                $("#my-info").addClass("info");
                $('#my-info').text("Resumption Date Settings Created Successfully");
            } else {
                $('#next-term').text("Add Resumption Date").prop("disabled", false);
                $("#my-info").addClass("error");
                $("#my-info").html(data);
            }
        },
    });
}
//end add attendance settings


//End resumption date settings