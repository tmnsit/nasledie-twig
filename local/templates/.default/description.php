<?
$arTemplate = array(
	'NAME'          => 'main',
	'DESCRIPTION'   => '',
	'SORT'          => '',
	'TYPE'          => '',
	'EDITOR_STYLES' => \Uplab\Core\Helper::isDevMode()
		? [
			'/local/templates/.default/frontend/dist/css/index.css',
			'/local/templates/.default/frontend/dist/css/components.css',
			'/dist/prog/app.css',
			'/local/templates/main/editor.css',
		]
		: [
			'/dist/css/index.css',
			'/dist/css/components.css',
			'/dist/prog/app.css',
			'/local/templates/main/editor.css',
		],
);
?>
