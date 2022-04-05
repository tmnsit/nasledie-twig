<?php
$arUrlRewrite=array (
  2 => 
  array (
    'CONDITION' => '#^/online/([\\.\\-0-9a-zA-Z]+)(/?)([^/]*)#',
    'RULE' => 'alias=$1',
    'ID' => NULL,
    'PATH' => '/desktop_app/router.php',
    'SORT' => 100,
  ),
  1 => 
  array (
    'CONDITION' => '#^/video([\\.\\-0-9a-zA-Z]+)(/?)([^/]*)#',
    'RULE' => 'alias=$1&videoconf',
    'ID' => NULL,
    'PATH' => '/desktop_app/router.php',
    'SORT' => 100,
  ),
  4 => 
  array (
    'CONDITION' => '#^\\/?\\/mobileapp/jn\\/(.*)\\/.*#',
    'RULE' => 'componentName=$1',
    'ID' => NULL,
    'PATH' => '/bitrix/services/mobileapp/jn.php',
    'SORT' => 100,
  ),
  6 => 
  array (
    'CONDITION' => '#^/bitrix/services/ymarket/#',
    'RULE' => '',
    'ID' => '',
    'PATH' => '/bitrix/services/ymarket/index.php',
    'SORT' => 100,
  ),
  3 => 
  array (
    'CONDITION' => '#^/online/(/?)([^/]*)#',
    'RULE' => '',
    'ID' => NULL,
    'PATH' => '/desktop_app/router.php',
    'SORT' => 100,
  ),
  0 => 
  array (
    'CONDITION' => '#^/stssync/calendar/#',
    'RULE' => '',
    'ID' => 'bitrix:stssync.server',
    'PATH' => '/bitrix/services/stssync/calendar/index.php',
    'SORT' => 100,
  ),
  16 => 
  array (
    'CONDITION' => '#^/appartaments/#',
    'RULE' => '',
    'ID' => 'bitrix:news',
    'PATH' => '/appartaments/index.php',
    'SORT' => 100,
  ),
  11 => 
  array (
    'CONDITION' => '#^/comercial/#',
    'RULE' => '',
    'ID' => 'bitrix:news',
    'PATH' => '/comercial/index.php',
    'SORT' => 100,
  ),
  14 => 
  array (
    'CONDITION' => '#^/partners/#',
    'RULE' => '',
    'ID' => 'bitrix:news',
    'PATH' => '/partners/index.php',
    'SORT' => 100,
  ),
  15 => 
  array (
    'CONDITION' => '#^/projects/#',
    'RULE' => '',
    'ID' => 'bitrix:news',
    'PATH' => '/projects/index.php',
    'SORT' => 100,
  ),
  9 => 
  array (
    'CONDITION' => '#^/test/#',
    'RULE' => '',
    'ID' => 'bitrix:news',
    'PATH' => '/test/index.php',
    'SORT' => 100,
  ),
  7 => 
  array (
    'CONDITION' => '#^/test/#',
    'RULE' => '',
    'ID' => 'bitrix:news',
    'PATH' => '/test/index.php',
    'SORT' => 100,
  ),
  5 => 
  array (
    'CONDITION' => '#^/rest/#',
    'RULE' => '',
    'ID' => NULL,
    'PATH' => '/bitrix/services/rest/index.php',
    'SORT' => 100,
  ),
  13 => 
  array (
    'CONDITION' => '#^/news/#',
    'RULE' => '',
    'ID' => 'bitrix:news',
    'PATH' => '/news/index.php',
    'SORT' => 100,
  ),
);
