<?php

namespace Omnipay\Transactium\Api;

use Omnipay\Transactium\Api\Responses\GetHostedPaymentResponse;

class GetHostedPayment extends AbstractRequest
{
    public function sendData($data)
    {
        return new GetHostedPaymentResponse($this, $this->soapClient->GetHostedPayment($data));
    }

    public function getData()
    {
        return $this->parameters->all();
    }

    public function setHpsid($value)
    {
        $this->parameters->set('HPSID', $value);
    }
}
