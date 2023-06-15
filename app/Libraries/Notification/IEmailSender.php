<?php

namespace App\Libraries\Notification;

use App\Parameters\EmailParameters;

interface IEmailSender {

    public function send(EmailParameters $emailParameters);

}
