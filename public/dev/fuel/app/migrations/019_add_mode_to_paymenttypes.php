<?php

namespace Fuel\Migrations;

class Add_mode_to_paymenttypes
{
    public function up()
    {
        \DBUtil::add_fields('paymenttypes', array(
            'mode' => array('constraint' => 255, 'type' => 'varchar'),
        ));

        $payment_types = \Model_Paymenttype::find('all');
        foreach ($payment_types as $payment_type) {
            $payment_type->mode = 'recurring';
            $payment_type->save();
        }

        \Model_Paymenttype::forge(array("name" => "1 Month", "amount" => 24.99, "mode" => 'recurring'))->save();
        \Model_Paymenttype::forge(array("name" => "3 Months", "amount" => 59.97, "mode" => 'recurring'))->save();
        \Model_Paymenttype::forge(array("name" => "6 Months", "amount" => 95.94, "mode" => 'recurring'))->save();
        \Model_Paymenttype::forge(array("name" => "12 Months", "amount" => 119.8, "mode" => 'recurring'))->save();
        \Model_Paymenttype::forge(array("name" => "Dating Agent", "amount" => 300.00, "mode" => 'one-time'))->save();
	}

    public function down()
    {
        \DBUtil::drop_fields('paymenttypes', array(
            'mode'

        ));
    }
}