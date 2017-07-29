$(function() {
    $( "#datepicker" ).datepicker();
  });

//get birthdays NOT COMPLETE

 $('.birthdays').on('click', function(evt) {
    evt.preventDefault();
    let url = $(this).attr('href');
    //alert(url);
     $('#new-content').load(url, function() {
        // put the set interval function or code here
     //    $("#new-content").on('click', '#ID-BUTTON', function(e){
        //on click of the send Message BUTTON, get the ID OF THE USER AND PASS INTO THE SEND MESSAGE FUNCTION
     //       e.preventDefault();
     //       //var id = $('#ID OF user ID element').attr('value');
     //       sendMessage(id);
     });

     // });
})
//end getbirthdays ////NOT COMPLETE

//get all students
    $('.all-students').on('click', function(evt) {
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
 getallStudents(url);
})
//get all students
 function getallStudents(url)
    {
            //get inserted records from the database
            jQuery.getJSON( url, function( response ){
                if(typeof response==='object')
                {
                var profileHTML = '<ul class="inst-profile">';
                $.each(response, function(index, profile){
                    // if(profile.inst_logo === ""){
                    //     var logo = "Logo not uploaded!";
                    // }
                    // else{
                    //     logo = profile.inst_logo;
                    // }
                    //generate HTML to display added information
                    profileHTML+= '<li> ' + profile.fullname + ' </li>';
                   //  profileHTML+= '<li>' + profile.category_name + ' </li>';
                   //  profileHTML+= '<li><strong>COUNTRY OF LOCATION: </strong> ' + profile.nationality + ' </li>';
                   //  profileHTML+= '<li><strong>STATE OF LOCATION:</strong> ' + profile.state_name + ' </li>';
                   //  profileHTML+= '<li><strong>LGA of Location:</strong> ' + profile.lga + ' </li>';
                   //  profileHTML+= '<li><strong>CITY: </strong> ' + profile.city_name + ' </li>';
                   //  profileHTML+= '<li><strong>INSTITUTION ADDRESS:</strong> ' + profile.inst_add + ' </li>';
                   //  profileHTML+= '<li><strong>INSTITUTION MOBILE: </strong> ' + profile.inst_mobile + ' </li>';
                   // profileHTML+= '<li><strong>INSTITUTION LOGO:</strong> ' + ' <img  class="headerImage mr-3" src="'+logo+'" height="40" width="40"></li>';
                });
                profileHTML+='</ul>';
                $('#new-content').html(profileHTML);
                }
                else
                {
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
    function getMyStaff(url)
    {
            //get inserted records from the database
            jQuery.getJSON( url, function( response ){
                if(typeof response==='object')
                {
                var profileHTML = '<ul class="inst-profile">';
                $.each(response, function(index, profile){
                    // if(profile.inst_logo === ""){
                    //     var logo = "Logo not uploaded!";
                    // }
                    // else{
                    //     logo = profile.inst_logo;
                    // }
                    //generate HTML to display added information
                    profileHTML+= '<li> ' + profile.fullname + ' </li>';
                   //  profileHTML+= '<li>' + profile.category_name + ' </li>';
                   //  profileHTML+= '<li><strong>COUNTRY OF LOCATION: </strong> ' + profile.nationality + ' </li>';
                   //  profileHTML+= '<li><strong>STATE OF LOCATION:</strong> ' + profile.state_name + ' </li>';
                   //  profileHTML+= '<li><strong>LGA of Location:</strong> ' + profile.lga + ' </li>';
                   //  profileHTML+= '<li><strong>CITY: </strong> ' + profile.city_name + ' </li>';
                   //  profileHTML+= '<li><strong>INSTITUTION ADDRESS:</strong> ' + profile.inst_add + ' </li>';
                   //  profileHTML+= '<li><strong>INSTITUTION MOBILE: </strong> ' + profile.inst_mobile + ' </li>';
                   // profileHTML+= '<li><strong>INSTITUTION LOGO:</strong> ' + ' <img  class="headerImage mr-3" src="'+logo+'" height="40" width="40"></li>';
                });
                profileHTML+='</ul>';
                $('#new-content').html(profileHTML);
                }
                else
                {
                 $('#new-content').html(response); 
                }
               
            });
           
            } 
//End Get Staff Records


//////////////////////////////////

    //add new Staff
    $('.new-emplyee').on('click', function(evt) {
    evt.preventDefault();
    let url = $(this).attr('href');
     $('#new-content').load(url, function() {
        $("#new-content").on('click', '#staff-account', function(e){
           e.preventDefault();
          $('#staff-account').text("Please wait....").prop("disabled", true);
            var email = $("#email").val();
            var pass = $("#my-pass").val();
            var username = $("#username").val();
            var role =  $("#role option:selected").val();
           //var jsURL = $('#input').attr('value');
           submit(email,username,pass,role);
        });

     });
    //console.log(url);   

})
//function to add new staff call back
function submit(email,user,pass,role){
                    $.ajax({
                    url:'addNewStaff.php',
                    type :'POST',
                    data: {email:email,username:user,pass:pass,role:role},
                    success: function(response){
                        var data = $.trim(response);
                        if(data==="ok"){
                        $('#staff-account').text("Create Staff").prop("disabled", false);
                        $("#my-info").addClass("info");
                        $("#my-info").html("Staff added successfully"); 
                        }
                        else{
                        //alert("me")
                        $('#staff-account').text("Create Staff").prop("disabled", false);
                        $("#my-info").addClass("error");;
                        $("#my-info").html(data);  
                        } 
                    },
                    //alert(user+pass+role);
                }) 
            }   //end new staff



//add new subject
    $('.new-subject').on('click', function(evt) {
    evt.preventDefault();
    let url = $(this).attr('href');
     $('#new-content').load(url, function() {
        $("#new-content").on('click', '#add-subject', function(e){
           e.preventDefault();
          $('#add-subject').text("Please wait....").prop("disabled", true);
            var staff = $("#staff option:selected").val();
            var subj_class = $("#class option:selected").val();
            var subj =  $("#subject option:selected").val();
           submit(staff,subj_class,subj);
        });
     });
    //console.log(url);   

})
//function to add new subject call back
function submit(staff,subj_class,subj){
                    $.ajax({
                    url:'addStaffSubject.php',
                    type :'POST',
                    data: {staff:staff,subj_class:subj_class,subj:subj},
                    success: function(response){
                        var data = $.trim(response);
                        if(data==="ok"){
                        $('#add-subject').text("Add Subject").prop("disabled", false);
                        $("#my-info").addClass("info");
                        $("#my-info").html("Subject added successfully"); 
                        }
                        else{
                        //alert("me")
                        $('#add-subject').text("Add Subject").prop("disabled", false);
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
    $.post("addSchoolProfile.php",{
    inst_name: inst_name,
    inst_category: inst_category,
    nation: nation, 
    state: state,
    lg:lg,
    city:city,
    address:address,
    mobile:mobile
    }).done(createInst);
});
//institution profile call back function
   function createInst(response)
   {
            $("#register").modal("hide");
            //get inserted records from the database

            var data = $.trim(response);
                if(data==="ok"){
                window.location.replace("uploadLogo.php");
                }
                else{
                //alert("me")
                $("#profile-info").addClass("error");;
                $("#profile-info").html(data);  
                }
        
            }
// end code to create institution profile

//Reload the content of after interval
setInterval(function () {
getInstProfile();
}, 1000);//120000


function getInstProfile()
   {
            //get inserted records from the database

            var url = "getProfile.php";
            jQuery.getJSON( url, function( response ){

                var profileHTML = '<ul class="inst-profile">';
                $.each(response, function(index, profile){
                    // if(profile.inst_logo === ""){
                    //     var logo = "Logo not uploaded!";
                    // }
                    // else{
                    //     logo = profile.inst_logo;
                    // }
                    //generate HTML to display added information
                    profileHTML+= '<li> ' + profile.institution_name + ' </li>';
                    profileHTML+= '<li>' + profile.category_name + ' </li>';
                    // profileHTML+= '<li><strong>COUNTRY OF LOCATION: </strong> ' + profile.nationality + ' </li>';
                    // profileHTML+= '<li><strong>STATE OF LOCATION:</strong> ' + profile.state_name + ' </li>';
                    // profileHTML+= '<li><strong>LGA of Location:</strong> ' + profile.lga + ' </li>';
                    // profileHTML+= '<li><strong>CITY: </strong> ' + profile.city_name + ' </li>';
                    // profileHTML+= '<li><strong>INSTITUTION ADDRESS:</strong> ' + profile.inst_add + ' </li>';
                    // profileHTML+= '<li><strong>INSTITUTION MOBILE: </strong> ' + profile.inst_mobile + ' </li>';
                   // profileHTML+= '<li><strong>INSTITUTION LOGO:</strong> ' + ' <img  class="headerImage mr-3" src="'+logo+'" height="40" width="40"></li>';
                });
                profileHTML+='</ul>';
                $('#right-school-profile').html(profileHTML);

            });
           
            }
            //end of get institutional profile


    //get staff by gender

    function getStaffByGender(url)
   {
            
            jQuery.getJSON( url, function( response ){

                var profileHTML = '<ul class="inst-profile">';
                $.each(response, function(index, profile){
                    if(jQuery.isEmptyObject(profile)){
                        console.log("empty");
                      $('#new-content').html("No matching record available");
                     }
                    else{
                    
         
                    //generate HTML to display added information
                    profileHTML+= '<li> ' + profile.fullname + ' </li>';
                    //profileHTML+= '<li>' + profile.category_name + ' </li>';
                    // profileHTML+= '<li><strong>COUNTRY OF LOCATION: </strong> ' + profile.nationality + ' </li>';
                    // profileHTML+= '<li><strong>STATE OF LOCATION:</strong> ' + profile.state_name + ' </li>';
                    // profileHTML+= '<li><strong>LGA of Location:</strong> ' + profile.lga + ' </li>';
                    // profileHTML+= '<li><strong>CITY: </strong> ' + profile.city_name + ' </li>';
                    // profileHTML+= '<li><strong>INSTITUTION ADDRESS:</strong> ' + profile.inst_add + ' </li>';
                    // profileHTML+= '<li><strong>INSTITUTION MOBILE: </strong> ' + profile.inst_mobile + ' </li>';
                   // profileHTML+= '<li><strong>INSTITUTION LOGO:</strong> ' + ' <img  class="headerImage mr-3" src="'+logo+'" height="40" width="40"></li>';
               }
                });
                profileHTML+='</ul>';
                $('#new-content').html(profileHTML);

            });
           
            }
            //end of get institutional profile

    //end staff by gender

// //load the content of a particuluar url that is clicked on
// $('.nav-link').on('click', function(evt) {
//     evt.preventDefault();
//     let url = $(this).attr('href');
//      $('#new-content').load(url);
//     console.log(url);   
    
    
// })


//load subjects on selection of class
$("#new-content").on('change','#class',function(){
var id = $("#class option:selected").val();  
$.post("listSubjects.php",{id:id}, function(data){   
$("#subject").html(data);
}); 
});



// create ticket
$('#my-ticket').on('click', function() {
    $(this).text("Sending, please wait...").prop("disabled", true);
    let title = $("#title").val();
    let priority = $("#priority").val();
    let notes = $("#notes").val();
    $.post("createTicket.php",{
    title: title,
    priority: priority,
    notes: notes
    }).done(myTicket);
});

//create ticket callback function
   function myTicket(result){

            var data = $.trim(result);
            if(data==="ok"){
            $("#my-ticket").text("Send Ticket").prop("disabled", false);
            $("#error-info").html(data);
            }
            else{
            $("#my-ticket").text("Send Ticket").prop("disabled", false);
            $("#error-info").html(data);  
            }
        }

//load  states on selection of country 
$("#nation").change(function(){
var id = $("#nation option:selected").val();  
$.post("listStates.php",{id:id}, function(data){   
$("#state").html(data);
}); 
});


//load  lga   
$("#state").change(function(){
var id = $("#state option:selected").val();  
$.post("listLga.php",{id:id}, function(data){   
$("#lg").html(data);
}); 
});


//load  cities   
$("#lg").change(function(){
var id = $("#lg option:selected").val();  
$.post("listCity.php",{id:id}, function(data){   
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
    function prepareUpload(event)
    {
        //firing ok
        //console.log('This function is working and firing the first event');
        files = event.target.files;
        //firing ok
        //.log(files);
        //var size  = files[0].size;
        //console.log(size);   
    }

    // Catch the form files
    function uploadFiles(event)
    {
        //firing ok
       // console.log('Testing the second event handler');
        event.stopPropagation(); // Stop stuff happening
        event.preventDefault(); // Totally stop stuff happening

        // START A LOADING SPINNER HERE

        // Create a formdata object and add the files
        var data = new FormData();
        $.each(files, function(key, value)
        {
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
    function uploadLogo(event)
    {
        //firing ok
        console.log('Testing the second event handler');
        event.stopPropagation(); // Stop stuff happening
        event.preventDefault(); // Totally stop stuff happening

        // START A LOADING SPINNER HERE

        // Create a formdata object and add the files
        var data = new FormData();
        $.each(files, function(key, value)
        {
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
function imageCall(result){
    
    $("#msg").html(result);  
    
}

///////////////////////////////////////////////////////////

// logo upload

 $('#logo-file').on('change', prepareUpload);
$('#logo-file').on('change', uploadLogo);

/////////////////////////










//login call back
function login_call(result){
    var a = 2;
    var b = 1;
    var c = 2;
    var data = $.trim(result);
    if(data==="successful"){
    window.location.replace("home.php");
    }
    else{
    //alert("me");
	$("#output").addClass("error");
    $("#output").html(data);  
    }
}

//login method     
function login(){
	var pin = $("#pinnumber").val();
	var reg = $("#reg").val();
    $.post("login.php",{pin:pin,reg:reg}).done(login_call);
}

//call back for saveVoucher
function saveVoucher_call(myresponse){
    var a = 2;
    var b =1;
    var c = 2;
	var pin = $("#pin").val();
    var data = $.trim(myresponse);
    if(data==="successful"){
	      //close the popup
         $("#newApp").modal("hide");
         $("#surname").val("");
        $("#firstname").val("");
        $("#teller").val("");
        $("#mobile").val("");
        $("#bankAdd").val("");
		//alert("yea" + pin);
         //read the records again
         readVoucher(pin);
    }
    else{
	//alert(data);
		$("#surname").val("");
        $("#firstname").val("");
        $("#teller").val("");
        $("#mobile").val("");
        $("#bankAdd").val("");
		$("#newApp").modal("hide");
		$("#output").addClass("error");
		$("#output").html(data); 
		//alert(pin);
    }
}

//Save payment Voucher function
function saveVoucher() {
    // get values
    var sn = $("#surname").val();
    var fn = $("#firstname").val();
    var teller = $("#teller").val();
    var mobile = $("#mobile").val();
    var amt = $("#amount option:selected").val();
    var bnk = $("#bank option:selected").val();
    var session = $("#session option:selected").val();
    var bnkAdd = $("#bankAdd").val();
    var pin = $("#pin").val();
    // Add record
    $.post("paymentVoucher.php",
		{
        sn: sn,
        fn: fn,
        teller: teller,
        mobile: mobile,
        amt: amt,
        bnk: bnk,
        session: session,
        bnkAdd: bnkAdd,
        pin:pin,
    }).done(saveVoucher_call);
}

//call back function for read voucher
function readVoucher_call(result){
    var a = 2;
    var b = 1;
    var c = 2;
    var data = $.trim(result);
    if(data==="Unable to fetch voucher!"){
    $("#output").addClass("error");
    $("#output").html(data);
    //window.location.replace("home.php");
    }
    else{
    //alert("me");
    $("#output").html(data);  
    }
}

//function to read voucher
function readVoucher(id) {
    $.post("readVoucher.php", {id:id}).done(readVoucher_call);
}

//function to process form submission
//// submit application form
function submitForm() {
    // get values
    var sn = $("#surname").val();
    var fn = $("#firstname").val();
    var dob = $("#datepicker").val();
    var nation = $("#nation").val();
    var state = $("#state").val();
    var lga = $("#lga").val();
    var rel = $("#religion option:selected").val();
    var course = $("#course option:selected").val();
    var town = $("#town").val();
    var resident = $("#resident").val();
    var padd = $("#padd").val();
    var mail = $("#mail").val();
    var mobile = $("#mobile").val();
    var guardian = $("#guardian").val();
    var gmobile = $("#gmobile").val();
    var gadd = $("#gadd").val();
    var goccup = $("#goccup").val();
    var sname = $("#sname").val();
    var sadd = $("#sadd").val();
    var sex = $("#sex option:selected").val();
    var status = $("#status option:selected").val();
  
    // Add record
    $.post("processForm.php", {
        sn: sn,
        fn: fn,
        dob: dob,
        nation: nation,
        state: state,
        lga: lga,
        rel: rel,
        course: course,
        town:town,
        resident: resident,
        padd: padd,
        mail: mail,
        mobile: mobile,
        guardian: guardian,
        gmobile:gmobile,
        gadd: gadd,
        goccup: goccup,
        sname:sname,
        sadd: sadd,
        sex: sex,
        status:status,
    }).done(submitForm_call); 
}

//call back for form submission
function submitForm_call(result){
    var data = $.trim(result);
    if(data==="successful"){
    window.location.replace("eFormAcade.php");
    }
    else{
    //alert("me");
    $("#output").addClass("error");
    $("#output").html(data);  
    }
}



//// Function to edit  application form
function editForm(){
    // get values
    var id= $("#ID").val();
    var sn = $("#surname").val();
    var fn = $("#firstname").val();
    var dob = $("#datepicker").val();
    var nation = $("#nation").val();
    var state = $("#state").val();
    var lga = $("#lga").val();
    var rel = $("#religion option:selected").val();
    var course = $("#course option:selected").val();
    var town = $("#town").val();
    var resident = $("#resident").val();
    var padd = $("#padd").val();
    var mail = $("#mail").val();
    var mobile = $("#mobile").val();
    var guardian = $("#guardian").val();
    var gmobile = $("#gmobile").val();
    var gadd = $("#gadd").val();
    var goccup = $("#goccup").val();
    var sname = $("#sname").val();
    var sadd = $("#sadd").val();
    var sex = $("#sex option:selected").val();
    var status = $("#status option:selected").val();
    // Add record
    $.post("processEditForm.php",{
        id:id,
        sn: sn,
        fn: fn,
        dob: dob,
        nation: nation,
        state: state,
        lga: lga,
        rel: rel,
        course: course,
        town:town,
        resident: resident,
        padd: padd,
        mail: mail,
        mobile: mobile,
        guardian: guardian,
        gmobile:gmobile,
        gadd: gadd,
        goccup: goccup,
        sname:sname,
        sadd: sadd,
        sex: sex,
        status:status,
    }).done(editForm_call);  
}
//call back function for Edit Form
function editForm_call(result){
    var data = $.trim(result);
    if(data==="Update Successful"){
	$("#output").addClass("info");
    $("#output").html(data); 
    }
    else{
    $("#output").addClass("error");
    $("#output").html(data);  
    }
}

//function to save academic records
/// Add Record
function addQualif(){
    // get values
    var exam = $("#exam option:selected").val();
    var yr = $("#yr option:selected").val();
    var subject = $("#subject option:selected").val();
    var grade = $("#grade option:selected").val();
    var sit = $("input[type=radio][name=sitting]:checked").val();
    // Add record
    $.post("addQualif.php",{
        exam: exam,
        yr: yr,
        subj: subject,
        grade: grade,
        sit: sit,
    }).done(addQualif_call);
}
//submit academic record call back
function addQualif_call(result){
	var data = $.trim(result);
	if(data==="successful"){
	//$("#output").addClass("info");
    //$("#output").html(data); 
		readAcademicQualif();
		}
		else{
		$("#output").addClass("error");
		$(".alert").html(data);  
		}
}

//read and display academic records after it has been added to the database
function readAcademicQualif() {

    $.get("readQualification.php").done(readQualif_call);
}
//read academic Qualif callback
function readQualif_call(result){
    var data = $.trim(result);
    if(data==="Unable to read records!"){
    $(".alert").addClass("error");
    $(".alert").html(data);
    }
    else{
    $(".alert").html(data);  
    }
}

//delete academic record
function deleteDetails(id) {
    var conf = confirm("Are you sure, you want to delete?");
    if (conf === true) {
        $.post("deleteQualification.php",{id: id}).done(deleteQualif_call);
    }
}
function deleteQualif_call(result){
    var data = $.trim(result);
    if(data==="Deleted"){
    //$(".alert").addClass("error");
    //$(".alert").html(data);
	readAcademicQualif();
    }
    else{
	$(".alert").addClass("error");
    $(".alert").html(data);  
    }
}