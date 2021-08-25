<?php

class CustomRules
{
    // note this is a static method
    public static function _validation_multiple_emails($val)
    {

		$emails = explode(",", $val);

		$email_pattern = "/^\S+@\S+\.\S+$/";

        foreach($emails as $email){
        	if( ! preg_match($email_pattern, trim($email))){
        		Validation::active()->set_message('multiple_emails', 'The field :label contains an invalid email.');
        		return false;
        	}
        	if( strlen($email) > 255){
        		Validation::active()->set_message('multiple_emails', 'The field :label contains an very long email address.');
        		return false;
        	}
        }
        
        return true;
    }

}