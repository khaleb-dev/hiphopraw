<!DOCTYPE HTML>
<html lang = "en-US">
<head>
<title>Search</title>
<?php echo Asset::css('search_view.css'); ?>
</head>
<body>
<div id = "wrapper">
 <a href=""> <input type = "submit" id = "back" value = "BACK"></a>
<h3>All Latest Members</h3>
<div id= "content">
<?php 
//print_r($result['match1'][0]);
$displaycounter = 0;

if(!empty($result['match1'][0]))     //should contain at least one mysql result not to be empty
{
    echo "<table><tr>";
foreach($result['match1'] as  $value) {
	    echo "<td id='display'>";
        echo'<img src="'.$value['picture'].'" id = "photo" >';
        echo "<br>";
		echo "<ins id = 'name'>".$value['last_name']."&nbsp".$value['first_name']."</ins>";
		echo "<br>";
		echo "<ins id = 'state'>".$value['state']."</ins>";
		echo "<br>";
		echo "<a href=" .'messages'. ">". Asset::img('mail.gif', array('id' => 'mail'))."</a>";
		echo "<a href=" .'chat'. ">". Asset::img('chat.gif', array('id' => 'chat'))."</a>";
		echo "<a href=" .'favorites'. ">". Asset::img('favorite.gif', array('id' => 'favorite'))."</a>";
		echo "</td>";
		$displaycounter++;
		if($displaycounter == 4)
		{
			$displaycounter = 0;
			echo "</tr></table>";
			echo "<table><tr>";
		}
}

}

if(!empty($result['match2'][0]))
{
foreach($result['match2'] as  $value) {
	    echo "<td id='display'></rb>";
        echo'<img src="'.$value['picture'].'" id = "photo" >';
        echo "<br>";
		echo "<ins id = 'name'>".$value['last_name']."&nbsp".$value['first_name']."</ins>";
		echo "<br>";
		echo "<ins id = 'state'>".$value['state']."</ins>";
		echo "<br>";
		echo "<a href=" .'messages'. ">". Asset::img('mail.gif', array('id' => 'mail'))."</a>";
		echo "<a href=" .'chat'. ">". Asset::img('chat.gif', array('id' => 'chat'))."</a>";
		echo "<a href=" .'favorites'. ">". Asset::img('favorite.gif', array('id' => 'favorite'))."</a>";
		echo "</td>";
		$displaycounter++;
		if($displaycounter == 4)
		{
			$displaycounter = 0;
			echo "</tr></table>";
			echo "<table><tr>";
		}
}

}

if(!empty($result['match3'][0]))
{
foreach($result['match3'] as  $value) {
	    echo "<td id='display'></rb>";
        echo'<img src="'.$value['picture'].'" id = "photo" >';
        echo "<br>";
		echo "<ins id = 'name'>".$value['last_name']."&nbsp".$value['first_name']."</ins>";
		echo "<br>";
		echo "<ins id = 'state'>".$value['state']."</ins>";
		echo "<br>";
		echo "<a href=" .'messages'. ">". Asset::img('mail.gif', array('id' => 'mail'))."</a>";
		echo "<a href=" .'chat'. ">". Asset::img('chat.gif', array('id' => 'chat'))."</a>";
		echo "<a href=" .'favorites'. ">". Asset::img('favorite.gif', array('id' => 'favorite'))."</a>";
		echo "</td>";
		$displaycounter++;
		if($displaycounter == 4)
		{
			$displaycounter = 0;
			echo "</tr></table>";
			echo "<table><tr>";
		}
}

}

