<?php


namespace ConferenceTools\Speakers\Controller;


use ConferenceTools\Speakers\Domain\Dashboard\Entity\Speaker;
use Phactor\ReadModel\Repository;
use Phactor\Zend\ControllerPlugin\MessageBus;
use Zend\Form\Form;
use Zend\Mvc\Controller\AbstractActionController;

/**
 * @method MessageBus messageBus()
 * @method Repository repository(string $className)
 * @method Form form(string $classname, array $options = [])
 * @method Speaker currentSpeaker()
 * @method FlashMessenger flashMessenger()
 */
class AppController extends AbstractActionController
{

}