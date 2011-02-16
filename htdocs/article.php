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
 * Loading template class
 */
require_once '..' . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'template.class.php';

/**
 * Include config class
 */
require_once '..' . DIRECTORY_SEPARATOR . 'application' . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'config.php';

/**
 * Models
 */
require_once '..' . DIRECTORY_SEPARATOR . 'application' . DIRECTORY_SEPARATOR . 'models' . DIRECTORY_SEPARATOR . 'articles.php';
require_once '..' . DIRECTORY_SEPARATOR . 'application' . DIRECTORY_SEPARATOR . 'models' . DIRECTORY_SEPARATOR . 'categories.php';

$iArticle_id		= ((!empty($_REQUEST['id'])) ? $_REQUEST['id'] : 0);

$oArticlesModel		= new articlesModel();
$oCategoriesModel	= new categoriesModel();
$oArticleData		= $oCategoryData = new stdClass();

try {
	$oArticleData = $oArticlesModel->getOne($iArticle_id);
} catch (Exception $e) { }

try {
	$oCategoryData = $oCategoriesModel->getRelationByArticleId($iArticle_id);
} catch (Exception $e) { }

// module content
$oTemplateModule = new template();
$oTemplateModule->setTemplate('views' . DIRECTORY_SEPARATOR . 'article');
$oTemplateModule->setVariable('article', $oArticleData);

// Layout structure
$oTemplateLayout = new template();
$oTemplateLayout->setTemplate('layouts' . DIRECTORY_SEPARATOR . '2columns');

if (is_object($oArticleData) && property_exists($oArticleData, 'article_id')) {
	$oArticleData->categories = $oCategoryData;
	$oTemplateLayout->setVariable('pageName', $oArticleData->title);
} else {
	header('HTTP/1.1 404 Not Found');
	$oTemplateLayout->setVariable('pageName', 'Podana strona nie istnieje - Błąd 404');
}

$oTemplateLayout->setVariable('siteName', 'DemoSite')
	->setVariable('content', $oTemplateModule->fetch())
	->display();
