<?
use Bitrix\Main\Application;
use Bitrix\Main\Page\Asset;
use Uplab\Core\Helper as UplabHelper;
\Bitrix\Main\UI\Extension::load("ui.notification");

defined("B_PROLOG_INCLUDED") && B_PROLOG_INCLUDED === true || die();
/**
 * @global CMain $APPLICATION
 * @var array    $arParams
 * @var array    $arResult
 */


if (!class_exists(UplabHelper::class)) {
	throw new Exception("Необходимо создать модуль проекта и подключить его в init.php");
}


global $assetsBasePath, $assetsProgPath;


$isMain = $APPLICATION->GetCurPage(false) == SITE_DIR;
$isAdmin = $USER->IsAdmin();


$asset = Asset::getInstance();


$assetsProgPath = "/dist/prog";


// если на сервере имеется возможность собираеть репозиторий фронденда,
// то используются ресурсы из этого собранного репозитория
$assetsBasePath = "/local/templates/.default/frontend/dist";
if (!UplabHelper::isDevMode() || !is_dir(Application::getDocumentRoot() . $assetsBasePath)) {
	// если такой возможности нет, то используются ресурсы,
	// передаваемые через GIT
	$assetsBasePath = "/dist";
}


//CJSCore::Init();
CJSCore::Init("jquery3");

CJSCore::Init(array("fx"));

// Ресурсы фронтенда
$asset->addCss("{$assetsBasePath}/css/vendors~index.chunk.css");
$asset->addCss("{$assetsBasePath}/css/index.css");
$asset->addCss("{$assetsBasePath}/css/components.css");


// Ресурсы бэкенда
$asset->addCss("{$assetsProgPath}/app.css");
$asset->addJs("{$assetsProgPath}/app.js");
$asset->addJs(SITE_TEMPLATE_PATH."/js/share.js");
$asset->addJs(SITE_TEMPLATE_PATH."/js/prog.js");


?><!doctype html>
<html lang="<?= LANGUAGE_ID ?>">
<head>

    <script>
        window.assetsProgPath = "<?=$assetsBasePath?>";
    </script>

    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
	<? $APPLICATION->ShowHead(); ?>
    <title><? $APPLICATION->ShowTitle() ?></title>

	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <link rel="apple-touch-icon" sizes="180x180" href="/dist/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/dist/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/dist/favicon-16x16.png">
	<? if (!UplabHelper::isDevMode()): ?>
		<link rel="manifest" href="/dist/site.webmanifest">
	<? endif ?>
    <link rel="mask-icon" href="/dist/safari-pinned-tab.svg" color="#fbfcff">
    <meta name="msapplication-TileColor" content="#fbfcff">
    <meta name="theme-color" content="#fbfcff">
	<meta property="og:title" content="<? $APPLICATION->ShowTitle() ?>"/>
	<meta property="og:type" content="article" />
	<meta property="og:url" content="<?=$APPLICATION->GetCurDir() ?>" />
	<meta property="og:image" content="https://<?=$_SERVER["HTTP_HOST"]?><? $APPLICATION->ShowProperty("og_image") ?>"/>
	<meta property="og:fb:image" content="https://<?=$_SERVER["HTTP_HOST"]?><? $APPLICATION->ShowProperty("og_image") ?>"/>
	<meta property="og:site_name" content="Наследие"/>

	<noscript>
		<style>
			.simplebar-content-wrapper {
				overflow: auto;
			}
		</style>
	</noscript>
</head>
<body <? /*{% if bodyClass %}class="{{ bodyClass }}"{% endif %}*/ ?>>

<div class="cursor">
	<div class="cursor-border"></div>
</div>
<div id="panel" style="position: fixed; bottom: 0px; left: 0px; right: 0px; z-index: 99999;"><? $APPLICATION->ShowPanel() ?></div>

<?if($APPLICATION->GetCurDir() == "/"):?>
	<h1 class="visually-hidden" style="display: none;"><? $APPLICATION->ShowTitle(false) ?></h1>
<?endif;?>

<div class="wrapper">
	<?$APPLICATION->IncludeComponent("uplab.core:template.block", "header", Array(
		"CACHE_FOR_PAGE" => "N",	// Добавить адрес страницы в кеш
			"CACHE_TIME" => "3600000",	// Время кеширования (сек.)
			"CACHE_TYPE" => "A",	// Тип кеширования
			"DELAY" => "N",	// Отложенное выполнение компонента
		),
		false
	);?>
	<main class="main">
		<?/*
		<?$APPLICATION->IncludeComponent(
			"uplab.core:template.block",
			"background",
			Array(
				"BANNER_CODE" => $APPLICATION->GetCurDir(),
				"CACHE_FOR_PAGE" => "N",
				"CACHE_TIME" => "3600000",
				"CACHE_TYPE" => "A",
				"DELAY" => "N"
			)
		);?>
		*/?>