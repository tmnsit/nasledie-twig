<?
require_once __DIR__ . "/../../bitrix/modules/main/cli/bootstrap.php";


function getLangPath($lang)
{
	return $_SERVER["DOCUMENT_ROOT"] . SITE_TEMPLATE_PATH . "/lang/{$lang}/lang.php";
}


function getLangMessages($lang)
{
	$MESS = [];

	/** @noinspection PhpIncludeInspection */
	include getLangPath($lang);

	return $MESS;
}


$messagesRu = getLangMessages("ru");
$messagesEn = getLangMessages("en");


$notExistInEn = array_diff_key($messagesRu, $messagesEn);
$notExistInRu = array_diff_key($messagesEn, $messagesRu);


print_r(compact("notExistInRu", "notExistInEn"));


foreach ($notExistInRu as $key => $value) {
	file_put_contents(
		getLangPath("ru"),
		PHP_EOL . "\$MESS[\"{$key}\"] = \"{$value}\"; // TODO: Переведи меня",
		FILE_APPEND
	);
}


foreach ($notExistInEn as $key => $value) {
	file_put_contents(
		getLangPath("en"),
		PHP_EOL . "\$MESS[\"{$key}\"] = \"{$value}\"; // TODO: Переведи меня",
		FILE_APPEND
	);
}
