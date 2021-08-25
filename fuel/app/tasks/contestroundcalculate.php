<?php

namespace Fuel\Tasks;

class Contestroundcalculate
{

	/**
	 * This method gets ran when a valid method name is not used in the command.
	 *
	 * Usage (from command line):
	 *
	 * php oil r contestroundcalculate
	 *
	 * @return string
	 */
	public static function run($args = NULL)
	{
		

		/***************************
		 Put in TASK DETAILS HERE
		 **************************/
		
		echo date("H:i:s m/d/Y")." Running Contest Round Calculations\n";
		
		$model_contest = new \Model_Contest();
		
		$model_contest->computeEndofRounds();
		
		echo date("H:i:s m/d/Y")." Round Calculation COMPLETE \n";
	}


	/**
	 * This method gets ran when a valid method name is not used in the command.
	 *
	 * Usage (from command line):
	 *
	 * php oil r contestroundcalculate:resetContest "CONTESTID,ROUNDID"
	 * example: php oil r contestroundcalculate:resetContest "3,1"
	 * 
	 *
	 * @return string
	 */
	public static function resetContest($args = null){
		
		if($args == null){
			echo "Please provide arguments.\n";
			echo "<cmd> \"<contestID>,<resetToRound#>\"\n";
			return;
		}
		
		$arr = preg_split("/,/",$args);
		
		if(count($arr) < 2){
			echo "Please provide arguments.\n";
			echo "<cmd> \"<contestID>,<resetToRound#>\"\n";
			return;
		}
		
		##print_r($arr);
		
		$model_contest = new \Model_Contest();
		$model_contest->resetContest($arr[0], $arr[1]);
	}
	

	/**
	 * This method gets ran when a valid method name is not used in the command.
	 *
	 * Usage (from command line):
	 *
	 * php oil r contestroundcalculate:index "arguments"
	 *
	 * @return string
	 */
	public static function index($args = NULL)
	{
		echo "\n===========================================";
		echo "\nRunning task [Contestroundcalculate:Index]";
		echo "\n-------------------------------------------\n\n";

		
		
	}

}
/* End of file tasks/contestroundcalculate.php */
