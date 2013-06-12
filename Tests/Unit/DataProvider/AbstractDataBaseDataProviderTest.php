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
 * Test case for class Tx_DfTabs_DataProvider_AbstractDataBaseDataProvider.
 */
class Tx_DfTabs_DataProvider_AbstractDataBaseDataProviderTest extends Tx_DfTabs_BaseTestCase {
	/**
	 * @var Tx_DfTabs_DataProvider_AbstractDataBaseDataProvider
	 */
	protected $fixture;

	/**
	 * @var t3lib_DB
	 */
	protected $backupDatabase = NULL;

	/**
	 * @var t3lib_DB | PHPUnit_Framework_MockObject_MockObject
	 */
	protected $database;

	/**
	 * @var tslib_cObj
	 */
	protected $contentObject = NULL;

	/**
	 * @return void
	 */
	public function setUp() {
		$this->backupDatabase = $GLOBALS['TYPO3_DB'];
		$GLOBALS['TYPO3_DB'] = $this->database = $this->getMock('t3lib_DB');

		$this->fixture = $this->getAccessibleMock(
			'Tx_DfTabs_DataProvider_AbstractDataBaseDataProvider', array('dummy')
		);
		$this->contentObject = $this->getMock('tslib_cObj');
		$this->fixture->injectContentObject($this->contentObject);
	}

	/**
	 * @return void
	 */
	public function tearDown() {
		$GLOBALS['TYPO3_DB'] = $this->backupDatabase;
		unset($this->fixture);
	}

	/**
	 * @test
	 * @return void
	 */
	public function getTabContentCallsContentObjectsRecordsMethodWithoutOwnRecordsConfiguration() {
		$configuration = array(
			'tables' => 'tt_content',
			'source' => '10',
			'dontCheckPid' => 1,
		);

		/** @noinspection PhpUndefinedMethodInspection */
		$this->contentObject->expects($this->once())->method('RECORDS')
			->with($configuration)->will($this->returnValue('Foo'));

		/** @noinspection PhpUndefinedMethodInspection */
		$this->assertSame('Foo', $this->fixture->_call('getTabContent', 10));
	}

	/**
	 * @test
	 * @return void
	 */
	public function getTabContentCallsContentObjectsRecordsMethodWithCustomRecordsConfiguration() {
		$pluginConfiguration = array('records.' => array('source' => 15));
		$this->fixture->injectPluginConfiguration($pluginConfiguration);

		$configuration = array(
			'tables' => 'tt_content',
			'source' => '15',
			'dontCheckPid' => 1,
		);

		/** @noinspection PhpUndefinedMethodInspection */
		$this->contentObject->expects($this->once())->method('RECORDS')
			->with($configuration)->will($this->returnValue('Foo'));

		/** @noinspection PhpUndefinedMethodInspection */
		$this->assertSame('Foo', $this->fixture->_call('getTabContent', array(12, 13)));
	}

	/**
	 * @test
	 * @return void
	 */
	public function getTitleFetchesTheTitleFromTheDatabase() {
		/** @noinspection PhpUndefinedMethodInspection */
		$this->fixture->_set('table', 'pages');

		$pluginConfiguration = array('pages.' => array('titleField' => 'title'));
		$this->fixture->injectPluginConfiguration($pluginConfiguration);

		/** @noinspection PhpUndefinedMethodInspection */
		$this->database->expects($this->once())->method('exec_SELECTgetSingleRow')
			->with('*', 'pages', 'uid = 1')->will($this->returnValue(array('title' => 'Foo')));
		$this->assertSame('Foo', $this->fixture->getTitle(1));
	}

	/**
	 * @test
	 * @return void
	 */
	public function getLinkDataFetchesTheLinkDataFromTheDatabase() {
		/** @noinspection PhpUndefinedMethodInspection */
		$this->fixture->_set('table', 'tt_content');

		$pluginConfiguration = array('tt_content.' => array('linkField' => 'header_link'));
		$this->fixture->injectPluginConfiguration($pluginConfiguration);

		/** @noinspection PhpUndefinedMethodInspection */
		$this->database->expects($this->once())->method('exec_SELECTgetSingleRow')
			->with('*', 'tt_content', 'uid = 1')->will($this->returnValue(array('header_link' => 'Foo')));
		$this->assertSame('Foo', $this->fixture->getLinkData(1));
	}

	/**
	 * @test
	 * @return void
	 */
	public function getAjaxFallbackTextFetchesTheTextFromTheDatabase() {
		/** @noinspection PhpUndefinedMethodInspection */
		$this->fixture->_set('table', 'tt_content');

		$pluginConfiguration = array('tt_content.' => array('ajaxFallbackTextField' => 'altText'));
		$this->fixture->injectPluginConfiguration($pluginConfiguration);

		/** @noinspection PhpUndefinedMethodInspection */
		$this->database->expects($this->once())->method('exec_SELECTgetSingleRow')
			->with('*', 'tt_content', 'uid = 1')->will($this->returnValue(array('altText' => 'Foo')));
		$this->assertSame('Foo', $this->fixture->getAjaxFallbackText(1));
	}

	/**
	 * @test
	 * @return void
	 */
	public function getTitleAndGetLinkDataAreUsingTheInternalCache() {
		/** @noinspection PhpUndefinedMethodInspection */
		$this->fixture->_set('table', 'pages');

		$pluginConfiguration = array('pages.' => array('titleField' => 'title', 'linkField' => 'header_link'));
		$this->fixture->injectPluginConfiguration($pluginConfiguration);

		/** @noinspection PhpUndefinedMethodInspection */
		$this->database->expects($this->once())->method('exec_SELECTgetSingleRow')
			->with('*', 'pages', 'uid = 1')->will($this->returnValue(array('title' => 'Foo', 'header_link' => 'Bar')));

		$this->assertSame('Foo', $this->fixture->getTitle(1));
		$this->assertSame('Bar', $this->fixture->getLinkData(1));
	}
}

?>