<?php
//https://docs.modx.com/current/en/extending-modx/developing-restful-api
/* @global $modx */
define('MODX_API_MODE', true);
require '../index.php';

$modx->initialize('web');
$modx->getService('error', 'error.modError');
$modx->setLogLevel(modX::LOG_LEVEL_FATAL);
$modx->setLogTarget(XPDO_CLI_MODE ? 'ECHO' : 'HTML');

//Начальная загрузка API
$rest = $modx->getService('rest', 'rest.modRestService', '', array(
    'basePath' => dirname(__FILE__) . '/Controllers/',
    'controllerClassSeparator' => '',
    'controllerClassPrefix' => 'myAppRest',
    'xmlRootNode' => 'response',
));
// Подготовить запрос
$rest->prepare();

// Удостовериться, что пользователю предоставлены необходимые права доступа; вернуть пользователю ошибку 401 в обратном случае
if (!$rest->checkPermissions()) {
    $rest->sendUnauthorized(true);
}
// Выполнить запрос
$rest->process();


