$(document).ready(function(){
  
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

	/*Validation for add article */	
   $("#add_article").validate({
	
        rules: {
            type:{
				required: true
			},
			title:{
				required: true
			}
		 }
		});
	
	/*Validation for edit article */	
   $("#edit_article").validate({
	
        rules: {
            type:{
				required: true
			},
			title:{
				required: true
			}
		  }
		});	
		
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
				}
		  }

		});
		
	/*Validation for Edit Profile */	
   $("#edit_profile").validate({
	
        rules: {
             name:{
				required: true
				}
		  }
		});
		
});