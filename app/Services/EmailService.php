<?php

namespace App\Services;

use Microsoft\Graph\Graph;
use Microsoft\Graph\Model\Message;
use Microsoft\Graph\Model\Recipient;
use Microsoft\Graph\Model\EmailAddress;
use Microsoft\Graph\Model\ItemBody;

class EmailService
{
    protected $graph;

    public function __construct($token)
    {
        $this->graph = new Graph();
        $this->graph->setAccessToken($token);
    }

    public function sendEmail($recipientEmail, $subject, $bodyContent)
    {
        $message = new Message();
        $message->setSubject($subject);

        $body = new ItemBody();
        $body->setContent($bodyContent);
        // Cambiamos el tipo de contenido a 'HTML' para permitir código HTML
        $body->setContentType('HTML');
        $message->setBody($body);

        $recipient = new Recipient();
        $recipientAddress = new EmailAddress();
        $recipientAddress->setAddress($recipientEmail);
        $recipient->setEmailAddress($recipientAddress);
        $message->setToRecipients([$recipient]);
        
        try {
            $this->graph->createRequest("POST", "/me/sendMail")
                        ->attachBody(['message' => $message])
                        ->execute();
            return "exitosamente";
        } catch (\Exception $e) {
            return "";
        }
    }

}
