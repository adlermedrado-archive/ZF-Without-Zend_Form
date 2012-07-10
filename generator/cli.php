<?php
/**
 * @author Adler Medrado
 */

error_reporting(E_ALL | E_STRICT);
date_default_timezone_set('America/Sao_Paulo');

define('PROJECT_ROOT', str_replace(basename(dirname(__FILE__)), "", dirname(__FILE__)));

$includePath = get_include_path();
$includePath .= PATH_SEPARATOR . PROJECT_ROOT . 'library';
set_include_path($includePath);

define('CONFIG_PATH', PROJECT_ROOT . 'application' . DIRECTORY_SEPARATOR . 'configs');
define('ENTITIES_PATH', PROJECT_ROOT . 'application' . DIRECTORY_SEPARATOR . 'models');
define('DBTABLE_PATH', PROJECT_ROOT . 'application' 
define('MAPPER_PATH', PROJECT_ROOT . 'application' . DIRECTORY_SEPARATOR . 'models');

require_once 'Zend/Loader/Autoloader.php';
$autoloader = Zend_Loader_Autoloader::getInstance();
$autoloader->setFallbackAutoloader(true);

try {
    $opts = new Zend_Console_Getopt(
                    array(
                        'help|h' => 'This message',
                        'env|e=s' => 'Environment (development, production, testing)',
                        'table|t=s' => 'Table name'
                    )
    );
    $opts->parse();
    
} catch (Zend_Console_Getopt_Exception $e) {
    exit($e->getMessage() . "\n\n" . $e->getUsageMessage());
}

if ( (isset($opts->h)) || (!isset($opts->e)) || (!isset($opts->t)) )  {
    echo $opts->getUsageMessage();
    exit;
}

if (!in_array($opts->e, array('development','production','testing','staging'))) {
    echo "Incorrect environment. Please select: development, production, testing or staging\n";
    echo $opts->getUsageMessage();
    exit;
}

$config = new Zend_Config_Ini(CONFIG_PATH . DIRECTORY_SEPARATOR . 'application.ini', $opts->e);
$config = $config->toArray();

$connection = Zend_Db::factory($config['resources']['db']['adapter'], array(
            'host' => $config['resources']['db']['params']['host'],
            'username' => $config['resources']['db']['params']['username'],
            'password' => $config['resources']['db']['params']['password'],
            'dbname' => $config['resources']['db']['params']['dbname'],
                )
);

$table = $connection->describeTable($opts->t);

$entity  = new Entity($table);
$dbTable = new DbTable($table);
$mapper  = new Mapper($table);

$fileWriter = new FileWriter();
$fileWriter->setEntity($entity);
$fileWriter->setDbTable($dbTable);
$fileWriter->setMapper($mapper);
$fileWriter->write();

if (count(Messaging::getMessages()) > 0) {
    echo "Files generation complete. But with errors or warnings:\n";
    foreach (Messaging::getMessages() as $message) {
        echo $message->getMessage() . "\n";
    }
}