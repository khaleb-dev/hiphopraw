
$(document).ready(function(){

	$("#dlt-btn").click(function(e){
		contest_id = $(this).data("contestid");

		url = $("#dlt-btn").attr("url");

		console.log(contest_id);
		console.log(url);

		$.post(url,{cid: contest_id}, function(response){

			console.log("success");
			
			contestremove = 'tbody.contest-'+ contest_id;
			console.log(contestremove);
            $(contestremove).fadeOut("fast"); 

			
				if(response.status){  	
                heading = "Delete Contest!";
                $("div#notification-container div.detail h3").html(heading);
                $("div#notification-container div.detail p").html(response.message);
                $("div#notification-container").slideDown("fast", function() {
                    setTimeout(function() {
                        $("div#notification-container").fadeOut("slow");
                    }, 4000);
                });
            }

		}, "json").error(function() {
                
                $("div#notification-container div.detail h3").html("Error!");
                $("div#notification-container div.detail p").html("Error occured while trying to delete contest.");
                $("div#notification-container").slideDown("fast", function() {
                    setTimeout(function() {
                        $("div#notification-container").fadeOut("slow");
                    }, 4000);
                });
            });
        e.preventDefault();


	});


});


function checkAddContest(frm){
	
	
	if(!frm.start_date.value.trim()){
		
		frm.start_date.select();
		
		alert("Please select a start date.");
		
		return false;
	}
	
	if(!frm.name.value.trim()){
		
		frm.name.select();
		
		alert("Please enter a name for this contest.");
		
		return false;	
	}
	
	
	
	
	return true;
}




function calculateEndofContest(start_date){
	
	
	var contest_duration = 28; // 28 days = 4 weeks. Week 1 = round 0 - signup, week 2 = round 1, week 3 = round 2, week 4 = round 3. Round 4 is 1 person, thus contest ends
	
	
	
	var datearr = start_date.split("/");

	////alert("year: "+datearr[2]+" month: "+datearr[0]+" day:"+datearr[1]);

	////new Date(YEAR, MONTH, DAY)
	var d = new Date(datearr[2], parseInt(datearr[0])-1,parseInt(datearr[1]) + contest_duration);
	
	return (d.getMonth()+1)+"/"+d.getDate()+"/"+d.getFullYear();
}