<?php

namespace ConferenceTools\Speakers\Controller\Admin;

use ConferenceTools\Speakers\Controller\AppController;
use ConferenceTools\Speakers\Domain\Dashboard\Entity\TravelReimbursement;
use ConferenceTools\Speakers\Domain\Speaker\Command\AcceptTravelReimbursement;
use ConferenceTools\Speakers\Domain\Speaker\Command\PayTravelReimbursement;
use ConferenceTools\Speakers\Domain\Speaker\Command\RejectTravelReimbursement;
use ConferenceTools\Speakers\Form\NotesForm;
use Doctrine\Common\Collections\Criteria;
use Zend\View\Model\ViewModel;

class TravelReimbursementController extends AppController
{
    public function indexAction()
    {
        $travelReimbursements = $this->repository(TravelReimbursement::class)->matching(Criteria::create());

        return new ViewModel(['travelReimbursements' => $travelReimbursements]);
    }

    public function acceptAction()
    {
        $form = $this->form(NotesForm::class, ['field-label' => 'Notes']);

        $speakerId = $this->params()->fromRoute('speakerId');
        $reimbursementRequestId = $this->params()->fromRoute('reimbursementRequestId');

        if ($this->getRequest()->isPost()) {
            $data = $this->params()->fromPost();
            $form->setData($data);

            if ($form->isValid()) {
                $data = $form->getData();
                $command = new AcceptTravelReimbursement($speakerId, $reimbursementRequestId, $data['notes']);
                $this->messageBus()->fire($command);

                $this->redirect()->toRoute('speakers/speaker', ['speakerId' => $speakerId]);
            }
        }

        $viewModel = new ViewModel(['form' => $form, 'action' => 'Accept Travel Reimbursement Request']);
        $viewModel->setTemplate('admin/form');
        return $viewModel;
    }

    public function rejectAction()
    {
        $form = $this->form(NotesForm::class, ['field-label' => 'Rejection reason']);

        $speakerId = $this->params()->fromRoute('speakerId');
        $reimbursementRequestId = $this->params()->fromRoute('reimbursementRequestId');

        if ($this->getRequest()->isPost()) {
            $data = $this->params()->fromPost();
            $form->setData($data);

            if ($form->isValid()) {
                $data = $form->getData();
                $command = new RejectTravelReimbursement($speakerId, $reimbursementRequestId, $data['notes']);
                $this->messageBus()->fire($command);

                $this->redirect()->toRoute('speakers/speaker', ['speakerId' => $speakerId]);
            }
        }

        $viewModel = new ViewModel(['form' => $form, 'action' => 'Reject Travel Reimbursement Request']);
        $viewModel->setTemplate('admin/form');
        return $viewModel;
    }

    public function paidAction()
    {
        $form = $this->form(NotesForm::class, ['field-label' => 'Notes']);

        $speakerId = $this->params()->fromRoute('speakerId');
        $reimbursementRequestId = $this->params()->fromRoute('reimbursementRequestId');

        if ($this->getRequest()->isPost()) {
            $data = $this->params()->fromPost();
            $form->setData($data);

            if ($form->isValid()) {
                $data = $form->getData();
                $command = new PayTravelReimbursement($speakerId, $reimbursementRequestId, $data['notes']);
                $this->messageBus()->fire($command);

                $this->redirect()->toRoute('speakers/speaker', ['speakerId' => $speakerId]);
            }
        }

        $viewModel = new ViewModel(['form' => $form, 'action' => 'Pay Travel Reimbursement Request']);
        $viewModel->setTemplate('admin/form');
        return $viewModel;
    }
}