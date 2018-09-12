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

        //@TODO needs auth module to pull this out of; otherwise will need to grab from url for a profile action
        //$speakerId = 'mGyheNGNVD4tOvhCUS0S73QYMghZUA'; //get from auth module.
        //$speaker = $this->repository(Speaker::class)->get($speakerId);
        /** @var Speaker $speaker */
        $speaker = $this->repository(Speaker::class)->matching(new Criteria())->current();
        $speakerId = $speaker->getIdentity();

        if (!$speaker->hasResponded()) {
            return $this->redirect()->toRoute('speakers/invitation', ['speakerId' => $speakerId]);
        }

        return new ViewModel(['speaker' => $speaker]);
    }
}