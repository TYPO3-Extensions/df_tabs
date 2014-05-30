<?php
/***************************************************************
 *  Copyright notice
 *
 *  (c) domainfactory GmbH (Stefan Galinski <stefan.galinski@gmail.com>)
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 * Data Provider for the pages table
 */
class Tx_DfTabs_DataProvider_PagesDataProvider extends Tx_DfTabs_DataProvider_AbstractDataBaseDataProvider {
	/**
	 * Related database table
	 *
	 * @var string
	 */
	protected $table = 'pages';

	/**
	 * Returns an array of tt_content ids that are related to the given page id. The result is
	 * filtered by some typoscript configuration options.
	 *
	 * @param int $uid
	 * @return array
	 */
	public function getContentUids($uid) {
		$where = 'pid = ' . intval($uid) . $this->contentObject->enableFields('tt_content') .
			' ' . $this->pluginConfiguration['pages.']['additionalWhere'] .
			' AND sys_language_uid IN (0,-1)';

		/** @var $db t3lib_DB */
		$db = $GLOBALS['TYPO3_DB'];
		$contentElements = $db->exec_SELECTgetRows(
			'uid', 'tt_content', $where, '',
			$this->pluginConfiguration['pages.']['orderBy'],
			$this->pluginConfiguration['pages.']['limit'],
			'uid'
		);

		return array_keys($contentElements);
	}
}

?>