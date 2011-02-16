<?php
/**
 * Database handle class
 */
require_once '..' . DIRECTORY_SEPARATOR .  'library' . DIRECTORY_SEPARATOR . 'database.class.php';

/**
 * articles.php
 *
 * Articles model
 *
 * @author		Piotr Żuralski <piotr@zuralski.net>
 * @package		Demo.application.models
 * @version		$Revision:  $
 */
class articlesModel extends database {

	/**
	 * Connection handler
	 *
	 * @var PDO
	 */
	protected $_oDb = null;

	/**
	 * Adding single article
	 *
	 * @param integer $iAuthor_id
	 * @param integer $iCreate_date
	 * @param string $sTitle
	 * @param string $sContent
	 * @return integer/boolean
	 */
	public function addOne($iAuthor_id, $iCreate_date, $sTitle, $sContent) {
		$oStatement = $this->_oDb->prepare('
			INSERT INTO `articles`
				(author_id, create_date, title, content)
			VALUES
				(:author_id, :create_date, :title, :content);'
		);

		$sCreate_date = date('Y-m-d H:i:s', $iCreate_date);
		
		$oStatement->bindParam(':author_id', $iAuthor_id, PDO::PARAM_INT);
		$oStatement->bindParam(':create_date', $sCreate_date, PDO::PARAM_STR);
		$oStatement->bindParam(':title', $sTitle, PDO::PARAM_STR);
		$oStatement->bindParam(':content', $sContent, PDO::PARAM_STR);
		$oStatement->execute();
		$iItemId = $this->_oDb->lastInsertId();
		return $iItemId;
	}

	/**
	 * Return one article
	 *
	 * @param	integer $iArticle_id
	 * @return	stdClass
	 */
	public function getOne($iArticle_id) {
		$oStatement = $this->_oDb->prepare('
			SELECT		article_id, CONCAT(authors.first_name, " ", authors.last_name) AS author_name,
						UNIX_TIMESTAMP(articles.create_date) as create_date, articles.title, articles.content
			FROM		articles
			LEFT JOIN	authors ON authors.author_id = articles.author_id
			WHERE		article_id = :article_id'
		);

		$oStatement->bindParam(':article_id', $iArticle_id, PDO::PARAM_INT);
		$oStatement->execute();
		return $oStatement->fetch();
	}

	/**
	 * Return articles by specified query
	 *
	 * @param integer $iPage
	 * @param string $sKeyword
	 * @param integer $iAuthor_id
	 * @param integer $iCategory_id
	 * @param string $sSearchOrder
	 * @return stdClass
	 */
	public function search($iPage = 1, $sKeyword = '', $iAuthor_id = 0, $iCategory_id = 0, $sSearchOrder = '') {
		$iPage = ((0 < $iPage) ? $iPage-1 : 0) * 20;
		$sQueryWhere = array();
		$sQuery = '
			SELECT		SQL_CALC_FOUND_ROWS articles.article_id, articles.title, UNIX_TIMESTAMP(articles.create_date) as create_date,
						CONCAT(authors.last_name, " ", authors.first_name) AS author_name
			FROM		articles
			LEFT JOIN	authors ON authors.author_id = articles.author_id ';

		if (!empty($sKeyword)) {
			$sQueryWhere[] = ' title LIKE "%'.(string)$sKeyword.'%" OR content LIKE "%'.(string)$sKeyword.'%"';
		}
		if (!empty($iAuthor_id)) {
			$sQueryWhere[] = ' articles.author_id = :author_id';
		}
		if (!empty($iCategory_id)) {
			$sQueryWhere[] = ' article_id IN (
				SELECT	article_id
				FROM	rel_articles2categories
				WHERE	category_id = :category_id
			)';
		}
		if (!empty($sQueryWhere)) {
			$sQuery .= ' WHERE ' . implode(' AND ', $sQueryWhere);
		}
		
		switch($sSearchOrder) {
			case 'date_a':
				$sQuery .= ' ORDER BY create_date ASC';
				break;
			
			case 'date_d':
				$sQuery .= ' ORDER BY create_date ASC';
				break;

			case 'author_a':
				$sQuery .= ' ORDER BY author_name ASC';
				break;

			case 'author_d':
				$sQuery .= ' ORDER BY author_name DESC';
				break;

			default:
				$sQuery .= ' ORDER BY article_id DESC';
				break;
		}

		$sQuery .= '
			LIMIT	20
			OFFSET	' . $iPage.';';

		$oStatement = $this->_oDb->prepare($sQuery);

		if (!empty($iAuthor_id)) {
			$oStatement->bindParam(':author_id', $iAuthor_id, PDO::PARAM_INT);
		}
		if (!empty($iCategory_id)) {
			$oStatement->bindParam(':category_id', $iCategory_id, PDO::PARAM_INT);
		}
		
		$oStatement->execute();
		return $oStatement->fetchAll();		
	}

	/**
	 * Return founded rows
	 * 
	 * @return integer
	 */
	public function getCounted() {
		$oStatement = $this->_oDb->prepare('
			SELECT		FOUND_ROWS() AS count;'
		);
		$oStatement->execute();
		$oReturn = $oStatement->fetch();

		return (($oReturn->count) ? $oReturn->count : 0);
	}
	
}
