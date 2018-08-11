<?php


namespace ConferenceTools\Speakers\Controller;


use Zend\View\Model\ViewModel;

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

        return new ViewModel();
    }
}