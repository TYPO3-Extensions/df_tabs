<?php

if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

// remove default plugin fields
t3lib_div::loadTCA('tt_content');
$list = 'layout,select_key,pages,recursive';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist']['df_tabs_plugin1'] = $list;

// add flexform configuration
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist']['df_tabs_plugin1'] = 'pi_flexform';
t3lib_extMgm::addPiFlexFormValue('df_tabs_plugin1', 'FILE:EXT:df_tabs/Configuration/FlexForms/flexform.xml');

// add plugin
t3lib_extMgm::addPlugin(
	array(
		'LLL:EXT:df_tabs/Resources/Private/Language/locallang.xlf:tt_content.list_type_plugin1',
		'df_tabs_plugin1',
		t3lib_extMgm::extRelPath('df_tabs') . 'Resources/Public/Images/contentElementWizard.png'
	),
	'list_type'
);

// add static typoscript template
t3lib_extMgm::addStaticFile('df_tabs', 'Configuration/TypoScript/', 'df_tabs');

// add plugin to the content element wizard list
if (TYPO3_MODE === 'BE') {
	$GLOBALS['TBE_MODULES_EXT']['xMOD_db_new_content_el']['addElClasses']['Tx_DfTabs_Wizards_ContentElementWizard'] =
		t3lib_extMgm::extPath('df_tabs') . 'Classes/Wizards/ContentElementWizard.php';
}

?>