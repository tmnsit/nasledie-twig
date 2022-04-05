<?
$obElement = CIBlockElement::GetByID($arResult["ID"])->GetNextElement();
$arItem = $obElement->GetFields();
if ($arItem["PREVIEW_PICTURE"]) {
	$APPLICATION->SetPageProperty("og_image", CFile::GetPath($arItem["PREVIEW_PICTURE"]));
}

?>