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

/**
 * Test case for class Tx_DfTabs_Domain_Model_Tab.
 */
class Tx_DfTabs_Domain_Model_LinkCheckTest extends Tx_DfTabs_BaseTestCase {
	/**
	 * @var Tx_DfTabs_Domain_Model_Tab
	 */
	protected $fixture;

	/**
	 * @return void
	 */
	public function setUp() {
		$this->fixture = new Tx_DfTabs_Domain_Model_Tab('foo', 12);
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
	public function setTitleWorks() {
		$this->fixture->setTitle('FooBar');
		$this->assertSame('FooBar', $this->fixture->getTitle());
	}

	/**
	 * @test
	 * @return void
	 */
	public function setRecordWorks() {
		$this->fixture->setRecord('1');
		$this->assertSame(1, $this->fixture->getRecord());

		$this->fixture->setRecord(2);
		$this->assertSame(2, $this->fixture->getRecord());
	}

	/**
	 * @test
	 * @return void
	 */
	public function setLinkWorks() {
		$this->fixture->setLink('1 _blank');
		$this->assertSame('1 _blank', $this->fixture->getLink());
	}

	/**
	 * @test
	 * @return void
	 */
	public function setContentWorks() {
		$this->fixture->setContent(array('FooBar'));
		$this->assertSame(array('FooBar'), $this->fixture->getContent());
	}
}

?>