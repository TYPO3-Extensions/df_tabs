<?php
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2009-2011 domainfactory GmbH (Stefan Galinski <sgalinski@df.eu>)
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
 * Class that adds the wizard icon for the plugin plugin1 of this extension.
 *
 * @author Stefan Galinski <sgalinski@df.eu>
 * @package TYPO3
 * @subpackage df_tabs
 */
class Tx_DfTabs_Wizards_ContentElementWizard {
	/**
	 * Adds an own wizard entry to the given list.
	 *
	 * @param array	$wizardItems current wizard items
	 * @return array modified array with wizard items
	 */
	public function proc($wizardItems) {
		$locallang = t3lib_div::readLLXMLfile(
			t3lib_extMgm::extPath('df_tabs') . 'Resources/Private/Language/locallang.xml',
			$GLOBALS['LANG']->lang
		);

		$wizardItems['plugins_tx_dftabs_plugin1'] = array(
			'icon' => t3lib_extMgm::extRelPath('df_tabs') . 'Resources/Public/Images/contentElementWizard.png',
			'title' => $GLOBALS['LANG']->getLLL('plugin1_title', $locallang),
			'description' => $GLOBALS['LANG']->getLLL('plugin1_plus_wiz_description', $locallang),
			'params' => '&defVals[tt_content][CType]=list' .
				'&defVals[tt_content][list_type]=df_tabs_plugin1'
		);

		return $wizardItems;
	}
}

?>