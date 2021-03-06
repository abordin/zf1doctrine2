<?php

if (!defined('LIB_PATH')){
    $path = realpath(__DIR__);    
    define('LIB_PATH', dirname(dirname(dirname(dirname($path)))).'/library');
}

require_once LIB_PATH . '/Doctrine/Common/ClassLoader.php';

$classLoader = new \Doctrine\Common\ClassLoader('Doctrine\ORM', LIB_PATH);
$classLoader->register();
$classLoader = new \Doctrine\Common\ClassLoader('Doctrine\DBAL', LIB_PATH);
$classLoader->register();
$classLoader = new \Doctrine\Common\ClassLoader('Doctrine\Common', LIB_PATH);
$classLoader->register();
$classLoader = new \Doctrine\Common\ClassLoader('Symfony', LIB_PATH . '/Doctrine');
$classLoader->register();
$classLoader = new \Doctrine\Common\ClassLoader('Entities', realpath(__DIR__.'../models'));
$classLoader->register();
$classLoader = new \Doctrine\Common\ClassLoader('Proxies', realpath(__DIR__.'../proxies'));
$classLoader->register();

// Variable $helperSet is defined inside cli-config.php
require __DIR__ . '/cli-config.php';

$cli = new \Symfony\Component\Console\Application('Doctrine Command Line Interface', Doctrine\Common\Version::VERSION);
$cli->setCatchExceptions(true);

$helperSet = $cli->getHelperSet();
foreach ($helpers as $name => $helper) {
    $helperSet->set($helper, $name);
}
$cli->addCommands(array(
    // DBAL Commands
    new \Doctrine\DBAL\Tools\Console\Command\RunSqlCommand(),
    new \Doctrine\DBAL\Tools\Console\Command\ImportCommand(),
    // ORM Commands
    new \Doctrine\ORM\Tools\Console\Command\ClearCache\MetadataCommand(),
    new \Doctrine\ORM\Tools\Console\Command\ClearCache\ResultCommand(),
    new \Doctrine\ORM\Tools\Console\Command\ClearCache\QueryCommand(),
    new \Doctrine\ORM\Tools\Console\Command\SchemaTool\CreateCommand(),
    new \Doctrine\ORM\Tools\Console\Command\SchemaTool\UpdateCommand(),
    new \Doctrine\ORM\Tools\Console\Command\SchemaTool\DropCommand(),
    new \Doctrine\ORM\Tools\Console\Command\EnsureProductionSettingsCommand(),
    new \Doctrine\ORM\Tools\Console\Command\ConvertDoctrine1SchemaCommand(),
    new \Doctrine\ORM\Tools\Console\Command\GenerateRepositoriesCommand(),
    new \Doctrine\ORM\Tools\Console\Command\GenerateEntitiesCommand(),
    new \Doctrine\ORM\Tools\Console\Command\GenerateProxiesCommand(),
    new \Doctrine\ORM\Tools\Console\Command\ConvertMappingCommand(),
    new \Doctrine\ORM\Tools\Console\Command\RunDqlCommand(),
    new \Doctrine\ORM\Tools\Console\Command\ValidateSchemaCommand(),
));
$cli->run();