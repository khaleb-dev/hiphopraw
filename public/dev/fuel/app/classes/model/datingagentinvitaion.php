<?php

class Model_Datingagentinvitaion extends \Orm\Model
{
	protected static $_properties = array(
		'id',
		'dating_agent_profile',
		'profile_from',
		'profile_to',
		'status',
		'created_at',
		'updated_at',
	);

	protected static $_observers = array(
		'Orm\Observer_CreatedAt' => array(
			'events' => array('before_insert'),
			'mysql_timestamp' => false,
		),
		'Orm\Observer_UpdatedAt' => array(
			'events' => array('before_update'),
			'mysql_timestamp' => false,
		),
	);
	protected static $_table_name = 'datingagentinvitaions';

    const INVITATION_PENDING = "Pending";
    const INVITATION_ACCEPTED = "Accepted";
    const INVITATION_REJECTED = "Rejected";


    public static function has_pending_invitations($profile_id)
    {
        $dating_agent_invitations = Model_Datingagentinvitaion::query()
        ->where(
                array(
                    'profile_to' => $profile_id,
                    'status' => self::INVITATION_PENDING
                )
        )
        ->get();

        if(count($dating_agent_invitations) > 0){
            return true;
        }

        return false;
    }

    public static function get_one_pending_invitation($profile_id)
    {
        $dating_agent_invitations = Model_Datingagentinvitaion::query()
            ->where(
                array(
                    'profile_to' => $profile_id,
                    'status' => self::INVITATION_PENDING
                )
            )
            ->order_by('created_at')
            ->get_one();

        if(count($dating_agent_invitations) === 1){
            return $dating_agent_invitations;
        }

        return false;
    }

}
