<?php
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2010-2011 domainfactory GmbH (Stefan Galinski <sgalinski@df.eu>)
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
 * Database Data Provider
 *
 * @author Stefan Galinski <sgalinski@df.eu>
 * @package	TYPO3
 * @subpackage df_tabs
 */
abstract class Tx_DfTabs_DataProvider_AbstractDataBaseDataProvider extends Tx_DfTabs_DataProvider_AbstractBaseDataProvider {
	/**
	 * Related database table
	 *
	 * @var string
	 */
	protected $table = '';

	/**
	 * Internally cached record data
	 *
	 * @var array
	 */
	protected $cachedRecord = NULL;

	/**
	 * Returns the internally used record data
	 *
	 * @param int $uid
	 * @return array
	 */
	protected function getRecordData($uid) {
		return $GLOBALS['TYPO3_DB']->exec_SELECTgetSingleRow('*', $this->table, 'uid = ' . intval($uid));
	}

	/**
	 * Returns the given input as an array
	 *
	 * Override this in your subclasses if required!
	 *
	 * @param int $uid
	 * @return array
	 */
	protected function getContentUids($uid) {
		return array($uid);
	}

	/**
	 * Returns the tab content for given tt_content identifiers
	 *
	 * @param int $uid
	 * @return string
	 */
	public function getTabContent($uid) {
		$configuration = array(
			'tables' => 'tt_content',
			'source' => implode(',', $this->getContentUids($uid)),
			'dontCheckPid' => 1
		);

		if (is_array($this->pluginConfiguration['records.'])) {
			$configuration = array_merge($configuration, $this->pluginConfiguration['records.']);
		}

		return $this->contentObject->RECORDS($configuration);
	}

	/**
	 * Returns the header field of the requested tt_content element
	 *
	 * @param int $uid
	 * @return string
	 */
	public function getTitle($uid) {
		if (!isset($this->cachedRecord[$uid])) {
			$this->cachedRecord[$uid] = $this->getRecordData($uid);
		}

		return $this->cachedRecord[$uid][$this->pluginConfiguration[$this->table . '.']['titleField']];
	}

	/**
	 * Returns the link data for this specific id
	 *
	 * @param int $uid
	 * @return string
	 */
	public function getLinkData($uid) {
		if (!isset($this->cachedRecord[$uid])) {
			$this->cachedRecord[$uid] = $this->getRecordData($uid);
		}

		return $this->cachedRecord[$uid][$this->pluginConfiguration[$this->table . '.']['linkField']];
	}

	/**
	 * Returns the ajax fallback text for this specific id
	 *
	 * @param int $uid
	 * @return string
	 */
	public function getAjaxFallbackText($uid) {
		if (!isset($this->cachedRecord[$uid])) {
			$this->cachedRecord[$uid] = $this->getRecordData($uid);
		}

		return $this->cachedRecord[$uid][$this->pluginConfiguration[$this->table . '.']['ajaxFallbackTextField']];
	}
}

?>