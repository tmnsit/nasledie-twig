<?
$_SERVER["DOCUMENT_ROOT"] = str_replace("/local/scripts", "", __DIR__);


$filePath = $_SERVER["DOCUMENT_ROOT"] . "/urlrewrite.php";


/** @noinspection PhpIncludeInspection */
include $filePath;


$sortStep = (int)max(ceil(90 / count($arUrlRewrite)), 1);
$sortStep = min($sortStep, 5);


echo PHP_EOL, $sortStep, PHP_EOL;


$sort = 0;
$res = [];
foreach ($arUrlRewrite as $rule) {
	$sort += $sortStep;
	$rule["ID"] = "";
	$rule["SORT"] = $sort;
	$res[] = $rule;
}


print_r($res);


file_put_contents($filePath, "<?php" . PHP_EOL . PHP_EOL . "\$arUrlRewrite = " . var_export($res, true) . ";");
