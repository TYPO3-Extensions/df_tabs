<?php

########################################################################
# Extension Manager/Repository config file for ext "df_tabs".
#
# Auto generated 07-11-2011 14:50
#
# Manual updates:
# Only the data in the array - everything else is removed by next
# writing. "version" and "dependencies" must not be touched!
########################################################################

$EM_CONF[$_EXTKEY] = array(
	'title' => 'Tabbed Content and Pages',
	'description' => 'Create tab based content elements and pages easily and flexible with configurable mouseover handling, animations, ajax and autoplay features! It\'s based upon mootools.',
	'category' => 'fe',
	'shy' => 0,
	'version' => '3.0.0',
	'dependencies' => '',
	'conflicts' => '',
	'priority' => '',
	'loadOrder' => '',
	'module' => '',
	'state' => 'stable',
	'uploadfolder' => 0,
	'createDirs' => '',
	'modify_tables' => '',
	'clearcacheonload' => 0,
	'lockType' => '',
	'author' => 'Stefan Galinski',
	'author_email' => 'sgalinski@df.eu',
	'author_company' => 'domainFACTORY',
	'CGLcompliance' => '',
	'CGLcompliance_note' => '',
	'constraints' => array(
		'depends' => array(
			'php' => '5.2.0-5.3.99',
			'typo3' => '4.5.0-4.6.99',
		),
		'conflicts' => array(
		),
		'suggests' => array(
		),
	),
	'_md5_values_when_last_written' => 'a:44:{s:16:"ext_autoload.php";s:4:"7da8";s:12:"ext_icon.gif";s:4:"0d1d";s:12:"ext_icon.png";s:4:"6b58";s:17:"ext_localconf.php";s:4:"4247";s:14:"ext_tables.php";s:4:"178f";s:25:"Classes/Ajax/LoadAjax.php";s:4:"cf44";s:39:"Classes/Controller/PluginController.php";s:4:"998e";s:49:"Classes/DataProvider/AbstractBaseDataProvider.php";s:4:"f185";s:53:"Classes/DataProvider/AbstractDataBaseDataProvider.php";s:4:"ef3b";s:44:"Classes/DataProvider/ContentDataProvider.php";s:4:"c401";s:44:"Classes/DataProvider/FactoryDataProvider.php";s:4:"7542";s:46:"Classes/DataProvider/InterfaceDataProvider.php";s:4:"aace";s:42:"Classes/DataProvider/PagesDataProvider.php";s:4:"74cc";s:47:"Classes/DataProvider/TypoScriptDataProvider.php";s:4:"763d";s:28:"Classes/Domain/Model/Tab.php";s:4:"6b43";s:43:"Classes/Domain/Repository/TabRepository.php";s:4:"7caa";s:40:"Classes/Service/ConfigurationService.php";s:4:"66d7";s:31:"Classes/View/TypoScriptView.php";s:4:"dbea";s:40:"Classes/Wizards/ContentElementWizard.php";s:4:"33cf";s:36:"Configuration/FlexForms/flexform.xml";s:4:"a1dd";s:38:"Configuration/TypoScript/constants.txt";s:4:"5919";s:34:"Configuration/TypoScript/setup.txt";s:4:"678e";s:43:"Resources/Private/Language/de.locallang.xml";s:4:"c0a0";s:40:"Resources/Private/Language/locallang.xml";s:4:"a964";s:47:"Resources/Public/Images/backgroundTabActive.png";s:4:"4ec0";s:58:"Resources/Public/Images/backgroundTabActiveAlternative.png";s:4:"31f4";s:49:"Resources/Public/Images/backgroundTabInactive.png";s:4:"0a02";s:48:"Resources/Public/Images/contentElementWizard.png";s:4:"7051";s:35:"Resources/Public/Scripts/df_tabs.js";s:4:"f03a";s:51:"Resources/Public/Scripts/History/History.Routing.js";s:4:"37be";s:43:"Resources/Public/Scripts/History/History.js";s:4:"2e43";s:40:"Resources/Public/StyleSheets/df_tabs.css";s:4:"9171";s:52:"Resources/Public/StyleSheets/df_tabs_alternative.css";s:4:"b5fe";s:27:"Tests/Unit/BaseTestCase.php";s:4:"1982";s:56:"Tests/Unit/DataProvider/AbstractBaseDataProviderTest.php";s:4:"875b";s:60:"Tests/Unit/DataProvider/AbstractDataBaseDataProviderTest.php";s:4:"37a5";s:51:"Tests/Unit/DataProvider/FactoryDataProviderTest.php";s:4:"a9d6";s:49:"Tests/Unit/DataProvider/PagesDataProviderTest.php";s:4:"7710";s:54:"Tests/Unit/DataProvider/TypoScriptDataProviderTest.php";s:4:"88d8";s:35:"Tests/Unit/Domain/Model/TabTest.php";s:4:"1983";s:50:"Tests/Unit/Domain/Repository/TabRepositoryTest.php";s:4:"d64d";s:47:"Tests/Unit/Service/ConfigurationServiceTest.php";s:4:"aa24";s:38:"Tests/Unit/View/TypoScriptViewTest.php";s:4:"0ce5";s:14:"doc/manual.sxw";s:4:"6e90";}',
	'suggests' => array(
	),
);

?>