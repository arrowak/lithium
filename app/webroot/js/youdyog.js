$(document).ready(function(){

		// hide the unwanted contents at the load-time
		$('#errorAlert').css("display", "none");
		$('#alertDiv').css("display", "none");	
		
		
		
		// set nav-bar item active according to the current url
		var pathname = window.location.pathname;
		
		if(pathname == '/connect'){
			$('#homeNav').attr('class','active');
		}
		else if(pathname == '/connect/connections'){
			$('#friendsNav').attr('class','active');
		}
		else if(pathname == '/connect/about'){
			$('#aboutNav').attr('class','active');
		}
		else{
		
		}
		
		// connect to a user
		$('#content').on('click','.connect',function(){		
		
			$.post('/connect',{id:$(this).attr('id')},function(data){
				if(data == '1')
				{
					$('#searchUserResults').html("Connected Successfully.");
				}
				else
				{
					$('#searchUserResults').html("Connection failed!");
				} 
			});
			return false;
		});
		
		// load all groups when groups button is ready
		$('#content').on('ready', '.btnAction', function(){				
			$.post('/getPrivateGroups',{},function(data){
				var newdata = jQuery.parseJSON(data);
				console.log(newdata);
				for(var i=0;i<newdata.length;i++){
					$('.groups').append("<li> <a href='#' id='"+newdata[i]+"' class='groupItem'>"+newdata[i]+"</a> </li>");
				}
			});	
			return false;	
		});
		
		
		// override close dropdown on click of add new group text box
		$('.txtGroupName').click(function(){
			return false;		
		});

		// add a group
		$('.frmNewGroup').submit(function(){
			$.post('/addGroup', {group : $('#txtGroupName').val()} , function(data){
				var newdata = jQuery.parseJSON(data);
				var userid = $(this).closest('div.groups').attr('data-id');
				$('.groups').html('');
					for(var i=0;i<newdata.length;i++){
						$('.groups').append("<li> <a href='#' id='"+newdata[i]+"' class='groupItem'>"+newdata[i]+"</a> </li>");				
					}
					$('#txtGroupName').val('');		
			});
			return false;	
		});	
		
		// add user to a group
		$( '.groups' ).on( 'click', '.groupItem', function () { 
			var userid = $(this).closest('div.groups').attr('data-id');
			var groupName = $(this).attr('id');
			$.post('connections/addUserToGroup', {userid: userid, group: groupName}, function(data){
				
			});
		});
		
		// add user to a public group
		$('#groupsList').on('click', '.btnJoinPublicGroup', function(){
			$.post('/addUserToPublicGroup', {groupId: $(this).attr('id')}, function(data){
				location.reload();
			});
			return true;
		});
		
		// remove user from public group
		$('#groupsList').on('click', '.btnUnjoinPublicGroup', function(){
			$.post('/removeUserFromPublicGroup', {groupId: $(this).attr('id')}, function(data){
				location.reload();
			});
			return true;
		});
		
		// get members of a public group
		$('#groupsList').on('click', '.publicGroup',function(){
			var id = $(this).attr('id');
			var groupName = $(this).attr('data-name');
			$.post('/getMembers',{groupId : id}, function(data){
				var newdata = jQuery.parseJSON(data);
				$('#groupsList').html('');
				$('#groupLegend').html('<a href="/getPublicGroups" onclick=""> Groups </a> | Members for '+groupName);
				for(var i=0;i<newdata.length;i++)
					$('#groupsList').append('<div class="listDiv"> <a href=""> '+newdata[i]+' </a></div>');
			});
			return false;
		});
		
		// get the searched groups
		$('#txtSearchGroup').submit(function(){
			var groupName = $(this).val();
			alert(groupName);
			$.post('/searchGroup',{group_name : groupName}, function(data){
				console.log(data);
			});
			return false;
		});		
		$('#btnSearchGroup').click(function(){
			var groupName = $('#txtSearchGroup').val();
			$.post('/searchGroup',{group_name : groupName}, function(data){
				var newdata = jQuery.parseJSON(data);
				console.log(newdata.length);
				$('#groupsList').html('');
				$('#groupLegend').html('<a href="/getPublicGroups" onclick=""> Groups </a> | Search Results for "'+groupName+'"');
				if(newdata.length == 0)
				{
					$('#groupsList').append('<h5><span style="color:#6F6F6F;">No matching groups.</span><h5>');
				}
				else{
					for(var i=0;i<newdata.length;i++)
					{
						$('#groupsList').append('<div class="listDiv"> <a class="publicGroup" data-name="'+newdata[i]['group_name']+'" href="" id="'+newdata[i]['id']['$id']+'">'+newdata[i]['group_name']+'</a>');
						if(newdata[i]['isMember'] == "1"){
							$('#groupsList').append("<button class='btn btn-success pull-right btnUnjoinPublicGroup' style='margin-top : -50px;' id='"+newdata[i]['id']['$id']+"'> UnJoin </button></div>");					
						}
						else{
							$('#groupsList').append("<button class='btn btn-success pull-right btnJoinPublicGroup' style='margin-top : -50px;' id='"+newdata[i]['id']['$id']+"'> Join </button></div>");
						}					
					}
				}
			});
			return false;
		});
		
		// delete a group
		$('#groupsList').on('click','.btnDeleteGroup',function(){
			var groupId = $(this).attr('id');
			$.post('/deleteGroup',{groupId : groupId},function(data){
				console.log(data);
				if(data == '0')
				{
					$('#myGroupsAlert').attr('class','alert alert-danger');
					$('#myGroupsAlert').css('display','block');
					$('#myGroupsAlert').html('<strong> Oops! </strong> Something terribly went wrong. Please try after sometime.');
					$('#myGroupsAlert').hide().fadeIn(300);
				}
				else
				{
					location.reload();
				}
			}); 
			return false;
		});
		
		// search a user via navbar search box
		$('#frmSearchUser').submit(function(){
			var searchName = $('#txtSearchName').val();
			$.post('/searchUser', {searchName : searchName}, function(data){
				var newdata = jQuery.parseJSON(data);
				console.log(newdata);
				for(var i=0;i<newdata.length;i++){
					if(newdata[i]['isFriend'] == '0')
					{
						$('#content').html('<div id="searchUserResults" class="wrapper"> <legend> Search Results </legend> <div id="resultsList" class="listDiv"> Name : '+newdata[i]['name']+' <br> Email : '+newdata[i]['email']+'<button id="'+newdata[i]['id']['$id']+'" class="btn btn-success pull-right connect"> Connect </button> </div></div>');
					}
					else
					{
						$('#content').html('<div id="searchUserResults" class="wrapper"> <legend> Search Results </legend> <div id="resultsList" class="listDiv"> Name : '+newdata[i]['name']+' <br> Email : '+newdata[i]['email']+'<button id="'+newdata[i]['id']['$id']+'" class="btn btn-success pull-right unconnect"> Unconnect </button> </div></div>');
					}
				}
			});
			return false;
		});
		
				
});


