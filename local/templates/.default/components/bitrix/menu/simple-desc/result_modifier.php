<?
use Bitrix\Main\Application;
use EuroCement\Local\Helper;
use Uplab\Core\Components\TemplateBlock;
use EuroCement\Local\Vacancy;

defined("B_PROLOG_INCLUDED") && B_PROLOG_INCLUDED === true || die();
/**
 * @global CMain      $APPLICATION
 * @var array         $arParams
 * @var array         $arResult
 * @var TemplateBlock $component
 */

$arItems = [];
foreach($arResult as &$item) {
	
	if ($item["PARAMS"]["HEADING"] == "#COUNT_VACANCIES#") {
		$obVacancy = new Vacancy;
		$item["PARAMS"]["HEADING"] = $obVacancy->filterVacancy(["UF_ACTIVE" => true], [], true).' вакансий';
	}
}