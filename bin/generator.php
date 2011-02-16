#!/usr/bin/php
<?php
/**
 * Shell script that generates articles upon request parameters
 *
 * @author		Piotr Żuralski <piotr@zuralski.net>
 * @package		Demo.bin
 * @version		$Revision:  $
 */

/**
 * Random generator class
 */
require_once '..' . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'randomStringGenerator.class.php';

/**
 * Models
 */
require_once '..' . DIRECTORY_SEPARATOR . 'application' . DIRECTORY_SEPARATOR . 'models' . DIRECTORY_SEPARATOR . 'articles.php';
require_once '..' . DIRECTORY_SEPARATOR . 'application' . DIRECTORY_SEPARATOR . 'models' . DIRECTORY_SEPARATOR . 'categories.php';

// we don't nedd file name
unset($_SERVER['argv']['0']);

$sParams = array();
parse_str(implode('&', $_SERVER['argv']), $sParams);

// input params
$iArticleAmount = ((!empty($sParams['articleAmount'])) ? (integer)$sParams['articleAmount'] : 0);
$sDateStart		= ((!empty($sParams['dateStart'])) ?
					filter_var($sParams['dateStart'], FILTER_SANITIZE_STRING) : 0);
$sDateEnd		= ((!empty($sParams['dateEnd'])) ?
					filter_var($sParams['dateEnd'], FILTER_SANITIZE_STRING) : 0);
$iAuthorAmount	= ((!empty($sParams['authorAmount'])) ? (integer)$sParams['authorAmount'] : 0);
$iCategoryAmount= ((!empty($sParams['categoryAmount'])) ? (integer)$sParams['categoryAmount'] : 0);

if (empty($iArticleAmount) || empty($sDateStart) || empty($sDateEnd) || empty($iAuthorAmount) || empty($iCategoryAmount)) {
	// help
	echo 'Skrypt generowania artykułów' . PHP_EOL .
	'użycie: ' . $_SERVER['PHP_SELF'] . ' articleAmount=' . $iArticleAmount . ' dateStart=' . $sDateStart .
		' dateEnd=' . $sDateEnd . ' authorAmount=' . $iAuthorAmount . ' categoryAmount=' . $iCategoryAmount . PHP_EOL .
		PHP_EOL .
	'Parametry wywołania (wszystkie są obowiązkowe)' . PHP_EOL .
		'  articleAmount - liczba - ilość artykułów' . PHP_EOL .
		'  dateStart - data w formacie DD-MM-YYY - data początkowa' . PHP_EOL .
		'  dateEnd - data w formacie DD-MM-YYY - data końcowa' . PHP_EOL .
		'  authorAmount - liczba - ilość autorów' . PHP_EOL .
		'  categoryAmount - liczba - ilość kategorii' . PHP_EOL;
	exit();
}

// if too many authors, it's said that there are 20 of them
if (20 < $iAuthorAmount) {
	echo 'Wybrana ilość autorów jest zbyt duża, wartość zostanie obniżona do 20' . PHP_EOL;
	$iAuthorAmount = 20;
}

// and 5 of categories
if (5 < $iCategoryAmount) {
	echo 'Wybrana ilość kategorii jest zbyt duża, wartość zostanie obniżona do 5' . PHP_EOL;
	$iCategoryAmount = 5;
}

$oRandomStringGenerator = new randomStringGenerator();
$oArticlesModel			= new articlesModel();
$oCategoriesModel		= new categoriesModel();

// start time & end time
$iDateStart		= strtotime($sDateStart . '00:00:00');
$iDateEnd		= strtotime($sDateEnd . '23:59:59');
$iTimeJump		= ($iDateEnd-$iDateStart)/$iArticleAmount;

// generating articles
for ($i = 1; $i <= $iArticleAmount;) {
	$iArticleDate		= $iDateStart+$iTimeJump;
	$iDateStart			= $iArticleDate;
	$iArticleAuthor_id	= mt_rand(1, 20);
	$aArticleCategories = array();

	$iArticleCategory	= 0;
	$bWhile				= true;
	while ($bWhile) {
		$iArticleCategory = mt_rand(1, 5);
		if (!array_key_exists($iArticleCategory, $aArticleCategories)) {
			$aArticleCategories[$iArticleCategory] = true;
		}
		if ($iCategoryAmount == count($aArticleCategories)) {
			$bWhile = false;
		}
	}

	// different lenght of title and content for articles
	$iLength = mt_rand(150, 200);
	$sArticleTitle	= $oRandomStringGenerator->genRandomString($iLength);
	$iLength = mt_rand(1500, 2000);
	$sArticleContent= $oRandomStringGenerator->genRandomString($iLength);

	// checking if inserting was successful
	$iAddingResult = $oArticlesModel->addOne($iArticleAuthor_id, $iArticleDate, $sArticleTitle, $sArticleContent);

	// and then adding realation wih category
	if (is_numeric($iAddingResult)) {
		foreach($aArticleCategories as $iCategory => $bValue) {
			$oCategoriesModel->addRelation($iAddingResult, $iCategory);
		}
	}
	if (!$iAddingResult) {
		echo 'Błąd dodawania artykułu do bazy' . PHP_EOL;
	}

	// footer per generated article
	echo 'Artykuł ' . $i .' z ' . $iArticleAmount . PHP_EOL;
	++$i;

}
