<div id="center">
	<div id="content">
		<h2>Latest Contest <span>Round ( 1 )</span></h2>
		<div class="items members clearfix">
			<?php $category = array("Singers", "Rappers", "Dancers", "Musicians", "Bands", "Dj's", "Lip Sync", "Kids Talent"); ?>
			<?php for($i=1; $i < 9; $i++){ ?>

				<div class="battle">
					<h2><span><?php echo $category[$i-1]; ?></span></h2>

					<div class="battle-group clearfix">
						<div class="item content-box <?php echo $i%5 == 0 ? "last" : ""; ?>">
							<?php echo Asset::img("contest_winners/winner_". (($i * 2) - 1 ).".jpg"); ?>
							<h3>Winner Name</h3>
							<p class="views">Views (1,000) By: Username</p>
							<div class="clearfix">
								<p class="votes">Votes (2,887)</p>
								<p class="icons">
									<?php echo Html::anchor(Router::get("home"), "Vote", array("class" => "button dark-gradient")); ?>
								</p>
							</div>					
						</div>

						<?php echo Asset::img("vs.png", array("class" => "battle-vs")); ?>

						<div class="item content-box <?php echo $i%5 == 0 ? "last" : ""; ?>">
							<?php echo Asset::img("contest_winners/winner_". ($i * 2) .".jpg"); ?>
							<h3>Winner Name</h3>
							<p class="views">Views (1,000) By: Username</p>
							<div class="clearfix">
								<p class="votes">Votes (2,887)</p>
								<p class="icons">
									<?php echo Html::anchor(Router::get("home"), "Vote", array("class" => "button dark-gradient")); ?>
								</p>
							</div>						
						</div>

					</div>					
				</div>
			<?php } ?>
		</div>

		<?php echo Asset::img("logo_slogan.png", array("class" => "logo-slogan")); ?>
	</div>
</div>