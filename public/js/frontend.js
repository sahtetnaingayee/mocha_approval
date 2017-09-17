$(document).ready(function(){

	var maxLength = 300;

	$(".show-read-more").each(function(){

		var myStr = $(this).html();
		if($.trim(myStr).length > maxLength){

			var newStr = myStr.substring(0, maxLength);
			var removedStr = myStr.substring(maxLength, $.trim(myStr).length);
			$(this).empty().html(newStr);
			$(this).append(' <a href="javascript:void(0);" class="read-more">...See More</a>');
			$(this).append('<span class="more-text">' + removedStr + '</span>');
		}
	});
	$(".read-more").click(function(){
		$(this).siblings(".more-text").contents().unwrap();
		$(this).remove();
	});
});

$(document).on("submit","form.frmComment",function(e){

    e.preventDefault();
    
    var $form = $(this);

    $.ajax({

        type: $form.attr('method'),
        url: $form.attr('action'),
        data: $form.serialize(),
        dataType: 'json',
        success: function(data) {


            if (data.success) {

                
            	$("div.comment_panel").append(data.html);
            } else {
            	
                
            }
        }
    });
});


$(document).on("submit","form.frmArpprove",function(e){

    e.preventDefault();
    
    var $form = $(this);

    $.ajax({

        type: $form.attr('method'),
        url: $form.attr('action'),
        data: $form.serialize(),
        dataType: 'json',
        success: function(data) {


            if (data.success) {

            	$("div#p_"+data.index).addClass("approved");
            } else {
            	
                
            }
        }
    });
});
