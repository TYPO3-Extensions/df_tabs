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

/**
 * Test case for class Tx_DfTabs_Service_ConfigurationService.
 *
 * @author Stefan Galinski <sgalinski@df.eu>
 * @package df_tabs
 */
class Tx_DfTabs_Service_ConfigurationServiceTest extends Tx_DfTabs_BaseTestCase {
	/**
	 * @var Tx_DfTabs_Service_ConfigurationService
	 */
	protected $fixture;

	/**
	 * @var array
	 */
	protected $backupTypo3ConfigurationVars;

	/** @var tx_dftabs_plugin1 */
	protected $context = NULL;

	/**
	 * @return void
	 */
	public function setUp() {
		$this->backupTypo3ConfigurationVars = $GLOBALS['TYPO3_CONF_VARS'];
		$this->fixture = $this->getAccessibleMock('Tx_DfTabs_Service_ConfigurationService', array('dummy'));

		$this->context = new tx_dftabs_plugin1;
		$this->fixture->injectControllerContext($this->context);
	}

	/**
	 * @return void
	 */
	public function tearDown() {
		$GLOBALS['TYPO3_CONF_VARS'] = $this->backupTypo3ConfigurationVars;
		unset($this->fixture);
	}

	/**
	 * @test
	 * @return void
	 */
	public function controllerContextCanBeInjected() {
		/** @noinspection PhpParamsInspection */
		$context = $this->getMock('tx_dftabs_plugin1');
		$this->fixture->injectControllerContext($context);

		/** @noinspection PhpUndefinedMethodInspection */
		$this->assertSame($context, $this->fixture->_get('controllerContext'));
	}

	/**
	 * @test
	 * @return void
	 */
	public function getConfigurationReturnsCombinedConfigurationArray() {
		$expectedConfiguration = array(
			'conf1' => 'foo',
			'conf2' => 'foo',
			'mode' => 'mode',
		);

		$extensionConfiguration = array('conf1' => 'foo', 'conf2' => 'bar');
		$GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['df_tabs'] = serialize($extensionConfiguration);

		$this->context->conf = array('conf2' => 'foo');

		$this->context->cObj->data['pi_flexform'] = array(
			'data' => array(
				'sDEF' => array(
					'lDEF' => array(
						'mode' => array('vDEF' => 'mode'),
					),
				),
			),
		);

		$this->assertSame($expectedConfiguration, $this->fixture->getConfiguration());
	}

	/**
	 * @test
	 * @return void
	 */
	public function getConfigurationIgnoresUndefinedEntriesInFlexformConfiguration() {
		$expectedConfiguration = array(
			'mode' => 'mode',
		);

		$this->context->cObj->data['pi_flexform'] = array(
			'data' => array(
				'sDEF' => array(
					'lDEF' => array(
						'mode' => array('vDEF' => 'mode'),
						'conf1' => array('vDEF' => 'foo'),
					),
				),
			),
		);

		$this->assertSame($expectedConfiguration, $this->fixture->getConfiguration());
	}

	/**
	 * @test
	 * @return void
	 */
	public function getConfigurationHandlesSpecialTitlesPropertyInFlexformSource() {
		$expectedConfiguration = array(
			'titles' => array('foo', 'bar'),
		);

		$this->context->cObj->data['pi_flexform'] = array(
			'data' => array(
				'sDEF' => array(
					'lDEF' => array(
						'titles' => array('vDEF' => 'foo' . chr(10) . 'bar'),
					),
				),
			),
		);

		$this->assertSame($expectedConfiguration, $this->fixture->getConfiguration());
	}

	/**
	 * @test
	 * @return void
	 */
	public function getConfigurationHandlesSpecialTitlesPropertyInTypoScriptSource() {
		$expectedConfiguration = array(
			'titles' => array('foo', 'bar'),
		);

		$this->context->conf = array('titles' => 'foo,bar');

		$this->assertSame($expectedConfiguration, $this->fixture->getConfiguration());
	}
}

?>