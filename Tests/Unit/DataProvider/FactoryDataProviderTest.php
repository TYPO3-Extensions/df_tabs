<?php

/***************************************************************
 *  Copyright notice
 *
 *  (c) domainfactory GmbH (Stefan Galinski <stefan.galinski@gmail.com>)
 *
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

require_once(t3lib_extMgm::extPath('df_tabs') . 'Tests/Unit/BaseTestCase.php');
require_once(t3lib_extMgm::extPath('df_tabs') . 'Classes/DataProvider/InterfaceDataProvider.php');

/**
 * Test case for class Tx_DfTabs_DataProvider_FactoryDataProvider.
 */
class Tx_DfTabs_DataProvider_FactoryDataProviderTest extends Tx_DfTabs_BaseTestCase {
	/**
	 * @return array
	 */
	public function getDataProviderReturnsProviderBasedOnModeDataProvider() {
		return array(
			'content' => array(
				'tt_content', 'Tx_DfTabs_DataProvider_ContentDataProvider'
			),
			'pages' => array(
				'pages', 'Tx_DfTabs_DataProvider_PagesDataProvider'
			),
			'typoscript' => array(
				'typoscript', 'Tx_DfTabs_DataProvider_TypoScriptDataProvider'
			),
		);
	}

	/**
	 * @dataProvider getDataProviderReturnsProviderBasedOnModeDataProvider
	 * @test
	 * @param string $mode
	 * @param string $expectedDataProvider
	 * @return void
	 */
	public function getDataProviderReturnsProviderBasedOnMode($mode, $expectedDataProvider) {
		$contentObject = new tslib_cObj();
		$dataProvider = Tx_DfTabs_DataProvider_FactoryDataProvider::getDataProvider(
			$mode, array('mode' => $mode), $contentObject
		);
		$this->assertInstanceOf($expectedDataProvider, $dataProvider);
	}

	/**
	 * @expectedException tx_dftabs_Exception_GenericException
	 * @test
	 * @return void
	 */
	public function getDataProviderThrowsExceptionIfNoValidMatchIsAvailable() {
		$contentObject = new tslib_cObj();
		Tx_DfTabs_DataProvider_FactoryDataProvider::getDataProvider('foo', array('mode' => 'foo'), $contentObject);
	}
}

?>