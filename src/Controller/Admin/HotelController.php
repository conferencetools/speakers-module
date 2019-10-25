<?php

namespace ConferenceTools\Speakers\Controller\Admin;

use ConferenceTools\Speakers\Controller\AppController;
use ConferenceTools\Speakers\Domain\Dashboard\Entity\Speaker;
use ConferenceTools\Speakers\Domain\Speaker\Command\BookAccommodation;
use ConferenceTools\Speakers\Domain\Speaker\Command\RequestAccommodation;
use ConferenceTools\Speakers\Form\HotelBookingForm;
use Doctrine\Common\Collections\Criteria;
use Zend\View\Model\ViewModel;

class HotelController extends AppController
{
    public function indexAction()
    {
        $availableDates = [
            '2020-04-02' => 'Thursday 2nd of April',
            '2020-04-03' => 'Friday 3rd of April',
            '2020-04-04' => 'Saturday 4th April'
        ];
        $speakers = $this->repository(Speaker::class)->matching(Criteria::create());
        return new ViewModel(['speakers' => $speakers, 'hotelDates' => $availableDates]);
    }

    public function makeBookingAction()
    {
        $speakerId = $this->params()->fromRoute('speakerId');
        /** @var Speaker $speaker */
        $speaker = $this->repository(Speaker::class)->get($speakerId);

        $availableDates = [
            '2020-04-02' => 'Thursday 2nd of April',
            '2020-04-03' => 'Friday 3rd of April',
            '2020-04-04' => 'Saturday 4th April'
        ];
        $form = $this->form(HotelBookingForm::class, ['available_dates' => $availableDates]);

        if ($this->getRequest()->isPost()) {
            $data = $this->params()->fromPost();
            $form->setData($data);

            if ($form->isValid()) {
                $data = $form->getData();
                $command = new BookAccommodation(
                    $speaker->getIdentity(),
                    ...$data['dates']
                );
                $this->messageBus()->fire($command);

                $this->flashMessenger()->addSuccessMessage('Hotel booking request updated');
                return $this->redirect()->toRoute('speakers/speaker', ['speakerId' => $speaker->getIdentity()]);
            }
        }

        $view = new ViewModel(['form' => $form, 'action' => 'Book hotel rooms']);
        $view->setTemplate('admin/form');
        return $view;
    }
}