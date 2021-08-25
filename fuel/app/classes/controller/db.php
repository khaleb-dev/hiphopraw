
<?php
/**
 * The development database settings. These get merged with the global settings.
 */

return array(
	'default' => array(
        'type' => 'pdo',
		'connection'  => array(
            'dsn'        => 'mysql:host=localhost;dbname=hiphopraw',
            'username'   => 'hhr_db_user',
            'password'   => 'hhr#_14!',
		),
	),
);

