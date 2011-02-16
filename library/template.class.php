<?php
/**
 * include Smarty class
 */
require_once 'vendor' . DIRECTORY_SEPARATOR . 'Smarty' . DIRECTORY_SEPARATOR . 'Smarty.class.php';

/**
 * Template class based on Smarty
 *
 * @author		Piotr Żuralski <piotr@zuralski.net>
 * @package		Demo.library
 * @version		$Revision:  $
 */
class template {

	/**
	 * Template file name
	 * 
	 * @var string
	 */
	protected $_sTemplate = '';

	/**
	 * Array with variables to set to template
	 * 
	 * @var array
	 */
	protected $_aVariables = array();

	/**
	 * Smarty Template Object
	 *
	 * @var Smarty
	 */
	protected $_oSmarty = null;

	public function __construct() {
		$this->_oSmarty = new Smarty();
		$this->_config();
	}

	/**
	 * Sets variable and it's content
	 * 
	 * @param string $sVariableName
	 * @param mixed $mVariableContent
	 * @return template
	 */
	public function setVariable($sVariableName, $mVariableContent) {
		$sVariableName = (string)$sVariableName;
		if (!isset($this->_aVariables[$sVariableName])) {
			$this->_aVariables[$sVariableName] = $mVariableContent;
		}
		return $this;
	}

	/**
	 * Sets path to template
	 * 
	 * @param	string $sTemplate
	 * @return	template
	 */
	public function setTemplate($sTemplate) {
		$this->_sTemplate = $sTemplate;
		return $this;
	}

	/**
	 * Return parsed template
	 * 
	 * @return	string
	 */
	public function fetch() {
		$this->_oSmarty->assign((array)$this->_aVariables);
		return $this->_oSmarty->fetch($this->_sTemplate . '.tpl');
	}

	/**
	 * Display parsed template
	 *
	 * @return	string
	 */
	public function display() {
		$this->_oSmarty->assign((array)$this->_aVariables);
		$this->_oSmarty->display($this->_sTemplate . '.tpl');
	}

	/**
	 * Sets Smarty config
	 *
	 * @return	void
	 */
	private function _config() {
		$oConfig = new config();
		$aSmartyConfig = $oConfig->getConfig('smarty');
		
		foreach($aSmartyConfig as $sSingleSmartyConfigName => $sSingleSmartyConfigValue) {
			if (isset($this->_oSmarty->{$sSingleSmartyConfigName})) {
				$this->_oSmarty->{$sSingleSmartyConfigName} = $sSingleSmartyConfigValue;
			}
		}
	}

}
