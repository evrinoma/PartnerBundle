<?php

use Doctrine\ORM\Tools\Console\ConsoleRunner;
use Doctrine\ORM\Tools\Console\EntityManagerProvider\SingleManagerProvider;

// replace with path to your own project bootstrap file
require dirname(__DIR__).'/../vendor/autoload.php';

// replace with mechanism to retrieve EntityManager in your app

$commands = [
    // If you want to add your own custom console commands,
    // you can do so here.
];

$entityManager = new ManagerRegistry();

ConsoleRunner::run(
    new \Doctrine\Bundle\DoctrineBundle\Command\CreateDatabaseDoctrineCommand($entityManager),
    $commands
);