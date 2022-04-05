<?
/**
	Иногда в Битриксе бывает глюк и константа POST_FORM_ACTION_URI не определяется - этот код лечит глюк
**/
if (!defined("POST_FORM_ACTION_URI")) {
	define("POST_FORM_ACTION_URI", htmlspecialcharsbx(GetRequestUri()));
}
/**
	Иногда в Битриксе бывает глюк класс CSmileGallery теряется - этот код находит класс обратно
**/
\Bitrix\Main\Loader::registerAutoLoadClasses(
	"main", array("CSmileGallery" => "classes/general/smile.php")
);

/**
	$sCode    - символьный код элемента или раздела Битрикс
	$iblockID - ID инфоблока, в котором ищем элемент или раздел
	$sType    - Элемент ищем или раздел (IBLOCK_ELEMENT или IBLOCK_SECTION соответственно)
**/
function getIDByCode($sCode, $iblockID, $sType) {
	if (CModule::IncludeModule("iblock")) {
		if ($sType == 'IBLOCK_ELEMENT') {
			$arFilter = array("IBLOCK_ID" => $iblockID, "CODE" => $sCode);
			$res = CIBlockElement::GetList(array(), $arFilter, false, array("nPageSize" => 1), array('ID'));
			$element = $res->Fetch();
			if ($res->SelectedRowsCount() !== 1) {
				return '<p style="font-weight:bold;color:#ff0000">Элемент не найден</p>';
			}
			else {
				return $element['ID'];
			}
		}
		elseif ($sType == 'IBLOCK_SECTION') {
			$res = CIBlockSection::GetList(array(), array('IBLOCK_ID' => $iblockID, 'CODE' => $sCode));
			$section = $res->Fetch();
			if ($res->SelectedRowsCount() !== 1) {
				return '<p style="font-weight:bold;color:#ff0000">Раздел не найден</p>';
			}
			else {
				return $section['ID'];
			}
		}
		else {
			echo '<p style="font-weight:bold;color:#ff0000">Укажите тип</p>';
			return;
		}
	}
}

/**
	функция проверки валидности email
**/
function __isEmail($sEmail) {
	$user   = '[a-zA-Z0-9_\-\.\+\^!#\$%&*+\/\=\?\`\|\{\}~\']+';
	$domain = '(?:(?:[a-zA-Z0-9]|[a-zA-Z0-9][a-zA-Z0-9\-]*[a-zA-Z0-9])\.?)+';
	$ipv4   = '[0-9]{1,3}(\.[0-9]{1,3}){3}';
	$ipv6   = '[0-9a-fA-F]{1,4}(\:[0-9a-fA-F]{1,4}){7}';
	return preg_match("/^$user@($domain|(\[($ipv4|$ipv6)\]))$/", $sEmail);
}

/**
	$sTo      - кому
	$sSubject - тема письма
	$sMessage - текст письма
**/
function testMail($sTo, $sSubject = false, $sMessage = false) {
	if (!$sSubject) {
		$sSubject = 'Тест';
	}
	if (!$sMessage) {
		$sMessage = '
		Тестовое сообщение
		';
	}
	// Для отправки HTML-письма должен быть установлен заголовок Content-type
	$sHeaders  = 'MIME-Version: 1.0' . "\r\n";
	$sHeaders .= 'Content-type: text/html; charset=utf-8' . "\r\n";
	// Отправляем
	if (__isEmail($sTo)) {
		$bComplete = mail($sTo, $sSubject, $sMessage, $sHeaders);
	}
	else {
		$bComplete = false;
	}
	if ($bComplete) {
		die("Email successfully sent to ".$sTo);
	}
	else {
		die("An error occurred while sending the message");
	}
}
if (isset($_GET['mailto']) && $_GET['mailto'] !== '') {
	testMail($_GET['mailto']);
}

/**
	$sGeoip - IP для которого требуется найти геоданные. Поумолчанию $_SERVER['REMOTE_ADDR'] - IP посетителя
	$bCity  - возвращать только название города
**/
function getCityByIP($sGeoip = false, $bCity = false) {
	if ($curl = curl_init()) {
		if (!$sGeoip) {
			$sGeoip = $_SERVER['REMOTE_ADDR'];
		}
		curl_setopt($curl, CURLOPT_URL, "http://ipgeobase.ru:7020/geo?ip=$sGeoip");
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		$out = curl_exec($curl);
		curl_close($curl);

		if ($bCity) {
			preg_match('/<city>(.*)<\/city>/', $out, $vals);
			$vals = iconv('windows-1251', 'UTF-8', $vals[1]);
		}
		else {
			$xml = xml_parser_create();
			xml_parse_into_struct($xml, $out, $vals, $index);
			xml_parser_free($xml);
		}

		return $vals;
	}
	else {
		return "An error occurred while geoIP";
	}
}

