$(document).ready(function () {
    $("#upload-video-form p span.error").hide();
    $("#youtube-video-form p span.error").hide();
    $("#select-thumbnail").hide();
    $("#selected_thumb").hide();

$("#upload-video-container").click(function(event){ 

   $("#upload-complete-confirmation").hide();

});
   

    $("#youtube-video-form").submit(function (e) {
        e.preventDefault();
        $("#upload-complete-confirmation").hide();
        var passedValidation = areybInputsCorrect();

        if (passedValidation) {
            var options = {
                beforeSend: function () {
                    console.log("uploading");
                    $("#progress-bar-yb-container, #percent").show();

                    $("#progress-bar-yb").width('0%');
                    $("#message").html("");
                    $("#percent").html("0%");
                    console.log("before send");
                    $('#submit').attr('disabled', 'disabled');
                },
                uploadProgress: function (event, position, total, percentComplete) {
                    $("#progress-bar-yb").width((percentComplete<100?percentComplete:99) + '%');
                    $("#percent").html('Uploading:' + (percentComplete<100?percentComplete:99) + '%');
                    if(percentComplete > 95 && percentComplete<100){
                    $("#wait").html('Please wait while your preview thumbnails are being created');
                    }
                    console.log(percentComplete);
                },
                success: function (responseStr) {
                    response=JSON.parse(responseStr);
                    console.log("the response");
                    console.log(response);
                    console.log("ajax success");
                    console.log(response);
                    if (response.status === "success") {
                        //provideSuccessFeedbackAndResetForm();
                        username=response.username;
                        video=response.thevideo;
                        id= response.theid;                     
               
                    } else {
                        showErrorAlert();
                    }
                },
                complete: function () {
                    console.log("ajax complete");
                    $("#progress-bar-yb").width('99%');
                    $("#percent").html('Uploading: 99%');
                    provideSuccessFeedbackAndResetFormyb()


                },
                error: function (response) {
                    console.log("ajax error");
                    showErrorAlert();
                }
            };
            console.log("no input validation error");
            $("#youtube-video-form").ajaxSubmit(options);
        } else {
            console.log("input validation error");
        }
    });

    $("#upload-video-form").submit(function (e) {
        e.preventDefault();
        $("#upload-complete-confirmation").hide();
        var passedValidation = areInputsCorrect();

        if (passedValidation) {
            var options = {
                // type: "POST",
                // dataType: "json",
                // contentType: "application/json; charset=utf-8",
                //timeout: (600 * 1000),
                remote: true,
                beforeSend: function () {
                    console.log("uploading");
                    $("#progress-bar-container, #percent").show();

                    $("#progress-bar").width('0%');
                    $("#message").html("");
                    $("#percent").html("0%");
                    console.log("before send");
                    $('#submit').attr('disabled', 'disabled');
                },
                uploadProgress: function (event, position, total, percentComplete) {
                    $("#progress-bar").width((percentComplete<100?percentComplete:99) + '%');
                    $("#percent").html('Uploading:' + (percentComplete<100?percentComplete:99) + '%');
                    if(percentComplete > 95 && percentComplete<100){
                    $("#wait").html('Please wait while your preview thumbnails are being created');
                    }
                    console.log(percentComplete);
                },
                success: function (responseStr) {
                    response=JSON.parse(responseStr);
                    console.log("the response");
                    console.log(response);
                    console.log("ajax success");
                    console.log(response);
                    if (response.status === "success") {
                        //provideSuccessFeedbackAndResetForm();
                        username=response.username;
                        video=response.thevideo;
                        id= response.theid;
                        $("#submit").hide();
                        

                        $("#select-thumbnail").show();
                        $('html, body').animate({scrollTop: $("#select-thumbnail").offset().top}, 2000);
                         
                        $("#thumb1_check").append("<input class=\"check-each\"  name=\"thumb_check\" value=\"0\" type=\"checkbox\" />");
                        $("#thumb1").append($('<img>',{id:'thumb1', src:$("#selected-thumb").attr("url")+ response.username+'/videokes/thumb_0_172x114_'+response.thevideo+'.jpg' }))
                        $("#thumb2_check").append("<input class=\"check-each\"  name=\"thumb_check\" value=\"1\" type=\"checkbox\" />");
                        $("#thumb2").append($('<img>',{id:'thumb2', src:$("#selected-thumb").attr("url")+ response.username+'/videokes/thumb_1_172x114_'+response.thevideo+'.jpg' }))
                        $("#thumb3_check").append("<input class=\"check-each\"  name=\"thumb_check\" value=\"2\" type=\"checkbox\" />");
                        $("#thumb3").append($('<img>',{id:'thumb3', src:$("#selected-thumb").attr("url")+ response.username+'/videokes/thumb_2_172x114_'+response.thevideo+'.jpg' }))
                        $("#thumb4_check").append("<input class=\"check-each\"  name=\"thumb_check\" value=\"3\" type=\"checkbox\" />");
                        $("#thumb4").append($('<img>',{id:'thumb4', src:$("#selected-thumb").attr("url")+ response.username+'/videokes/thumb_3_172x114_'+response.thevideo+'.jpg' }))
                        $("#thumb4_check").append("<input  id=\"thevideo\" name=\"video\" type=\"hidden\" value="+id+" >" );
                    } else {
                        showErrorAlert();
                    }
                },
                complete: function () {
                    console.log("ajax complete");
                    $("#progress-bar").width('99%');
                    $("#percent").html('Uploading: 99%');

                },
                error: function (response) {
                    console.log("ajax error");
                    showErrorAlert();
                }
            };
            console.log("no input validation error");
            $("#upload-video-form").ajaxSubmit(options);
        } else {
            console.log("input validation error");
        }
    });

    $("input, textarea").change(function () {
        if ($(this).val() !== "")
            $(this).next("span").hide();
    });

   
    $("#select-thumb").click(function (e) {               
            $("#upload-video-form p span.error").hide();
            $("#select-thumbnail").hide();
            $("#upload-video-form").hide();
            $("#youtube-video-form").hide();
            $(".youtube").hide();
            $("#upload-complete-confirmation").hide();
            url = $("#select-thumbnail").attr("url");
            zvideo=Number($("input[id='thevideo']").val());
            $('input[name="thumb_check"]').each(function() {
                 
                 if($(this).is(':checked')){
                        thumb=Number(($(this).val()));
                    }
            
            });
            
        $.post(url+zvideo+'/'+ thumb,null, function(response) {
                if(response.status){  
                    $("#selected-thumb").show();
                     username= response.username;
                     video=response.thevideo;
                     id= response.theid;
                     thetitle=response.thetitle;
                     $("html, body").animate({ scrollTop: 0 }, "slow");
                  
                     $('#thumb-image').append($('<img>',{id:'thumb-s', src:$("#selected-thumb").attr("url")+username+'/videokes/thumb_172x114_'+video+'.jpg' }));
                     $('#thumb-info').append("<span style='float: left; font-weight: bold' class='uppercase'>"+thetitle+"</span><br>");
                     $('#thumb-info').append($('<img>',{id:'thumb-s-image', height:'15px', src:'http://hiphopraw.com/assets/img/selection.jpg'}));
                     $('#thumb-info').append("<span style='float: left;'> Your Video was successfuly uploaded </span> <br>");
                     $('#thumb-info').append("<spann style='float: left;'>Your Video is now ready to view at</span> <br>");
                     $('#thumb-info').append("<a href='http://www.hiphopraw.com/videos/show/"+id+ "' ><span class='red'>http://www.hiphopraw.com/videos/show/"+id+"</span></a>");
                     $('#thumb-info').append(" or <br> ");
                     $('#thumb-info').append("<a href='http://www.hiphopraw.com/pages/show/"+id+ "'><span class='red'>http://www.hiphopraw.com/pages/show/"+id+"</span></a>");
                  


                }

        }, "json").error(function() {
            console.log("i am not okay");
                                  
        });
        e.preventDefault();

});
                 
    
});

