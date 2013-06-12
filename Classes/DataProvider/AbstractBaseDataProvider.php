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
 * Base Data Provider
 */
abstract class Tx_DfTabs_DataProvider_AbstractBaseDataProvider implements Tx_DfTabs_DataProvider_InterfaceDataProvider, t3lib_Singleton {
	/**
	 * Plugin configuration
	 *
	 * @var array
	 */
	protected $pluginConfiguration = array();

	/**
	 * Instance of tslib_cObj
	 *
	 * @var tslib_cObj
	 */
	protected $contentObject = NULL;

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
	 * Injects the content object
	 *
	 * @param tslib_cObj $contentObject
	 * @return void
	 */
	public function injectContentObject(tslib_cObj $contentObject) {
		$this->contentObject = $contentObject;
	}
}

?>