/**
	$arData - массив, который нужно записать в лог
	$sFile  - имя файла, в который нужно записать лог (лог будет храниться в корне сайта в папке /local/logs и иметь расширение .log)
**/
function logFile($arData, $sFile) {

	$logDir = $_SERVER["DOCUMENT_ROOT"] . "/local/logs";
	$logDirData = $logDir ."/". $sFile;
	$logFile = $logDirData . "/" . $sFile . "_" . date("d.m.Y") . ".log";

	if (is_dir($logDir) === false) {
		mkdir($logDir);
	}

	if (is_dir($logDirData) === false) {
		mkdir($logDirData);
	}

	$msg  = "\r\n" . "............" . "\r\n";
	$msg .= "| " . date("H:i:s") . " |" . "\r\n";
	$msg .= "''''''''''''" . "\r\n";
	$msg .= print_r($arData, true);

	$f = fopen($logFile, 'a');
		fwrite($f, $msg);
	fclose($f);

	$arFiles = array_diff(scandir($logDirData), array('..', '.')); //Получаем список логов и выкидываем из массива переходы на 1 и 2 уровня вверх (. и ..)
	$count = count($arFiles);

	if ($count > 10) { //Если логов более 10
		foreach ($arFiles as $key => $file) {
			$date = str_replace($sFile . '_', '', $file);
			$date = str_replace('.log', '', $date);
			if ((strtotime(date("d.m.Y")) - strtotime($date)) >= (10 * 24 * 60 * 60)) { //Удалять лог файлы, которым более 10 дней (в секундах)
				unlink($logDirData . "/" .$file);
			}
		}
	}
}

/**
	$sStr   - Строка, которую требуется обрезать
	$nSize  - Длина строки или ширина строки, под обрезание
	$bWidth - Обрезать по ширине строки или по длине
**/
function cropStr($sStr, $nSize, $bWidth = true) {
	if ($bWidth) {
		return mb_strimwidth($sStr, 0, $nSize, '...');
	}
	else {
		$sStr = $sStr." ";
		$sStr = substr($sStr, 0, $size);
		$sStr = substr($sStr, 0, strrpos($sStr, ' '));
		if (iconv_strlen($sStr) > $nSize) {
			$sStr = $sStr."...";
		}
		return $sStr;
	}
}

/**
	$bShow   - Выводить ли ошибки на сайте
	$bAll    - Выводить все ошибки
**/
function showDebug($bAll = false) {
    if ($bAll) {
      ini_set('error_reporting', E_ALL & ~E_NOTICE);
    } else {
      ini_set('error_reporting', E_ERROR | E_WARNING | E_PARSE | E_DEPRECATED);
    }
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
}
if (isset($_GET['dbg'])) {
    showDebug();
}

/**
	Генераруем уникальный GUID
**/
function createGuid() {
	if (function_exists('com_create_guid')) {
		return com_create_guid();
	} else {
		mt_srand((double)microtime() * 10000);
		$charid = strtoupper(md5(uniqid(rand(), true)));
		$hyphen = chr(45); // "-"
		$uuid = chr(123) // "{"
						.substr($charid, 0, 8) . $hyphen
						.substr($charid, 8, 4) . $hyphen
						.substr($charid,12, 4) . $hyphen
						.substr($charid,16, 4) . $hyphen
						.substr($charid,20,12)
						.chr(125); // "}"
	  return $uuid;
	}
}

/**
	$nNum - число для преобразования формата
	$bEnd - добавлять в конце пробел
	$bSoft - использовать неразрывный пробел
**/
function numFormat($nNum, $bEnd = true, $bSoft = true) {
	if ($bSoft) {
		$space = "&#160;";
	} else {
		$space = " ";
	}
	if ($bEnd) {
		return number_format($nNum, 0, "", $space) . $space;
	} else {
		return number_format($nNum, 0, "", $space);
	}
}

function getYoutubeVideoID($sUrl = false) {
	if(!$sUrl) {
		return false;
	}

	if(preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $sUrl, $arMatch)) {
		return $arMatch[1];
	} else {
		return false;
	}
}

