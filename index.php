<?php
require_once(dirname(__FILE__).'/config/ProjectConfiguration.class.php');

$configuration = ProjectConfiguration::getApplicationConfiguration('frontend', 'prod', false);
sfContext::createInstance($configuration)->dispatch();

/* TODO:
 * 
 * Test:
 *		Формирование анонса игр.
 * 
 * Issues:
 *		Normal: Попытка подать заявку в команду повторно - дает исключение.
 */