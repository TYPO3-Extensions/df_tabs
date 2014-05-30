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
 * Data Provider for plain typoscript
 */
class Tx_DfTabs_DataProvider_TypoScriptDataProvider extends Tx_DfTabs_DataProvider_AbstractBaseDataProvider {
	/**
	 * Returns the tab content for the given typoscript object
	 *
	 * @param int $uid
	 * @return string
	 */
	public function getTabContent($uid) {
		return $this->contentObject->stdWrap(
			'', $this->pluginConfiguration['stdWrap.']['typoscriptData.']['tab' . $uid . '.']
		);
	}

	/**
	 * Returns an empty string as the titles should be configured with typoscript
	 *
	 * @param int $uid
	 * @return string
	 */
	public function getTitle($uid) {
		return '';
	}

	/**
	 * Returns the link data for this typoscript element
	 *
	 * @param int $uid
	 * @return string
	 */
	public function getLinkData($uid) {
		return $this->contentObject->stdWrap(
			'', $this->pluginConfiguration['stdWrap.']['typoscriptLinks.']['tab' . $uid . '.']
		);
	}

	/**
	 * Returns the ajax fallback text for this typoscript element
	 *
	 * @param int $uid
	 * @return string
	 */
	public function getAjaxFallbackText($uid) {
		return $this->contentObject->stdWrap(
			'', $this->pluginConfiguration['stdWrap.']['typoscriptAjaxFallbackText.']['tab' . $uid . '.']
		);
	}
}

?>