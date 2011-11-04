<?php
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2011 domainfactory GmbH (Stefan Galinski <sgalinski@df.eu>)
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
 * Data Provider Interface
 *
 * @author Stefan Galinski <sgalinski@df.eu>
 * @package	TYPO3
 * @subpackage df_tabs
 */
interface Tx_DfTabs_DataProvider_InterfaceDataProvider {
	/**
	 * Returns the title for this specific id
	 *
	 * @param int $uid
	 * @return string
	 */
	public function getTitle($uid);

	/**
	 * Returns the tab content for this specific id
	 *
	 * @see getContentUids
	 * @param int $uid
	 * @return string
	 */
	public function getTabContent($uid);

	/**
	 * Returns the link data for this specific id
	 *
	 * @param int $uid
	 * @return string
	 */
	public function getLinkData($uid);

	/**
	 * Returns the ajax fallback text for this specific id
	 *
	 * @param int $uid
	 * @return string
	 */
	public function getAjaxFallbackText($uid);
}

?>