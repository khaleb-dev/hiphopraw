<!DOCTYPE HTML>
<html lang = "en-US">
<head>

<title>Browse</title>
<?php echo Asset::css('browse_view.css'); ?>
</head>
<body>
<div id="content" class="clearfix">
    <div id="middle">
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
          }
         }
      ?>
            
        </div>
        <div class="link"><a href="">Back</a></div>
        </section>
    </div>   
</div>
</body>
</html>
