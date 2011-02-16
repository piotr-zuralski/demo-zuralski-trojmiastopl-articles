<?php

require_once '..' . DIRECTORY_SEPARATOR .  'library' . DIRECTORY_SEPARATOR . 'database.class.php';

/**
 * authors.php
 *
 * Authors model
 *
 * @author		Piotr Żuralski <piotr@zuralski.net>
 * @package		Demo.application.models
 * @version		$Revision:  $
 */
class authorsModel extends database {

	/**
	 * Connection handler
	 *
	 * @var PDO
	 */
	protected $_oDb = null;

	/**
	 * Return all authors
	 * 
	 * @return stdCalss
	 */
	public function getAll() {
		$oStatement = $this->_oDb->prepare('
			SELECT		author_id, CONCAT(last_name, ", ", first_name) AS name
			FROM		authors
			ORDER BY	name ASC'
		);
		$oStatement->execute();
		return $oStatement->fetchAll(PDO::FETCH_ASSOC);
	}

}