if(!empty($result['match4'][0]))
{
	foreach($result['match4'] as  $value) {
	    echo "<td id='display'></rb>";
	    echo'<img src="'.$value['picture'].'" id = "photo" >';
        echo "<br>";
		echo "<ins id = 'name'>".$value['last_name']."&nbsp".$value['first_name']."</ins>";
		echo "<br>";
		echo "<ins id = 'state'>".$value['state']."</ins>";
		echo "<br>";
		echo "<a href=" .'messages'. ">". Asset::img('mail.gif', array('id' => 'mail'))."</a>";
		echo "<a href=" .'chat'. ">". Asset::img('chat.gif', array('id' => 'chat'))."</a>";
		echo "<a href=" .'favorites'. ">". Asset::img('favorite.gif', array('id' => 'favorite'))."</a>";
		echo "</td>";
		$displaycounter++;
		if($displaycounter == 4)
		{
			$displaycounter = 0;
			echo "</tr></table>";
			echo "<table><tr>";
		}
}

}

if(!empty($result['match5'][0]))
{
	
foreach($result['match5'] as  $value) {
	    echo "<td id='display'></rb>";
	    echo'<img src="'.$value['picture'].'" id = "photo" >';
        echo "<br>";
		echo "<ins id = 'name'>".$value['last_name']."&nbsp".$value['first_name']."</ins>";
		echo "<br>";
		echo "<ins id = 'state'>".$value['state']."</ins>";
		echo "<br>";
		echo "<a href=" .'messages'. ">". Asset::img('mail.gif', array('id' => 'mail'))."</a>";
		echo "<a href=" .'chat'. ">". Asset::img('chat.gif', array('id' => 'chat'))."</a>";
		echo "<a href=" .'favorites'. ">". Asset::img('favorite.gif', array('id' => 'favorite'))."</a>";
		echo "</td>";
		$displaycounter++;
		if($displaycounter == 4)
		{
			$displaycounter = 0;
			echo "</tr></table>";
			echo "<table><tr>";
		}
}

}

if(!empty($result['match6'][0]))
{
foreach($result['match6'] as  $value) {
	    echo "<td id='display'></rb>";
        echo'<img src="'.$value['picture'].'" id = "photo" >';
        echo "<br>";
		echo "<ins id = 'name'>".$value['last_name']."&nbsp".$value['first_name']."</ins>";
		echo "<br>";
		echo "<ins id = 'state'>".$value['state']."</ins>";
		echo "<br>";
		echo "<a href=" .'messages'. ">". Asset::img('mail.gif', array('id' => 'mail'))."</a>";
		echo "<a href=" .'chat'. ">". Asset::img('chat.gif', array('id' => 'chat'))."</a>";
		echo "<a href=" .'favorites'. ">". Asset::img('favorite.gif', array('id' => 'favorite'))."</a>";
		echo "</td>";
		$displaycounter++;
		if($displaycounter == 4)
		{
			$displaycounter = 0;
			echo "</tr></table>";
			echo "<table><tr>";
		}
}

}

if(!empty($result['match7'][0]))
{
	
foreach($result['match7'] as  $value) {
	    echo "<td id='display'></rb>";
	    echo'<img src="'.$value['picture'].'" id = "photo" >';
        echo "<br>";
		echo "<ins id = 'name'>".$value['last_name']."&nbsp".$value['first_name']."</ins>";
		echo "<br>";
		echo "<ins id = 'state'>".$value['state']."</ins>";
		echo "<br>";
		echo "<a href=" .'messages'. ">". Asset::img('mail.gif', array('id' => 'mail'))."</a>";
		echo "<a href=" .'chat'. ">". Asset::img('chat.gif', array('id' => 'chat'))."</a>";
		echo "<a href=" .'favorites'. ">". Asset::img('favorite.gif', array('id' => 'favorite'))."</a>";
		echo "</td>";
		$displaycounter++;
		if($displaycounter == 4)
		{
			$displaycounter = 0;
			echo "</tr></table>";
			echo "<table><tr>";
		}
}

}

