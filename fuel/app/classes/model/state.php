
<?php

class Model_State extends \Orm\Model
{
	protected static $_properties = array(
		'id',
		'state_name',
	);

    public static function getStates(){
        $states = array();

        foreach(Model_State::find("all") as $state){
            $states[$state->id] = $state->state_name;
        }
        return $states;
    }

	protected static $_table_name = 'states';

}
