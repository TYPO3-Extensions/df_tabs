<?php

########################################################################
# Extension Manager/Repository config file for ext "df_tabs".
#
# Auto generated 18-05-2012 16:59
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
	'version' => '3.3.1',
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
	'author_email' => 'stefan.galinski@gmail.com',
	'author_company' => 'domainFACTORY',
	'CGLcompliance' => '',
	'CGLcompliance_note' => '',
	'constraints' => array(
		'depends' => array(
			'php' => '5.3.0-5.4.99',
			'typo3' => '4.6.0-6.1.99',
		),
		'conflicts' => array(
		),
		'suggests' => array(
		),
	),
	'_md5_values_when_last_written' => 'a:46:{s:16:"ext_autoload.php";s:4:"24ba";s:12:"ext_icon.gif";s:4:"0d1d";s:12:"ext_icon.png";s:4:"6b58";s:17:"ext_localconf.php";s:4:"4247";s:14:"ext_tables.php";s:4:"96a3";s:25:"Classes/Ajax/LoadAjax.php";s:4:"cf44";s:39:"Classes/Controller/PluginController.php";s:4:"0eee";s:49:"Classes/DataProvider/AbstractBaseDataProvider.php";s:4:"f185";s:53:"Classes/DataProvider/AbstractDataBaseDataProvider.php";s:4:"ef3b";s:44:"Classes/DataProvider/ContentDataProvider.php";s:4:"c401";s:44:"Classes/DataProvider/FactoryDataProvider.php";s:4:"5152";s:46:"Classes/DataProvider/InterfaceDataProvider.php";s:4:"aace";s:42:"Classes/DataProvider/PagesDataProvider.php";s:4:"74cc";s:47:"Classes/DataProvider/TypoScriptDataProvider.php";s:4:"763d";s:28:"Classes/Domain/Model/Tab.php";s:4:"6b43";s:43:"Classes/Domain/Repository/TabRepository.php";s:4:"7caa";s:38:"Classes/Exception/GenericException.php";s:4:"a6e2";s:40:"Classes/Service/ConfigurationService.php";s:4:"b281";s:31:"Classes/View/TypoScriptView.php";s:4:"5037";s:40:"Classes/Wizards/ContentElementWizard.php";s:4:"941b";s:36:"Configuration/FlexForms/flexform.xml";s:4:"b2c5";s:38:"Configuration/TypoScript/constants.txt";s:4:"5919";s:34:"Configuration/TypoScript/setup.txt";s:4:"678e";s:43:"Resources/Private/Language/de.locallang.xlf";s:4:"0217";s:40:"Resources/Private/Language/locallang.xlf";s:4:"a2b6";s:47:"Resources/Public/Images/backgroundTabActive.png";s:4:"4ec0";s:58:"Resources/Public/Images/backgroundTabActiveAlternative.png";s:4:"31f4";s:49:"Resources/Public/Images/backgroundTabInactive.png";s:4:"0a02";s:48:"Resources/Public/Images/contentElementWizard.png";s:4:"7051";s:35:"Resources/Public/Scripts/df_tabs.js";s:4:"f357";s:40:"Resources/Public/Scripts/tabAnimation.js";s:4:"a2cd";s:51:"Resources/Public/Scripts/History/History.Routing.js";s:4:"8c7e";s:43:"Resources/Public/Scripts/History/History.js";s:4:"7e00";s:40:"Resources/Public/StyleSheets/df_tabs.css";s:4:"124d";s:52:"Resources/Public/StyleSheets/df_tabs_alternative.css";s:4:"e5ca";s:27:"Tests/Unit/BaseTestCase.php";s:4:"1982";s:56:"Tests/Unit/DataProvider/AbstractBaseDataProviderTest.php";s:4:"875b";s:60:"Tests/Unit/DataProvider/AbstractDataBaseDataProviderTest.php";s:4:"37a5";s:51:"Tests/Unit/DataProvider/FactoryDataProviderTest.php";s:4:"bfa7";s:49:"Tests/Unit/DataProvider/PagesDataProviderTest.php";s:4:"69a6";s:54:"Tests/Unit/DataProvider/TypoScriptDataProviderTest.php";s:4:"88d8";s:35:"Tests/Unit/Domain/Model/TabTest.php";s:4:"1983";s:50:"Tests/Unit/Domain/Repository/TabRepositoryTest.php";s:4:"6419";s:47:"Tests/Unit/Service/ConfigurationServiceTest.php";s:4:"c0e6";s:38:"Tests/Unit/View/TypoScriptViewTest.php";s:4:"d29c";s:14:"doc/manual.sxw";s:4:"2219";}',
	'suggests' => array(
	),
);

?>