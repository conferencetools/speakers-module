<?php


namespace ConferenceTools\Speakers\Mvc\Controller\Plugin;


use ConferenceTools\Speakers\Domain\Dashboard\Entity\Speaker;
use Doctrine\Common\Collections\Criteria;
use Zend\Mvc\Controller\Plugin\AbstractPlugin;

class CurrentSpeaker extends AbstractPlugin
{
    public function __invoke(): ?Speaker
    {
        $criteria = Criteria::create()->where(Criteria::expr()->eq('email', $this->controller->identity()->getIdentifier()));
        /** @var Speaker $speaker */
        $speaker = $this->controller->repository(Speaker::class)->matching($criteria)->current();

        if (!$speaker) {
            return null;
        }

        return $speaker;
    }
}