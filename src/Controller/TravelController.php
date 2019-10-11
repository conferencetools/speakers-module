<?php

namespace ConferenceTools\Speakers\Controller;

use ConferenceTools\Speakers\Domain\Speaker\Command\ProvideJourneyDetails;
use ConferenceTools\Speakers\Domain\Speaker\Journey;
use ConferenceTools\Speakers\Form\ProvideTravelDetails;
use Zend\View\Model\ViewModel;

class TravelController extends AppController
{
    public function provideTravelDetailsAction()
    {
        $speaker = $this->currentSpeaker();
        $form = $this->form(ProvideTravelDetails::class);

        if ($this->getRequest()->isPost()) {
            $data = $this->params()->fromPost();
            $form->setData($data);

            if ($form->isValid()) {
                $data = $form->getData();
                $command = new ProvideJourneyDetails(
                    $speaker->getIdentity(),
                    new Journey(
                        $data['arriveAt'],
                        $data['departFrom'],
                        new \DateTime($data['arrivalTime']),
                        new \DateTime($data['departureTime']),
                        $data['notes']
                    )
                );
                $this->messageBus()->fire($command);

                $this->flashMessenger()->addSuccessMessage('Travel details added ');
                $this->redirect()->toRoute('speakers/dashboard');
            }
        }

        $viewModel = new ViewModel(['form' => $form, 'action' => 'Provide travel details']);
        $viewModel->setTemplate('admin/form');
        return $viewModel;
    }
}