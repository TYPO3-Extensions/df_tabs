<?php

if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

t3lib_extMgm::addPItoST43('df_tabs', 'Classes/Controller/PluginController.php', '_plugin1', 'list_type', 1);

$GLOBALS['TYPO3_CONF_VARS']['FE']['eID_include']['dftabs'] = 'EXT:df_tabs/Classes/Ajax/LoadAjax.php';

// set global storage pid
$dfTabsExtConf = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['df_tabs']);
$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['df_tabs']['useJQuery'] = $dfTabsExtConf['useJQuery'] ? 1 : 0;

?>