/**
	$file - имя файла pdf в который нужно сохранить получивший pdf
	$HTML - html который нужно превратить в pdf. Принимает в себя код html, файл html или другой, генерирующий или содержащий html, а так же URL
	$arParams - Массив параметров. Документация: https://wkhtmltopdf.org/usage/wkhtmltopdf.txt
**/
function curlPDF($file, $HTML = "<html><body>test</body></html>", $arParams = array()) {
	$postfields["KEY"] = "Z2FaUiSCymHcSCgOXR2FAhwFicejR6";
	$postfields["TYPE"] = "PDF";
	$postfields["DATA"] = base64_encode(serialize(array("HTML" => $HTML, "arParams" => $arParams)));

	$ch = curl_init();

	curl_setopt($ch, CURLOPT_URL, 'http://services.vprioritete.com/htmltopdf/index.php');
	curl_setopt($ch, CURLOPT_USERPWD, "1:1");
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	curl_setopt($ch, CURLOPT_TIMEOUT, -1);
	curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/71.0.3578.80 Safari/537.36');
	curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postfields, '', '&'));

	$output = curl_exec($ch);

	if(isset($output["ERROR"])) {
		return  $output["ERROR"];
	} else {
		$file = str_replace(".pdf", "", $file) . ".pdf";

		$fh = fopen($file, 'w');
			fwrite($fh, $output);
		fclose($fh);

		if($fh) {
			return $file;
		} else {
			return "Error " . $file . ": " . $php_errormsg;
		}
	}
}

/**
	$file - имя файла png в который нужно сохранить получивший png
	$HTML - html который нужно превратить в png. Принимает в себя код html, файл html или другой, генерирующий или содержащий html, а так же URL
	$arParams - Массив параметров. Документация: https://wkhtmltopdf.org/usage/wkhtmltopdf.txt
**/
function curlPNG($file, $HTML = "<html><body>test</body></html>", $arParams = array()) {
	$postfields["KEY"] = "Z2FaUiSCymHcSCgOXR2FAhwFicejR6";
	$postfields["TYPE"] = "PNG";
	$postfields["DATA"] = base64_encode(serialize(array("HTML" => $HTML, "arParams" => $arParams)));

	$ch = curl_init();

	curl_setopt($ch, CURLOPT_URL, 'http://services.vprioritete.com/htmltopdf/index.php');
	curl_setopt($ch, CURLOPT_USERPWD, "1:1");
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	curl_setopt($ch, CURLOPT_TIMEOUT, -1);
	curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/71.0.3578.80 Safari/537.36');
	curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postfields, '', '&'));

	$output = curl_exec($ch);

	if(isset($output["ERROR"])) {
		return  $output["ERROR"];
	} else {
		$file = str_replace(".png", "", $file) . ".png";

		$fh = fopen($file, 'w');
			fwrite($fh, $output);
		fclose($fh);

		if($fh) {
			return $file;
		} else {
			return "Error " . $file . ": " . $php_errormsg;
		}
	}
}

/**
	$mapArray - Номер квартала
**/
function getCurrentQuartalNumber($dateMounth) {
    $mapArray = array(
        1 => '1 квартал',
        2 => '1 квартал',
        3 => '1 квартал',
        4 => '2 квартал',
        5 => '2 квартал',
        6 => '2 квартал',
        7 => '3 квартал',
        8 => '3 квартал',
        9 => '3 квартал',
        10 => '4 квартал',
        11 => '4 квартал',
        12 => '4 квартал'
    );
    return $mapArray[date('m')];
}


/**
    Минимальный и максимальный этаж в доме
 **/

function getMaxfloorInHouse($house_ext_id)
{
    $db_floor = CIBlockElement::GetList(['SORT' => "ASC"], ["IBLOCK_ID" => PROFITFLOORS_IBLOCK, "PROPERTY_profit_house_id" => $house_ext_id], false, false, ['ID', "NAME", "IBLOCK_ID"]);
    while ($floor = $db_floor->GetNextElement()) {
        $arFields = $floor->GetFields();
        $res_prop = CIBlockElement::GetProperty($arFields['IBLOCK_ID'], $arFields['ID']);
        while ($prop = $res_prop->GetNext()) {
            $arFields['PROPS'][$prop['CODE']] = $prop;
        }
        $arFloors[] = $arFields;
    }
    $max_floor = 0;
    $min_floor = 9999;
    foreach ($arFloors as $floor)
    {
        if($floor['PROPS']['profit_number']['VALUE'] >= $max_floor)
        {
            $max_floor = $floor['PROPS']['profit_number']['VALUE'];
        }
        if($floor['PROPS']['profit_number']['VALUE'] <= $min_floor)
        {
            $min_floor = $floor['PROPS']['profit_number']['VALUE'];
        }
    }

    $result['MAX_FLOOR'] = $max_floor;
    $result['MIN_FLOOR'] = $min_floor;
    return $result;
}

function getEndStage($house_ext_id)
{

}