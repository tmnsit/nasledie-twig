<?php

use Uplab\Core\Helper;


/**
 * Пример использования:
 * *
 * --namespace - необязательный параметр
 *
 * EntityName - в единственном числе (н-р, Bookmark)
 *
 * php local/scripts/updateEntity.php -e "EntityName" --namespace "Module\Name"
 */


/** @noinspection PhpIncludeInspection */
require_once __DIR__ . "/../../bitrix/modules/main/cli/bootstrap.php";


$options = getopt("e:", ["namespace:"]);
$entity = $options["e"];


if (empty($entity)) {
	throw new Exception("Укажите имя сущности");
}


if (!empty($options["namespace"])) {
	$namespace = $options["namespace"];
} else {
	$namespace = array_filter([
		Helper::getOption("project_code"),
		Helper::getOption("module_suffix"),
		"Entities",
	]);
	if (count($namespace) > 1) {
		$namespace = "\\" . implode("\\", $namespace);
	}
}


// var_export(compact("options", "namespace"));


$entityClass = "{$namespace}\\{$entity}\\{$entity}Table";


if (!class_exists($entityClass)) {
	throw new Exception("Класс {$entityClass} не найден");
}


if ($f = $entityClass . "::install") {
	call_user_func($f);
	echo $f . " - ok ..." . PHP_EOL;
}


if ($f = $entityClass . "::updateDBStructureByEntity") {
	call_user_func($f);
	echo $f . " - ok ..." . PHP_EOL;
}
