
var global_username = '';
var global_recipient = '';
//global_recipient = 'neha';
sinchClient = new SinchClient({
	applicationKey: '862f5439-9994-4cc4-8ac4-83a4752a97f1',
	capabilities: {messaging: true},
});

var clearError = function() {
	$('div.error').text("");
}

var showPickRecipient = function() {
    $('div#auth').css('display', 'none');
    $('#pickRecipient').show();
}

var showChat = function() {
    $('form#pickRecipient').css('display', 'none');
    $('div#chat').show();
	$('span#username').text(global_username);
    $('span#recipient').text(global_recipient);
}

var handleError = function(error) {
	$('button#createUser').attr('disabled', false);
	$('button#loginUser').attr('disabled', false);
	$('div.error').text(error.message);
}


$('button#createUser').on('click', function(event) {

    $('button#createUser').attr('disabled', true);
    $('button#loginUser').attr('disabled', true);
	clearError();
    
	var username = $('input#username').val('admin');
	var password = $('input#password').val('admin123');
    
    var loginObject = {username: username, password: password};
	sinchClient.newUser(loginObject, function(ticket) {
		sinchClient.start(ticket, function() {
			global_username = username;
			showPickRecipient();
		}).then(handleSuccess).fail(handleError);
	}).fail(handleError);
	
	function handleSuccess(){
	var username = $('input#username').val();
	var password = $('input#password').val();
		sinchClient.start({username: username, password: password})
    then(function() {
        localStorage['sinchSession-' + sinchClient.applicationKey] = JSON.stringify(sinchClient.getSession());
    });
	}
});

$(document).ready(function(){
	$("a#chatUser").trigger( "click" );
});

$('a#chatUser').on('click', function(event) {
	
	event.preventDefault();
	//alert('hello');
    //$('button#createUser').attr('disabled', true);
   // $('button#loginUser').attr('disabled', true);
	clearError();
	
	//var username = 'admin';
	//var password = 'admin123';
	
   // var loginObject = {username: username, password: password};
	/*sinchClient.start(loginObject, function() {
		global_username = username;
		showPickRecipient();
	}).fail(handleError);*/
	$.get('ticket.php', function(authTicket) {
		/*sinchClient.start(eval("(" + authTicket + ")"))
				//global_username = username;
				//showPickRecipient();
			.then(function() {
            console.log("success");
        })
        .fail(function(error) {
            console.log("fail");
        });*/
		

sinchClient.start({username: 'admin', password: 'admin123'})
    .then(function() {
        //Do things on success, like show UI, etc
    })
    .fail(function() {
        //Handle error, such as incorrect username/password
    });


		
    });
	/*sinchClient.start(ticket, function() {
			global_username = username;
			showPickRecipient();
		}).then(handleSuccess).fail(handleError);
	}).fail(handleError);*/
	
});

/*$('button#pickRecipient').on('click', function(event) {
    event.preventDefault();
    clearError();
    
    showChat();
}); */


var messageClient = sinchClient.getMessageClient();

/*$('1sendMsg').on('keyup', function(ev){
	event.preventDefault();
	clearError();
	 if(ev.keyCode === 13) {
alert('hit');
	var text = $('input#message').val();
    $('input#message').val('');
	//alert(global_username);
	//alert(global_recipient);
	var sinchMessage = messageClient.newMessage(global_recipient, text);
	
	messageClient.send(sinchMessage).fail(handleError);
	 }
});*/

var eventListener = {
	onIncomingMessage: function(message) {
		console.log(message.delivered);
		$.ajax({
			url:'sinch/msgdata.php',
			type:'POST',
			data:{message:message.textBody,senderId:message.senderId,recipientIds:global_recipient,time:message.timestamp},
			success:function(data){
				if(data.code==0){
					//alert(data.msg); 
					//alert(JSON.stringify(message));
				}
				
			}
			
		});		
		
		
        if (message.senderId == global_username) {
            $('#chatArea_'+global_recipient).append('<div>' + message.senderId + " : " + message.textBody + '</div>');
				
        } else {
            $('#chatArea_'+global_recipient).append('<div style="color:red;">' +message.senderId + " : " + message.textBody + '</div>');
        }		
	}
}

messageClient.addEventListener(eventListener);
 
 //this function can remove a array element.
            Array.remove = function(array, from, to) {
                var rest = array.slice((to || from) + 1 || array.length);
                array.length = from < 0 ? array.length + from : from;
                return array.push.apply(array, rest);
            };
       
            //this variable represents the total number of popups can be displayed according to the viewport width
            var total_popups = 0;
           
            //arrays of popups ids
            var popups = [];
       
            //this is used to close a popup
            function close_popup(id)
            {
				global_recipient = id;
                for(var iii = 0; iii < popups.length; iii++)
                {
                    if(id == popups[iii])
                    {
                        Array.remove(popups, iii);
                       
                        document.getElementById(id).style.display = "none";
                       
                        calculate_popups();
                       
                        return;
                    }
                }  
            }
       
            //displays the popups. Displays based on the maximum number of popups that can be displayed on the current viewport width
            function display_popups()
            {
                var right = 220;
               
                var iii = 0;
                for(iii; iii < total_popups; iii++)
                {
                    if(popups[iii] != undefined)
                    {
                        var element = document.getElementById(popups[iii]);
                        element.style.right = right + "px";
                        right = right + 320;
                        element.style.display = "block";
                    }
                }
               
                for(var jjj = iii; jjj < popups.length; jjj++)
                {
                    var element = document.getElementById(popups[jjj]);
                    element.style.display = "none";
                }
            }
           
		    function message(id,e) {
				var code = (e.keyCode ? e.keyCode : e.which);
				if (code == 13) { //Enter keycode
					alert("Sending your Message : " + document.getElementById('msg').value);
					alert(id);
				}
			}
			
            //creates markup for a new popup. Adds the id to popups array.
            function register_popup(id, name)
            {
               
                for(var iii = 0; iii < popups.length; iii++)
                {  
                    //already registered. Bring it to front.
                    if(id == popups[iii])
                    {
                        Array.remove(popups, iii);
                   
                        popups.unshift(id);
                       
                        calculate_popups();
                       
                       
                        return;
                    }
                }              
               
			   var element = '<div class="popup-box chat-popup" id="'+ id +'">';
                element = element + '<div class="popup-head">';
                element = element + '<div class="popup-head-left">'+ name +'</div>';
                element = element + '<div class="popup-head-right"><a href="javascript:close_popup(\''+ id +'\');">&#10005;</a></div>';
                element = element + '<div style="clear: both"></div></div><div class="popup-messages"></div>';
				element = element + '<div class="popup-textarea"><textarea id="msg" cols="51" rows="3" onkeypress="message(\''+ id +'\',event, this)" style=""></textarea></div>';
				element = element + '</div>';
				
               
                
                document.getElementsByTagName("body")[0].innerHTML = document.getElementsByTagName("body")[0].innerHTML + element; 
       
                popups.unshift(id);
                       
                calculate_popups();
               
            }
    
            //calculate the total number of popups suitable and then populate the toatal_popups variable.
            function calculate_popups()
            {
                var width = window.innerWidth;
                if(width < 540)
                {
                    total_popups = 0;
                }
                else
                {
                    width = width - 200;
                    //320 is width of a single popup box
                    total_popups = parseInt(width/320);
                }
               
                display_popups();
               
            }
			
           
            //recalculate when window is loaded and also when window is resized.
            window.addEventListener("resize", calculate_popups);
            window.addEventListener("load", calculate_popups);