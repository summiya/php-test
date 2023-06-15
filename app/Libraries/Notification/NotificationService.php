<?php

namespace App\Libraries\Notification;

use App\Parameters\EmailParameters;
use Symfony\Component\HttpFoundation\ParameterBag;

class NotificationService {

    protected IEmailSender $emailSender;

    public function __construct(IEmailSender $IEmailSender) {
        $this->emailSender = $IEmailSender;
    }

    public function sendEmail(ParameterBag $request) {

        $emailParameters = $this->getEmailParameters($request);
        $this->emailSender->send($emailParameters);

    }

    public function getEmailParameters(ParameterBag $request): EmailParameters {

        $emailParameters = new EmailParameters();

        // construct all email parameters
        $emailParameters->setTo($request->get('email'))
            ->setFromEmail(env('DEFAULT_SENDER_EMAIL'))
            ->setFromName(env('DEFAULT_SENDER_NAME'));

        $subject = $request->get('company_name');

        $body = $this->getBody($request->get('start_date'), $request->get('end_date'));

        $emailParameters
            ->setBody($body)
            ->setSubject($subject);

        return $emailParameters;

    }

    private function getBody(string $startDate, string $endDate): string {
        return "From {$startDate} To {$endDate}";
    }

}