if(!empty($result['match8'][0]))
{
foreach($result['match8'] as  $value) {
	    echo "<td id='display'></rb>";
	    echo'<img src="'.$value['picture'].'" id = "photo" >';
        echo "<br>";
		echo "<ins id = 'name'>".$value['last_name']."&nbsp".$value['first_name']."</ins>";
		echo "<br>";
		echo "<ins id = 'state'>".$value['state']."</ins>";
		echo "<br>";
		echo "<a href=" .'messages'. ">". Asset::img('mail.gif', array('id' => 'mail'))."</a>";
		echo "<a href=" .'chat'. ">". Asset::img('chat.gif', array('id' => 'chat'))."</a>";
		echo "<a href=" .'favorites'. ">". Asset::img('favorite.gif', array('id' => 'favorite'))."</a>";
		echo "</td>";
		$displaycounter++;
		if($displaycounter == 4)
		{
			$displaycounter = 0;
			echo "</tr></table>";
			echo "<table><tr>";
		}
}

}

if(!empty($result['match9'][0]))
{
foreach($result['match9'] as  $value) {
	    echo "<td id='display'></rb>";
        echo'<img src="'.$value['picture'].'" id = "photo" >';
        echo "<br>";
		echo "<ins id = 'name'>".$value['last_name']."&nbsp".$value['first_name']."</ins>";
		echo "<br>";
		echo "<ins id = 'state'>".$value['state']."</ins>";
		echo "<br>";
		echo "<a href=" .'messages'. ">". Asset::img('mail.gif', array('id' => 'mail'))."</a>";
		echo "<a href=" .'chat'. ">". Asset::img('chat.gif', array('id' => 'chat'))."</a>";
		echo "<a href=" .'favorites'. ">". Asset::img('favorite.gif', array('id' => 'favorite'))."</a>";
		echo "</td>";
		$displaycounter++;
		if($displaycounter == 4)
		{
			$displaycounter = 0;
			echo "</tr></table>";
			echo "<table><tr>";
		}

}

}

if(!empty($result['match10'][0]))
{
foreach($result['match10'] as  $value) {
	    echo "<td id='display'></rb>";
	    echo'<img src="'.$value['picture'].'" id = "photo" >';
        echo "<br>";
		echo "<ins id = 'name'>".$value['last_name']."&nbsp".$value['first_name']."</ins>";
		echo "<br>";
		echo "<ins id = 'state'>".$value['state']."</ins>";
		echo "<br>";
		echo "<a href=" .'messages'. ">". Asset::img('mail.gif', array('id' => 'mail'))."</a>";
		echo "<a href=" .'chat'. ">". Asset::img('chat.gif', array('id' => 'chat'))."</a>";
		echo "<a href=" .'favorites'. ">". Asset::img('favorite.gif', array('id' => 'favorite'))."</a>";
		echo "</td>";
		$displaycounter++;
		if($displaycounter == 4)
		{
			$displaycounter = 0;
			echo "</tr></table>";
			echo "<table><tr>";
		}

}

}

if(!empty($result['match11'][0]))
{
foreach($result['match11'] as  $value) {
	    echo "<td id='display'></rb>";
	    echo'<img src="'.$value['picture'].'" id = "photo" >';
        echo "<br>";
		echo "<ins id = 'name'>".$value['last_name']."&nbsp".$value['first_name']."</ins>";
		echo "<br>";
		echo "<ins id = 'state'>".$value['state']."</ins>";
		echo "<br>";
		echo "<a href=" .'messages'. ">". Asset::img('mail.gif', array('id' => 'mail'))."</a>";
		echo "<a href=" .'chat'. ">". Asset::img('chat.gif', array('id' => 'chat'))."</a>";
		echo "<a href=" .'favorites'. ">". Asset::img('favorite.gif', array('id' => 'favorite'))."</a>";
		echo "</td>";
		$displaycounter++;
		if($displaycounter == 4)
		{
			$displaycounter = 0;
			echo "</tr></table>";
			echo "<table><tr>";
		}

}

}

