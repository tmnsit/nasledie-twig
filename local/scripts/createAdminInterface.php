<?

use Uplab\Core\Data\StringUtils;
use Uplab\Core\Helper;


/**
 * Пример использования:
 * *
 * --namespace - необязательный параметр
 * --module    - необязательный параметр
 * По умолчанию модуль и неймспейс берутся из настроек Uplab.Core
 *
 * EntityName - в единственном числе (н-р, Bookmark)
 *
 *
 * php local/scripts/createAdminInterface.php -e "EntityName" --namespace "Module\Name" --module "module.name"
 */


/** @noinspection PhpIncludeInspection */
require_once __DIR__ . "/../../bitrix/modules/main/cli/bootstrap.php";


$shortOpts = "";
$shortOpts .= "e:";  // Название сущности (например, Cities)

$longOpts = [
	"module:",    // ID модуля
	"namespace:", // неймспейс
];
$options = getopt($shortOpts, $longOpts);


$module = $options["m"];
$entity = $options["e"];


$arNamespace = array_filter([
	StringUtils::ucFirst(Helper::getOption("project_code")),
	StringUtils::ucFirst(Helper::getOption("module_suffix")),
]);


if (!empty($options["module"])) {
	$module = $options["module"];
} elseif (count($arNamespace) == 2) {
	$module = implode(".", array_map("mb_strtolower", $arNamespace));
}


if (!empty($options["namespace"])) {
	$namespace = $options["namespace"];
} elseif (count($arNamespace) == 2) {
	$namespace = "\\" . implode("\\", $arNamespace);
}


Uplab\Core\Generator\EntityGenerator::generate($module, $entity, $namespace);