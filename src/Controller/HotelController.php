<?php


namespace ConferenceTools\Speakers\Controller;


use ConferenceTools\Speakers\Domain\Speaker\Bio;
use ConferenceTools\Speakers\Domain\Speaker\Command\RequestAccommodation;
use ConferenceTools\Speakers\Domain\Speaker\Command\UpdateProfile;
use ConferenceTools\Speakers\Domain\Speaker\DietaryRequirements;
use ConferenceTools\Speakers\Domain\Speaker\Email;
use ConferenceTools\Speakers\Form\HotelBookingForm;
use Zend\View\Model\ViewModel;

class HotelController extends AppController
{
    public function alterBookingAction()
    {
        $speaker = $this->currentSpeaker();
        $bookings = $speaker->getAccommodation();

        $availableDates = [
            '2020-04-02' => 'Thursday 2nd of April',
            '2020-04-03' => 'Friday 3rd of April',
            '2020-04-04' => 'Saturday 4th April'
        ];
        $form = $this->form(HotelBookingForm::class, ['available_dates' => $availableDates]);
        $form->setData(['dates' => array_keys($bookings)]);

        if ($this->getRequest()->isPost()) {
            $data = $this->params()->fromPost();
            $form->setData($data);

            if ($form->isValid()) {
                $data = $form->getData();
                $command = new RequestAccommodation(
                    $speaker->getIdentity(),
                    ...$data['dates']
                );
                $this->messageBus()->fire($command);

                $this->flashMessenger()->addSuccessMessage('Hotel booking request updated');
                $this->redirect()->toRoute('speakers/dashboard');
            }
        }

        $view = new ViewModel(['form' => $form, 'actop']);
        $view->setTemplate('admin/form');
        return $view;
    }
}