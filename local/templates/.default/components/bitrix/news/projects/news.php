<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);
$request = \Bitrix\Main\Application::getInstance()->getContext()->getRequest();
$activeItem = ($request->get('activeItem')) ? $request->get('activeItem') : $request->getPost('activeItem') ;
if ($activeItem == "Все проекты") {
	$activeItem = "";
}
?>

<?$APPLICATION->IncludeComponent(
	"uplab.core:template.block",
	"intro-detail",
	Array(
		"BANNER_CODE" => $APPLICATION->GetCurDir(),
		"CACHE_FOR_PAGE" => "N",
		"CACHE_TIME" => "3600000",
		"CACHE_TYPE" => "A",
		"DELAY" => "N"
	)
);?>

<div id="all-projects">
	<?$APPLICATION->IncludeComponent(
	"uplab.core:template.block", 
	"projects", 
	array(
		"TYPE" => $activeItem,
		"CACHE_FOR_PAGE" => "N",
		"CACHE_TIME" => "3600000",
		"CACHE_TYPE" => "N",
		"DELAY" => "N",
		"COMPONENT_TEMPLATE" => "projects",
		"BLOCK_TITLE" => "",
		"BTN_TEXT_DETAIL" => "",
		"BTN_CLASS" => "",
		"TAB_TYPES" => array(
			0 => "116",
			1 => "117",
			2 => "118",
		)
	),
	false
);?>
</div>
