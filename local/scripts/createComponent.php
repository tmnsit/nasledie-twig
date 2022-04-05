<?
use Uplab\Core\Data\StringUtils;
use Uplab\Core\Generator\ComponentGenerator;
use Uplab\Core\Helper;


/**
 * Пример использования:
 * *
 * --title  - необязательный параметр
 * --module - необязательный параметр, по умолчанию - из настроек Uplab.Core
 *
 * php local/scripts/createComponent.php -n "component.name" --title "Текстовое описание" --module "module.name"
 */


/** @noinspection PhpIncludeInspection */
require_once __DIR__ . "/../../bitrix/modules/main/cli/bootstrap.php";


$options = getopt("n:", ["module:", "title:"]);


$name = $options["n"];
$title = $options["title"] ?: $name;


$arNamespace = array_filter([
	StringUtils::ucFirst(Helper::getOption("project_code")),
	StringUtils::ucFirst(Helper::getOption("module_suffix")),
]);
if (!empty($options["module"])) {
	$module = $options["module"];
} elseif (count($arNamespace) == 2) {
	$module = implode(".", array_map("mb_strtolower", $arNamespace));
}


print_r(compact("name", "title", "module", "options"));


new ComponentGenerator($name, $title, $module);
