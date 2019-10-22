<?php

namespace ConferenceTools\Speakers\Controller\Admin;

use ConferenceTools\Speakers\Controller\AppController;
use ConferenceTools\Speakers\Domain\Dashboard\Entity\PickupRequest;
use ConferenceTools\Speakers\Domain\Speaker\Command\AcceptStationPickupRequest;
use ConferenceTools\Speakers\Domain\Speaker\Command\RejectStationPickupRequest;
use ConferenceTools\Speakers\Form\NotesForm;
use Doctrine\Common\Collections\Criteria;
use Zend\View\Model\ViewModel;

class StationPickupController extends AppController
{
    public function indexAction()
    {
        $pickupRequests = $this->repository(PickupRequest::class)->matching(Criteria::create());

        return new ViewModel(['stationPickups' => $pickupRequests]);
    }

    public function acceptAction()
    {
        $form = $this->form(NotesForm::class, ['field-label' => 'Notes']);

        $speakerId = $this->params()->fromRoute('speakerId');
        $pickupRequestId = $this->params()->fromRoute('pickupRequestId');

        if ($this->getRequest()->isPost()) {
            $data = $this->params()->fromPost();
            $form->setData($data);

            if ($form->isValid()) {
                $data = $form->getData();
                $command = new AcceptStationPickupRequest($speakerId, $pickupRequestId, $data['notes']);
                $this->messageBus()->fire($command);

                $this->redirect()->toRoute('speakers/speaker', ['speakerId' => $speakerId]);
            }
        }

        $viewModel = new ViewModel(['form' => $form, 'action' => 'Accept Station Pickup Request']);
        $viewModel->setTemplate('admin/form');
        return $viewModel;
    }

    public function rejectAction()
    {
        $form = $this->form(NotesForm::class, ['field-label' => 'Rejection reason']);

        $speakerId = $this->params()->fromRoute('speakerId');
        $pickupRequestId = $this->params()->fromRoute('pickupRequestId');

        if ($this->getRequest()->isPost()) {
            $data = $this->params()->fromPost();
            $form->setData($data);

            if ($form->isValid()) {
                $data = $form->getData();
                $command = new RejectStationPickupRequest($speakerId, $pickupRequestId, $data['notes']);
                $this->messageBus()->fire($command);

                $this->redirect()->toRoute('speakers/speaker', ['speakerId' => $speakerId]);
            }
        }

        $viewModel = new ViewModel(['form' => $form, 'action' => 'Reject Station Pickup Request']);
        $viewModel->setTemplate('admin/form');
        return $viewModel;
    }
}