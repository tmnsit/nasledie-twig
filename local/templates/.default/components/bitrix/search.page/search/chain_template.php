<?
//Navigation chain template
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$arChainBody = array();
foreach($arCHAIN as $item)
{
	if(strlen($item["LINK"])<strlen(SITE_DIR))
		continue;
	if($item["LINK"] <> "")
		$arChainBody[] = [
			"href" => $item["LINK"],
			"text" => htmlspecialcharsex($item["TITLE"])
		];
	else
		$arChainBody[] = [
			"text" => htmlspecialcharsex($item["TITLE"])
		];
}
return $arChainBody;
?>