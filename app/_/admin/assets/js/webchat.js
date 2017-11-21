var global_username = '';
var global_recipient = '';
var globle_recipient_id= '';
var chat_name= '';
var fix_id= '';
var user_chat_image='';



var showUI = function() {
	$('div#chat').show();
	$('div#auth').hide();
	$('div#userInfo').css('display', 'block');
	$('span#username').text(global_username);
	var height = 0;
	$('#chatArea_'+fix_id+' .row').each(function(i, value){
	height += parseInt($(this).height());
	});
	height += '';
	$('#chatArea_'+fix_id).animate({scrollTop: height});

}


/*** Handle errors, report them and re-enable UI ***/

var handleError = function(error) {

	//Show error
	if(error.message=="PubNub: Error sending frame")
	{
		error_message='<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert">X</a><strong>Connectivity issue!</strong> Please try again</div>';
		$('div.error').html(error_message);
		$('div.error').show();
		setTimeout(function(){
			$('div.error').hide();
		}, 3000);
		
	}	
	else
	{
	  $('div.error').text(error.message);
	  $('div.error').show();
	   setTimeout(function(){
			$('div.error').hide();
		}, 3000);
	}	
	
}


/** Always clear errors **/
var clearError = function() {
	$('div.error').hide();
}

/*** If no valid session could be started, show the login interface ***/

var showLoginUI = function() {
	$('form#userForm').css('display', 'inline');
	$('input#username').focus();
}

//*** Set up sinchClient ***/
sinchClient = new SinchClient({
	applicationKey: '862f5439-9994-4cc4-8ac4-83a4752a97f1',
	capabilities: {messaging: true},
	startActiveConnection: true,
	//Note: For additional loging, please uncomment the three rows below
	onLogMessage: function(message) {
		console.log(message);
	}
});

/*** Create user and start sinch for that user and save session in localStorage ***/


function registerUser(data){
	
	clearError();

	var signUpObj = {};
	signUpObj.username = data.username;;
	signUpObj.password = data.password;

	//Use Sinch SDK to create a new user
	sinchClient.newUser(signUpObj, function(ticket) {
		//On success, start the client
		sinchClient.start(ticket, function() {
			global_username = signUpObj.username;
			//On success, show the UI
			showUI();

			//Store session & manage in some way (optional)
			localStorage[sessionName] = JSON.stringify(sinchClient.getSession());
		}).fail(handleError);
	}).fail(handleError);
}

/*** Login user and save session in localStorage ***/
function loginUser(){

	clearError();
    $.post("ajax/adminInfo.php", function(data) {
	 if(data.code ==1){	
        
		var signInObj = {};
		signInObj.username = data.username;
		signInObj.password = data.password;
		
	   //Use Sinch SDK to authenticate a user
		sinchClient.start(signInObj, function() {
			global_username = signInObj.username;
			//On success, show the UI
			showUI();

			//Store session & manage in some way (optional)
			localStorage[sessionName] = JSON.stringify(sinchClient.getSession());
		}).fail(function(errorInfo) {
			registerUser(signInObj.username,signInObj.password);
		});
	  }
	  
	
	});
}


/*** Name of session, can be anything. ***/

var sessionName = 'sinchSession-' + sinchClient.applicationKey;

/*** Check for valid session. NOTE: Deactivated by default to allow multiple browser-tabs with different users. Remove "false &&" to activate session loading! ***/

var sessionObj = JSON.parse(localStorage[sessionName] || '{}');
if(false && sessionObj.userId) { //Remove "false &&"" to actually check start from a previous session!
	sinchClient.start(sessionObj)
		.then(function() {
			global_username = sessionObj.userId;
			//On success, show the UI
			showUI();
			//Store session & manage in some way (optional)
			localStorage[sessionName] = JSON.stringify(sinchClient.getSession());
		})
		.fail(function() {
			//No valid session, take suitable action, such as prompting for username/password, then start sinchClient again with login object
			loginUser();
		});
}
else {
	loginUser();
}

/*** Send a new message ***/

var messageClient = sinchClient.getMessageClient();

