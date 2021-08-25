<?php
function address_update () {
global $wpdb;

$facebook= isset($_POST["facebook"])?$_POST["facebook"]:'';
$tweet= isset($_POST["tweet"])?$_POST["tweet"]:'';
$email= isset($_POST["email"])?$_POST["email"]:'';
$vemo= isset($_POST["vemo"])?$_POST["vemo"]:'';
$pin= isset($_POST["pin"])?$_POST["pin"]:'';

//update
if(isset($_POST['update'])){	
	$wpdb->update(
		'address', //table
		array('name' => $name), //data
		array( 'ID' => $id ), //where
		array('%s'), //data format
		array('%s') //where format
	);	
		$wpdb->query( $wpdb->prepare(
			"UPDATE address SET facebook=%s, tweet =%s, email=%s, vemo=%s, pin=%s where id=%s",
			array($facebook,$tweet,$email, $vemo,$pin, 1)
			) );	
}
//selecting value to update	
else{ 
	$address = $wpdb->get_results($wpdb->prepare("SELECT * from address where id=%s",1));
	foreach ($address as $s ){
		$facebook = $s->facebook;
		$tweet = $s->tweet;
		$email = $s->email;
		$vemo = $s->vemo;
		$pin = $s->pin;
	}
}
?>
<link type="text/css" href="<?php echo WP_PLUGIN_URL; ?>/address/style-admin.css" rel="stylesheet" />
<div class="wrap">
<h2>Update Address</h2>

<?php if($_POST['update']) {?>
<div class="updated"><p>Update Successful!</p></div>

<?php } ?>
<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
	<table class='wp-list-table widefat fixed'>
	<tr><th>Email</th><td><input type="text" name="email" value="<?php echo $email;?>"/></td></tr>
	<tr><th>Facebook</th><td><input type="text" name="facebook" value="<?php echo $facebook;?>"/></td></tr>
	<tr><th>tweet</th><td><input type="text" name="tweet" value="<?php echo $tweet;?>"/></td></tr>
	<tr><th>Vemo</th><td><input type="text" name="vemo" value="<?php echo $vemo;?>"/></td></tr>
	<tr><th>Pinterest</th><td><input type="text" name="pin" value="<?php echo $pin;?>"/></td></tr>
	</table>
	<input type='submit' name="update" value='Update' class='button'>

</form>

</div>
<?php
}