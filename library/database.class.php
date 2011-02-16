<?php
/**
 * Include config class
 */
require_once '..' . DIRECTORY_SEPARATOR . 'application' . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'config.php';

/**
 * Database connection library
 *
 * @author		Piotr Żuralski <piotr@zuralski.net>
 * @package		Demo.library
 * @version		$Revision:  $
 */
class database {

	/**
	 * Connection handler
	 * 
	 * @var PDO
	 */
	protected $_oDb = null;

	public function __construct() {
		$oConfig = new config();

		$aConnectionConfigDefault = array(
			'schame' => '',
			'user' => '',
			'pass' => '',
			'path' => '',
			'query' => '',
		);
		$aConnectionConfig = parse_url($oConfig->getConfig('database')) + $aConnectionConfigDefault;

		if(!empty($aConnectionConfig['query'])) {
			$aConnectionConfig['query'] = str_replace('&', ';', $aConnectionConfig['query']);
		}

		$sDsn = $aConnectionConfig['scheme'] . ':dbname=' . trim($aConnectionConfig['path'], '/') . ';';
		$sDsn .= 'host=' . $aConnectionConfig['host'];
		$sDsn .= ((!empty($aConnectionConfig['query'])) ? ';' . $aConnectionConfig['query'] : null);
		
		$aOptions = array(
			PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
			PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\'',
		);

		$this->_oDb = new PDO($sDsn, $aConnectionConfig['user'], $aConnectionConfig['pass'], $aOptions);

		$this->_oDb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$this->_oDb->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
		if ('mysql' == $aConnectionConfig['scheme']) {
			$this->_oDb->setAttribute(PDO::ATTR_AUTOCOMMIT, true);
		}
	}

}