var eventListener = {
	onIncomingMessage: function(message) {
		console.log(message.delivered);
		if(message.textBody.indexOf('.jpg') !='-1' || message.textBody.indexOf('.png') !='-1' || message.textBody.indexOf('.jpeg') !='-1' || message.textBody.indexOf('.gif') !='-1'){
			msg_type="1";
		} else {
			msg_type="0";
		}
		//alert(msg_type);
		$.ajax({
			url:'ajax/chatMsg.php',
			type:'POST',
			data:{message:message.textBody,msg_type:msg_type,senderId:message.senderId,time:message.timestamp,data_type:'new',msg_id:message.messageId,array_ids:message.recipientIds},
			success:function(data){
				if(data.code==0){
					if(data.send=='admin'){
						globle_recipient_id=data.resceiver;
						chat_name='admin';
					} else {
						globle_recipient_id=data.send;
						chat_name=data.firstname;
					}
					var baseUrl = '/assets/audio/';
					var audio = ["facebook.mp3"];
					new Audio(baseUrl + audio[0]).play();          //play corresponding audio
					

				}
				var chat_chat='';
				if (message.senderId == global_username) { 
					            chat_chat+='<div class="row">';
								chat_chat+='<div class="col-sm-1 col-xs-2 user-img">';
								chat_chat+='<img src="http://thelittlethingsadmin.com/images/admin.jpg" alt="user-img" />';
								chat_chat+='</div>';
								chat_chat+='<div class="col-sm-10 col-xs-10">';
								chat_chat+='<div class="Chater-name">';
								chat_chat+='<h4>' +chat_name+'</h4>';
								chat_chat+='</div>';
								chat_chat+='<div class="chating">';
								if(msg_type!='1'){
								chat_chat+='<p>'+message.textBody+'</p>';
								} else {
								chat_chat+='<a href="'+message.textBody+'" target="_blank"><img src="'+message.textBody+'" height="100px" /></a>';
								}
								chat_chat+='</div>';
								chat_chat+='</div>';
							    chat_chat+='</div>';
								
						$('#chatArea_'+globle_recipient_id).append(chat_chat);
						//$('#chatArea_'+globle_recipient_id).scrollTop();
						var height = 0;
						$('#chatArea_'+globle_recipient_id+' .row').each(function(i, value){
							height += parseInt($(this).height());
						});

						height += '';

						$('#chatArea_'+globle_recipient_id).animate({scrollTop: height});
							
					} else {
						        chat_chat+='<div class="row">';
								chat_chat+='<div class="col-sm-1 col-xs-2 user-img">';
								if(user_chat_image!=''){
								chat_chat+='<img src="'+user_chat_image+'" alt="user-img" />';
								} else {
								chat_chat+='<img src="http://thelittlethingsadmin.com/images/default_user.png" alt="user-img" />';
								}
								chat_chat+='</div>';
								chat_chat+='<div class="col-sm-10 col-xs-10">';
								chat_chat+='<div class="Chater-name">';
								chat_chat+='<h4>' +chat_name+'</h4>';
								chat_chat+='</div>';
								chat_chat+='<div class="chating">';
								if(msg_type!='1'){
								chat_chat+='<p>'+message.textBody+'</p>';
								} else {
								chat_chat+='<a href="'+message.textBody+'" target="_blank"><img src="'+message.textBody+'" height="100px" /></a>';
								}
								chat_chat+='</div>';
								chat_chat+='</div>';
							    chat_chat+='</div>';
								
						$('#chatArea_'+globle_recipient_id).append(chat_chat);
						// moving position to latest msg
						var height = 0; 
						$('#chatArea_'+globle_recipient_id+' .row').each(function(i, value){
							height += parseInt($(this).height());
						});
						height += '';
						$('#chatArea_'+globle_recipient_id).animate({scrollTop: height});
					}
					get_chat_users('last','',''); // get latest msg chat user first
				$('.chat_btn').attr("disabled","disabled");
				
		}
			//get_total_message(id);
		});		
		
        		
	}
}

messageClient.addEventListener(eventListener);

/*** Handle delivery receipts ***/ 

var eventListenerDelivery = {
	onMessageDelivered: function(messageDeliveryInfo) {
		$.ajax({
			url:'ajax/chatUpdate.php',
			type:'POST',
			data:{data_type:'update',msg_id:messageDeliveryInfo.messageId},
			success:function(data){
				if(data.code==1){
				}
				
			}
			
		});	
	}
}

