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
 * A Tab
 *
 * @author Stefan Galinski <sgalinski@df.eu>
 * @package	TYPO3
 * @subpackage df_tabs
 */
class Tx_DfTabs_Domain_Model_Tab {
	/**
	 * Title
	 *
	 * @var string
	 */
	protected $title;

	/**
	 * Record Id
	 *
	 * @var int
	 */
	protected $record;

	/**
	 * TypoScript Link Data
	 *
	 * @var string
	 */
	protected $link;

	/**
	 * Rendered Content
	 *
	 * @var string
	 */
	protected $content;

	/**
	 * Sets title and record
	 *
	 * @param string $title
	 * @param int $record
	 */
	public function __construct($title, $record) {
		$this->setTitle($title);
		$this->setRecord($record);
	}

	/**
	 * Sets the title
	 *
	 * @param string $title
	 * @return void
	 */
	public function setTitle($title) {
		$this->title = $title;
	}

	/**
	 * Sets the record id
	 *
	 * @param int $record
	 * @return void
	 */
	public function setRecord($record) {
		$this->record = intval($record);
	}

	/**
	 * Returns the title
	 *
	 * @return string
	 */
	public function getTitle() {
		return $this->title;
	}

	/**
	 * Returns the record id
	 *
	 * @return int
	 */
	public function getRecord() {
		return $this->record;
	}

	/**
	 * Sets the link data
	 *
	 * @param string $link
	 * @return void
	 */
	public function setLink($link) {
		$this->link = $link;
	}

	/**
	 * Returns the link data
	 *
	 * @return string
	 */
	public function getLink() {
		return $this->link;
	}

	/**
	 * Set's the content
	 *
	 * @param string $content
	 * @return void
	 */
	public function setContent($content) {
		$this->content = $content;
	}

	/**
	 * Returns the content
	 *
	 * @return string
	 */
	public function getContent() {
		return $this->content;
	}
}

?>