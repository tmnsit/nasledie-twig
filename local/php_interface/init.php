<?
use Bitrix\Main\Context;
use Bitrix\Main\Loader;
use Integration\Amocrm\Main;


$logPath = __DIR__ . "/log";
define("LOG_FILENAME", $logPath . "/" . date("Ymd") . ".log");
file_exists($logPath) || mkdir($logPath, 0777, true);


include_once $_SERVER["DOCUMENT_ROOT"] . "/local/vendor/autoload.php";


/**
 * подключение модуля __projectModule__ (https://bitbucket.org/uplabteam/uplab.core):
 * - модуль сгенерирован автоматически с помощью модуля Uplab.Core
 * - автогенерация констант инфоблоков
 * - автогенерация констант форм
 * - вспомогательные классы для решения часто повторяющихся задач
 * подробнее: https://bitbucket.org/uplabteam/uplab.core
 */
if (!Loader::includeModule("projectname.tools") && !Context::getCurrent()->getRequest()->isAdminSection()) {
	throw new Exception(
		"Необходимо указать в init.php код модуля проекта и убедиться, что модуль сгенерирован и установлен"
	);
}

include_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/wsrubi.smtp/classes/general/wsrubismtp.php");


/*
    Функции логирования
**/
if (file_exists($_SERVER['DOCUMENT_ROOT'].'/local/php_interface/include/mprjs.php')) {
    require_once $_SERVER['DOCUMENT_ROOT'].'/local/php_interface/include/mprjs.php';
}

if (file_exists($_SERVER['DOCUMENT_ROOT'].'/local/php_interface/include/functions.php')) {
    require_once $_SERVER['DOCUMENT_ROOT'].'/local/php_interface/include/functions.php';
}

if(Loader::includeModule("integration.amocrm")){
	AddEventHandler("iblock", "OnAfterIBlockElementAdd", Array("AddAmoCRM", "AddNewApplicationInAmo"));
	class AddAmoCRM{
		function AddNewApplicationInAmo(&$arFields){
			if($arFields["IBLOCK_ID"] == 17){
				//работает только для формы в всплывающем окне
				$arElement = CIBlockElement::GetByID($arFields["ID"]);
				if($ar_res = $arElement->GetNextElement()){
					$props = $ar_res->GetProperties();
					$name = $props["NAME"]["VALUE"];
					$phone = $props["TEL"]["VALUE"];
					$email = $props["EMAIL"]["VALUE"];
					$formName = $arFields["PROPERTY_VALUES"]["FORM_NAME"];
					$formCode = $arFields["PROPERTY_VALUES"]["FORM_CODE"];
					$integration = new Main();
					$integration->addNewApplication($name, $phone, $email, $formName, $formCode);
				}
			}
		}
	}
}