function showErrorAlert() {
    alert("error has occured in the upload. Please contact the Hip Hop Raw Admin for assistance");
    $('#submit').removeAttr("disabled");
}

function areInputsCorrect() {
    var passedValidation = true;
    var formatOkay = false;
    var sizeOkay = false;
    $("#upload-video-form p span.error").hide();
    $("#upload-video-form input, #upload-video-form textarea").each(function () {
        if ($(this).val() === "") {
            $(this).parent().find("span.empty").show();
            passedValidation = false;
        }
    });

    if ($("#video").val() !== "") {
        formatOkay = isVideoFormatOkay();
        passedValidation = passedValidation && formatOkay;
        if (!formatOkay) {
            $("#video").parent().find("span.unsupported-format").show();
        } else {
            sizeOkay = isFileSizeOkay()
            passedValidation = passedValidation && sizeOkay;
            if (!sizeOkay) {
                $("#video").parent().find("span.file-too-large").show();
            }
        }
    }
    return passedValidation;
}

function areybInputsCorrect() {
    var passedValidation = true;
    var formatOkay = false;
    var sizeOkay = false;
    $("#youtube-video-form p span.error").hide();
    $("#youtube-video-form input, #youtube-video-form textarea").each(function () {
        if ($(this).val() === "") {
            $(this).parent().find("span.empty").show();
            passedValidation = false;
        }
    });

    return passedValidation;
}

function isVideoFormatOkay() {
    var supportedFormats = ["webm", "ogg", "mov", "wmv", "flv", "mp4"];
    var formatOkay = false;
    var extension = $("#video").val().split('.').pop();
    console.log(extension);
    for (var i = 0; i < supportedFormats.length; i++) {
        formatOkay = formatOkay || (extension.toUpperCase() === supportedFormats[i].toUpperCase());
        console.log(extension + "===" + supportedFormats[i] + "=" + (extension === supportedFormats[i]));
    }
    return formatOkay;
}

function isFileSizeOkay() {
    var MAX_FILE_SIZE = 350 * 1024 * 1024;//350MB
    var fileSizeOkay = true;
    //Full File API support.
    if (window.FileReader && window.File && window.FileList && window.Blob) {
        try {
            console.log($("#video"));
            console.log($("#video")[0].files);
            var fileSize = $("#video")[0].files[0].size;
            console.log("fileSize=" + fileSize);
            if (fileSize > MAX_FILE_SIZE) {
                fileSizeOkay = false;
            }
        } catch (e) {
            return true;
        }
    } else {
        //file api not supported, and if file size>MAX_FILE_SIZE then the php will make the ajax fail
        return true;
    }


    return fileSizeOkay;
}

function resetUploadVideoForm(){
    $('#upload-video-form')[0].reset();
    $("#progress-bar-container, #percent").hide();
    $('#submit').removeAttr("disabled");
}
function resetYoutubeVideoForm(){
    $('#youtube-video-form')[0].reset();
    $("#progress-bar-yb-container, #percent").hide();
    $('#submit').removeAttr("disabled");

}
function provideSuccessFeedbackAndResetForm(){
    $("#upload-complete-confirmation").show();
    resetUploadVideoForm();
}
function provideSuccessFeedbackAndResetFormyb(){
    $("#upload-complete-confirmation").show();
    resetYoutubeVideoForm();

}