/* integration_25-01-13 | login, register | Sumanth, Pavan */

// For alternate Email

$(document).ready(function(){
		 $("#emailshow").click(function(){
		
			$(".txtemail").show();
			return false;
		});
});

$(document).ready(function(){
		 $("#emailshow").dblclick(function(){
			$(".txtemail").hide();
			return false;
		});
});


// To validate Email id

function validateEmail(sEmail) {
    var filter = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
    if (filter.test(sEmail)) {

        return true;
    }
    else {

        return false;
    }


}

// Password shopuld contain alpha numeric type

function validateAlphanumeric(sPass) {
    var filter = /^[a-zA-Z0-9]+$/;
    if (filter.test(sPass)) {

        return true;
    }
    else {

        return false;
    }
}

// Contact no should contain numbers

function validateNumber(sNumber) {
    var filter = /^[0-9]+$/;
    if (filter.test(sNumber)) {

        return true;
    }
    else {

        return false;
    }
}

// To validate Password

function validatePassword(sPass) {
    var filter = /^[a-zA-Z0-9]{4,32}$/;
    if (filter.test(sPass)) {

        return true;
    }
    else {

        return false;
    }
}


// username should contain only alphabets n check

function validateAlphabets(sAlpha) {
    var filter = /^[a-zA-Z]+$/;
    if (filter.test(sAlpha)) {

        return true;
    }
    else {

        return false;
    }
}

