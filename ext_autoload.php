<?php

$extensionPath = t3lib_extMgm::extPath('df_tabs');
return array(
	'tx_dftabs_ajax_loadajax' => $extensionPath . 'Classes/Ajax/LoadAjax.php',
	'tx_dftabs_domain_model_tab' => $extensionPath . 'Classes/Domain/Model/Tab.php',
	'tx_dftabs_domain_repository_tabrepository' => $extensionPath . 'Classes/Domain/Repository/TabRepository.php',
	'tx_dftabs_dataprovider_abstractbasedataprovider' => $extensionPath . 'Classes/DataProvider/AbstractBaseDataProvider.php',
	'tx_dftabs_dataprovider_abstractdatabasedataprovider' => $extensionPath . 'Classes/DataProvider/AbstractDataBaseDataProvider.php',
	'tx_dftabs_dataprovider_factorydataprovider' => $extensionPath . 'Classes/DataProvider/FactoryDataProvider.php',
	'tx_dftabs_dataprovider_pagesdataprovider' => $extensionPath . 'Classes/DataProvider/PagesDataProvider.php',
	'tx_dftabs_dataprovider_contentdataprovider' => $extensionPath . 'Classes/DataProvider/ContentDataProvider.php',
	'tx_dftabs_dataprovider_typoscriptdataprovider' => $extensionPath . 'Classes/DataProvider/TypoScriptDataProvider.php',
	'tx_dftabs_dataprovider_interfacedataprovider' => $extensionPath . 'Classes/DataProvider/InterfaceDataProvider.php',
	'tx_dftabs_service_configurationservice' => $extensionPath . 'Classes/Service/ConfigurationService.php',
	'tx_dftabs_view_typoscriptview' => $extensionPath . 'Classes/View/TypoScriptView.php',
	'tx_dftabs_plugin1' => $extensionPath . 'Classes/Controller/PluginController.php',
	'tx_dftabs_wizards_contentelementwizard' => $extensionPath . 'Classes/Wizards/ContentElementWizard.php',
	'tx_dftabs_basetestcase' => $extensionPath . 'Tests/Unit/BaseTestCase.php',
);

?>