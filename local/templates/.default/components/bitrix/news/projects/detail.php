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
$activeTab = ($request->get('activeTab')) ? $request->get('activeTab') : $request->getPost('activeTab') ;
?>

<?
// mpr($arResult, false);
// mpr($arResult["PROJECT"], false);
// mpr($arParams, false);
?>

<?$APPLICATION->IncludeComponent("uplab.core:template.block", "intro", Array(
		"CACHE_FOR_PAGE" => "N",
		"CACHE_TIME" => "3600000",
		"CACHE_TYPE" => "A",
		"DELAY" => "N",
	),
	false
);?>

<div class="container">
	<div class="layout">
		<div class="layout__sidebar">
			<div class="layout__sidebar-wrapper">
				<?$APPLICATION->IncludeComponent(
					"uplab.core:template.block",
					"sidebar",
					Array(
						"CACHE_FOR_PAGE" => "N",
						"CACHE_TIME" => "3600000",
						"CACHE_TYPE" => "A",
						"DELAY" => "N"
					)
				);?>
				<!-- {% view '^sidebar'%} -->
			</div>
		</div>
		<div class="layout__content">
			<?$APPLICATION->IncludeComponent(
				"uplab.core:template.block",
				"about-project",
				Array(
					"PROJECT" => $arResult["PROJECT"],
					"CACHE_FOR_PAGE" => "N",
					"CACHE_TIME" => "3600000",
					"CACHE_TYPE" => "A",
					"DELAY" => "N",
				)
			);?>
			<!-- {% view '&about-project'%} -->
			
			<?$APPLICATION->IncludeComponent(
				"uplab.core:template.block",
				"project-plan",
				Array(
					"ACTIVE_TAB" => $activeTab,
					"PROJECT" => $arResult["PROJECT"],
					"CACHE_FOR_PAGE" => "N",
					"CACHE_TIME" => "3600000",
					"CACHE_TYPE" => "N",
					"DELAY" => "N",
					"REQUEST" => "",
				)
			);?>
			<!-- {% view '&project-plan'%} -->
			
			<?$APPLICATION->IncludeComponent(
				"uplab.core:template.block",
				"flat-advantages",
				Array(
					"PROJECT" => $arResult["PROJECT"],
					"CACHE_FOR_PAGE" => "N",
					"CACHE_TIME" => "3600000",
					"CACHE_TYPE" => "A",
					"DELAY" => "N",
				)
			);?>
			<!-- {% view '&flat-advantages'%} -->

			<?$APPLICATION->IncludeComponent(
				"uplab.core:template.block",
				"projectSlider",
				Array(
					"PROJECT" => $arResult["PROJECT"],
					"CACHE_FOR_PAGE" => "N",
					"CACHE_TIME" => "3600000",
					"CACHE_TYPE" => "A",
					"DELAY" => "N",
				)
			);?>
			<!-- {% for projectSlider in projectSliders %}
				{% view '&project-slider' with {
					item: projectSlider
				} %}
			{% endfor %} -->

			<?$APPLICATION->IncludeComponent(
				"uplab.core:template.block",
				"payment-description",
				Array(
					"PROJECT" => $arResult["PROJECT"],
					"CACHE_FOR_PAGE" => "N",
					"CACHE_TIME" => "3600000",
					"CACHE_TYPE" => "A",
					"DELAY" => "N",
				)
			);?>
			<!-- {% view '&payment-description' with {
				isLayout: true
			} %} -->

			<?$APPLICATION->IncludeComponent(
				"uplab.core:template.block",
				"commerce-house",
				Array(
					"PROJECT" => $arResult["PROJECT"],
					"CACHE_FOR_PAGE" => "N",
					"CACHE_TIME" => "3600000",
					"CACHE_TYPE" => "A",
					"DELAY" => "N",
				)
			);?>
			<!-- {% view '&commerce-house'%} -->

			<?/*
			<?$APPLICATION->IncludeComponent(
				"uplab.core:template.block",
				"flat-map",
				Array(
					"PROJECT" => $arResult["PROJECT"],
					"CACHE_FOR_PAGE" => "N",
					"CACHE_TIME" => "3600000",
					"CACHE_TYPE" => "A",
					"DELAY" => "N",
				)
			);?>
			*/?>
			<!-- {% view '&flat-map' %} -->

			<?if($arResult["PROJECT"]["PROGRESS_SLIDER"]["VALUE"]):?>
				<?$APPLICATION->IncludeComponent(
					"uplab.core:template.block",
					"project-steps",
					Array(
						"PROJECT" => $arResult["PROJECT"],
						"CACHE_FOR_PAGE" => "N",
						"CACHE_TIME" => "3600000",
						"CACHE_TYPE" => "A",
						"DELAY" => "N",
					)
				);?>
			<?endif;?>
			<!-- {% view '&project-steps' %} -->

			<?$APPLICATION->IncludeComponent(
				"uplab.core:template.block",
				"news",
				Array(
					"PROJECT" => $arResult["PROJECT"],
					"CACHE_FOR_PAGE" => "N",
					"CACHE_TIME" => "3600000",
					"CACHE_TYPE" => "A",
					"DELAY" => "N",
                    "PAGE_SIZE" => "2",
                    "COMPONENT_TEMPLATE" => "news",
                    "BLOCK_TITLE" => "Новости",
                    "TEXT_MORE" => "Показать все",
                    "LINK_MORE" => "/news/"
				)
			);?>
			<!-- {% view '&news'%} -->
		</div>
	</div>
</div>
