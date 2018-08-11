<?php


namespace ConferenceTools\Speakers\Controller;


use Carnage\Phactor\ReadModel\Repository;
use Carnage\Phactor\Zend\ControllerPlugin\MessageBus;
use Zend\Mvc\Controller\AbstractActionController;

/**
 * @method MessageBus messageBus()
 * @method Repository repository(string $className)
 */
class AppController extends AbstractActionController
{

}