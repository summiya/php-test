<?php

namespace App\Libraries\Notification\Implementations;

use App\Libraries\Notification\IEmailSender;
use App\Parameters\EmailParameters;

class MandrillService implements IEmailSender {

    protected \Mandrill $mandrillClient;

    public function __construct(\Mandrill $mandrillClient) {
        $this->mandrillClient = $mandrillClient;
    }

    public function send(EmailParameters $emailParameters) {

        $recipients = [
            [
                'email' => $emailParameters->getTo(),
                'name' => $emailParameters->getTo(),
                'type' => 'to'
            ]
        ];

        $parameters = [
            'to' => $recipients,
            'subject' => $emailParameters->getSubject(),
            'from_email' => $emailParameters->getFromEmail(),
            'from_name' => $emailParameters->getFromName(),
            'html' => $emailParameters->getBody()
        ];

        return $this->mandrillClient->messages->send($parameters);

    }

}
