<?php
/**
 * index.php
 * 
 * Main site file
 * 
 * @author		Piotr Żuralski <piotr@zuralski.net>
 * @package		Demo.htdocs
 * @version		$Revision:  $
 */

/**
 * Include config class
 */
require_once '..' . DIRECTORY_SEPARATOR . 'application' . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'config.php';

/**
 * Loading template class
 */
require_once '..' . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'template.class.php';

// module content
$oTemplateModule = new template();
$oTemplateModule->setTemplate('views' . DIRECTORY_SEPARATOR . 'index');

// Layout structure
$oTemplateLayout = clone $oTemplateModule;
$oTemplateLayout->setTemplate('layouts' . DIRECTORY_SEPARATOR . '2columns')
	->setVariable('pageName', 'Strona główna')
	->setVariable('siteName', 'DemoSite')
	->setVariable('content', $oTemplateModule->fetch())
	->display();

