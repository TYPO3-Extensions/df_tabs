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
 * Handles configuration related stuff
 *
 * @author Stefan Galinski <sgalinski@df.eu>
 * @package	TYPO3
 * @subpackage df_tabs
 */
class Tx_DfTabs_Service_ConfigurationService {
	/**
	 * @var tx_dftabs_plugin1
	 */
	protected $controllerContext = NULL;

	/**
	 * Injects the controller context
	 *
	 * @param tx_dftabs_plugin1 $context
	 * @return void
	 */
	public function injectControllerContext(tx_dftabs_plugin1 $context) {
		$this->controllerContext = $context;
	}

	/**
	 * Returns the plugin configuration that contains configurations from
	 * different sources in the following order. The last available property
	 * wins!
	 *
	 * - Extension Configuration
	 * - TypoScript Configuration
	 * - Flexform Configuration
	 *
	 * @return array
	 */
	public function getConfiguration() {
		$configuration = array_merge(
			$this->getExtensionConfiguration(),
			$this->getTypoScriptConfiguration(),
			$this->getFlexformConfiguration()
		);

		if (isset($configuration['autoPlayInterval'])) {
			$configuration['autoPlayInterval'] = intval($configuration['autoPlayInterval']);
		}

		if (isset($configuration['pollingInterval'])) {
			$configuration['pollingInterval'] = intval($configuration['pollingInterval']);
		}

		if (isset($configuration['animationSpeed'])) {
			$configuration['animationSpeed'] = intval($configuration['animationSpeed']);
		}

		return $configuration;
	}

	/**
	 * Returns the extension configuration
	 *
	 * @return array
	 */
	protected function getExtensionConfiguration() {
		$configuration = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['df_tabs']);
		if (!is_array($configuration)) {
			return array();
		}

		return $configuration;
	}

	/**
	 * Returns the prepared typoscript configuration
	 *
	 * @return array
	 */
	protected function getTypoScriptConfiguration() {
		$configuration = (array) $this->controllerContext->conf;
		foreach ($configuration as $key => &$option) {
			if ($key{strlen($key) - 1} !== '.' && isset($configuration[$key . '.'])) {
				$option = $this->controllerContext->cObj->stdWrap($option, $configuration[$key . '.']);
			}
		}

		if (isset($configuration['titles'])) {
			$configuration['titles'] = t3lib_div::trimExplode(',', $configuration['titles'], TRUE);
		}

		return $configuration;
	}

	/**
	 * Returns the flexform configuration with fallback values
	 *
	 * @return array
	 */
	protected function getFlexformConfiguration() {
		$data =& $this->controllerContext->cObj->data['pi_flexform'];
		$configuration = array();

		$value = trim($this->controllerContext->pi_getFFvalue($data, 'ajax'));
		if ($value !== '') {
			$configuration['ajax'] = $value;
		}

		$value = trim($this->controllerContext->pi_getFFvalue($data, 'enableAutoPlay'));
		if ($value !== '') {
			$configuration['enableAutoPlay'] = $value;
		}

		$value = trim($this->controllerContext->pi_getFFvalue($data, 'enableMouseOver'));
		if ($value !== '') {
			$configuration['enableMouseOver'] = $value;
		}

		$value = trim($this->controllerContext->pi_getFFvalue($data, 'autoPlayInterval'));
		if ($value !== '') {
			$configuration['autoPlayInterval'] = intval($value);
		}

		$value = trim($this->controllerContext->pi_getFFvalue($data, 'animationSpeed'));
		if ($value !== '') {
			$configuration['animationSpeed'] = intval($value);
		}

		$value = trim($this->controllerContext->pi_getFFvalue($data, 'mode'));
		if ($value !== '') {
			$configuration['mode'] = $value;
		}

		$value = trim($this->controllerContext->pi_getFFvalue($data, 'titles'));
		if ($value !== '') {
			$configuration['titles'] = explode(chr(10), $value);
		}

		### BEGIN Compatibility Code ###
		$value = trim($this->controllerContext->pi_getFFvalue($data, 'pages'));
		if ($value !== '') {
			$configuration['data'] = $value;
		}

		$value = trim($this->controllerContext->pi_getFFvalue($data, 'tt_content'));
		if ($value !== '') {
			$configuration['data'] = $value;
		}
		### END Compatibility Code ###

		$value = trim($this->controllerContext->pi_getFFvalue($data, 'data'));
		if ($value !== '') {
			$configuration['data'] = $value;
		}

		return $configuration;
	}
}

?>