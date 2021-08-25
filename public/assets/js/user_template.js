$(document).ready(function () {
	
	 $(document).on('click','.header-request', function (e) {
		var receiver_id = $(this).attr("to");
		var sender_id = $(this).attr("from");
		var status = $(this).attr("status");
		
		 var data = new Object();
		 data.receiver_id = receiver_id;
		 data.sender_id = sender_id;
		 data.status = status;
		$.ajax({
	        method: "post",
	        url: $("#url-holder").attr("url"),
	        data: data,
	        success: function (res) {  
	        	console.log(res);
	        	var responseJSON = JSON.parse(res);

	        	$("#header-friend-"+ sender_id).hide();
	        	 //if (responseJSON.identifer) {	
	        	// $(responseJSON.html).insertAfter("#reference");
	        	// $(".no-message-data").remove();
	        	 //}
	        	$("div#notification-container div.detail h3").html("Success");
                $("div#notification-container div.detail p").html(responseJSON.message);
                
                $.clearModalForm();
                $("div.modal").modal('hide');

                $("div#notification-container").slideDown("fast", function() {
                    setTimeout(function() {
                        $("div#notification-container").fadeOut("slow");
                    }, 4000);
                });
	        
	        },
	        error: function () {
	        	$("div#notification-container div.detail h3").html("error");
                $("div#notification-container div.detail p").html("there is an error encountered.");
                
                $.clearModalForm();
                $("div.modal").modal('hide');

                $("div#notification-container").slideDown("fast", function() {
                    setTimeout(function() {
                        $("div#notification-container").fadeOut("slow");
                    }, 4000);
                });
	        }
	    });
	});
	
	
	
	
	
	
	
	
	$(".drop-down-lists").hide();	
	$(".drop-down-logout").hide();
	$(".drop-down-friends").hide();
	$(".drop-down-messages").hide();
	$(".drop-down-comments").hide();

	$("#header-dropdown").click(function(e){
        $(".drop-down-lists").show();
    });
		
	$("#header-friends-dropdown").click(function(e){
        $(".drop-down-friends").show();
    });

    $("#header-comments-dropdown").click(function(e){
        $(".drop-down-comments").show();
    });
    $("#header-message-dropdown").click(function(e){
        $(".drop-down-messages").show();
    });
	$("#header-name-dropdown").click(function(e){
        $(".drop-down-logout").show();
    });

		
	$(document).mouseup(function (e)
			{
			    var container = $(".drop-down-lists");

			    if (!container.is(e.target)
			        && container.has(e.target).length === 0) 
			    {
			        container.hide();
			    }
			});
	$(document).mouseup(function (e)
			{
			    var container = $(".drop-down-friends");

			    if (!container.is(e.target)
			        && container.has(e.target).length === 0) 
			    {
			        container.hide();
			    }
			});
	$(document).mouseup(function (e)
			{
			    var container = $(".drop-down-comments");

			    if (!container.is(e.target)
			        && container.has(e.target).length === 0) 
			    {
			        container.hide();
			    }
			});
	$(document).mouseup(function (e)
			{
			    var container = $(".drop-down-messages");

			    if (!container.is(e.target)
			        && container.has(e.target).length === 0) 
			    {
			        container.hide();
			    }
			});
	
	$(document).mouseup(function (e)
			{
			    var container = $(".drop-down-logout");

			    if (!container.is(e.target)
			        && container.has(e.target).length === 0) 
			    {
			        container.hide();
			    }
			});
	
	var $hiddenSearch = $("#search-header"),
		$displaySearch = $("#display-search"),
		$searchOverlay = $("#search-overlay"),
		$searchList = $("#search-data");

	$("#search-header").keydown(function(){ 
		$searchOverlay.show(); 
		$hiddenSearch.focus(); 
	});
	
	$searchOverlay.click(function(event){ 
		$hiddenSearch.focus(); 
		if(event.target.id == "search-overlay" || event.target.id == "close"){
			$hiddenSearch.blur(); 
			$(this).animate({"opacity": 0}, 500, function(){ 
				$(this).hide().css("opacity", 1); 
			});
		}
	});
		
	
	$hiddenSearch.keydown(function(e){
		currentQuery = $displaySearch.val(); 
		
		if(e.keyCode == 8){ 
		
			latestQuery = currentQuery.substring(0, currentQuery.length - 1); 
			
			$displaySearch.val(latestQuery.toLowerCase()); 
			updateResults(latestQuery); 			
		
		}		
		else if(e.keyCode == 32 || (e.keyCode >= 65 && e.keyCode <= 90) || (e.keyCode >= 48 && e.keyCode <= 57)){ 
			latestQuery = currentQuery + String.fromCharCode(e.keyCode); 
			console.log(latestQuery);	
			$displaySearch.val(latestQuery.toLowerCase()); 

			updateResults(latestQuery); 
		}
	});
	
	function updateResults(latestQuery){
			

		if(latestQuery.length > 1){ 
				
			$.post($("#header-search-container").attr('url')+ latestQuery.toLowerCase(),null, function(response){ 
				
			    if(response.status){ 
			    	data = response.result; 
			    	word = response.word;
			    	$("#search-data li").remove(":contains('No results')");
					$("#results").show(); 
					
					previousTerms = new Array(); 

					$("#search-data li").each(function(){ 
						previousTerms.push(($(this).text()).trim()); 
					});
										
					keepTerms = new Array();
					console.log("previousTerms");
					for(term in previousTerms){
						console.log(previousTerms[term]);
					}
						console.log("Terms fetched");				
					for(term in data){ 
						url = data[term]; 
						console.log(word[term]);
						if($.inArray((word[term]).trim(), previousTerms ) === -1){ //if this term isn't in the previous list of terms (and isn't already being displayed)...
							$searchList.prepend('<p ><li >'+url+'  '+term+'</li></p>');
						}else{ 
							keepTerms.push(word[term].trim()); //add the term we want to keep to an array
						}																				
					}

					console.log("keepTerms");
					for(term in keepTerms){
						console.log(keepTerms[term]);
					}
						
					if(Object.getOwnPropertyNames(data).length === 0 || (keepTerms.length == 0 && (previousTerms.length != 0 || $displaySearch.val() == ""))){
						$searchList.html("<li>No results</li>");
					
					}else{						
						for(term in previousTerms){ 
								
							if($.inArray((previousTerms[term]).trim(), keepTerms) === -1){
								$("#search-data li").filter(function(){
									return $(this).text().trim() == previousTerms[term].trim()
								}).remove();
							}

						}
					}
					
			    }

			}, 'json');
		
		
	}
		else{
			$searchList.empty();
			$searchOverlay.hide();
		}
		
	}





});