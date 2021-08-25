<?php
/**
 * Fuel is a fast, lightweight, community driven PHP5 framework.
 *
 * @package    Fuel
 * @version    1.5
 * @author     Fuel Development Team
 * @license    MIT License
 * @copyright  2010 - 2013 Fuel Development Team
 * @link       http://fuelphp.com
 */

/**
 * Set error reporting and display errors settings.  You will want to change these when in production.
 */
error_reporting(-1);
ini_set('display_errors', 1);

/**
 * Website document root
 */
define('DOCROOT', __DIR__.DIRECTORY_SEPARATOR);

/**
 * Path to the application directory.
 */
define('APPPATH', realpath(__DIR__.'/../fuel/app/').DIRECTORY_SEPARATOR);

/**
 * Path to the default packages directory.
 */
define('PKGPATH', realpath(__DIR__.'/../fuel/packages/').DIRECTORY_SEPARATOR);

/**
 * The path to the framework core.
 */
define('COREPATH', realpath(__DIR__.'/../fuel/core/').DIRECTORY_SEPARATOR);

// Get the start time and memory for use later
defined('FUEL_START_TIME') or define('FUEL_START_TIME', microtime(true));
defined('FUEL_START_MEM') or define('FUEL_START_MEM', memory_get_usage());

// Boot the app
require APPPATH.'bootstrap.php';



/**
 * Adding a bypass, to skip the interface garbage fuelphp does, so you can do some AJAX/API shit, without all that ugly HTML getting in the way!
 * Added By: Jonathan Will 10/25/2013
 */
if(isset($_REQUEST['bypass_fuel_mode']) && intval($_REQUEST['bypass_fuel_mode']) > 0){
	
	
	
	///echo "fuck you, fuelphp, <3 phreak";
	
	$model_contest = new Model_Contest();
	
// 	$contest = $model_contest->getByID(20);
	// 	print_r($contest);
	
	
	//$video_id = intval($_REQUEST['video_id']);
	
	if(Auth::check()){
		list($driver, $user_id) = Auth::get_user_id();
	
		$current_user = Model_User::find($user_id);
	} else {
		$current_user = null;
	}
	
	View::set_global('current_user', $current_user);
	
	if(		$current_user != null && 
			isset($_REQUEST['contest_id']) && 
			isset($_REQUEST['video_id']) && 
			isset($_REQUEST['rating']) &&
			isset($_REQUEST['round'])
	){
	
	// VARIABLE GATHERING	
		
		//echo $user_id;
		
		$contest_id = intval($_REQUEST['contest_id']);
		$video_id = intval($_REQUEST['video_id']);
		$rating = intval($_REQUEST['rating']);
		$round = intval($_REQUEST['round']);
		
	// LOOK UP THE VOTES TABLE FOR THE CURRENT USER, THE CONTEST ID, VIDEO ID
	
		// GET THE CURRENT HIT COUNT
		
		
		
		// CHECK IF THEY VOTED ON THIS VIDEO FOR THIS CONTEST, IN THIS ROUND
		list($has_voted,$vote) = $model_contest->hasVotedAlready($contest_id, $round, $video_id, $user_id);
		
		// IF THEY VOTED ALREADY, ERROR (BUT STILL UPDATE THE CURRENT COUNT)
		if($has_voted > 0){
			
			$current_rating = $model_contest->getVideoContestVotes($contest_id, $round, $video_id);
			
			echo "-1:".$current_rating.":Error:You have already voted (".$vote.") on this video, for this round.";
			
		}else{	
		
			// IF NOT, LOG THE VOTE
			
			$model_contest->postVote($contest_id, $round, $video_id, $user_id, $rating);
			
			// GET THE CURRENT HIT COUNT AGAIN
			$current_rating = $model_contest->getVideoContestVotes($contest_id, $round, $video_id);
			
			// RETURN SUCCESS WITH CURRENT COUNT
			
			echo "1:".$current_rating.":Success:Your vote has been added.";
		}		
		
		
	// NOT LOGGED IN - CANT VOTE - ERROR OUT
	}else{
		
		echo "-1:0:Error:Not logged in, or fields not specified.";
		
	}
	
	
	exit;
}





// Generate the request, execute it and send the output.
try
{
	$response = Request::forge()->execute()->response();
}
catch (HttpNotFoundException $e)
{
	$route = array_key_exists('_404_', Router::$routes) ? Router::$routes['_404_']->translation : Config::get('routes._404_');

	if($route instanceof Closure)
	{
		$response = $route();

		if( ! $response instanceof Response)
		{
			$response = Response::forge($response);
		}
	}
	elseif ($route)
	{
		$response = Request::forge($route, false)->execute()->response();
	}
	else
	{
		throw $e;
	}
}

// This will add the execution time and memory usage to the output.
// Comment this out if you don't use it.
$bm = Profiler::app_total();
$response->body(
	str_replace(
		array('{exec_time}', '{mem_usage}'),
		array(round($bm[0], 4), round($bm[1] / pow(1024, 2), 3)),
		$response->body()
	)
);

$response->send(true);
