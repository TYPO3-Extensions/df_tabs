<?php

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2011 domainfactory GmbH (Stefan Galinski <sgalinski@df.eu>)
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
 * Renders the content
 *
 * @author Stefan Galinski <sgalinski@df.eu>
 * @package	TYPO3
 * @subpackage df_tabs
 */
class Tx_DfTabs_View_TypoScriptView {
	/**
	 * @var array
	 */
	protected $pluginConfiguration = array();

	/**
	 * Page Renderer Instance
	 *
	 * @var t3lib_PageRenderer
	 */
	protected $pageRenderer = NULL;
	
	/**
	 * @var tslib_cObj
	 */
	protected $contentObject = NULL;
	
	/**
	 * Injects the plugin configuration
	 *
	 * @param array $configuration
	 * @return void
	 */
	public function injectPluginConfiguration(array $configuration) {
		$this->pluginConfiguration = $configuration;
	}
	
	/**
	 * Injects the page renderer
	 * 
	 * @param t3lib_PageRenderer $pageRenderer
	 * @return void
	 */
	public function injectPageRenderer(t3lib_PageRenderer $pageRenderer) {
		$this->pageRenderer = $pageRenderer;
	}
	
	/**
	 * Injects the content object
	 * 
	 * @param tslib_cObj $contentObject
	 * @return void
	 */
	public function injectContentObject(tslib_cObj $contentObject) {
		$this->contentObject = $contentObject;
	}

	/**
	 * Adds the inline javascript code for this plugin
	 *
	 * @param array $records
	 * @param string $mode
	 * @return void
	 */
	public function addInlineJavaScriptCode($records, $mode) {
		if ($this->pluginConfiguration['enableJavascript'] !== '1') {
			return;
		}

		$uid = $this->contentObject->data['uid'];
		$config = &$this->pluginConfiguration;

		$animationCallback = '';
		if ($config['animationCallback'] !== '') {
			$animationCallback = ',animationCallback: ' . $config['animationCallback'];
		}

		array_shift($records);
		$inlineJavaScript = '
			document.documentElement.className = "' . $this->addPrefix('plugin1-hasJS') . ' "
				+ document.documentElement.className;
			window.addEvent("domready", function() {
				this.TabBar' . $uid . ' = new TabBar(
					$$("#' . $this->addPrefix('tabMenu-' . $uid) . ' > ' . $config['menuNodeType'] . '"),
					$$("#' . $this->addPrefix('tabContents-' . $uid) . ' > ' . $config['contentNodeType'] . '"), {
						autoPlayInterval: ' . $config['autoPlayInterval'] . ',
						enableAjax: ' . ($config['ajax'] ? 'true' : 'false') . ',
						ajaxPageId: ' . intval($GLOBALS['TSFE']->id) . ',
						ajaxRecords: "' . implode(',', $records) . '",
						ajaxPluginMode: "' . $mode . '",
						enableAutoPlay: ' . ($config['enableAutoPlay'] ? 'true' : 'false') . ',
						enableMouseOver: ' . ($config['enableMouseOver'] ? 'true' : 'false') . ',
						classPrefix: "' . $config['classPrefix'] . '",
						hashName: "' . $config['hashName'] . '",
						pollingInterval: ' . $config['pollingInterval'] . ',
						onBeforeInitialize: ' . $config['events.']['onBeforeInitialize'] . ',
						onAfterInitialize: ' . $config['events.']['onAfterInitialize'] . ',
						onTabChange: ' . $config['events.']['onTabChange'] . '
						' . $animationCallback . '
					}
				);
			});
		';

		$this->pageRenderer->addJsFooterInlineCode(
			$this->addPrefix('plugin1') . 'tx_dftabs_' . $uid,
			$inlineJavaScript
		);
	}

