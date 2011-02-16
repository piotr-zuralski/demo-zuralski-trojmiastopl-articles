<?php

require_once '..' . DIRECTORY_SEPARATOR .  'library' . DIRECTORY_SEPARATOR . 'database.class.php';

/**
 * categories.php
 *
 * Categories model
 *
 * @author		Piotr Żuralski <piotr@zuralski.net>
 * @package		Demo.application.models
 * @version		$Revision:  $
 */
class categoriesModel extends database {

	/**
	 * Connection handler
	 *
	 * @var PDO
	 */
	protected $_oDb = null;

	/**
	 * Return all categories
	 * 
	 * @return stdClass
	 */
	public function getAll() {
		$oStatement = $this->_oDb->prepare('
			SELECT		category_id, name
			FROM		categories
			ORDER BY	name ASC;'
		);
		$oStatement->execute();
		return $oStatement->fetchAll(PDO::FETCH_ASSOC);
	}

	/**
	 * Adds relation between category and article
	 *
	 * @param integer $iArticle_id
	 * @param integer $iCategory_id
	 * @return integer/boolean
	 */
	public function addRelation($iArticle_id, $iCategory_id) {
		$oStatement = $this->_oDb->prepare('
			INSERT INTO `rel_articles2categories`
				(article_id, category_id)
			VALUES
				(:article_id, :category_id);'
		);

		$oStatement->bindParam(':article_id', $iArticle_id, PDO::PARAM_INT);
		$oStatement->bindParam(':category_id', $iCategory_id, PDO::PARAM_INT);
		$oStatement->execute();
		$iItemId = $this->_oDb->lastInsertId();
		return $iItemId;
	}

	/**
	 * Return articles categories
	 * 
	 * @param integer $iArticle_id
	 * @return stdClass
	 */
	public function getRelationByArticleId($iArticle_id) {
		$oStatement = $this->_oDb->prepare('
			SELECT		name
			FROM		categories
			WHERE		category_id IN (
				SELECT	category_id
				FROM	rel_articles2categories
				WHERE	article_id = :article_id
			);'
		);

		$oStatement->bindParam(':article_id', $iArticle_id, PDO::PARAM_INT);
		$oStatement->execute();
		return $oStatement->fetchAll(PDO::FETCH_ASSOC);
	}

}