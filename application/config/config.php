<?php
/**
 * Configuration file
 *
 * @author		Piotr Żuralski <piotr@zuralski.net>
 * @package		Demo.application.config
 * @version		$Revision:  $
 */
class config {

	protected $_aConfig = array(
		'smarty' => array(
			'force_compile' => false,
			'caching' => false,
			'allow_php_tag' => true,

			'template_dir' => '',
			'compile_dir' => '',
		),
		'database' => 'mysql://root:@localhost/demo_trojmiasto',
	);

	public function __construct() {
		$this->_aConfig['smarty']['template_dir']  = dirname(dirname(dirname(__FILE__))) . DIRECTORY_SEPARATOR;
		$this->_aConfig['smarty']['template_dir'] .= 'application' . DIRECTORY_SEPARATOR . 'templates';

		$this->_aConfig['smarty']['compile_dir']  = dirname(dirname(dirname(__FILE__))) . DIRECTORY_SEPARATOR . 'var';
		$this->_aConfig['smarty']['compile_dir'] .= DIRECTORY_SEPARATOR . 'templates_c';
	}

	/**
	 * Reurns config
	 *
	 * @return mixed (false/string/array)
	 */
	public function getConfig($sName) {
		if (!isset($this->_aConfig[$sName])) {
			return false;
		}
		return $this->_aConfig[$sName];
	}

}