messageClient.addEventListener(eventListenerDelivery);

           
		    function message(id,e) {
				var code = (e.keyCode ? e.keyCode : e.which);
				var text = $('#msg_'+id).val();
				if(text != ""){
					$('.chat_btn').removeAttr("disabled");
				}
				else
				{
					$('.chat_btn').attr("disabled","disabled");
				}	
				if (code == 13) { //Enter keycode
					var text = $('#msg_'+id).val();
					if(text != ""){
						$('#msg_'+id).val('');
						globle_recipient_id=id;
						var get_current_recipient=$('#re_'+id).val();
						global_recipient=get_current_recipient;  
						var sinchMessage = messageClient.newMessage(global_recipient, text);
						messageClient.send(sinchMessage).fail(handleError);
						
					}	
				}
				
			}
			// Sending msg on click of send button
			function sendbutton(id,e) {
				e.preventDefault();
					var text = $('#msg_'+id).val();
					if(text != ""){
						$('#msg_'+id).val('');
						globle_recipient_id=id;
						var get_current_recipient=$('#re_'+id).val();
						global_recipient=get_current_recipient;  
						var sinchMessage = messageClient.newMessage(global_recipient, text);
						messageClient.send(sinchMessage).fail(handleError);
						
				    }
			}
			
			
            //creates markup for a new popup.
            function register_popup(id, name)
            {
				//alert(id+" "+name);
                user_chat_image=$('#img_'+id).val();
			    chat_name=name;
				 var chat_chat='';
				// Getting old chat
					$.ajax({
					url:'ajax/getChat.php',
					type:'POST',
					data:{user_id:id,type:'singleRecord'},
					success:function(data){
						if(data.code==1){
							
							var count=Object.keys(data.chat_msg).length;
                          if(count!='0'){
							$.each(data.chat_msg, function(i, val){
								if(val.senderid!='admin'){
									chat_chat+='<div class="row">';
									chat_chat+='<div class="col-sm-1 col-xs-2 user-img">';
										if(user_chat_image!=''){
										chat_chat+='<img src="'+user_chat_image+'" alt="user-img" />';
										} else {
											chat_chat+='<img src="http://thelittlethingsadmin.com/images/default_user.png" alt="user-img" />';
										}
											chat_chat+='</div>';
											chat_chat+='<div class="col-sm-10 col-xs-10">';
											chat_chat+='<div class="Chater-name">';
											chat_chat+='<h4>' +chat_name+'</h4>';
											chat_chat+='</div>';
											chat_chat+='<div class="chating">';
											//alert(val.messageImage);
											if(val.messageImage=='0'){
											chat_chat+='<p>'+val.textMessage+'</p>';
											}
											else{
											chat_chat+='<p><a href="'+val.textMessage+'" target="_blank"><img src="'+val.textMessage+'" height="100px" /></a></p>';
											}
											chat_chat+='</div>';
											chat_chat+='</div>';
											chat_chat+='</div>';	
									
								} else {
									
											chat_chat+='<div class="row">';
											chat_chat+='<div class="col-sm-1 col-xs-2 user-img">';
											chat_chat+='<img src="http://thelittlethingsadmin.com/images/admin.jpg" alt="user-img" />';
											chat_chat+='</div>';
											chat_chat+='<div class="col-sm-10 col-xs-10">';
											chat_chat+='<div class="Chater-name">';
											chat_chat+='<h4>'+val.senderid+'</h4>';
											chat_chat+='</div>';
											chat_chat+='<div class="chating">';
											//alert(val.messageImage);
											if(val.messageImage=='0'){
											chat_chat+='<p>'+val.textMessage+'</p>';
											}
											else{
											chat_chat+='<p><a href="'+val.textMessage+'" target="_blank"><img src="'+val.textMessage+'" height="100px" /></a></p>';
											}
											chat_chat+='</div>';
											chat_chat+='</div>';
											chat_chat+='</div>';
								}
							});
						  }
					$('#userInfo').empty();
					var element='';
					element = '<div class="chat-main-box">';
			        element = element + '<div class="for-bg">';
				    element = element + '<div class="col-sm-4 col-xs-12">';
					element = element + '<h3>'+name+'</h3>';
				    element = element + '</div>';
				    element = element + '<div class="col-sm-8 col-xs-12">';
					element = element + '<div class="user_part">';
					element = element + '<div class="icons">';
					element = element + '<div class="icons1">';
					element = element + '<a title="Edit Profile" href="editClient.php?uid='+ id +'" target="_blank"><i class="glyphicon glyphicon-pencil"></i></a>';
					element = element + '</div>';
					element = element + '<div class="icons1">';
					element = element + '<a title="View Profile" href="viewclientDetails.php?uid='+ id +'" target="_blank"><i class="glyphicon glyphicon-eye-open"></i></a>';
					element = element + '</div>';
					element = element + '<div class="icons1">';
					element = element + '<a title="Events List" href="events.php?uid='+ id +'" target="_blank"><i class="glyphicon glyphicon-flag"></i></a>';
					element = element + '</div>';
					element = element + '<div class="icons1">';
					element = element + '<a title="Invoices List" href="invoices.php?uid='+ id +'" target="_blank"><i class="glyphicon glyphicon-list-alt"></i></a>';
					element = element + '</div>';
					element = element + '<div class="icons1">';
					element = element + '<a title="Credit Paid" href="creditPay.php?uid='+ id +'" target="_blank"><i class="glyphicon glyphicon-usd "></i></a>';
					element = element + '</div>';
					element = element + '</div>';
					element = element + '</div>';
				    element = element + '</div>';
				    element = element + '</div>';
				    element = element + '<div class="col-sm-12 col-xs-12">';
					element = element + '<div class="row">';
					element = element + '<div class="comment_scrl" id="chatArea_'+id+'">';
                    element = element + chat_chat;
					element = element + '</div>';
					element = element + '</div>';
				    element = element + '</div>';
				    element = element + '<div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">';
					element = element + '<div class="row">';
					element = element + '<div class="comment_box"><div class="error"></div>';
					element = element + '<div class="comment_type_main">';
					element = element + '<input type="text" id="msg_'+id+'" class="input-text" onkeypress="message(\''+ id +'\',event, this)"></input>';
					element = element + '<div class="msg-composer-action">';
					element = element + '<div class="icons1">';
					element = element + '<form id="fileupload_'+ id +'" enctype="multipart/form-data"><input id="file_'+id+'" type="file" name="file" class="send-btn file_input" onchange="showfile(\''+ id +'\',event, this);"/></form>';
					element = element + '<i class="fa fa-paperclip icn"></i>';
					element = element + '</div>';
					element = element + '</div>';
					element = element + '<div class="send_btn">';
					element = element + '<button class="btn_send chat_btn" type="button" onclick="sendbutton(\''+ id +'\',event, this)" disabled>Send</button>';
					element = element + '</div>';
					element = element + '<div class="selected-file">';
					element = element + '<div class="upload_img" id="selected_file_'+id+'">';
					element = element + '</div>';
					element = element + '</div>';
					element = element + '</div>';
					element = element + '</div>';
					element = element + '</div>';
				    element = element + '</div>';
			        element = element + '</div>';
				
							$('#userInfo').append(element);
							var height = 0;
							$('#chatArea_'+id+' .row').each(function(i, value){
								height += parseInt($(this).height());
							});
							height += '';
							$('#chatArea_'+id).animate({scrollTop: height});


						}
						get_chat_users('last','','');
					}
					
				});
            }

		/* image upload */	
		
		function uploadfile(id){
				var formData = new FormData($('#fileupload_'+id)[0]);
			
				   $.ajax({
					url: "ajax/upload.php", // Url to which the request is send
					type: "POST",             // Type of request to be send, called as method
					data: formData, // Data sent to server, a set of key/value pairs (i.e. form fields and values)
					contentType: false,       // The content type used when sending data to the server.
					cache: false,             // To unable request pages to be cached
					processData:false,        // To send DOMDocument or non processed data file it is set to false
					 xhr: function () {
						 $('#selected_file_'+id).prepend('<div class="form-group"><div class="progress"><div class="progress-bar progress-bar-success myprogress" role="progressbar" style="width:0%">0%</div></div>');
                            var xhr = new window.XMLHttpRequest();
                            xhr.upload.addEventListener("progress", function (evt) {
                                if (evt.lengthComputable) {
                                    var percentComplete = evt.loaded / evt.total;
                                    percentComplete = parseInt(percentComplete * 100);
                                    $('.myprogress').text(percentComplete + '%');
                                    $('.myprogress').css('width', percentComplete + '%');
                                }
                            }, false);
                            return xhr;
                        },
					success: function(data)   // A function to be called if request succeeds
					{
					if(data.code=='0'){
					var text=data.file_path;
					$('#msg_'+id).val('');
									globle_recipient_id=id;
									var get_current_recipient=$('#re_'+id).val();
									global_recipient=get_current_recipient;  
									var sinchMessage = messageClient.newMessage(global_recipient, text);
									
									messageClient.send(sinchMessage).fail(handleError);
					}
					removeDisplay(id);
					}
					});
		}
 // preview the image selected
   function showfile (id,event){

            if (typeof (FileReader) != "undefined") {

            var image_holder = $("#selected_file_"+id);
            image_holder.empty();
            var imgPath = $('#file_'+id)[0].value;
			var extn = imgPath.substring(imgPath.lastIndexOf('.') + 1).toLowerCase();
			 if (extn == "gif" || extn == "png" || extn == "jpg" || extn == "jpeg" || extn == "PNG" || extn == "JPG") {
					var reader = new FileReader();
					reader.onload = function (e) {
						$("<img />", {
							"src": e.target.result,
							"class": "thumb-image",
							"height": "100px",
							'width': "100px"
						}).appendTo(image_holder);

					}
					image_holder.show();
							reader.readAsDataURL($('#file_'+id)[0].files[0]);
							$("#selected_file_"+id).append('<div class="upload_confirm"><a href="javascript:void(0);" class="confirm_a" onclick="uploadfile('+id+');"><i class="fa fa-check">&nbsp;Confirm</i></a> <a href="javascript:void(0);" class="close_a" onclick="removeDisplay('+id+');"><i class="fa fa-close">&nbsp;Cancel</i></a></div>');
        } else {
            alert("Only Images are allowed!");
        }
			} else {
				alert("This browser does not support FileReader.");
				
			}
		
   }
   
   // Remove the image selected.
   function removeDisplay(id){
	   var image_holder = $("#selected_file_"+id);
            image_holder.empty();
   }
 
 function get_total_message(uid)
 {
	 $.post("ajax/chatnotification.php",{ uid:uid} ,function(data) {
		 if(data.code=='1'){
			if(data.total_count != 0)
			{
				$('.chat_msg').html('<span class="total_msg">'+data.total_count+'</span>');
			}	
			else
			{
				$('.chat_msg').html("");
			}	
			if(data.user_msg != 0)
			{
				$('.chat_total_msg').html('<span class="total_msg">'+data.user_msg+'</span>');
			}	
			else
			{
				$('.chat_total_msg').html("");
			}	
			
		 }	 
	 }); 
 }
   // function to get chat user with latest msg user on top
     function get_chat_users(check,uid,name)
            {
				
                var chat_bar=''
			    $.post("ajax/chatBar.php", function(data) {
					if(data.code=='1'){
						//alert(data.users_list.length);
						for(var i=0;i<data.users_list.length;i++){
							var result=data.users_list[i];
							//alert(result['uid']);
								
									chat_bar+='<div class="sidebar-name">';
									chat_bar+='<input type="hidden" id="re_'+result['uid']+'" value="'+result['email']+'">'; 
									chat_bar+='<input type="hidden" id="img_'+result['uid']+'" value="'+result['profile_image']+'">'; 
									chat_bar+='<a href="javascript:register_popup(\''+ result['uid'] +'\', \''+ result['name'] +'\');">';
									if(result['profile_image']!=''){
									chat_bar+='<img width="30" height="30" src="'+result['profile_image']+'" />';
									} else{
										chat_bar+='<img width="30" height="30" src="images/default_user.png" />';
									}
									chat_bar+='<span>'+result['name']+'</span>';
									if(data.msg_count[i]!='0' || data.msg_count[i]!=''){
									chat_bar+='<span class="msg-count">'+data.msg_count[i]+'</span>';
									}
									chat_bar+='</a>';
									chat_bar+='</div>';
									}
									$('#chat').empty();
									$('#chat').append(chat_bar);
									
								if(data.total_count != 0)
								{
									$('.chat_msg').html('<span class="total_msg">'+data.total_count+'</span>');
								}	
								else
								{
									$('.chat_msg').html("");
								}	
					}
								if(check=='first'){
									fix_id=data.users_list[0]['uid'];
									register_popup(fix_id,data.users_list[0]['name']);
								}
								else if(uid!='' && name!='')
								{
									register_popup(uid,name);
								}	
				});
			}
			
	  /* Query string */
		function getParameterByName(name, url) {
			if (!url) url = window.location.href;
			name = name.replace(/[\[\]]/g, "\\$&");
			var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
				results = regex.exec(url);
			if (!results) return null;
			if (!results[2]) return '';
			return decodeURIComponent(results[2].replace(/\+/g, " "));
		}
		
		
		$(document).ready(function(){
			var uid = getParameterByName('uid'); 
			var name = getParameterByName('name'); 
			var currentLocation = window.location.pathname;
			if(currentLocation=="/chat.php"){
				if(uid != null && name!= null)
				{
					get_chat_users('second',uid,name);
				}	
				else
				{
					get_chat_users('first',null,null);// Function calling chat user list
				}
			}
			else
			{
				if(uid != null)
				{
					get_total_message(uid);
				}	
				else
				{
					get_total_message();// Function calling chat user list
				}
				
			}	
		});
		
	