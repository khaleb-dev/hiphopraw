<div id="center" style="margin:0px">
<?php 

			$button_text = (!$current_user)?"Join to Vote Now":"View Contest";
			$link_to = (!$current_user)?"sign_up":"contest/:contest_id";
			
			// MODEL_CONTEST = $model_contest
			
			//print_r($contests);
			#print_r($contests_by_category);

			
				
			
			?><div id="content"  style="line-height:1.4">
				<div class="heading-with-ad clearfix">
					<h2><span>Latest Contests</span></h2>
				</div>
				<div class="items clearfix" style="margin-bottom:10px">
					
					<div class="item content-box" style="margin:10px">
		
						<div style="font-weight:bold;padding-bottom:3px">Singers</div>
						
						<?php 
							if(isset($contests_by_category[1]) && count($contests_by_category[1]) > 0){

								echo Html::anchor(Router::get($link_to, array("contest_id"=>$contests_by_category[1][0]['id']) ), Asset::img("contest/singers.jpg"), array("class" => ""));
								?><div style="font-size:10px;text-align:center">
									<?php echo Html::anchor(Router::get($link_to, array("contest_id"=>$contests_by_category[1][0]['id'])), $button_text, array("class" => "button rounded-corners")); ?>
								</div><?php 

							}else{

								echo Asset::img("contest/singers.jpg");
								
								?><div style="font-size:12px;height:40px;text-align:center">
									<br />
									No contests yet!
								</div><?php 


							}
						
						
						?>						
					</div>
					<div class="item content-box" style="margin:10px">
		
						<div style="font-weight:bold;padding-bottom:3px">Rappers</div>
		
						<?php 
						if(isset($contests_by_category[2]) && count($contests_by_category[2]) > 0){

							echo Html::anchor(Router::get($link_to, array("contest_id"=>$contests_by_category[2][0]['id'])), Asset::img("contest/rappers.jpg"), array("class" => "")); ?>
							<div style="font-size:10px;text-align:center">
								<?php echo Html::anchor(Router::get($link_to, array("contest_id"=>$contests_by_category[2][0]['id'])), $button_text, array("class" => "button rounded-corners")); ?>
							</div><?php
							 
						}else{

							echo Asset::img("contest/rappers.jpg");

							?><div style="font-size:12px;height:40px;text-align:center">
								<br />
								No contests yet!
							</div><?php 


						}
					?></div>
					<div class="item content-box" style="margin:10px">
		
						<div style="font-weight:bold;padding-bottom:3px">Dancers</div>
		
						<?php 
						
						if(isset($contests_by_category[3]) && count($contests_by_category[3]) > 0){


							echo Html::anchor(Router::get($link_to, array("contest_id"=>$contests_by_category[3][0]['id'])), Asset::img("contest/dancers.jpg"), array("class" => "")); ?>
							<div style="font-size:10px;text-align:center">
								<?php echo Html::anchor(Router::get($link_to, array("contest_id"=>$contests_by_category[3][0]['id'])), $button_text, array("class" => "button rounded-corners")); ?>
							</div><?php 
						}else{

							echo Asset::img("contest/dancers.jpg");
							?><div style="font-size:12px;height:40px;text-align:center">
								<br />
								No contests yet!
							</div><?php 

						}
					?></div>	
					<div class="item content-box" style="margin:10px">
		
						<div style="font-weight:bold;padding-bottom:3px">Musicians/Bands</div>
		
						<?php 
						if(isset($contests_by_category[4]) && count($contests_by_category[4]) > 0){


							echo Html::anchor(Router::get($link_to, array("contest_id"=>$contests_by_category[4][0]['id'])), Asset::img("contest/bands.jpg"), array("class" => "")); ?>
							<div style="font-size:10px;text-align:center">
								<?php echo Html::anchor(Router::get($link_to, array("contest_id"=>$contests_by_category[4][0]['id'])), $button_text, array("class" => "button rounded-corners")); ?>
							</div><?php 
						}else{
							echo Asset::img("contest/bands.jpg");
							?><div style="font-size:12px;height:40px;text-align:center">
								<br />
								No contests yet!
							</div><?php 
						}
					?></div>
					<div class="item content-box" style="margin:10px">
		
						<div style="font-weight:bold;padding-bottom:3px">Dj's</div>
		
						<?php 
						if(isset($contests_by_category[6]) && count($contests_by_category[6]) > 0){


							echo Html::anchor(Router::get($link_to, array("contest_id"=>$contests_by_category[6][0]['id'])), Asset::img("contest/djs.jpg"), array("class" => "")); ?>
							<div style="font-size:10px;text-align:center">
								<?php echo Html::anchor(Router::get($link_to, array("contest_id"=>$contests_by_category[6][0]['id'])), $button_text, array("class" => "button rounded-corners")); ?>
							</div><?php 
						}else{
							echo Asset::img("contest/djs.jpg");
							?><div style="font-size:12px;height:40px;text-align:center">
								<br />
								No contests yet!
							</div><?php 
						}
					?></div>
					<div class="item content-box" style="margin:10px">
		
						<div style="font-weight:bold;padding-bottom:3px">Lip Sync</div>
						<?php 
						
						if(isset($contests_by_category[7]) && count($contests_by_category[7]) > 0){
						
							

							echo Html::anchor(Router::get($link_to, array("contest_id"=>$contests_by_category[7][0]['id'])), Asset::img("contest/lipsync.jpg"), array("class" => "")); ?>
							<div style="font-size:10px;text-align:center">
								<?php echo Html::anchor(Router::get($link_to, array("contest_id"=>$contests_by_category[7][0]['id'])), $button_text, array("class" => "button rounded-corners")); ?>
							</div><?php 
						}else{

							echo Asset::img("contest/lipsync.jpg");
							?><div style="font-size:12px;height:40px;text-align:center">
								<br />
								No contests yet!
							</div><?php 
						}
					?></div>
					<div class="item content-box" style="margin:10px">
		
						<div style="font-weight:bold;padding-bottom:3px">Kids Talent</div>
		
						<?php 
						if(isset($contests_by_category[8]) && count($contests_by_category[8]) > 0){

							

							echo Html::anchor(Router::get($link_to, array("contest_id"=>$contests_by_category[8][0]['id'])), Asset::img("contest/kidtalent.jpg"), array("class" => "")); ?>
							<div style="font-size:10px;text-align:center">
								<?php echo Html::anchor(Router::get($link_to, array("contest_id"=>$contests_by_category[8][0]['id'])), $button_text, array("class" => "button rounded-corners")); ?>
							</div><?php 
						}else{

							echo Asset::img("contest/kidtalent.jpg");
							?><div style="font-size:12px;height:40px;text-align:center">
								<br />
								No contests yet!
							</div><?php 
						}
						
						
					?></div>
					<div class="item content-box" style="margin:10px">
		
		
						<div style="font-weight:bold;padding-bottom:3px">Rants &amp; Statements</div>
						<?php 

						if(isset($contests_by_category[9]) && count($contests_by_category[9]) > 0){
						

							

							echo Html::anchor(Router::get($link_to, array("contest_id"=>$contests_by_category[9][0]['id'])), Asset::img("contest/rants.jpg"), array("class" => "")); ?>
							<div style="font-size:10px;text-align:center">
								<?php echo Html::anchor(Router::get($link_to, array("contest_id"=>$contests_by_category[9][0]['id'])), $button_text, array("class" => "button rounded-corners")); ?>
							</div><?php 
						}else{

							echo Asset::img("contest/rants.jpg");
							?><div style="font-size:12px;height:40px;text-align:center">
								<br />
								No contests yet!
							</div><?php 

						}
					?></div>	
					<div class="item content-box" style="margin:10px">
		
						<div style="font-weight:bold;padding-bottom:3px">Comedians</div>
						<?php 
						
						if(isset($contests_by_category[11]) && count($contests_by_category[11]) > 0){

							

							echo Html::anchor(Router::get($link_to, array("contest_id"=>$contests_by_category[11][0]['id'])), Asset::img("contest/comedians.jpg"), array("class" => "")); ?>
							<div style="font-size:10px;text-align:center">
								<?php echo Html::anchor(Router::get($link_to, array("contest_id"=>$contests_by_category[11][0]['id'])), $button_text, array("class" => "button rounded-corners")); ?>
							</div><?php 
						}else{

							echo Asset::img("contest/comedians.jpg");
							?><div style="font-size:12px;height:40px;text-align:center">
								<br />
								No contests yet!
							</div><?php 
						}
					?></div>
					<div class="item content-box" style="margin:10px">
		
		
						<div style="font-weight:bold;padding-bottom:3px">Judges</div>
						<?php 
						
						
						
						
						if(isset($contests_by_category[10]) && count($contests_by_category[10]) > 0){

						

							echo Html::anchor(Router::get($link_to, array("contest_id"=>$contests_by_category[10][0]['id'])), Asset::img("contest/judges.jpg"), array("class" => "")); ?>
							<div style="font-size:10px;text-align:center">
								<?php echo Html::anchor(Router::get($link_to, array("contest_id"=>$contests_by_category[10][0]['id'])), $button_text, array("class" => "button rounded-corners")); ?>
							</div><?php 
						}else{
							echo Asset::img("contest/judges.jpg");
							?><div style="font-size:12px;height:40px;text-align:center">
								<br />
								No contests yet!
							</div><?php 

						}
					?></div>
					<div class="item content-box" style="margin:10px">
		
		
						<div style="font-weight:bold;padding-bottom:3px">Spoken Word</div>
						<?php 
						
						
						
						
						if(isset($contests_by_category[5]) && count($contests_by_category[5]) > 0){

						

							echo Html::anchor(Router::get($link_to, array("contest_id"=>$contests_by_category[5][0]['id'])), Asset::img("contest/spokenword.jpg"), array("class" => "")); ?>
							<div style="font-size:10px;text-align:center">
								<?php echo Html::anchor(Router::get($link_to, array("contest_id"=>$contests_by_category[5][0]['id'])), $button_text, array("class" => "button rounded-corners")); ?>
							</div><?php 
						}else{
							echo Asset::img("contest/spokenword.jpg");
							?><div style="font-size:12px;height:40px;text-align:center">
								<br />
								No contests yet!
							</div><?php 

						}
					?></div>
				</div>
				<div class="heading-with-ad clearfix">
					<h2><span>Contest</span></h2>
					<div id="heading-ad" style="float:right">
						<span>Click here to see how it works</span> 
						<?php echo Asset::img("arrow_right.png"); ?>
						<?php echo Html::anchor(Router::get('contest_how_to'), "See how it works", array("class" => "button rounded-corners")); ?>
					</div>
				</div>
				<div class="content-box">
					<p>
						HipHopRaw will periodically run contests in each category that's
		                                offered on the site. This will be done to reward the performer (YOU)
		                                for their talent. We will announce a contest and allow all who wish to
		                                enter and judge a chance to upload and vote on videos. Once the contest
		                                is finished, all votes will be counted and the top 8 videos will be placed
		                                in a tournament style bracket. Once in the bracket, videos will battle
		                                head to head for votes until a winner is crowned. The best part about
                        HipHopRaw is the contests and votes being automatically run by
		                                the site itself.
					</p>
					<p>
						It has the intelligence to count votes on it's own, place the videos in
		                                brackets on it's own, and crown a winner on it's own. So there will be no
		                                favoritism behind the scenes. You can truly see if you are the best on
                        HipHopRaw. Nobody can pay for votes, and no human can mess with
		                                the voting process.
					</p>
				</div>
				<hr />
				<?php echo Html::anchor(Router::get('home'), Asset::img("win_gifts_and_prizes.png"), array("class" => "win-gifts-and-prizes")); ?>
				
				
			</div><?php 
			

			#echo "asfsfsdf";

		//}
		?>
	
</div>