if(!empty($result['match12'][0]))
{

foreach($result['match12'] as  $value) {
	    echo "<td id='display'></rb>";
        echo'<img src="'.$value['picture'].'" id = "photo" >';
        echo "<br>";
		echo "<ins id = 'name'>".$value['last_name']."&nbsp".$value['first_name']."</ins>";
		echo "<br>";
		echo "<ins id = 'state'>".$value['state']."</ins>";
		echo "<br>";
		echo "<a href=" .'messages'. ">". Asset::img('mail.gif', array('id' => 'mail'))."</a>";
		echo "<a href=" .'chat'. ">". Asset::img('chat.gif', array('id' => 'chat'))."</a>";
		echo "<a href=" .'favorites'. ">". Asset::img('favorite.gif', array('id' => 'favorite'))."</a>";
		echo "</td>";
		$displaycounter++;
		if($displaycounter == 4)
		{
			$displaycounter = 0;
			echo "</tr></table>";
			echo "<table><tr>";
		}

}

}

if(!empty($result['match13'][0]))
{

foreach($result['match13'] as  $value) {
	    echo "<td id='display'></rb>";
         echo'<img src="'.$value['picture'].'" id = "photo" >';
        echo "<br>";
		echo "<ins id = 'name'>".$value['last_name']."&nbsp".$value['first_name']."</ins>";
		echo "<br>";
		echo "<ins id = 'state'>".$value['state']."</ins>";
		echo "<br>";
		echo "<a href=" .'messages'. ">". Asset::img('mail.gif', array('id' => 'mail'))."</a>";
		echo "<a href=" .'chat'. ">". Asset::img('chat.gif', array('id' => 'chat'))."</a>";
		echo "<a href=" .'favorites'. ">". Asset::img('favorite.gif', array('id' => 'favorite'))."</a>";
		echo "</td>";
		$displaycounter++;
		if($displaycounter == 4)
		{
			$displaycounter = 0;
			echo "</tr></table>";
			echo "<table><tr>";
		}
}

}

if(!empty($result['match14'][0]))
{

foreach($result['match14'] as  $value) {
	    echo "<td id='display'></rb>";
        echo'<img src="'.$value['picture'].'" id = "photo" >';
        echo "<br>";
		echo "<ins id = 'name'>".$value['last_name']."&nbsp".$value['first_name']."</ins>";
		echo "<br>";
		echo "<ins id = 'state'>".$value['state']."</ins>";
		echo "<br>";
		echo "<a href=" .'messages'. ">". Asset::img('mail.gif', array('id' => 'mail'))."</a>";
		echo "<a href=" .'chat'. ">". Asset::img('chat.gif', array('id' => 'chat'))."</a>";
		echo "<a href=" .'favorites'. ">". Asset::img('favorite.gif', array('id' => 'favorite'))."</a>";
		echo "</td>";
		$displaycounter++;
		if($displaycounter == 4)
		{
			$displaycounter = 0;
			echo "</tr></table>";
			echo "<table><tr>";
		}

}

}

if(!empty($result['match15'][0]))
{
foreach($result['match15'] as  $value) {
	    echo "<td id='display'></rb>";
	    echo'<img src="'.$value['picture'].'" id = "photo" >';
        echo "<br>";
		echo "<ins id = 'name'>".$value['last_name']."&nbsp".$value['first_name']."</ins>";
		echo "<br>";
		echo "<ins id = 'state'>".$value['state']."</ins>";
		echo "<br>";
		echo "<a href=" .'messages'. ">". Asset::img('mail.gif', array('id' => 'mail'))."</a>";
		echo "<a href=" .'chat'. ">". Asset::img('chat.gif', array('id' => 'chat'))."</a>";
		echo "<a href=" .'favorites'. ">". Asset::img('favorite.gif', array('id' => 'favorite'))."</a>";
		echo "</td>";
		$displaycounter++;
		if($displaycounter == 4)
		{
			$displaycounter = 0;
			echo "</tr></table>";
			echo "<table><tr>";
		}

}

}

