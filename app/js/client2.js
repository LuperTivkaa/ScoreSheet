$(document).ready(function(){

    //click on the navigation
    $('.new-emplyee').on('click', function(evt) {
    evt.preventDefault();
    let url = $(this).attr('href');
     $('#new-content').load(url, function() {
        $("#new-content").on('click', '#add-subject', function(e){
           e.preventDefault();
           //var jsURL = $('#input').attr('value');
           submit();
        });

     });
    //console.log(url);   
    
    
})

        
});

function submit(){
                    // $.ajax({
                    // url:'http://www.someurl.com/submit.php',
                    // type :'GET',
                    // success: function(data){
                    // $('#submit-status').html(data);
                    // }
                    // });
                    alert("Kai its really frustrating");
                }






                ///////////////////
                $( document ).ready(function() {
// create new staff
$('#new-content').on('click', '#staff-account', function() {

    $(this).text("Please wait...").prop("disabled", true);
    var username = $("#username").val();
    var pass = $("#my-pass").val();
   var role =  $("#role option:selected").val();

    $.post("addNewStaff.php",{
    username: username,
    pass: pass,
    role: role, 
    })
});
});

//add staff call back
   function addStaff(response)
   {
            
            //get inserted records from the database

            var data = $.trim(response);
                if(data==="ok"){
                $(this).text("Create Staff").prop("disabled", false);
                //window.location.replace("uploadLogo.php");
                $("#my-info").addClass("info");;
                $("#my-info").html(data); 
                }
                else{
                //alert("me")
                $(this).text("Create Staff").prop("disabled", false);
                $("#my-info").addClass("error");;
                $("#my-info").html(data);  
                }        
            }
        // end code to create new staff

        ///////////////////////////////////////////////////////////////////

        $.post( "test.php", { name: "John", time: "2pm" })
  .done(function( data ) {
    alert( "Data Loaded: " + data );
  });