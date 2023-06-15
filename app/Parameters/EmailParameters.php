<?php

namespace App\Parameters;

class EmailParameters {

    private string $to;
    private string $fromEmail;
    private string $fromName;
    private string $subject;
    private string $body;

    public function getTo() : string {
        return $this->to;
    }

    public function setTo(string $to): self {
        $this->to = $to;
        return $this;
    }

    public function getFromEmail() : ?string {
        return $this->fromEmail ?? null;
    }

    public function setFromEmail(?string $fromEmail): self {
        if (!is_null($fromEmail)) {
            $this->fromEmail = $fromEmail;
        }
        return $this;
    }

    public function getFromName() {
        return $this->fromName;
    }

    public function setFromName($fromName): self {
        $this->fromName = $fromName;
        return $this;
    }

    public function getSubject() : string {
        return $this->subject;
    }

    public function setSubject(string $subject): self {
        $this->subject = $subject;
        return $this;
    }

    public function getBody() : string {
        return $this->body;
    }

    public function setBody(string $body): self {
        $this->body = $body;
        return $this;
    }

}