// to check for login

function validateLogin(val1,val2){

if(validateEmail($("#txtemail").val()) && validatePassword($("#txtpassword").val())){

return true;
}

return false;

}


// for First Name and Last Name
function validateName(sname) {
    var filter = /^[a-zA-Z]{2,32}$/;
    if (filter.test(sname)) {

        return true;
    }
    else {

        return false;
    }
}
	

 // To check for Registration for a user

function validateRegisterPage(){
var result = false;

	if(validateEmail($("#txtemail").val())){
		$("#emailalertBox").css("display","block").hide().fadeIn(200);
		$("#emailalertBox").css("display","none");
		result = true;
		
	}

	else{
		$("#emailalertBox").css("display","block").hide().fadeIn(200);
		$("#emailalertBox").html("Please enter valid email id");
		
	}
	
	if(validateAlphabets($("#txtfname").val())){
		$("#fnamealertBox").css("display","block").hide().fadeIn(200);
		$("#fnamealertBox").css("display","none");
		result = true;
		
	}

	else{
		$("#fnamealertBox").css("display","block").hide().fadeIn(200);
		$("#fnamealertBox").html("First Name cannot be empty");
		
	}
         
         if(validateAlphabets($("#txtlname").val())){
		$("#lnamealertBox").css("display","block").hide().fadeIn(200);
		$("#lnamealertBox").css("display","none");
		result = true;
		
	}

	else{
		$("#lnamealertBox").css("display","block").hide().fadeIn(200);
		$("#lnamealertBox").html("Last Name cannot be empty");
		
	}
         
	if(validateAlphanumeric($("#password").val())){
		$("#passwordalertBox").css("display","block").hide().fadeIn(200);
		$("#passwordalertBox").css("display","none");
		result =  true;
	}

	else{
		$("#passwordalertBox").css("display","block").hide().fadeIn(200);
		$("#passwordalertBox").html("Password Should Contain AlphaNumeric Values");
		

	}
	if(validateAlphabets($("#txtusername").val())){
		$("#usernamealertBox").css("display","block").hide().fadeIn(200);
		$("#usernamealertBox").css("display","none");
		result = true;
	}

	else{
		$("#usernamealertBox").css("display","block").hide().fadeIn(200);
		$("#usernamealertBox").html("Only Alphabets allowed");
		
	}

	if(validateNumber($("#txtcontactno").val())){
		$("#contactnoalertBox").css("display","block").hide().fadeIn(200);
	        $("#contactnoalertBox").css("display","none");
	result = true;	
	
	}

	else{
		$("#contactnoalertBox").css("display","block").hide().fadeIn(200);
		$("#contactnoalertBox").html("Not a valid phone number / Cannot be left blank.");
		return false;

	}

	return result;
	
}

// To validate User Name length .... (minimum requirment)



// password Strength .....

