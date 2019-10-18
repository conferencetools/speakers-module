<?php


namespace ConferenceTools\Speakers\Controller;


use ConferenceTools\Speakers\Domain\Dashboard\Entity\Speaker;
use Zend\View\Model\ViewModel;
use Doctrine\Common\Collections\Criteria;

class DashboardController extends AppController
{
    public function indexAction()
    {
        /*
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
        $speaker = $this->repository(Speaker::class)->matching(new Criteria())->current();

        if (!$speaker->hasResponded()) {
            return $this->redirect()->toRoute('speakers/invitation');
        }

        return new ViewModel(['speaker' => $speaker]);
    }
}