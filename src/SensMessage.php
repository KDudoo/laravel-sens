<?php

namespace NotificationChannels\Sens;

use DateTime;

class SensMessage
{

    public $payload = [];

    public static function create(array $payload = [])
    {
        return (new static())->setPayload($payload);
    }

    public function getAttribute(string $key)
    {
        return $this->payload[$key] ?? null;
    }

    public function setPayload(array $payload)
    {
        $this->payload = $payload;
        return $this;
    }

    public function to(string $number)
    {
        $this->payload['to'] = array($number);
        return $this;
    }

    public function from(string $number)
    {
        $this->payload['from'] = $number;
        return $this;
    }


    public function toSMS()
    {
        $this->payload['type'] = 'sms';
        return $this;
    }

    public function toLMS()
    {
        $this->payload['type'] = 'lms';
        return $this;
    }

    public function forAD()
    {
        $this->payload['contentType'] = 'AD';
        return $this;
    }

    public function forCommon()
    {
        $this->payload['contentType'] = 'COMM';
        return $this;
    }

    public function countryCode(string $code)
    {
        $this->payload['countryCode'] = $code;
        return $this;
    }

    public function content(string $content)
    {
        $this->payload['content'] = $content;
        return $this;
    }

    public function subject(string $subject)
    {
        $this->payload['subject'] = $subject;
        $this->payload['type'] = 'lms';
        return $this;
    }

    public function reserveTime(DateTime $datetime)
    {
        $this->payload['reserveTime'] = $datetime->format('yyyy-MM-dd HH:mm');
        return $this;
    }

    public function reserveTimeZone(string $timezone)
    {
        $this->payload['reserveTimeZone'] = $timezone;
        return $this;
    }

    public function scheduleCode(string $scheduleCode)
    {
        $this->payload['scheduleCode'] = $scheduleCode;
        return $this;
    }

    public function generateSignature(string $secretKey)
    {
        return hash_hmac('sha256', $this->toJson(), $secretKey);
    }

    public function toArray()
    {
        return $this->payload;
    }

    public function toJson()
    {
        return json_encode($this->toArray());
    }
}
