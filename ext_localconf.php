<?php

if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

t3lib_extMgm::addPItoST43($GLOBALS['_EXTKEY'], 'Classes/Controller/PluginController.php', '_plugin1', 'list_type', 1);

$TYPO3_CONF_VARS['FE']['eID_include']['dftabs'] = 'EXT:df_tabs/Classes/Ajax/LoadAjax.php';

?>