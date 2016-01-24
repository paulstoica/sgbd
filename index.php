<?php

// Need to trace all kind of errors
ini_set('display_errors', 'On');
error_reporting(E_ALL);

include __DIR__ . '/developer.php';

$loader = require __DIR__ . '/vendor/autoload.php';

use App\Project;

Project::start();

$em = Project::getEntityManager();

//$entity = $em->insert('App\Entity\CategoryEntity', array('name' => 'Root'));
//pr($entity);
//
//$entity = $em->get('App\Entity\CategoryEntity', 7);
//
//pr($entity);
//
//$entity = $em->update($entity, array('name' => 'Root'));
//
//pr($entity);
//
//$entity = $em->getOneBy('App\Entity\CategoryEntity', array('name' => 'Test'));
//
//pr($entity);
//
//$entities = $em->getAll('App\Entity\CategoryEntity');
//
//pr($entities);
//
//$entities = $em->getAllBy('App\Entity\CategoryEntity', array('name' => 'Root'));
//
//pr($entities);

