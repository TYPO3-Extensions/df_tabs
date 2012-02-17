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
 * Plugin for the 'df_tabs' extension
 *
 * @author Stefan Galinski <sgalinski@df.eu>
 * @package	TYPO3
 * @subpackage df_tabs
 */
class tx_dftabs_plugin1 extends tslib_pibase {
	public $prefixId = 'tx_dftabs_plugin1';
	public $scriptRelPath = 'Resources/Private/Language/locallang.xml';
	public $extKey = 'df_tabs';
	public $pi_checkCHash = TRUE;

	/**
	 * @var tslib_cObj
	 */
	public $cObj;

	/**
	 * Data Provider Instance
	 *
	 * @var Tx_DfTabs_DataProvider_AbstractBaseDataProvider
	 */
	protected $dataProvider = NULL;

	/**
	 * Plugin configuration
	 *
	 * @var array
	 */
	protected $pluginConfiguration = array();

	/**
	 * Returns an instance of the renderer
	 *
	 * @return Tx_DfTabs_View_TypoScriptView
	 */
	protected function getRenderer() {
		/** @var $renderer Tx_DfTabs_View_TypoScriptView */
		$renderer = t3lib_div::makeInstance('Tx_DfTabs_View_TypoScriptView');
		$renderer->injectPluginConfiguration($this->pluginConfiguration);
		$renderer->injectPageRenderer($GLOBALS['TSFE']->getPageRenderer());
		$renderer->injectContentObject($this->cObj);

		return $renderer;
	}

	/**
	 * Returns an instance of the configuration manager
	 *
	 * @return Tx_DfTabs_Service_ConfigurationService
	 */
	protected function getConfigurationManager() {
		/** @var $configurationManager Tx_DfTabs_Service_ConfigurationService */
		$configurationManager = t3lib_div::makeInstance('Tx_DfTabs_Service_ConfigurationService');
		$configurationManager->injectControllerContext($this);

		return $configurationManager;
	}

	/**
	 * Returns an instance of the tab repository
	 *
	 * @return Tx_DfTabs_Domain_Repository_TabRepository
	 */
	protected function getTabRepository() {
		/** @var $repository Tx_DfTabs_Domain_Repository_TabRepository */
		$repository = t3lib_div::makeInstance('Tx_DfTabs_Domain_Repository_TabRepository');
		$repository->injectContentObject($this->cObj);
		$repository->injectPluginConfiguration($this->pluginConfiguration);

		return $repository;
	}

	/**
	 * Controls the data flow from the repository to the view to render
	 * the tab menus
	 *
	 * @param string $content
	 * @param array $configuration
	 * @return string
	 */
	public function main($content, $configuration) {
		try {
			$this->conf = $configuration;
			$this->pi_setPiVarDefaults();
			$this->pi_loadLL();
			$this->pi_initPIflexForm();

			$this->pluginConfiguration = $this->getConfigurationManager()->getConfiguration();

			$repository = $this->getTabRepository();
			$renderer = $this->getRenderer();

			$records = $repository->getRecords();
			$tabElements = $repository->buildTabElements($this->pluginConfiguration['titles'], $records);
			$content .= $renderer->renderTabs($tabElements);
			$renderer->addInlineJavaScriptCode($records, $this->pluginConfiguration['mode']);

		} catch (Exception $exception) {
			$content = $exception->getMessage();
		}

		$this->prefixId = $this->pluginConfiguration['classPrefix'] . 'plugin1';
		return $this->pi_wrapInBaseClass($content);
	}

	/**
	 * Controls the data flow for the usage within an AJAX call that should
	 * only return the contents of the given records
	 *
	 * @param array $records
	 * @param string $mode
	 * @return string
	 */
	public function ajax($records, $mode) {
		$content = '';
		try {
			$configurationManager = $this->getConfigurationManager();
			$this->pluginConfiguration = $configurationManager->getConfiguration();
			$this->pluginConfiguration['mode'] = $mode;

			$repository = $this->getTabRepository();
			$tabElements = $repository->buildTabElements(array(), $records);

			/** @var $element Tx_DfTabs_Domain_Model_Tab */
			foreach ($tabElements as $element) {
				$content .= '<div>' . $element->getContent() . '</div>';
			}

		} catch (Exception $exception) {
			$content = $exception->getMessage();
		}

		return $content;
	}
}

?>