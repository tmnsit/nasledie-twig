<?
// require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
if (!$USER->IsAdmin()) die("-");

$log = file_get_contents(LOG_FILENAME);
?>

<pre><?= htmlspecialchars($log) ?: var_export(file_exists(LOG_FILENAME)) ?></pre>

<?
// require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php");
