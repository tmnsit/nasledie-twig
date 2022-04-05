<?
$cnt = count($arResult);
foreach ($arResult as $i => &$item) {
	if ($i == $cnt - 1) {
		$item["LINK"] = "";
	}

	$item = [
		"text" => $item["TITLE"],
		"href" => $item["LINK"],
	];
}

return $arResult;