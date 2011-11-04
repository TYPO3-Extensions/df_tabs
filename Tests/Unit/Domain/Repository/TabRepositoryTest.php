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
 * Test case for class Tx_DfTabs_Domain_Repository_TabRepository.
 *
 * @author Stefan Galinski <sgalinski@df.eu>
 * @package df_tabs
 */
class Tx_DfTabs_Domain_Repository_TabRepositoryTest extends Tx_DfTabs_BaseTestCase {
	/**
	 * @var Tx_DfTabs_Domain_Repository_TabRepository
	 */
	protected $fixture;

	/**
	 * @return void
	 */
	public function setUp() {
		$this->fixture = $this->getAccessibleMock('Tx_DfTabs_Domain_Repository_TabRepository', array('getDataProvider'));
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
		/** @noinspection PhpUndefinedMethodInspection */
		$configuration = array('foo');
		$this->fixture->injectPluginConfiguration($configuration);
		$this->assertSame($configuration, $this->fixture->_get('pluginConfiguration'));
	}

	/**
	 * @test
	 * @return void
	 */
	public function contentObjectCanBeInjected() {
		/** @noinspection PhpUndefinedMethodInspection */
		$contentObject = new tslib_cObj;
		$this->fixture->injectContentObject($contentObject);
		$this->assertSame($contentObject, $this->fixture->_get('contentObject'));
	}

	/**
	 * @test
	 * @return void
	 */
	public function buildTabElementsReturnsATabElementCollectionWithPreferredAndDefaultTitle() {
		$this->fixture->injectPluginConfiguration(array('defaultTabTitle' => 'Title2'));

		/** @noinspection PhpUndefinedMethodInspection */
		$dataProvider = $this->getMock('Tx_DfTabs_DataProvider_AbstractBaseDataProvider');
		$this->fixture->expects($this->exactly(2))->method('getDataProvider')->will($this->returnValue($dataProvider));
		$dataProvider->expects($this->exactly(2))->method('getTabContent')->will($this->returnValue('Foo'));
		$dataProvider->expects($this->exactly(2))->method('getLinkData')->will($this->returnValue(''));
		$dataProvider->expects($this->once())->method('getTitle')->will($this->returnValue(''));

		$tab1 = new Tx_DfTabs_Domain_Model_Tab('Title1', 1);
		$tab1->setContent('Foo');

		$tab2 = new Tx_DfTabs_Domain_Model_Tab('Title2', 2);
		$tab2->setContent('Foo');

		$collection = $this->fixture->buildTabElements(array('Title1', ''), array());
		$this->assertEquals(array($tab1, $tab2), $collection);
	}

	/**
	 * @test
	 * @return void
	 */
	public function buildTabElementsReturnsATabElementCollectionDefinedByRecordsWithCalculatedTitles() {
		/** @noinspection PhpUndefinedMethodInspection */
		$dataProvider = $this->getMock('Tx_DfTabs_DataProvider_AbstractBaseDataProvider');
		$this->fixture->expects($this->exactly(2))->method('getDataProvider')->will($this->returnValue($dataProvider));
		$dataProvider->expects($this->exactly(2))->method('getTabContent')->will($this->returnValue('Foo'));
		$dataProvider->expects($this->exactly(2))->method('getLinkData')->will($this->returnValue(''));
		$dataProvider->expects($this->exactly(2))->method('getTitle')->will($this->returnValue('TITLE'));

		$tab1 = new Tx_DfTabs_Domain_Model_Tab('TITLE', 1);
		$tab1->setContent('Foo');

		$tab2 = new Tx_DfTabs_Domain_Model_Tab('TITLE', 2);
		$tab2->setContent('Foo');

		$collection = $this->fixture->buildTabElements(array(), array('pages_1', '2'));
		$this->assertEquals(array($tab1, $tab2), $collection);
	}

	/**
	 * @test
	 * @return void
	 */
	public function buildTabElementsReturnsATabElementCollectionWithMixedProviders() {
		/** @noinspection PhpUndefinedMethodInspection */
		$dataProvider = $this->getMock('Tx_DfTabs_DataProvider_AbstractBaseDataProvider');
		$this->fixture->expects($this->exactly(2))->method('getDataProvider')->will($this->returnValue($dataProvider));
		$dataProvider->expects($this->exactly(2))->method('getTabContent')->will($this->returnValue('Foo'));
		$dataProvider->expects($this->exactly(2))->method('getLinkData')->will($this->returnValue(''));
		$dataProvider->expects($this->exactly(2))->method('getTitle')->will($this->returnValue('Bar'));

		$tab1 = new Tx_DfTabs_Domain_Model_Tab('Bar', 2);
		$tab1->setContent('Foo');

		$tab2 = new Tx_DfTabs_Domain_Model_Tab('Bar', 2);
		$tab2->setContent('Foo');

		$collection = $this->fixture->buildTabElements(array(), array('pages_2', 'tt_content_2'));
		$this->assertEquals(array($tab1, $tab2), $collection);
	}

	/**
	 * @test
	 * @return void
	 */
	public function buildTabElementsReturnsATabElementCollectionWithAjaxInMind() {
		$this->fixture->injectPluginConfiguration(array('ajax' => '1',));

		/** @noinspection PhpUndefinedMethodInspection */
		$dataProvider = $this->getMock('Tx_DfTabs_DataProvider_AbstractBaseDataProvider');
		$this->fixture->expects($this->exactly(2))->method('getDataProvider')->will($this->returnValue($dataProvider));
		$dataProvider->expects($this->once())->method('getAjaxFallbackText')->will($this->returnValue('Fallback'));
		$dataProvider->expects($this->once())->method('getTabContent')->will($this->returnValue('Foo'));
		$dataProvider->expects($this->exactly(2))->method('getLinkData')->will($this->returnValue(''));
		$dataProvider->expects($this->exactly(2))->method('getTitle')->will($this->returnValue('Bar'));

		$tab1 = new Tx_DfTabs_Domain_Model_Tab('Bar', 2);
		$tab1->setContent('Foo');

		$tab2 = new Tx_DfTabs_Domain_Model_Tab('Bar', 2);
		$tab2->setContent('Fallback');

		$collection = $this->fixture->buildTabElements(array(), array('pages_2', 'tt_content_2'));
		$this->assertEquals(array($tab1, $tab2), $collection);
	}

	/**
	 * @test
	 * @return void
	 */
	public function getRecordsWithoutStdWrap() {
		$this->fixture->injectPluginConfiguration(array('data' => '1,2,3'));
		$this->assertSame(array('1', '2', '3'), $this->fixture->getRecords());
	}

	/**
	 * @test
	 * @return void
	 */
	public function getRecordsWithStdWrap() {
		$pluginConfiguration = array(
			'mode' => 'test',
			'stdWrap.' => array('test.' => array('foo' => 'bar')),
		);
		$this->fixture->injectPluginConfiguration($pluginConfiguration);

		/** @noinspection PhpParamsInspection */
		$contentObject = $this->getMock('tslib_cObj');
		$this->fixture->injectContentObject($contentObject);
		$contentObject->expects($this->once())->method('stdWrap')->will($this->returnValue('pages_2,tt_content_2'));

		$this->assertSame(array('pages_2', 'tt_content_2'), $this->fixture->getRecords());
	}
}

?>