if(!empty($result['match16'][0]))
{
foreach($result['match16'] as  $value) {
	    echo "<td id='display'></rb>";
        echo'<img src="'.$value['picture'].'" id = "photo" >';
        echo "<br>";
		echo "<ins id = 'name'>".$value['last_name']."&nbsp".$value['first_name']."</ins>";
		echo "<br>";
		echo "<ins id = 'state'>".$value['state']."</ins>";
		echo "<br>";
		echo "<a href=" .'messages'. ">". Asset::img('mail.gif', array('id' => 'mail'))."</a>";
		echo "<a href=" .'chat'. ">". Asset::img('chat.gif', array('id' => 'chat'))."</a>";
		echo "<a href=" .'favorites'. ">". Asset::img('favorite.gif', array('id' => 'favorite'))."</a>";
		echo "</td>";
		$displaycounter++;
		if($displaycounter == 4)
		{
			$displaycounter = 0;
			echo "</tr></table>";
			echo "<table><tr>";
		}
}

}

if(!empty($result['match17'][0]))
{

foreach($result['match17'] as  $value) {
	    echo "<td id='display'></rb>";
        echo'<img src="'.$value['picture'].'" id = "photo" >';
        echo "<br>";
		echo "<ins id = 'name'>".$value['last_name']."&nbsp".$value['first_name']."</ins>";
		echo "<br>";
		echo "<ins id = 'state'>".$value['state']."</ins>";
		echo "<br>";
		echo "<a href=" .'messages'. ">". Asset::img('mail.gif', array('id' => 'mail'))."</a>";
		echo "<a href=" .'chat'. ">". Asset::img('chat.gif', array('id' => 'chat'))."</a>";
		echo "<a href=" .'favorites'. ">". Asset::img('favorite.gif', array('id' => 'favorite'))."</a>";
		echo "</td>";
		$displaycounter++;
		if($displaycounter == 4)
		{
			$displaycounter = 0;
			echo "</tr></table>";
			echo "<table><tr>";
		}
}

}

if(!empty($result['match18'][0]))
{
foreach($result['match18'] as  $value) {
	    echo "<td id='display'></rb>";
	    echo'<img src="'.$value['picture'].'" id = "photo" >';
        echo "<br>";
		echo "<ins id = 'name'>".$value['last_name']."&nbsp".$value['first_name']."</ins>";
		echo "<br>";
		echo "<ins id = 'state'>".$value['state']."</ins>";
		echo "<br>";
		echo "<a href=" .'messages'. ">". Asset::img('mail.gif', array('id' => 'mail'))."</a>";
		echo "<a href=" .'chat'. ">". Asset::img('chat.gif', array('id' => 'chat'))."</a>";
		echo "<a href=" .'favorites'. ">". Asset::img('favorite.gif', array('id' => 'favorite'))."</a>";
		echo "</td>";
		$displaycounter++;
		if($displaycounter == 4)
		{
			$displaycounter = 0;
			echo "</tr></table>";
			echo "<table><tr>";
		}

}

}

if(!empty($result['match19'][0]))
{
foreach($result['match19'] as  $value) {
	    echo "<td id='display'></rb>";
	    echo'<img src="'.$value['picture'].'" id = "photo" >';
        echo "<br>";
		echo "<ins id = 'name'>".$value['last_name']."&nbsp".$value['first_name']."</ins>";
		echo "<br>";
		echo "<ins id = 'state'>".$value['state']."</ins>";
		echo "<br>";
		echo "<a href=" .'messages'. ">". Asset::img('mail.gif', array('id' => 'mail'))."</a>";
		echo "<a href=" .'chat'. ">". Asset::img('chat.gif', array('id' => 'chat'))."</a>";
		echo "<a href=" .'favorites'. ">". Asset::img('favorite.gif', array('id' => 'favorite'))."</a>";
		echo "</td>";
		$displaycounter++;
		if($displaycounter == 4)
		{
			$displaycounter = 0;
			echo "</tr></table>";
			echo "<table><tr>";
		}

}

}

