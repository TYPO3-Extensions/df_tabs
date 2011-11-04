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
 * Test case for class Tx_DfTabs_DataProvider_TypoScriptDataProvider.
 *
 * @author Stefan Galinski <sgalinski@df.eu>
 * @package df_tabs
 */
class Tx_DfTabs_DataProvider_TypoScriptDataProviderTest extends Tx_DfTabs_BaseTestCase {
	/**
	 * @var Tx_DfTabs_DataProvider_TypoScriptDataProvider
	 */
	protected $fixture;

	/**
	 * @var tslib_cObj
	 */
	protected $contentObject;

	/**
	 * @return void
	 */
	public function setUp() {
		$this->fixture = new Tx_DfTabs_DataProvider_TypoScriptDataProvider();

		/** @noinspection PhpParamsInspection */
		$this->contentObject = $this->getMock('tslib_cObj');
		$this->fixture->injectContentObject($this->contentObject);
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
	public function getTabContentReturnsTheResultsOfDedicatedStandardWraps() {
		$pluginConfiguration = array(
			'stdWrap.' => array(
				'typoscriptData.' => array(
					'tab1.' => array(
						'foo' => 'bar',
					),
				),
			),
		);
		$this->fixture->injectPluginConfiguration($pluginConfiguration);

		/** @noinspection PhpUndefinedMethodInspection */
		$this->contentObject->expects($this->once())->method('stdWrap')
			->with('', array('foo' => 'bar'))->will($this->returnValue('Foo'));

		$this->assertSame('Foo', $this->fixture->getTabContent(1));
	}

	/**
	 * @test
	 * @return void
	 */
	public function getLinkDataReturnsTheResultsOfDedicatedStandardWraps() {
		$pluginConfiguration = array(
			'stdWrap.' => array(
				'typoscriptLinks.' => array(
					'tab1.' => array(
						'foo' => 'bar',
					),
				),
			),
		);
		$this->fixture->injectPluginConfiguration($pluginConfiguration);

		/** @noinspection PhpUndefinedMethodInspection */
		$this->contentObject->expects($this->once())->method('stdWrap')
			->with('', array('foo' => 'bar'))->will($this->returnValue('Foo'));

		$this->assertSame('Foo', $this->fixture->getLinkData(1));
	}

	/**
	 * @test
	 * @return void
	 */
	public function getAjaxFallbackTextReturnsTheResultsOfDedicatedStandardWraps() {
		$pluginConfiguration = array(
			'stdWrap.' => array(
				'typoscriptAjaxFallbackText.' => array(
					'tab1.' => array(
						'foo' => 'bar',
					),
				),
			),
		);
		$this->fixture->injectPluginConfiguration($pluginConfiguration);

		/** @noinspection PhpUndefinedMethodInspection */
		$this->contentObject->expects($this->once())->method('stdWrap')
			->with('', array('foo' => 'bar'))->will($this->returnValue('Foo'));

		$this->assertSame('Foo', $this->fixture->getAjaxFallbackText(1));
	}
}

?>