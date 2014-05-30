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

if (!defined('PATH_typo3conf')) {
	die('Could not access this script directly!');
}

require_once(t3lib_extMgm::extPath('css_styled_content') . '/pi1/class.tx_cssstyledcontent_pi1.php');

/**
 * Ajax Postloader
 */
class Tx_DfTabs_Ajax_LoadAjax {
	/**
	 * @var array
	 */
	protected $content = array();

	/**
	 * Controlling method
	 *
	 * @return void
	 */
	public function main() {
		tslib_eidtools::connectDB();
		tslib_eidtools::initTCA();

		$parameters = t3lib_div::_GP('df_tabs');
		$this->initTSFE($parameters['id']);

		/** @var $controller tx_dftabs_plugin1 */
		$controller = t3lib_div::makeInstance('tx_dftabs_plugin1');
		$controller->cObj = $GLOBALS['TSFE']->cObj;
		$controller->conf = $GLOBALS['TSFE']->tmpl->setup['plugin.']['tx_dftabs_plugin1.'];
		$controller->conf['ajax'] = FALSE;

		$records = t3lib_div::trimExplode(',', $parameters['records']);
		$this->content = $controller->ajax($records, $parameters['mode']);
	}

	/**
	 * Prints the content
	 *
	 * @return void
	 */
	public function printContent() {
		header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
		header('Cache-Control: no-store, no-cache, must-revalidate');
		header('Cache-Control: post-check=0, pre-check=0', FALSE);
		header('Pragma: no-cache');

		echo $this->content;
	}

	/**
	 * Initializes the TSFE object
	 *
	 * @param int $pageId
	 * @return void
	 */
	protected function initTSFE($pageId) {
		if (!is_object($GLOBALS['TSFE'])) {
			$GLOBALS['TSFE'] = t3lib_div::makeInstance('tslib_fe', $GLOBALS['TYPO3_CONF_VARS'], $pageId, 0);
			$GLOBALS['TSFE']->initFEuser();
			$GLOBALS['TSFE']->fetch_the_id();
			$GLOBALS['TSFE']->getPageAndRootline();
			$GLOBALS['TSFE']->initTemplate();
			$GLOBALS['TSFE']->forceTemplateParsing = TRUE;
			$GLOBALS['TSFE']->getCompressedTCarray();
			$GLOBALS['TSFE']->getConfigArray();
			$GLOBALS['TSFE']->absRefPrefix = $GLOBALS['TSFE']->config['config']['absRefPrefix'];

			$GLOBALS['TSFE']->no_cache = TRUE;
			$GLOBALS['TSFE']->tmpl->start($GLOBALS['TSFE']->rootLine);
			$GLOBALS['TSFE']->no_cache = FALSE;
			$GLOBALS['TSFE']->newCObj();
		}
	}
}

/** @var $object Tx_DfTabs_Ajax_LoadAjax */
$object = t3lib_div::makeInstance('Tx_DfTabs_Ajax_LoadAjax');
$object->main();
$object->printContent();

?>