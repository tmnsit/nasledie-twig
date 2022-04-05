<?
defined("B_PROLOG_INCLUDED") && B_PROLOG_INCLUDED === true || die();
/**
 * @global CMain $APPLICATION
 * @var array    $arParams
 * @var array    $arResult
 */

global $assetsBasePath, $assetsProgPath;
?>
		<?$APPLICATION->IncludeComponent("uplab.core:template.block", "widget", Array(
			"CACHE_FOR_PAGE" => "N",	// Добавить адрес страницы в кеш
				"CACHE_TIME" => "3600000",	// Время кеширования (сек.)
				"CACHE_TYPE" => "A",	// Тип кеширования
				"DELAY" => "N",	// Отложенное выполнение компонента
			),
			false
		);?>
	</main>
	<?$APPLICATION->IncludeComponent("uplab.core:template.block", "footer", Array(
		"CACHE_FOR_PAGE" => "N",	// Добавить адрес страницы в кеш
			"CACHE_TIME" => "3600000",	// Время кеширования (сек.)
			"CACHE_TYPE" => "A",	// Тип кеширования
			"DELAY" => "N",	// Отложенное выполнение компонента
		),
		false
	);?>
</div>

<?$APPLICATION->IncludeComponent("uplab.core:template.block", "popup-form", Array(
	"CACHE_FOR_PAGE" => "N",	// Добавить адрес страницы в кеш
		"CACHE_TIME" => "3600000",	// Время кеширования (сек.)
		"CACHE_TYPE" => "A",	// Тип кеширования
		"DELAY" => "N",	// Отложенное выполнение компонента
	),
	false
);?>

<?/*
	</div>
	<div class="main-footer">
		<? $APPLICATION->IncludeComponent(
			"uplab.core:template.block",
			"footer",
			array()
		); ?>
	</div>
</div>

<?$APPLICATION->IncludeComponent(
	"uplab.core:template.block",
	"svg-sprite",
	Array()
);?>



<? if ((!isset($_REQUEST["WEB_FORM_ID"]))
	|| (isset($_REQUEST["WEB_FORM_ID"]) && $_REQUEST["WEB_FORM_ID"] == 1)
	) {?>
<? EuroCement\Local\Helper::ajaxBuffer(); ?>
<? $APPLICATION->IncludeComponent(
	"bitrix:form.result.new",
	"question",
	array(
		"CACHE_TIME"             => "3600",
		"CACHE_TYPE"             => "N",
		"CHAIN_ITEM_LINK"        => "",
		"CHAIN_ITEM_TEXT"        => "",
		"EDIT_URL"               => "",
		"IGNORE_CUSTOM_TEMPLATE" => "N",
		"LIST_URL"               => "",
		"SEF_MODE"               => "N",
		"SUCCESS_URL"            => "",
		"USE_EXTENDED_ERRORS"    => "Y",
		"WEB_FORM_ID"            => "1",
		"COMPONENT_TEMPLATE"     => "question",
		"VARIABLE_ALIASES"       => array(
			"WEB_FORM_ID" => "WEB_FORM_ID",
			"RESULT_ID"   => "RESULT_ID",
		),
	),
	false
); ?>
<? EuroCement\Local\Helper::ajaxBuffer(false); ?>
<? } ?>

<? if ((!isset($_REQUEST["WEB_FORM_ID"]))
	|| (isset($_REQUEST["WEB_FORM_ID"]) && $_REQUEST["WEB_FORM_ID"] == 2)
	) {?>
<? $APPLICATION->IncludeComponent(
	"bitrix:form.result.new",
	"resume",
	array(
		"CACHE_TIME"             => "3600",
		"CACHE_TYPE"             => "N",
		"CHAIN_ITEM_LINK"        => "",
		"CHAIN_ITEM_TEXT"        => "",
		"EDIT_URL"               => "",
		"IGNORE_CUSTOM_TEMPLATE" => "N",
		"LIST_URL"               => "",
		"SEF_MODE"               => "N",
		"SUCCESS_URL"            => "",
		"USE_EXTENDED_ERRORS"    => "Y",
		"WEB_FORM_ID"            => "2",
		"COMPONENT_TEMPLATE"     => "resume",
		"VARIABLE_ALIASES"       => array(
			"WEB_FORM_ID" => "WEB_FORM_ID",
			"RESULT_ID"   => "RESULT_ID",
		),
	),
	false
); ?>
<? } ?>
*/?>


<?/* if ((!isset($_REQUEST["WEB_FORM_ID"]))
	|| (isset($_REQUEST["WEB_FORM_ID"]) && $_REQUEST["WEB_FORM_ID"] == 2)
	) {?>

<? EuroCement\Local\Helper::ajaxBuffer(); ?>
<? $APPLICATION->IncludeComponent(
	"bitrix:form.result.new",
	"question",
	array(
		"CACHE_TIME"             => "3600",
		"CACHE_TYPE"             => "N",
		"CHAIN_ITEM_LINK"        => "",
		"CHAIN_ITEM_TEXT"        => "",
		"EDIT_URL"               => "",
		"IGNORE_CUSTOM_TEMPLATE" => "N",
		"LIST_URL"               => "",
		"SEF_MODE"               => "N",
		"SUCCESS_URL"            => "",
		"USE_EXTENDED_ERRORS"    => "Y",
		"WEB_FORM_ID"            => "2",
		"COMPONENT_TEMPLATE"     => "question",
		"VARIABLE_ALIASES"       => array(
			"WEB_FORM_ID" => "WEB_FORM_ID",
			"RESULT_ID"   => "RESULT_ID",
		),
	),
	false
); ?>
<? EuroCement\Local\Helper::ajaxBuffer(false); ?>
<? } */?>


<?
foreach (["vendors~index.chunk", "index", "components"] as $item) {
	print(
		"<script data-skip-moving=true src='" .
		CUtil::GetAdditionalFileURL("{$assetsBasePath}/js/{$item}.js") .
		"' defer></script>"
	);
}
?>
</body></html>
