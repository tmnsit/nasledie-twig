<?
use Uplab\Core\Data\StringUtils;
use Uplab\Core\Generator\HighloadGenerator;
use Uplab\Core\Helper;


/**
 * Создает класс-наследник для работы с Highload-блоками и аннотации к нему
 *
 * Пример использования:
 * *
 * -e          - название сущности // см. здесь: https://take.ms/x7c5g
 * --module    - необязательный параметр, по умолчанию - из настроек Uplab.Core
 * --namespace - необязательный параметр, корневой неймспейс модуля
 *
 * php local/scripts/createHighload.php -e "EntityName" --module "project.tools"
 */

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


new HighloadGenerator($module, $entity, $namespace);
