<?php


namespace ConferenceTools\Speakers\Controller;


use ConferenceTools\Speakers\Domain\Speaker\Command\ProvideJourneyDetails;
use ConferenceTools\Speakers\Domain\Speaker\Journey;
use Zend\Form\Element\Submit;
use Zend\Form\Element\Text;
use Zend\Form\Element\Textarea;
use Zend\Form\Form;
use Zend\View\Model\ViewModel;

class TravelController extends AppController
{
    public function provideTravelDetailsAction()
    {
        $speakerId = $this->params()->fromRoute('speakerId');
        /** @var Speaker $speaker */

        //@TODO validate + format dates
        $form = new Form();
        $form->add(new Text('departFrom', ['label' => 'Depart from']));
        $form->add(new Text('departureTime', ['label' => 'Departure time']));
        $form->add(new Text('arriveAt', ['label' => 'Arrive at']));
        $form->add(new Text('arrivalTime', ['label' => 'Arrival time']));
        $form->add(new Textarea('notes', ['label' => 'Notes']));
        $form->add(new Submit('submit', ['value' => 'Edit']));

        if ($this->getRequest()->isPost()) {
            $data = $this->params()->fromPost();
            $form->setData($data);

            if ($form->isValid()) {
                $data = $form->getData();
                $command = new ProvideJourneyDetails(
                    $speakerId,
                    new Journey(
                        $data['arriveAt'],
                        $data['departFrom'],
                        \DateTime::createFromFormat('Y-m-d h:i', $data['arrivalTime']),
                        \DateTime::createFromFormat('Y-m-d h:i', $data['departureTime']),
                        $data['notes']
                    )
                );
                $this->messageBus()->fire($command);

                //redirect base on role
                //add flash message
                $this->redirect()->toRoute('speakers/dashboard');
            }
        }

        return new ViewModel(['form' => $form]);
    }
}