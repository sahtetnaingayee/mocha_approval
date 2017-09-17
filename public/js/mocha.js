$(document)
    .one('focus.autoExpand', 'textarea.autoExpand', function(){
        var savedValue = this.value;
        this.value = '';
        this.baseScrollHeight = this.scrollHeight;
        this.value = savedValue;
    })
    .on('input.autoExpand', 'textarea.autoExpand', function(){
        var minRows = this.getAttribute('data-min-rows')|0, rows;
        this.rows = minRows;
        rows = Math.ceil((this.scrollHeight - this.baseScrollHeight) / 17);
        this.rows = minRows + rows;
    });

    $(document)
    .one('focus.previewExpand', 'textarea.previewExpand', function(){
        var savedValue = this.value;
        this.value = '';
        this.baseScrollHeight = this.scrollHeight;
        this.value = savedValue;
    })
    .on('input.previewExpand', 'textarea.previewExpand', function(){
        var minRows = this.getAttribute('data-min-rows')|0, rows;
        this.rows = minRows;
        rows = Math.ceil((this.scrollHeight - this.baseScrollHeight) / 17);
        this.rows = minRows + rows;
    });

$(document).on("click","input[name='publish_type']",function(){


    var $value=$(this).val();

    $value==20?$("#schedule-panel").removeClass("dn"):$("#schedule-panel").addClass("dn");

})


/*======= NUMBER ONLY ========*/


var $ctrKey=false;
function numberOnly(event) {

    var key = event.keyCode;
    return ((key >= 48 && key <= 57) || (key >= 96 && key <= 105) ||  (event.shiftKey && event.ctrlKey && key==37 ) || (event.shiftKey && key == 36) || (event.ctrlKey && key ==86) || key == 8 ||  key==189 || key==9 || key==32 || key==16 || key==37 || key==39 || key==46 || (event.ctrlKey && key ==90) ||  (event.ctrlKey && key ==88) || (event.ctrlKey && key ==190));
}

/* Real Time DATA BINDING */


$(document).on("keyup","textarea.new-message",function(){
    
    $key=$(this).val().replace(/\n/g, '<br />');
    
    $("div.preview_message").html($key);

});


/* BINDING PREVIEW */

$("input[name='file']").change(function(){
    
    readURL(this);

    if(input.files[0].type!='video/mp4'){

        $("div.play").addClass("dn");    
    }

});

$("input[name='thumbnail']").change(function(){
    
    readURL(this);
    $("div.play").removeClass("dn");

});

function readURL(input) {

    if (input.files && input.files[0]) {


        var reader = new FileReader();

        if(input.files[0].type!='video/mp4'){

            reader.onload = function (e) {

                $('#imgpreview').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }
}


/* ============= GET PAGE'S POST  =================== */


/* ============= CHECKBOX CHECKING BEFORE FORM SUBMIT ==============*/

$(document).on("submit","form.frmPage",function(){

    if($(".chkPage").is(':checked')){
         
        return true;

    } else {
        alert("Plase check at least one page.");

        return false;
    }

    return false;

});

/* ============= CHECKBOX Post ==============*/

$("input[name='post_type']").on("change",function(e){

    if($(this).val()==10){/* IF PHOTO */

        $("div#video_thumbnail").addClass("dn");

        $("span#label").text("Photo");

        $("input[name='file']").attr("accept","image/*");

    }else{/* IF VIDOE */

        $("div#video_thumbnail").removeClass("dn");
        $("input[name='file']").attr("accept","video/mp4");
        $("span#label").text("Video");
    }
});

function showLoading(){

    $('body').append("<div class='loading_panel'><div class='l_panel'><div class='loader'></div></div></div>");


}

function hideLoading(){

   $(".loader").remove();
}


$(document).on("click","button#btn_campaign",function(){


    if($("input[name='objective']").is(':checked')){
         
        $("div#advert_set").addClass("active");

        $("div#campaign").removeClass("active");

        $("li#li_campaign").removeClass("active");
        $("li#li_advert_set").addClass("active");

        $("li#li_advert_set a").removeClass("pn");

    } else {

        alert("Plase check at least one objective.");

        
    }


});

$(document).on("click","button#btn_adver_set",function(){


    if($("input[name='campaign_name']").val()!='' && $("input[name='adset_name']").val()!=''){


        $("div#advert").addClass("active");

        $("div#advert_set").removeClass("active");

        $("li#li_advert_set").removeClass("active");
        $("li#li_advert").addClass("active");

        $("li#li_advert a").removeClass("pn");

    }else{

        alert("Please fill required fields.");
    }

    /*===== CHECKING REQUIRED FIELDS ====*/


    
});

$(document).on("click","button#btn_back_advert_set",function(){


    $("div#advert_set").removeClass("active");

    $("div#campaign").addClass("active");

    $("li#li_campaign").addClass("active");
    $("li#li_advert_set").removeClass("active");

    

});

$(document).on("click","button#btn_back_advert",function(){


    $("div#advert").removeClass("active");

    $("div#advert_set").addClass("active");

    $("li#li_advert_set").addClass("active");
    $("li#li_advert").removeClass("active");

    

});


$(document).on("change","input[name='schedule']",function(){


    if($(this).val()==20){
        
        $("#schedule_panel").removeClass("dn");    

    }else{

         $("#schedule_panel").addClass("dn");    
    }
    

});

$(document).on("submit","form.frmBasic",function(){

    showLoading();
});

$(document).on("change","select[name='budget_type']",function(){
    

    if($(this).val()==20){

        $(".schedule_type_panel").addClass("dn");
        $("#schedule_panel").removeClass("dn");

    }else{

        $(".schedule_type_panel").removeClass("dn");
        $("#schedule_panel").addClass("dn");

    }
}); 













