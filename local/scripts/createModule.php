<?
use Uplab\Core\Generator\ModuleGenerator;


/**
 * Пример использования:
 * *
 * --title  - необязательный параметр
 * --module - необязательный параметр, по умолчанию - из настроек Uplab.Core
 *
 * EntityName - в единственном числе (н-р, Bookmark)
 *
 * php local/scripts/createModule.php --code "CodeCamelCase" --suffix "tools"
 */

require_once __DIR__ . "/../../bitrix/modules/main/cli/bootstrap.php";


$options = getopt("", ["code:", "suffix:"]);


$name = $options["code"];
$suffix = $options["suffix"];


new ModuleGenerator($name, $suffix);
