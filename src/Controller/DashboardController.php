<?php


namespace ConferenceTools\Speakers\Controller;


use ConferenceTools\Speakers\Domain\Dashboard\Entity\Speaker;
use Zend\View\Model\ViewModel;
use Doctrine\Common\Collections\Criteria;

class DashboardController extends AppController
{
    public function indexAction()
    {
        /* @TODO Fetch speaker information for currently logged in user
          Display:
         1) Talks selected, links/form to edit
         2) Travel information if supplied, form or link to provide otherwise
         3) Hotel information, plus form/link to request it be booked
         4) General event information
            a) Location of event
            b) Date/times of event
            c) Local travel information eg taxis, buses etc
            d) Location of speakers hotel
         5) AV information
         6) Speakers dinner rsvp and details.
         */

        /** @var Speaker $speaker */
        $criteria = Criteria::create()->where(Criteria::expr()->eq('email', $this->identity()->getIdentifier()));
        $speaker = $this->repository(Speaker::class)->matching($criteria)->current();
        $speakerId = $speaker->getIdentity();

        if (!$speaker->hasResponded()) {
            return $this->redirect()->toRoute('speakers/invitation', ['speakerId' => $speakerId]);
        }

        //@TODO pull from config or db
        $availableDates = [
            '2020-04-02' => 'Thursday 2nd of April',
            '2020-04-03' => 'Friday 3rd of April',
            '2020-04-04' => 'Saturday 4th April'
        ];

        return new ViewModel(['speaker' => $speaker, 'hotelDates' => $availableDates]);
    }
}