$(document).ready(function () {
	
	/*New Project Validation */
	$("#newproject").validate({
		rules: {
            project_name:{
				required: true
				},
			project_url:{
				required: true,
				/*url:true*/
				} 
			}
	});
	
	/*Core Topic Validation */
	$("#core_topic").validate({
		rules: {
            topic_name:{
				required: true
				}
			}
	});
	
	/* campaign Script */
	$("#subtopic_form").submit(function(){
		var total = $('input[name="keywords[]"]:checked').length;
		var min=1;
		var max=12;
		if(total>=min && total <=max)
		{
			
			return true;
		}
		else
		{
			if(total<min){message="You need to select Minimum "+min+" Subtopics";}
			else if(total>max){message="You can select Maximum "+max+" Subtopics";}
			new Messi(message, {
				title: "Error",
				titleClass: "anim error",
				modal: !0,
				buttons: [{
					id: 0,
					label: "Ok",
					val: "X"
				}]
			}); 
			return false;
		}	
	});
	/* end */
	
/* Approve Keyword Page Script */
	$("#keywordType").submit(function(){
		var total = $('input[name="contenttype[]"]:checked').length;
		var total_keywords=$("#total_Keywords").val();
		
		if(total==total_keywords)
		{
			
			return true;
		}
		else
		{
			if(total<total_keywords){message="You need to select "+total_keywords+" Subtopic Type";}
			new Messi(message, {
				title: "Error",
				titleClass: "anim error",
				modal: !0,
				buttons: [{
					id: 0,
					label: "Ok",
					val: "X"
				}]
			}); 
			return false;
		}	
	});
	/* end */
/* Approve Title Page Script */
	$("#article_approve").submit(function(){
		var total = $('input[name="approve[]"]:checked').length;
		var min=1;
		
		if(total>=min)
		{
			
			return true;
		}
		else
		{
			if(total<min){message="You need to select Minimum "+min+" Article";}
			new Messi(message, {
				title: "Error",
				titleClass: "anim error",
				modal: !0,
				buttons: [{
					id: 0,
					label: "Ok",
					val: "X"
				}]
			}); 
			return false;
		}	
	});
	/* end */
	
	/* Ajax for find resaurces */
	$('.approvecontent2__button-item').on('click', function () {
		$(".articles").html("");
		$(".loader").show();
		var title=$(this).data('title');
		
		$.ajax({
					url:'articles_ajax.php',
					type:'POST',
					data:{title:title},
					success:function(data){
						$(".loader").hide();
						$(".articles").html(data);
					}
		});		
	});
	
	/* end */			
	
    $('.approvecontent2__button-item').on('click', function () {
        $('.approvecontent2__button-item').removeClass('approvecontent2__button-active');
        $(this).addClass('approvecontent2__button-active');

        if ($('.js-show__button-things').hasClass("approvecontent2__button-active")) {
            $('.resources-item').fadeOut(0);
            $('.js-show-block-thing').fadeIn(10);
        }

        if ($('.js-show__button-how').hasClass("approvecontent2__button-active")) {
            $('.resources-item').fadeOut(0);
            $('.js-show-block-how').fadeIn();
        }

        if ($('.js-show__button-introdution').hasClass("approvecontent2__button-active")) {
            $('.resources-item').fadeOut(0);
            $('.js-show-block-introdution').fadeIn();
        }
    })
	
	/* tooltip */
		 $('[data-toggle="tooltip"]').tooltip();   
});