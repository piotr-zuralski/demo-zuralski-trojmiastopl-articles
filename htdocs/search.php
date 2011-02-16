<?php
/**
 * Loading template class
 */
require_once '..' . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'template.class.php';

/**
 * Include config class
 */
require_once '..' . DIRECTORY_SEPARATOR . 'application' . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'config.php';

/**
 * Include models
 */
require_once '..' . DIRECTORY_SEPARATOR . 'application' . DIRECTORY_SEPARATOR . 'models' . DIRECTORY_SEPARATOR . 'articles.php';
require_once '..' . DIRECTORY_SEPARATOR . 'application' . DIRECTORY_SEPARATOR . 'models' . DIRECTORY_SEPARATOR . 'authors.php';
require_once '..' . DIRECTORY_SEPARATOR . 'application' . DIRECTORY_SEPARATOR . 'models' . DIRECTORY_SEPARATOR . 'categories.php';

/**
 * search.php
 *
 * Search form & result file
 *
 * @author		Piotr Żuralski <piotr@zuralski.net>
 * @package		Demo.htdocs
 * @version		$Revision:  $
 */

// supporting GET & POST request
$sSearchKeyword		= ((!empty($_REQUEST['keyword'])) ? filter_var($_REQUEST['keyword'], FILTER_SANITIZE_STRING) : '');
$iSearchAuthor_id	= ((!empty($_REQUEST['author_id'])) ? (integer)$_REQUEST['author_id'] : 0);
$iSearchCategory_id = ((!empty($_REQUEST['category_id'])) ? (integer)$_REQUEST['category_id'] : 0);
$sSearchOrder		= ((!empty($_REQUEST['order'])) ? filter_var($_REQUEST['order'], FILTER_SANITIZE_STRING) : '');
$iPage				= ((!empty($_REQUEST['page'])) ? (integer)$_REQUEST['page'] : 1);

if (1 > $iPage) {
	$iPage = 1;
}

$oCategoriesModel	= new categoriesModel();
$oAuthorsModel		= new authorsModel();
$oArticlesModel		= new articlesModel();

$aSearch = array(
	'values' => array(
		'keyword' => $sSearchKeyword,
		'author_id' => $iSearchAuthor_id,
		'category_id' => $iSearchCategory_id,
		'order' => $sSearchOrder,
		'submit' => false,
	),
	'options' => array(
		'authors' => $oAuthorsModel->getAll(),
		'category' => $oCategoriesModel->getAll(),
	),
	'results' => '',
	'pagination' => array(
		'found_records' => 0,
		'page_active' => $iPage,
		'query_string' => '',
	),
	
);

if (!empty($sSearchKeyword) || !empty($iSearchAuthor_id) || !empty($iSearchCategory_id) || !empty($sSearchOrder)) {
	$aSearch['values']['submit'] = true;
	$aSearch['results'] = $oArticlesModel->search($iPage, $sSearchKeyword, $iSearchAuthor_id, $iSearchCategory_id, $sSearchOrder);
	$aSearch['pagination']['found_records'] = $oArticlesModel->getCounted();
	$aSearch['pagination']['found_records'] = $aSearch['pagination']['found_records']/20;
	parse_str($_SERVER['QUERY_STRING'], $sUrl);
	unset($sUrl['page']);
	$aSearch['pagination']['query_string'] = http_build_query($sUrl);


}

// module content
$oTemplateModule = new template();
$oTemplateModule->setTemplate('views' . DIRECTORY_SEPARATOR . 'search')
	->setVariable('search', $aSearch);

// Layout structure
$oTemplateLayout = new template();
$oTemplateLayout->setTemplate('layouts' . DIRECTORY_SEPARATOR . '2columns')
	->setVariable('pageName', 'Szukaj')
	->setVariable('siteName', 'DemoSite')
	->setVariable('content', $oTemplateModule->fetch())
	->display();
