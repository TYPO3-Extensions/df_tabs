<?php

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2011 domainfactory GmbH (Stefan Galinski <sgalinski@df.eu>)
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
 * Test case for class Tx_DfTabs_DataProvider_AbstractBaseDataProvider.
 *
 * @author Stefan Galinski <sgalinski@df.eu>
 * @package df_tabs
 */
class Tx_DfTabs_DataProvider_AbstractBaseDataProviderTest extends Tx_DfTabs_BaseTestCase {
	/**
	 * @var Tx_DfTabs_DataProvider_AbstractBaseDataProvider
	 */
	protected $fixture;

	/**
	 * @return void
	 */
	public function setUp() {
		$this->fixture = $this->getAccessibleMock(
			'Tx_DfTabs_DataProvider_AbstractBaseDataProvider',
			array('getLinkData', 'getTabContent', 'getTitle', 'getAjaxFallbackText')
		);
	}

	/**
	 * @return void
	 */
	public function tearDown() {
		unset($this->fixture);
	}

	/**
	 * @test
	 * @return void
	 */
	public function pluginConfigurationCanBeInjected() {
		$configuration = array('foo');
		$this->fixture->injectPluginConfiguration($configuration);

		/** @noinspection PhpUndefinedMethodInspection */
		$this->assertSame($configuration, $this->fixture->_get('pluginConfiguration'));
	}

	/**
	 * @test
	 * @return void
	 */
	public function contentObjectCanBeInjected() {
		$contentObject = new tslib_cObj;
		$this->fixture->injectContentObject($contentObject);

		/** @noinspection PhpUndefinedMethodInspection */
		$this->assertSame($contentObject, $this->fixture->_get('contentObject'));
	}
}

?>