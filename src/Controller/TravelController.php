<?php

namespace ConferenceTools\Speakers\Controller;

use ConferenceTools\Speakers\Domain\Speaker\Command\ProvideJourneyDetails;
use ConferenceTools\Speakers\Domain\Speaker\Command\RequestStationPickup;
use ConferenceTools\Speakers\Domain\Speaker\Command\RequestTravelReimbursement;
use ConferenceTools\Speakers\Domain\Speaker\Journey;
use ConferenceTools\Speakers\Form\ProvideTravelDetails;
use ConferenceTools\Speakers\Form\RequestStationPickupForm;
use ConferenceTools\Speakers\Form\RequestTravelReimbursementForm;
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

                $this->flashMessenger()->addSuccessMessage('Travel details added');
                $this->redirect()->toRoute('speakers/dashboard');
            }
        }

        $viewModel = new ViewModel(['form' => $form, 'action' => 'Provide travel details']);
        $viewModel->setTemplate('admin/form');
        return $viewModel;
    }

    public function requestReimbursementAction()
    {
        $speaker = $this->currentSpeaker();
        $form = $this->form(RequestTravelReimbursementForm::class);

        if ($this->getRequest()->isPost()) {
            $data = $this->params()->fromPost();
            $form->setData($data);

            if ($form->isValid()) {
                $data = $form->getData();
                $command = new RequestTravelReimbursement(
                    $speaker->getIdentity(),
                    $data['amount'] * 100,
                    $data['notes'],
                    ''
                );
                $this->messageBus()->fire($command);

                $this->flashMessenger()->addSuccessMessage('Travel reimbursement requested, one of the organisers will look at it shortly');
                $this->redirect()->toRoute('speakers/dashboard');
            }
        }

        $viewModel = new ViewModel(['form' => $form, 'action' => 'Request travel reimbursement']);
        $viewModel->setTemplate('admin/form');
        return $viewModel;
    }

    public function requestStationPickupAction()
    {
        $speaker = $this->currentSpeaker();
        $form = $this->form(RequestStationPickupForm::class);

        if ($this->getRequest()->isPost()) {
            $data = $this->params()->fromPost();
            $form->setData($data);

            if ($form->isValid()) {
                $data = $form->getData();
                $command = new RequestStationPickup(
                    $speaker->getIdentity(),
                    $data['station'],
                    new \DateTime($data['pickupTime']),
                    $data['notes']
                );
                $this->messageBus()->fire($command);

                $this->flashMessenger()->addSuccessMessage('Station pickup requested, one of the organisers will look at it shortly');
                $this->redirect()->toRoute('speakers/dashboard');
            }
        }

        $viewModel = new ViewModel(['form' => $form, 'action' => 'Request station pickup']);
        $viewModel->setTemplate('admin/form');
        return $viewModel;
    }
}