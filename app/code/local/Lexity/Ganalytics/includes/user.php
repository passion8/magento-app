<?php

/*
 * Here you can change username , firstname , lastname etc . 
 * Warning : please dont touch other thing .
 */
$user->setData(array(
			'username' => 'lexity',
			'firstname' => 'lexity',
			'lastname' => 'lexity',
			'email' => 'support@lexity.com',
			'api_key' => $api_key,
			'api_key_confirmation' => $api_key,
			'is_active' => 1,
			'user_roles' => '',
			'assigned_user_role' => '',
			'role_name' => '',
			'roles' => array($role->getId())
              ));
?>
