<?php


namespace ConferenceTools\Speakers\Controller;


use ConferenceTools\Speakers\Domain\Speaker\Command\ProvideJourneyDetails;
use ConferenceTools\Speakers\Domain\Speaker\Journey;
use ConferenceTools\Speakers\Form\ProvideTravelDetails;
use Zend\Form\Element\DateTime;
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
        $form = $this->form(ProvideTravelDetails::class);

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
                        new \DateTime($data['arrivalTime']),
                        new \DateTime($data['departureTime']),
                        $data['notes']
                    )
                );
                $this->messageBus()->fire($command);

                //redirect base on role
                //add flash message
                $this->redirect()->toRoute('speakers/dashboard');
            }
        }

        $viewModel = new ViewModel(['form' => $form, 'action' => 'Provide travel details']);
        $viewModel->setTemplate('admin/form');
        return $viewModel;
    }
}