if(!empty($result['match20'][0]))
{
foreach($result['match20'] as  $value) {
	    echo "<td id='display'></rb>";
	    echo'<img src="'.$value['picture'].'" id = "photo" >';
        echo "<br>";
		echo "<ins id = 'name'>".$value['last_name']."&nbsp".$value['first_name']."</ins>";
		echo "<br>";
		echo "<ins id = 'state'>".$value['state']."</ins>";
		echo "<br>";
		echo "<a href=" .'messages'. ">". Asset::img('mail.gif', array('id' => 'mail'))."</a>";
		echo "<a href=" .'chat'. ">". Asset::img('chat.gif', array('id' => 'chat'))."</a>";
		echo "<a href=" .'favorites'. ">". Asset::img('favorite.gif', array('id' => 'favorite'))."</a>";
		echo "</td>";
		$displaycounter++;
		if($displaycounter == 4)
		{
			$displaycounter = 0;
			echo "</tr></table>";
			echo "<table><tr>";
		}
}

}

if(!empty($result['match21'][0]))
{
foreach($result['match21'] as  $value) {
	    echo "<td id='display'></rb>";
	    echo'<img src="'.$value['picture'].'" id = "photo" >';
        echo "<br>";
		echo "<ins id = 'name'>".$value['last_name']."&nbsp".$value['first_name']."</ins>";
		echo "<br>";
		echo "<ins id = 'state'>".$value['state']."</ins>";
		echo "<br>";
		echo "<a href=" .'messages'. ">". Asset::img('mail.gif', array('id' => 'mail'))."</a>";
		echo "<a href=" .'chat'. ">". Asset::img('chat.gif', array('id' => 'chat'))."</a>";
		echo "<a href=" .'favorites'. ">". Asset::img('favorite.gif', array('id' => 'favorite'))."</a>";
		echo "</td>";
		$displaycounter++;
		if($displaycounter == 4)
		{
			$displaycounter = 0;
			echo "</tr></table>";
			echo "<table><tr>";
		}
}

}

if(!empty($result['match22'][0]))
{
foreach($result['match22'] as  $value) {
	    echo "<td id='display'></rb>";
	    echo'<img src="'.$value['picture'].'" id = "photo" >';
        echo "<br>";
		echo "<ins id = 'name'>".$value['last_name']."&nbsp".$value['first_name']."</ins>";
		echo "<br>";
		echo "<ins id = 'state'>".$value['state']."</ins>";
		echo "<br>";
		echo "<a href=" .'messages'. ">". Asset::img('mail.gif', array('id' => 'mail'))."</a>";
		echo "<a href=" .'chat'. ">". Asset::img('chat.gif', array('id' => 'chat'))."</a>";
		echo "<a href=" .'favorites'. ">". Asset::img('favorite.gif', array('id' => 'favorite'))."</a>";
		echo "</td>";
		$displaycounter++;
		if($displaycounter == 4)
		{
			$displaycounter = 0;
			echo "</tr></table>";
			echo "<table><tr>";
		}
}

}

if(!empty($result['match23'][0]))
{
foreach($result['match23'] as  $value) {
	    echo "<td id='display'></rb>";
	    echo'<img src="'.$value['picture'].'" id = "photo" >';
        echo "<br>";
		echo "<ins id = 'name'>".$value['last_name']."&nbsp".$value['first_name']."</ins>";
		echo "<br>";
		echo "<ins id = 'state'>".$value['state']."</ins>";
		echo "<br>";
		echo "<a href=" .'messages'. ">". Asset::img('mail.gif', array('id' => 'mail'))."</a>";
		echo "<a href=" .'chat'. ">". Asset::img('chat.gif', array('id' => 'chat'))."</a>";
		echo "<a href=" .'favorites'. ">". Asset::img('favorite.gif', array('id' => 'favorite'))."</a>";
		echo "</td>";
		$displaycounter++;
		if($displaycounter == 4)
		{
			$displaycounter = 0;
			echo "</tr></table>";
			echo "<table><tr>";
		}

}

}

