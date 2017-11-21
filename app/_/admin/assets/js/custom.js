$(document).ready(function(){
  $(".submenu > a").click(function(e) {
    e.preventDefault();
    var $li = $(this).parent("li");
    var $ul = $(this).next("ul");

    if($li.hasClass("open")) {
      $ul.slideUp(350);
      $li.removeClass("open");
    } else {
      $(".nav > li > ul").slideUp(350);
      $(".nav > li").removeClass("open");
      $ul.slideDown(350);
      $li.addClass("open");
    }
  });
});

 /* Text area word count */
var max_count = 50;
$(document).ready(function () {
   
     $("#appointment_descp").on('keyup', function() {
		 var text = this.value;
		 var words=text ? text.match(/\S+/g).length : "0";
        if (words > max_count) {
            // Split the string on first 200 words and rejoin on spaces
            var trimmed = $(this).val().split(/\s+/, max_count).join(" ");
            // Add a space at the end to keep new typing making new words
            $(this).val(trimmed + " ");
        }
        else {
			wordsLeft = max_count-words;
			$('.words-left').html(wordsLeft + ' words left');
			if(wordsLeft == 0) {
			$('.words-left').css({
				'background':'red',
				'color':'#fff'
			}).prepend('<i class="glyphicon glyphicon-warning-sign"></i>');
		  }
            
        }
    });
});  
	
jQuery(function($){
	var response;
	$.validator.addMethod("checkEmail", function(value, element) {
	  // allow any non-whitespace characters as the host part
	  $.ajax({
					url: "ajax/checkemail.php",
					type: 'POST',
					data: {email:value},
					dataType: 'json',
					success: function (data) {
						if(data.code==0)
						{
							response=false;
						}	
						else
						{
							response=true;
						}
					}
				});
	return response;
	}, 'Email Already Exists');


	/*Validation for Add Profile */
    $("#add_profile").validate({
	
        rules: {
             name:{
				required: true
				},
			email:{
				required: true,
				email:true,
				checkEmail:true
				},
			password:{
				required: true
				},
			gender:{
				required: true
				},
			phone_number:{
				required: true
				}
		  }

		});
		
	/*Validation for Edit Profile */	
   $("#edit_profile").validate({
	
        rules: {
             name:{
				required: true
				},
			email:{
				required: true,
				email:true
				},
			gender:{
				required: true
				},
			phone_number:{
				required: true
				}
		  }
		});
		
$.validator.addMethod('ccDate', function (value,element) {
	   var exp_month=$('#expire_visa_month').val();
	   var exp_year=$('#expire_visa_year').val();
       var d = new Date(),
		curr_month = d.getMonth(),
		curr_year = d.getFullYear();
		
		if (new Date(exp_year, exp_month) > new Date(curr_year, curr_month)){
		 return true;
		}
		
    }, function() {
                    var $msg = 'Visa is expired';  
                    return $msg;
        });
	
	/*Validation for add Invoice */	
   $("#add_invoice").validate({
	
        rules: {
            title:{
				required: true
			},
			description:{
				required: true
			},
			amount:{
				required: true
			},
			card_id:{
				required: true,
				ccDate: true
			}
		 },
		 submitHandler: function(form) {
			 var amount=$('#amount').val();
			 if (confirm('Do you want to deduct $'+amount+'?')) {
			   form.submit();
		   } else {
			   return false;
		   }
				
		 }
		});
		
	/*Validation for edit Invoice */	
   $("#edit_invoice").validate({
	
        rules: {
            title:{
				required: true
			},
			description:{
				required: true
			},
			amount:{
				required: true
			}
		  }
		});
	
	 /* Validation for add Appointment*/	
	 
	$("#add_appointment").validate({
	
        rules: {
            appointment_with:{
				required: true
			},
			appointment_descp:{
				required: true
			},
			time_from:{
				required: true
			}
		  }
		});
	
     /* Validation for edit Appointment  */	
	 
	$("#edit_appointment").validate({
	
        rules: {
            appointment_with:{
				required: true
			},
			appointment_descp:{
				required: true
			},
			time_from:{
				required: true
			}
		  }
		});
		
	 /* Validation for discover  */	
	 
	$("#form_discover").validate({
	
        rules: {
            discover:{
				required: true
			}
		  }
		});
	

    /*Validation for credit pay*/	
	
	$("#credit_pay").validate({
	
        rules: {
             credit_amount:{
				required: true,
				number: true
				},
			credit_title:{
				required: true
				},
			credit_description:{
				required: true
				},
			invoice_title:{
				required: true
			},
			invoice_description:{
				required: true
			},
			invoice_amount:{
				required: true,
				number: true
			},
			card_id:{
				required: true
			}
		 },
		 submitHandler: function(form) {
			  var amount=$('#credit_amount').val();
			  var invoice_amount=$('#invoice_amount').val();
			  if($('#invoice_amount').length==0){
				  invoice_amount='';
			  }
			  var msg='';
			  if(invoice_amount!='' || invoice_amount!=0){
				  msg='Do you want to deduct '+amount+' credits and $'+invoice_amount+' Amount?';
			  } else {
				  msg='Do you want to deduct '+amount+' credits?';
			  }
			  if (confirm(msg)) {
			   form.submit();
		   } else {
			   return false;
		   }
				
		 }
		});	
		
		
		 /*Validation for Edit credit pay*/	
	
	$("#edit_credit_pay").validate({
	
        rules: {
             credit_amount:{
				required: true,
				number: true
				},
			credit_title:{
				required: true
				},
			credit_description:{
				required: true
				},
			invoice_title:{
				required: true
			},
			invoice_description:{
				required: true
			},
			invoice_amount:{
				required: true,
				number: true
			},
		 },
		 submitHandler: function(form) {
			  var amount=$('#credit_more_amount').val();
			  var invoice_amount=$('#invoice_more_amount').val();
			  var msg='';
			  if(invoice_amount!=0 && amount!=0 ){
				  msg+='Do you want to deduct more '+amount+' credits and $'+invoice_amount+'.00 Amount?';
			  } 
			  if(invoice_amount==0 && amount==0){
				   msg+='Do you want to update Credits and Invoice details?';
			  } 
			  if(invoice_amount==0 && amount!=0){
				   msg+='Do you want to deduct more '+amount+' credits and update invoice details?';
			  }
			  if(invoice_amount!=0 && amount==0){
				   msg+='Do you want update credits details and deduct $'+invoice_amount+'.00 more Amount?';
			  }
			  
			  if (confirm(msg)) {
			   form.submit();
		   } else {
			   return false;
		   }
				
		 }
		});
		
	/* Validation for Change Password */
   $("#change_password").validate({
	
        rules: {
             password:{
				required: true
				},
			confirm_password:{
				equalTo: "#password"
				}
		 }
		});	
		
	$("#add_coupon").validate({
		rules:{
			coupon_code:{
				required:true
			},
			discount_amount:{
				required:true,
				number:true,
				range:[1,100]
			}
		}
	});	
		
});