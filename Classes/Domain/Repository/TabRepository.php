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
 * Tab Repository
 */
class Tx_DfTabs_Domain_Repository_TabRepository {
	/**
	 * @var array
	 */
	protected $pluginConfiguration = array();

	/**
	 * @var tslib_cObj
	 */
	protected $contentObject = NULL;

	/**
	 * Injects an instance of the content object
	 *
	 * @param tslib_cObj $contentObject
	 * @return void
	 */
	public function injectContentObject(tslib_cObj $contentObject) {
		$this->contentObject = $contentObject;
	}

	/**
	 * Injects the plugin configuration
	 *
	 * @param array $configuration
	 * @return void
	 */
	public function injectPluginConfiguration(array $configuration) {
		$this->pluginConfiguration = $configuration;
	}

	/**
	 * Returns a data provider instance
	 *
	 * @param string $type
	 * @return Tx_DfTabs_DataProvider_AbstractBaseDataProvider
	 */
	protected function getDataProvider($type) {
		return Tx_DfTabs_DataProvider_FactoryDataProvider::getDataProvider(
			$type, $this->pluginConfiguration, $this->contentObject
		);
	}

	/**
	 * Returns the configured records
	 *
	 * @return array
	 */
	public function getRecords() {
		$records = $this->pluginConfiguration['data'];
		$stdWrap = $this->pluginConfiguration['stdWrap.'][$this->pluginConfiguration['mode'] . '.'];
		if (is_array($stdWrap)) {
			$GLOBALS['TSFE']->register['dftabs_pluginElement'] = $this->contentObject->data;
			$records = $this->contentObject->stdWrap($records, $stdWrap);
		}

		/** @noinspection PhpParamsInspection */
		return t3lib_div::trimExplode(',', $records, TRUE);
	}

	/**
	 * Returns an array of tab elements
	 *
	 * @param array $preferredTitles
	 * @param array $records
	 * @return array
	 */
	public function buildTabElements($preferredTitles, $records) {
		$tabElements = array();
		$amountOfTabs = max(count($preferredTitles), count($records));
		$hasAJAX = ($this->pluginConfiguration['ajax'] == TRUE);
		for ($index = 0; $index < $amountOfTabs; ++$index) {
			$recordId = $records[$index];
			$type = $this->pluginConfiguration['mode'];
			if (strrpos($recordId, '_') !== FALSE) {
				$type = substr($recordId, 0, strrpos($recordId, '_'));
				$recordId = substr($recordId, strrpos($recordId, '_') + 1);
			}

			$recordId = (!$recordId ? $index + 1 : $recordId);
			$dataProvider = $this->getDataProvider($type);

			$title = trim($preferredTitles[$index]);
			$title = ($title === '' ? $dataProvider->getTitle($recordId) : $title);
			$title = ($title === '' ? $this->pluginConfiguration['defaultTabTitle'] : $title);

			/** @var $tabElement Tx_DfTabs_Domain_Model_Tab */
			$tabElement = t3lib_div::makeInstance('Tx_DfTabs_Domain_Model_Tab', htmlspecialchars($title), $recordId);
			$tabElement->setLink($dataProvider->getLinkData($recordId));
			if (!$hasAJAX || ($hasAJAX && !$index)) {
				$tabElement->setContent($dataProvider->getTabContent($recordId));
			} else {
				$tabElement->setContent($dataProvider->getAjaxFallbackText($recordId));
			}
			$tabElements[] = $tabElement;
		}

		return $tabElements;
	}
}

?>