	/**
	 * Renders the tabs
	 *
	 * @param array $tabElements
	 * @return string
	 */
	public function renderTabs($tabElements) {
		if (!count($tabElements)) {
			return '';
		}

		$tabContents = $tabMenuEntries = '';
		for ($index = 0; $index < count($tabElements); ++$index) {
			$tabContents .= $this->getTabContent($tabElements[$index], $index);
			$tabMenuEntries .= $this->getTabMenuEntry($tabElements[$index], $index);
		}

		$tabContents = str_replace(
			array('###CLASSES###', '###ID###'),
			array($this->addPrefix('tabContents'), $this->addPrefix('tabContents-' . $this->contentObject->data['uid'])),
			$this->stdWrap($tabContents, 'tabContents')
		);

		$tabMenuEntries = str_replace(
			array('###CLASSES###', '###ID###'),
			array($this->addPrefix('tabMenu'), $this->addPrefix('tabMenu-' . $this->contentObject->data['uid'])),
			$this->stdWrap($tabMenuEntries, 'tabMenu')
		);

		return $tabMenuEntries . PHP_EOL . $tabContents . PHP_EOL;
	}

	/**
	 * Renders a tab menu entry
	 *
	 * @param Tx_DfTabs_Domain_Model_Tab $tabElement
	 * @param int $index
	 * @return string
	 */
	protected function getTabMenuEntry(Tx_DfTabs_Domain_Model_Tab $tabElement, $index) {
		$menuEntry = $this->stdWrap($tabElement->getTitle(), 'tabMenuEntry');

		$classes = $this->addPrefix('tabMenuEntry') .
			($index === 0 ? ' ' . $this->addPrefix('tabMenuEntrySelected') : '');
		$id = $this->addPrefix('tabMenuEntry' . $index);
		$linkId = $this->pluginConfiguration['hashName'] . $index;
		$hash = $this->contentObject->currentPageUrl(t3lib_div::_GET()) . '#' . $linkId;

		$typolink = $target = '';
		if (strpos($menuEntry, '###LINK###') !== FALSE) {
			$typolink = $this->contentObject->typoLink('', array(
				'parameter' => $tabElement->getLink(),
				'returnLast' => 'url'
			));

			$target = $this->contentObject->typoLink('', array(
				'parameter' => $tabElement->getLink(),
				'returnLast' => 'target'
			));
			$target = ($target === '' ? '_self' : $target);
		}

		$menuEntry = str_replace(
			array('###CLASSES###', '###ID###', '###LINK_ANCHOR###', '###LINK_ID###', '###LINK###', '###TARGET###'),
			array($classes, $id, $hash, $linkId, $typolink, $target),
			$menuEntry
		);

		return $menuEntry;
	}

	/**
	 * Returns a rendered content tab without the related menu entry. The markup is completely
	 * configurable by the usage of typoscript. The title parameter is added add the top of the
	 * tab and can be used for fallback purposes (no javascript) and for SEO.
	 *
	 * @param Tx_DfTabs_Domain_Model_Tab $tabElement
	 * @param int $index
	 * @return string
	 */
	protected function getTabContent(Tx_DfTabs_Domain_Model_Tab $tabElement, $index) {
		$tabContent = $this->stdWrap($tabElement->getContent(), 'tabContent');
		$classes = $this->addPrefix('tabContent') . ($index === 0 ? ' ' . $this->addPrefix('tabContentSelected') : '');
		$tabContent = str_replace(
			array('###CLASSES###', '###ID###'),
			array($classes, $this->addPrefix('tabContent' . $index)),
			$tabContent
		);

		$tab = str_replace(
			'###CLASSES###',
			$this->addPrefix('tabTitle'),
			$this->stdWrap($tabElement->getTitle(), 'tabTitle')
		);

		return $tab . PHP_EOL . $tabContent;
	}

	/**
	 * Adds a prefix to a given string
	 *
	 * @param string $string
	 * @return string
	 */
	protected function addPrefix($string) {
		return $this->pluginConfiguration['classPrefix'] . $string;
	}

	/**
	 * Returns the given content after applying a stdWrap call
	 *
	 * @param string $content
	 * @param string $wrap name of the stdWrap property
	 * @return string
	 */
	protected function stdWrap($content, $wrap) {
		if (isset($this->pluginConfiguration['stdWrap.'][$wrap . '.'])) {
			$content = $this->contentObject->stdWrap($content, $this->pluginConfiguration['stdWrap.'][$wrap . '.']);
		}

		return $content;
	}
}

?>