if(!empty($result['match24'][0]))
{
foreach($result['match24'] as  $value) {
	    echo "<td id='display'></rb>";
	    echo'<img src="'.$value['picture'].'" id = "photo" >';
        echo "<br>";
		echo "<ins id = 'name'>".$value['last_name']."&nbsp".$value['first_name']."</ins>";
		echo "<br>";
		echo "<ins id = 'state'>".$value['state']."</ins>";
		echo "<br>";
		echo "<a href=" .'messages'. ">". Asset::img('mail.gif', array('id' => 'mail'))."</a>";
		echo "<a href=" .'chat'. ">". Asset::img('chat.gif', array('id' => 'chat'))."</a>";
		echo "<a href=" .'favorites'. ">". Asset::img('favorite.gif', array('id' => 'favorite'))."</a>";
		echo "</td>";
		$displaycounter++;
		if($displaycounter == 4)
		{
			$displaycounter = 0;
			echo "</tr></table>";
			echo "<table><tr>";
		}
	
}

}

if(!empty($result['match25'][0]))
{
foreach($result['match25'] as  $value) {
	    echo "<td id='display'></rb>";
	    echo'<img src="'.$value['picture'].'" id = "photo" >';
        echo "<br>";
		echo "<ins id = 'name'>".$value['last_name']."&nbsp".$value['first_name']."</ins>";
		echo "<br>";
		echo "<ins id = 'state'>".$value['state']."</ins>";
		echo "<br>";
		echo "<a href=" .'messages'. ">". Asset::img('mail.gif', array('id' => 'mail'))."</a>";
		echo "<a href=" .'chat'. ">". Asset::img('chat.gif', array('id' => 'chat'))."</a>";
		echo "<a href=" .'favorites'. ">". Asset::img('favorite.gif', array('id' => 'favorite'))."</a>";
		echo "</td>";
		$displaycounter++;
		if($displaycounter == 4)
		{
			$displaycounter = 0;
			echo "</tr></table>";
			echo "<table><tr>";
		}
	
}

}

if(!empty($result['match26'][0]))
{
foreach($result['match26'] as  $value) {
	    echo "<td id='display'></rb>";
	    echo'<img src="'.$value['picture'].'" id = "photo" >';
        echo "<br>";
		echo "<ins id = 'name'>".$value['last_name']."&nbsp".$value['first_name']."</ins>";
		echo "<br>";
		echo "<ins id = 'state'>".$value['state']."</ins>";
		echo "<br>";
		echo "<a href=" .'messages'. ">". Asset::img('mail.gif', array('id' => 'mail'))."</a>";
		echo "<a href=" .'chat'. ">". Asset::img('chat.gif', array('id' => 'chat'))."</a>";
		echo "<a href=" .'favorites'. ">". Asset::img('favorite.gif', array('id' => 'favorite'))."</a>";
		echo "</td>";
		$displaycounter++;
		if($displaycounter == 4)
		{
			$displaycounter = 0;
			echo "</tr></table>";
			echo "<table><tr>";
		}
	
}

}

if(!empty($result['match27'][0]))
{
foreach($result['match27'] as  $value) {
	    echo "<td id='display'></rb>";
	    echo'<img src="'.$value['picture'].'" id = "photo" >';
        echo "<br>";
		echo "<ins id = 'name'>".$value['last_name']."&nbsp".$value['first_name']."</ins>";
		echo "<br>";
		echo "<ins id = 'state'>".$value['state']."</ins>";
		echo "<br>";
		echo "<a href=" .'messages'. ">". Asset::img('mail.gif', array('id' => 'mail'))."</a>";
		echo "<a href=" .'chat'. ">". Asset::img('chat.gif', array('id' => 'chat'))."</a>";
		echo "<a href=" .'favorites'. ">". Asset::img('favorite.gif', array('id' => 'favorite'))."</a>";
		echo "</td>";
		$displaycounter++;
		if($displaycounter == 4)
		{
			$displaycounter = 0;
			echo "</tr></table>";
			echo "<table><tr>";
		}
	
}

}

