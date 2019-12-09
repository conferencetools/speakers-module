<?php

namespace ConferenceTools\Speakers\Emails;

use ConferenceTools\Speakers\Domain\Dashboard\Entity\Speaker;
use ConferenceTools\Speakers\Domain\Speaker\Event\SpeakerWasInvited;
use Phactor\Message\DomainMessage;
use Phactor\Message\Handler;
use Phactor\ReadModel\Repository;
use Zend\Http\Response;
use Zend\Mail\Message;
use Zend\Mail\Transport\TransportInterface;
use Zend\Mime\Part as MimePart;
use Zend\Mime\Message as MimeMessage;
use Zend\View\Model\ViewModel;
use Zend\View\View;

class EmailInvite implements Handler
{
    private $view;
    private $mail;
    private $config;
    private $speakerRepository;

    public function __construct(
        Repository $speakerRepository,
        View $view,
        TransportInterface $mail,
        array $config = []
    ) {
        $this->view = $view;
        $this->mail = $mail;
        $this->config = $config;
        $this->config['subject'] = $this->config['subject'] ?? 'Your ticket receipt';
        $this->speakerRepository = $speakerRepository;
    }

    public function handle(DomainMessage $domainMessage)
    {
        $message = $domainMessage->getMessage();
        if (!($message instanceof SpeakerWasInvited)) {
            return;
        }

        $viewModel = new ViewModel([
            'speaker' => $message->getName(),
            'config'=> $this->config,
        ]);
        $viewModel->setTemplate('email/speaker-invite');

        $response = new Response();
        $this->view->setResponse($response);
        $this->view->render($viewModel);
        $html = $response->getContent();

        $emailMessage = $this->buildMessage($html);
        $emailMessage->setTo($message->getEmail()->getEmail());

        $this->mail->send($emailMessage);
    }

    private function buildMessage($htmlMarkup)
    {
        $html = new MimePart($htmlMarkup);
        $html->setCharset('UTF-8');
        $html->type = "text/html";

        $body = new MimeMessage();
        $body->setParts(array($html));

        $message = new Message();
        $message->setBody($body);
        $message->setSubject($this->config['subject']);
        if (isset($this->config['from'])) {
            $message->setFrom($this->config['from']);
        }
        $message->setEncoding('UTF-8');

        return $message;
    }
}
