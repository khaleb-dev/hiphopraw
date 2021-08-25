<!DOCTYPE HTML>
<html lang = "en-US">
<head>

<title>Browse</title>
<?php echo Asset::css('browse_view.css'); ?>
</head>
<body>
<div id="content" class="clearfix">
    <div id="middle">
        <section id="quick-search">
            <h2>Quick Search</h2>

            <div class="quick-search">
                <form action = "browse_members" method = "post">
                    <div>
                        <label for="Iam">I am a:</label><br>
                        <select  name="Iam">
                            <option selected>Female</option>
                            <option>Male</option>
                        </select>
                    </div>

                    <div>
                        <label for="seaking">Seaking a:</label><br>
                        <select  name="seaking">
                            <option>Female</option>
                            <option selected>Male</option>
                        </select>
                    </div>

                    <div>
                        <label for="age-range-1">Between Ages:</label><br>
                        <select  name="age-range-1">
                          <?php 
                         $range = range(18,100);
                         foreach ($range as $agemin) {
                         echo "<option value='$agemin'>$agemin</option>";
                              }
                           ?>
                        </select> To
                        <select  name="age-range-2">
                             <?php 
                         $range = range(18,100);
                         foreach ($range as $agemax) {
                         echo "<option value='$agemax'>$agemax</option>";
                              }
                           ?>
                        </select>
                    </div>

                    <div>
                        <label for="located">Located:</label><br>
                        <input type="text" name="located">
                    </div>

                    <div>
                        <label for="keywords">Keywords:</label><br>
                        <input type="text" size="90" name = "keywords">
                        <input type="submit" value="SEARCH">
                    </div>

                    <div>
                        <input type="checkbox" name="photo">
                        <label for="photo">Photos Only</label>
                    </div>

                    <div>
                        <input type="checkbox" name="online">
                        <label for="online">Online Only</label>
                    </div>
                    <div style="clear: both"></div>
                    </form>
            </div>
        </section>

        <section id="friends">
            <h2>Browse Members</h2>
            <div class="photos">
            <?php 
           if($identifier == 1 && $refine == 0)
           {	
            $displaycounter = 0;
            $alldisplaycounter = 0;
            echo "<table><tr>";
        foreach($result as  $value) {
	        echo "<td id='display'>";
            echo'<img src="'.$value['picture'].'" id = "photo" >';
            echo "<br>";
           if($photo == 0)
             {
		     echo "<ins id = 'name'>".$value['last_name']."&nbsp".$value['first_name']."</ins>";
		     echo "<br>";
		     echo "<ins id = 'state'>".$value['state']."</ins>";
		     echo "<br>";
             }       
		  echo "<a href=" .'messages'. ">". Asset::img('mail.gif', array('id' => 'mail'))."</a>";
		  echo "<a href=" .'chat'. ">". Asset::img('chat.gif', array('id' => 'chat'))."</a>";
		  echo "<a href=" .'favorites'. ">". Asset::img('favorite.gif', array('id' => 'favorite'))."</a>";
		  echo "</td>";
		  $displaycounter++;
		  $alldisplaycounter++;
		  if($displaycounter == 5)
		   {
			$displaycounter = 0;
			echo "</tr></table>";
			echo "<table><tr>";
		   }
		  if($alldisplaycounter == 15)
		   {
			break;
		   }
          }
        } 
        if($identifier == 0 && $refine == 1)
            {	
             $displaycounter = 0;
             $alldisplaycounter = 0;
             echo "<table><tr>";
        foreach($refined as  $value) {
	        echo "<td id='display'>";
	        echo'<img src="'.$value['picture'].'" id = "photo" >';
            echo "<br>";
          if($photo !=10 && $photo !=12)
           {
		    echo "<ins id = 'name'>".$value['last_name']."&nbsp".$value['first_name']."</ins>";
		    echo "<br>";
		    echo "<ins id = 'state'>".$value['state']."</ins>";
		    echo "<br>";
           }       
		    echo "<a href=" .'messages'. ">". Asset::img('mail.gif', array('id' => 'mail'))."</a>";
		    echo "<a href=" .'chat'. ">". Asset::img('chat.gif', array('id' => 'chat'))."</a>";
		    echo "<a href=" .'favorites'. ">". Asset::img('favorite.gif', array('id' => 'favorite'))."</a>";
		    echo "</td>";
		    $displaycounter++;
		    $alldisplaycounter++;
		   if($displaycounter == 5)
		    {
			 $displaycounter = 0;
			 echo "</tr></table>";
			 echo "<table><tr>";
		    }
		   if($alldisplaycounter == 15)
		   {
			break;
		   }
          }
         }
      ?>
            
        </div>
        <div class="link"><a href="allbrowse">View All Members</a></div>
        </section>
        
        <section id="upgrade">
            <?php echo \Fuel\Core\Html::anchor('',\Fuel\Core\Asset::img(array('upgrade.png')))?>
        </section>

        <section id="refine-search">
            <h2>Refine Search</h2>
            <div class="quick-search">
                <form action = "refine" method = "post">
                    <div>
                        <label for="body">Body Type:</label><br>
                        <select  name="body">
                            <option selected>Athletic</option>
                            <option selected>Average</option>
                            <option selected>Overweight</option>
                            <option selected>Curvy</option>
                            <option selected>Above Average</option>
                            <option selected>Slim</option>
                        </select>
                    </div>
                    <div>
                        <label for="ethnicity">Ethnicity:</label><br>
                        <select  name="ethnicity">
                            <option selected>European</option>
                            <option selected>Latino</option>
                            <option selected>Black/African</option>
                            <option selected>Asian</option>
                            <option selected>White/Caucasian</option>
                            <option selected>Latino/Hispanic</option>
                            <option selected>Middle Eastern</option>
                            <option selected>Other</option>
                             
                        </select>
                    </div>
                    <div>
                        <label for="occupation">Occupation:</label><br>
                        <select  name="occupation">
                            <option selected>Administrative/Secretarial</option>
                            <option selected>Artistic/Creative/Performance</option>
                            <option selected>Executive/Management</option>
                            <option selected>Financial services</option>
                            <option selected>Labor/Construction</option>                          
                            <option selected>Medical/Dental/Veterinary</option>
                            <option selected>Sales/Marketing</option>
                            <option selected>Technical/Computers/Engineering</option>
                            <option selected>Travel/Hospitality/Transportation</option>
                            <option selected>Political/Govt/Civil Service/Military</option>
                            <option selected>Retail/Food services</option>
                            <option selected>Teacher/Professor</option>
                            <option selected>Student</option>
                            <option selected>Retired</option>
                            <option selected>Other profession</option>
                            <option selected>Legal</option>
                        </select>
                    </div>
                    <div>
                        <label for="faith">Faith:</label><br>
                        <select  name="faith">                        
                            <option selected>Other</option>
                            <option selected>Agnostic</option>
                            <option selected>Atheist</option>
                            <option selected>Buddhist/Taoist</option>                           
                            <option selected>Jewish</option>
                            <option selected>Hindu</option>
                            <option selected>Muslim/Islam</option>
                            <option selected>Spiritual but not religious</option>
                            <option selected>Christian/Other</option>
                            <option selected>Christian/Protestant</option>                         
                            <option selected>Christian/Catholic</option>
                                                      
                        </select>
                    </div>
                    <div>
                        <label for="kids">Kids:</label><br>
                        <select  name="kids">
                            <option>No</option>
                            <option selected>Yes</option>
                        </select>
                    </div>
                    <div class="submit"><input type="submit" value="SEARCH"> </div>
                </form>
            </div>
        </section>

    </div>
    
</div>
</body>
</html>