if(!empty($result['match28'][0]))
{
foreach($result['match28'] as  $value) {
	    echo "<td id='display'></rb>";
        echo'<img src="'.$value['picture'].'" id = "photo" >';
        echo "<br>";
		echo "<ins id = 'name'>".$value['last_name']."&nbsp".$value['first_name']."</ins>";
		echo "<br>";
		echo "<ins id = 'state'>".$value['state']."</ins>";
		echo "<br>";
		echo "<a href=" .'messages'. ">". Asset::img('mail.gif', array('id' => 'mail'))."</a>";
		echo "<a href=" .'chat'. ">". Asset::img('chat.gif', array('id' => 'chat'))."</a>";
		echo "<a href=" .'favorites'. ">". Asset::img('favorite.gif', array('id' => 'favorite'))."</a>";
		echo "</td>";
		$displaycounter++;
		if($displaycounter == 4)
		{
			$displaycounter = 0;
			echo "</tr></table>";
			echo "<table><tr>";
		}
	
}

}

if(!empty($result['match29'][0]))
{
	
foreach($result['match29'] as  $value) {
	    echo "<td id='display'></rb>";
	    echo'<img src="'.$value['picture'].'" id = "photo" >';
        echo "<br>";
		echo "<ins id = 'name'>".$value['last_name']."&nbsp".$value['first_name']."</ins>";
		echo "<br>";
		echo "<ins id = 'state'>".$value['state']."</ins>";
		echo "<br>";
		echo "<a href=" .'messages'. ">". Asset::img('mail.gif', array('id' => 'mail'))."</a>";
		echo "<a href=" .'chat'. ">". Asset::img('chat.gif', array('id' => 'chat'))."</a>";
		echo "<a href=" .'favorites'. ">". Asset::img('favorite.gif', array('id' => 'favorite'))."</a>";
		echo "</td>";
		$displaycounter++;
		if($displaycounter == 4)
		{
			$displaycounter = 0;
			echo "</tr></table>";
			echo "<table><tr>";
		}
	
}

}

if(!empty($result['match30'][0]))
{
foreach($result['match30'] as  $value) {
	    echo "<td id='display'></rb>";
	    echo'<img src="'.$value['picture'].'" id = "photo" >';
        echo "<br>";
		echo "<ins id = 'name'>".$value['last_name']."&nbsp".$value['first_name']."</ins>";
		echo "<br>";
		echo "<ins id = 'state'>".$value['state']."</ins>";
		echo "<br>";
		echo "<a href=" .'messages'. ">". Asset::img('mail.gif', array('id' => 'mail'))."</a>";
		echo "<a href=" .'chat'. ">". Asset::img('chat.gif', array('id' => 'chat'))."</a>";
		echo "<a href=" .'favorites'. ">". Asset::img('favorite.gif', array('id' => 'favorite'))."</a>";
		echo "</td>";
		$displaycounter++;
		if($displaycounter == 4)
		{
			$displaycounter = 0;
			echo "</tr></table>";
			echo "<table><tr>";
		}
	
}

}

if(!empty($result['match31'][0]))
{
foreach($result['match31'] as  $value) {
	    echo "<td id='display'></rb>";
	    echo'<img src="'.$value['picture'].'" id = "photo" >';
        echo "<br>";
		echo "<ins id = 'name'>".$value['last_name']."&nbsp".$value['first_name']."</ins>";
		echo "<br>";
		echo "<ins id = 'state'>".$value['state']."</ins>";
		echo "<br>";
		echo "<a href=" .'messages'. ">". Asset::img('mail.gif', array('id' => 'mail'))."</a>";
		echo "<a href=" .'chat'. ">". Asset::img('chat.gif', array('id' => 'chat'))."</a>";
		echo "<a href=" .'favorites'. ">". Asset::img('favorite.gif', array('id' => 'favorite'))."</a>";
		echo "</td>";
		$displaycounter++;
		if($displaycounter == 4)
		{
			$displaycounter = 0;
			echo "</tr></table>";
			echo "<table><tr>";
		}
	
}

}

?>
 </div>
 </div>
</body>
</html>