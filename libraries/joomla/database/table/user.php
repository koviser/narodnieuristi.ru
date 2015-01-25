<?php
defined('JPATH_BASE') or die();

class JTableUser extends JTable
{
	var $id				= null;
	var $name			= null;
	var $family			= null;
	var $balance		= null;
	var $username		= null;
	var $email			= null;
	var $phone			= null;
	var $friend			= null;
	var $friendS		= null;
	var $birthDay		= null;
	var $gender			= null;
	var $id_roo			= null;
	var $bonus			= null;
	var $active			= null;
	var $password		= null;
	var $usertype		= null;
	var $block			= null;
	var $sendEmail		= null;
	var $gid			= null;
	var $registerDate	= null;
	var $lastvisitDate	= null;
	var $activation		= null;
	var $params			= null;
	var $advertiser		= null;
	var $image			= null;
	var $ref			= null;
	var $refUse			= null;
	var $partner		= null;
	var $reward 		= null;
	var $vip   	 		= null;

	function __construct( &$db )
	{
		parent::__construct( '#__users', 'id', $db );

		//initialise
		$this->id        = 0;
		$this->gid       = 0;
		$this->sendEmail = 0;
	}

	function check()
	{
		jimport('joomla.mail.helper');

		// Validate user information
		if (trim( $this->name ) == '') {
			$this->setError( JText::_( 'Please enter your name.' ) );
			return false;
		}

		if (trim( $this->username ) == '') {
			$this->setError( JText::_( 'Please enter a user name.') );
			return false;
		}

		if (preg_match( "#[<>\"'%;()&]#i", $this->username) || strlen(utf8_decode($this->username )) < 2) {
			$this->setError( JText::sprintf( 'VALID_AZ09', JText::_( 'Username' ), 2 ) );
			return false;
		}

		if ((trim($this->email) == "") || ! JMailHelper::isEmailAddress($this->email) ) {
			$this->setError( JText::_( 'WARNREG_MAIL' ) );
			return false;
		}

		if ($this->registerDate == null) {
			// Set the registration timestamp
			$now =& JFactory::getDate();
			$this->registerDate = $now->toMySQL();
		}


		// check for existing username
		$query = 'SELECT id'
		. ' FROM #__users '
		. ' WHERE username = ' . $this->_db->Quote($this->username)
		. ' AND id != '. (int) $this->id;
		;
		$this->_db->setQuery( $query );
		$xid = intval( $this->_db->loadResult() );
		if ($xid && $xid != intval( $this->id )) {
			$this->setError(  JText::_('WARNREG_INUSE'));
			return false;
		}


		// check for existing email
		$query = 'SELECT id'
			. ' FROM #__users '
			. ' WHERE email = '. $this->_db->Quote($this->email)
			. ' AND id != '. (int) $this->id
			;
		$this->_db->setQuery( $query );
		$xid = intval( $this->_db->loadResult() );
		if ($xid && $xid != intval( $this->id )) {
			$this->setError( JText::_( 'WARNREG_EMAIL_INUSE' ) );
			return false;
		}

		return true;
	}

	function store( $updateNulls=false )
	{
		$acl =& JFactory::getACL();

		$section_value = 'users';
		$k = $this->_tbl_key;
		$key =  $this->$k;

		if ($key)
		{
			// existing record
			$ret = $this->_db->updateObject( $this->_tbl, $this, $this->_tbl_key, $updateNulls );

			// syncronise ACL
			// single group handled at the moment
			// trivial to expand to multiple groups
			$object_id = $acl->get_object_id( $section_value, $this->$k, 'ARO' );

			$groups = $acl->get_object_groups( $object_id, 'ARO' );
			$acl->del_group_object( $groups[0], $section_value, $this->$k, 'ARO' );
			$acl->add_group_object( $this->gid, $section_value, $this->$k, 'ARO' );

			$acl->edit_object( $object_id, $section_value, $this->_db->getEscaped( $this->name ), $this->$k, 0, 0, 'ARO' );
		}
		else
		{
			// new record
			$ret = $this->_db->insertObject( $this->_tbl, $this, $this->_tbl_key );
			// syncronise ACL
			$acl->add_object( $section_value, $this->name, $this->$k, null, null, 'ARO' );
			$acl->add_group_object( $this->gid, $section_value, $this->$k, 'ARO' );
		}

		if( !$ret )
		{
			$this->setError( strtolower(get_class( $this ))."::". JText::_( 'store failed' ) ."<br />" . $this->_db->getErrorMsg() );
			return false;
		}
		else
		{
			return true;
		}
	}

	function delete( $oid=null )
	{
		$acl =& JFactory::getACL();

		$k = $this->_tbl_key;
		if ($oid) {
			$this->$k = intval( $oid );
		}
		$aro_id = $acl->get_object_id( 'users', $this->$k, 'ARO' );
		$acl->del_object( $aro_id, 'ARO', true );

		$query = 'DELETE FROM '. $this->_tbl
		. ' WHERE '. $this->_tbl_key .' = '. (int) $this->$k
		;
		$this->_db->setQuery( $query );

		if ($this->_db->query()) {
			// cleanup related data

			// private messaging
			$query = 'DELETE FROM #__messages_cfg'
			. ' WHERE user_id = '. (int) $this->$k
			;
			$this->_db->setQuery( $query );
			if (!$this->_db->query()) {
				$this->setError( $this->_db->getErrorMsg() );
				return false;
			}
			$query = 'DELETE FROM #__messages'
			. ' WHERE user_id_to = '. (int) $this->$k
			;
			$this->_db->setQuery( $query );
			if (!$this->_db->query()) {
				$this->setError( $this->_db->getErrorMsg() );
				return false;
			}

			return true;
		} else {
			$this->setError( $this->_db->getErrorMsg() );
			return false;
		}
	}

	/**
	 * Updates last visit time of user
	 *
	 * @param int The timestamp, defaults to 'now'
	 * @return boolean False if an error occurs
	 */
	function setLastVisit( $timeStamp=null, $id=null )
	{
		// check for User ID
		if (is_null( $id )) {
			if (isset( $this )) {
				$id = $this->id;
			} else {
				// do not translate
				jexit( 'WARNMOSUSER' );
			}
		}

		// if no timestamp value is passed to functon, than current time is used
		$date =& JFactory::getDate($timeStamp);

		// updates user lastvistdate field with date and time
		$query = 'UPDATE '. $this->_tbl
		. ' SET lastvisitDate = '.$this->_db->Quote($date->toMySQL())
		. ' WHERE id = '. (int) $id
		;
		$this->_db->setQuery( $query );
		if (!$this->_db->query()) {
			$this->setError( $this->_db->getErrorMsg() );
			return false;
		}

		return true;
	}

	/**
	* Overloaded bind function
	*
	* @access public
	* @param array $hash named array
	* @return null|string	null is operation was satisfactory, otherwise returns an error
	* @see JTable:bind
	* @since 1.5
	*/

	function bind($array, $ignore = '')
	{
		if (key_exists( 'params', $array ) && is_array( $array['params'] )) {
			$registry = new JRegistry();
			$registry->loadArray($array['params']);
			$array['params'] = $registry->toString();
		}

		return parent::bind($array, $ignore);
	}
}