function passwordStrength(password,passwordStrength,errorField)
{
 var desc = new Array();
 desc[0] = "Password strength: Very weak";
 desc[1] = "Password strength: Weak";
 desc[2] = "Password strength: Better";
 desc[3] = "Password strength: Medium";
 desc[4] = "Password strength: Strong";
 desc[5] = "Password strength: Strongest";

 var score   = 0;

 // if password bigger than 6 give 1 point
 if (password.length > 6) score++;
 
 // if password has both lower and uppercase characters give 1 point
 if ( ( password.match(/[a-z]/) ) && ( password.match(/[A-Z]/) ) ) score++;

 // if password has at least one number give 1 point
 if (password.match(/\d+/)) score++;

 // if password has at least one special caracther give 1 point
 if ( password.match(/.[!,@,#,$,%,^,&,*,?,_,~,-,(,)]/) ) score++;

 // if password bigger than 12 give another 1 point
 if (password.length > 10) score++;

  passwordStrength.innerHTML = desc[score];
  passwordStrength.className = "strength" + score;

 if (password.length < 6)
 {} 
 
}

// Recaptcha Colors / Custimization ... use white, red, or remove script for
// classic use

var RecaptchaOptions = {
    theme : 'white'
 };
 
// for Password Comparission
 
 function comp_pass()
 {
 var pass_comp = false;

 	if($("#password").val() == $("#txtcpass").val())
 	{
		$("#cpasswordalertBox").css("display","block").hide().fadeIn(200);
	$("#cpasswordalertBox").css("display","none");
	result = true;	
	}
        else
        {
		$("#cpasswordalertBox").css("display","block").hide().fadeIn(200);
		$("#cpasswordalertBox").html("Password did not match. Please try again!!");
		return false;
        }
 
 return pass_comp;       
 } 
 
// for phone number

$(document).ready(function() {
    $("#txtcontactno").keydown(function(event) {
        // Allow: backspace, delete, tab, escape, and enter
        if ( event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 27 || event.keyCode == 13 || 
             // Allow: home, end, left, right
            (event.keyCode >= 35 && event.keyCode <= 39)) {
                 // let it happen, don't do anything
                 return;
        }
        else {
            // Ensure that it is a number and stop the keypress
            if (event.shiftKey || (event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105 )) {
                event.preventDefault(); 
            }   
        }
    });
});
 

/* forgotten password */

$(document).ready(function() {
	$('#btnSubmitEmail').click(function(){
		var email = $('#txtForgotEmail').val();
		$.post('/getLink',{email : email}, function(data){
			var newdata = jQuery.parseJSON(data);
			$('#uniqueId').val(newdata['link']);
			$('#newPassword').css('display' , 'block');
			$('#emailContainer').append('<a href ="http://localhost/forgotpassword/'+newdata['link']+'" id="changePasswordLink"> Change Password </a>');
		});
	});
	
/* reset the forgotten password */
	$('#btnResetPassword').click(function(){
		var newPassword = $('#txtNewPassword').val();
		var confirmPassword = $('#txtConfirmPassword').val();
		
		if(newPassword != confirmPassword)
		{
			$('#alertNewPassword').css('display','block');
			$('#alertNewPassword').attr('class','alert alert-danger');
			$('#alertNewPassword').html('<strong> Oops! </strong> Passwords do not match. Please try again.');
			$('#alertNewpassword').hide().fadeIn(300);

		}
		else
		{
			var uniqueId = location.pathname.substring(16);
			$.post('/updatePassword',{password : newPassword, uniqueId : uniqueId},function(data){
				if(data == 1){
					$('#alertNewPassword').css('display','block');
					$('#innerWrapper').css('display','none');
					$('#alertNewPassword').attr('class','alert alert-success');
					$('#alertNewPassword').html('Your password has been changed. Please <strong> <a href="/login"> login </a> </strong> with your new password.');
					$('#alertNewpassword').hide().fadeIn(300);
				}
			});
		}
		return false;
	});
	
/* manage interests | manage tabs */
	$('#myTab').ready(function(){
		if($('#enabled').val() == "hows")
		{
			$('#managehowsLink').attr('class','active');
			$('#managehows').attr('class','tab-pane fade in active');
			$('#managewhatsLink').attr('class','');
			$('#managewhats').attr('class','tab-pane fade');
			$.post('/admin/getHows',{},function(data){
				var newdata = jQuery.parseJSON(data);
				$('#managehowscontent').html('');
				if(newdata.length == 0)
				{
					$('#managehowscontent').append('<center> There are no items to display. </center>');
				}
				for(var i=0;i<newdata.length;i++)
				{
					$('#managehowscontent').append('<div class="listDiv"> '+newdata[i]['name']+'<button title="Delete" style="margin-left : 20px;" class="btn pull-right deleteHow" id="'+newdata[i]['id']['$id']+'"> <i class="icon-trash"> </i> </button><button title="Rename" data-name="'+newdata[i]['name']+'"  class="btn pull-right editHow" id="'+newdata[i]['id']['$id']+'"> <i class="icon-edit"> </i> </button>');
				}
			});
		}
		else if($('#enabled').val() == "whats" || $('#enabled').val() == "/")
		{
			$('#managehowsLink').attr('class','');
			$('#managehows').attr('class','tab-pane fade');
			$('#managewhatsLink').attr('class','active');
			$('#managewhats').attr('class','tab-pane fade  in active');
			$.post('/admin/getWhats',{},function(data){
				var newdata = jQuery.parseJSON(data);
				$('#managewhatscontent').html('');
				if(newdata.length == 0)
				{
					$('#managewhatscontent').append('<center> There are no items to display. </center>');
				}
				for(var i=0;i<newdata.length;i++)
				{
					$('#managewhatscontent').append('<div class="listDiv"> '+newdata[i]['name']+'<button title="Delete" style="margin-left : 20px;" class="btn pull-right deleteWhat" id="'+newdata[i]['id']['$id']+'"> <i class="icon-trash"> </i> </button><button title="Rename" data-name="'+newdata[i]['name']+'" style="margin-left : 20px;" class="btn pull-right editWhat" id="'+newdata[i]['id']['$id']+'"> <i class="icon-edit"> </i> </button><a href="#wheresFor'+newdata[i]['name']+'" title="Wheres for '+newdata[i]['name']+'" data-name="'+newdata[i]['name']+'" style="margin-left : 20px;" class="btn pull-right manageWheres" id="'+newdata[i]['id']['$id']+'"> Wheres </a><a href="#whichsFor'+newdata[i]['name']+'" title="Whichs for '+newdata[i]['name']+'" data-name="'+newdata[i]['name']+'" class="btn pull-right manageWhichs" id="'+newdata[i]['id']['$id']+'"> Whichs </a>');
				}
			});
		}
		else
		{
			var splitted =  $('#enabled').val().split("/");
			var whatname = splitted[1];
			
			$('#managehowsLink').attr('class','');
			$('#managehows').attr('class','tab-pane fade');
			$('#managewhatsLink').attr('class','active');
			$('#managewhats').attr('class','tab-pane fade');
			$('#managewhichs').attr('class','tab-pane fade  in active');
			$.post('/admin/getWhichs',{whatname : whatname},function(data){
				var newdata = jQuery.parseJSON(data);
				$('#managewhichscontent').html('');
				if(newdata.length == 0)
				{
					$('#managewhichscontent').append('<center> There are no items to display. </center>');
				}
				for(var i=0;i<newdata.length;i++)
				{
					$('#managewhichscontent').append('<div class="listDiv"> '+newdata[i]['name']+'<button title="Delete" data-name="'+newdata[i]['name']+'" style="margin-left : 20px;" class="btn pull-right deleteWhich" id="'+newdata[i]['id']['$id']+'"> <i class="icon-trash"> </i> </button><button title="Rename" data-name="'+newdata[i]['name']+'" data-name="'+newdata[i]['name']+'" style="margin-left : 20px;" class="btn pull-right editWhich" id="'+newdata[i]['id']['$id']+'"> <i class="icon-edit"> </i> </button>');
				}
			});
		}
	});
	
/* manage interests | change url according to tabs clicked */
	$('#managehowsLink').click(function(){
		window.location.href = "/admin/managecategories/hows";
	});
	$('#managewhatsLink').click(function(){
		window.location.href = "/admin/managecategories/whats";
	});
	
/* display whichs | on click of whichs button in manage whats tab */
	$('#managewhatscontent').on('click' , '.manageWhichs', function(){
		$('#manageWhatsBreadcrumbs').html('<li id="manageWhatsBreadcrumb"><a href="#whats">Whats</a><span class="divider">/</span></li><li id="manageWhichsBreadcrumb" class="active">'+$(this).attr('title')+'<span class="divider">/</span></li>');
		window.location.href = "whats/"+$(this).attr('data-name')+"/whichs";
		$.post('/admin/getWhichs',{whatname : $(this).attr('data-name')},function(data){
			var newdata = jQuery.parseJSON(data);
			console.log(newdata);
		});
		return false;
	});

/* delete how | on click of delete button in manage hows tab */
	$('#managehowscontent').on('click' , '.deleteHow', function(){
		$.post('/admin/deleteHow',{id : $(this).attr('id')},function(data){
			location.reload();
		});
	});

/* delete what | on click of delete button in manage whats tab */
	$('#managewhatscontent').on('click' , '.deleteWhat', function(){
		$.post('/admin/deleteWhat',{id : $(this).attr('id')},function(data){
			location.reload();
		});
	});

/* delete which | on click of delete button in manage whichs tab */
	$('#managewhichscontent').on('click' , '.deleteWhich', function(){
		$.post('/admin/deleteWhich',{id : $(this).attr('id'),name : $(this).attr('data-name')},function(data){
			location.reload();
		});
	});


/* create new how | on click of + button in manage hows tab */
	$('#frmNewHow').submit(function(){
		var name = $('#txtHowName').val();
		if(name == "")
		{
			$('#alertCreatHow').html('<strong> Oops! </strong> Did you forget to enter the name?');
			$('#alertCreateHow').css('display','block');
			$('#alertCreateHow').attr('class','alert alert-danger');
			$('#alertCreateHow').hide().fadeIn(300);
			return false;
		}
		else
		{
			$.post('/admin/createHow',{name : name}, function(data){
				if(data == '1')
				{
					location.reload();
				}
				else
				{
					$('#alertCreatHow').html('<strong> Oops! </strong> Something went wrong while creating How. Please try again later.');
					$('#alertCreateHow').css('display','block');
					$('#alertCreateHow').attr('class','alert alert-danger');
					$('#alertCreateHow').hide().fadeIn(300);
	
				}
			});
		}
	});
	
	$('#createHowSubmit').click(function(){
		var name = $('#txtHowName').val();
		if(name == "")
		{
			$('#alertCreatHow').html('<strong> Oops! </strong> Did you forget to enter the name?');
			$('#alertCreateHow').attr('class','alert alert-danger');
			$('#alertCreateHow').css('display','block');
			$('#alertCreateHow').hide().fadeIn(300);
			return false;
		}
		else
		{
			$.post('/admin/createHow',{name : name}, function(data){
				if(data == '1')
				{
					location.reload();
				}
				else
				{
					$('#alertCreatHow').html('<strong> Oops! </strong> Something went wrong while creating How. Please try again later.');
					$('#alertCreateHow').attr('style','display : block');
					$('#alertCreateHow').attr('class','alert alert-danger');
					$('#alertCreateHow').hide().fadeIn(500);
	
				}
			});
		}
		return false;
	});
	
	
	/* create new what | on click of + button in manage whats tab */
	$('#frmNewWhat').submit(function(){
		var name = $('#txtWhatName').val();
		if(name == "")
		{
			$('#alertCreatWhat').html('<strong> Oops! </strong> Did you forget to enter the name?');
			$('#alertCreateWhat').css('display','block');
			$('#alertCreateWhat').attr('class','alert alert-danger');
			$('#alertCreateWhat').hide().fadeIn(300);
			return false;
		}
		else
		{
			$.post('/admin/createWhat',{name : name}, function(data){
				if(data == '1')
				{
					location.reload();
				}
				else
				{
					$('#alertCreatWhat').html('<strong> Oops! </strong> Something went wrong while creating What. Please try again later.');
					$('#alertCreateWhat').css('display','block');
					$('#alertCreateWhat').attr('class','alert alert-danger');
					$('#alertCreateWhat').hide().fadeIn(300);
	
				}
			});
		}
	});
	
	$('#createWhatSubmit').click(function(){
		var name = $('#txtWhatName').val();
		if(name == "")
		{
			$('#alertCreatWhat').html('<strong> Oops! </strong> Did you forget to enter the name?');
			$('#alertCreateWhat').attr('class','alert alert-danger');
			$('#alertCreateWhat').css('display','block');
			$('#alertCreateWhat').hide().fadeIn(300);
			return false;
		}
		else
		{
			$.post('/admin/createWhat',{name : name}, function(data){
				if(data == '1')
				{
					location.reload();
				}
				else
				{
					$('#alertCreatWhat').html('<strong> Oops! </strong> Something went wrong while creating What. Please try again later.');
					$('#alertCreateWhat').attr('style','display : block');
					$('#alertCreateWhat').attr('class','alert alert-danger');
					$('#alertCreateWhat').hide().fadeIn(500);
	
				}
			});
		}
		return false;
	});
	
/* on click of edit how button in manage interests page */	
	$('#managehowscontent').on('click', '.editHow', function(){
		$('#txtEditHowName').val($(this).attr('data-name'));
		$('#editId').val($(this).attr('id'));
		$('#editHowModal').modal('show');
	
	});
	
/* on click of edit what button in manage interests page */	
	$('#managewhatscontent').on('click', '.editWhat', function(){
		$('#txtEditWhatName').val($(this).attr('data-name'));
		$('#editId').val($(this).attr('id'));
		$('#editWhatModal').modal('show');
	
	});
	
	/* on submit of edit how form */
	$('#frmEditHow').submit(function(){
		var name = $('#txtEditHowName').val();
		if(name == "")
		{
			$('#alertEditHow').html('<strong> Oops! </strong> Did you forget to enter the name?');
			$('#alertEditHow').css('display','block');
			$('#alertEditHow').attr('class','alert alert-danger');
			$('#alertEditHow').hide().fadeIn(300);
			return false;
		}
		else
		{
			$.post('/admin/editHow',{name : name,id: $('#editId').val()}, function(data){
				if(data == '1')
				{
					location.reload();
				}
				else
				{
					$('#alertEditHow').html('<strong> Oops! </strong> Something went wrong while Editing How. Please try again later.');
					$('#alertEditHow').css('display','block');
					$('#alertEditHow').attr('class','alert alert-danger');
					$('#alertEditHow').hide().fadeIn(300);
	
				}
			});
		}
	});
	
	$('#editHowSubmit').click(function(){
		var name = $('#txtEditHowName').val();
		if(name == "")
		{
			$('#alertEditHow').html('<strong> Oops! </strong> Did you forget to enter the name?');
			$('#alertEditHow').attr('class','alert alert-danger');
			$('#alertEditHow').css('display','block');
			$('#alertEditHow').hide().fadeIn(300);
			return false;
		}
		else
		{
			$.post('/admin/editHow',{name : name,id: $('#editId').val()}, function(data){
				if(data == '1')
				{
					location.reload();
				}
				else
				{
					$('#alertEditHow').html('<strong> Oops! </strong> Something went wrong while editing How. Please try again later.');
					$('#alertEditHow').attr('style','display : block');
					$('#alertEditHow').attr('class','alert alert-danger');
					$('#alertEditHow').hide().fadeIn(500);
	
				}
			});
		}
		return false;
	});
	
/* on submit of edit what form */
	$('#frmEditWhat').submit(function(){
		var name = $('#txtEditWhatName').val();
		if(name == "")
		{
			$('#alertEditWhat').html('<strong> Oops! </strong> Did you forget to enter the name?');
			$('#alertEditWhat').css('display','block');
			$('#alertEditWhat').attr('class','alert alert-danger');
			$('#alertEditWhat').hide().fadeIn(300);
			return false;
		}
		else
		{
			$.post('/admin/editWhat',{name : name,id: $('#editId').val()}, function(data){
				if(data == '1')
				{
					location.reload();
				}
				else
				{
					$('#alertEditWhat').html('<strong> Oops! </strong> Something went wrong while Editing What. Please try again later.');
					$('#alertEditWhat').css('display','block');
					$('#alertEditWhat').attr('class','alert alert-danger');
					$('#alertEditWhat').hide().fadeIn(300);
	
				}
			});
		}
	});
	
	$('#editWhatSubmit').click(function(){
		var name = $('#txtEditWhatName').val();
		if(name == "")
		{
			$('#alertEditWhat').html('<strong> Oops! </strong> Did you forget to enter the name?');
			$('#alertEditWhat').attr('class','alert alert-danger');
			$('#alertEditWhat').css('display','block');
			$('#alertEditWhat').hide().fadeIn(300);
			return false;
		}
		else
		{
			$.post('/admin/editWhat',{name : name,id: $('#editId').val()}, function(data){
				if(data == '1')
				{
					location.reload();
				}
				else
				{
					$('#alertEditWhat').html('<strong> Oops! </strong> Something went wrong while editing What. Please try again later.');
					$('#alertEditWhat').attr('style','display : block');
					$('#alertEditWhat').attr('class','alert alert-danger');
					$('#alertEditWhat').hide().fadeIn(500);
	
				}
			});
		}
		return false;
	});
	
	/* create new which | on click of + button in manage whichs tab */
	$('#frmNewWhich').submit(function(){
		var name = $('#txtWhichName').val();
		if(name == "")
		{
			$('#alertCreateWhich').html('<strong> Oops! </strong> Did you forget to enter the name?');
			$('#alertCreateWhich').css('display','block');
			$('#alertCreateWhich').attr('class','alert alert-danger');
			$('#alertCreateWhich').hide().fadeIn(300);
			return false;
		}
		else
		{
			var splitted =  $('#enabled').val().split("/");
			var whatname = splitted[1];
			$.post('/admin/createWhich',{name : name,whatname : whatname}, function(data){
				if(data == '1')
				{
					location.reload();
				}
				else
				{
					$('#alertCreateWhich').html('<strong> Oops! </strong> Something went wrong while creating Which. Please try again later.');
					$('#alertCreateWhich').css('display','block');
					$('#alertCreateWhich').attr('class','alert alert-danger');
					$('#alertCreateWhich').hide().fadeIn(300);
	
				}
			});
		}
	});
	
	$('#createWhichSubmit').click(function(){
		var name = $('#txtWhichName').val();
		if(name == "")
		{
			$('#alertCreateWhich').html('<strong> Oops! </strong> Did you forget to enter the name?');
			$('#alertCreateWhich').attr('class','alert alert-danger');
			$('#alertCreateWhich').css('display','block');
			$('#alertCreateWhich').hide().fadeIn(300);
			return false;
		}
		else
		{
			var splitted =  $('#enabled').val().split("/");
			var whatname = splitted[1];
			$.post('/admin/createWhich',{name : name,whatname : whatname}, function(data){
				if(data == '1')
				{
					location.reload();
				}
				else
				{
					$('#alertCreateWhich').html('<strong> Oops! </strong> Something went wrong while creating Which. Please try again later.');
					$('#alertCreateWhich').attr('style','display : block');
					$('#alertCreateWhich').attr('class','alert alert-danger');
					$('#alertCreateWhich').hide().fadeIn(500);
	
				}
			});
		}
		return false;
	});

});


