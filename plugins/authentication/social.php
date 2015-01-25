<?php
defined('_JEXEC') or die( 'Restricted access' );

jimport( 'joomla.plugin.plugin' );

class plgAuthenticationSocial extends JPlugin
{

	public function onUserAuthenticate($credentials, $options, &$response)
	{
		return $this->onAuthenticate( $credentials, $options, $response );
	}

	function onAuthenticate( $credentials, $options, &$response )
	{
		$db =& JFactory::getDBO();

		$query = 'SELECT `id`, `password`, `gid`'
			. ' FROM `#__users`'
			. ' WHERE id='.(int)$credentials['id']
			;
		$db->setQuery( $query );
		$result = $db->loadObject();

		if($result)
		{
			$user = JUser::getInstance($result->id); // Bring this in line with the rest of the system
			$response->email = $user->email;
			$response->fullname = $user->name;
			$response->username = $user->username;
			$response->status = JAUTHENTICATE_STATUS_SUCCESS;
			$response->error_message = '';
			return true;
		}
		else
		{
			$response->status = JAUTHENTICATE_STATUS_FAILURE;
			$response->error_message = 'User does not exist';
			return false;
		}
	}
}
