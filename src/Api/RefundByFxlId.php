<?php

namespace Omnipay\Transactium\Api;

use Omnipay\Transactium\Api\Responses\RefundByFxlIdResponse;

class RefundByFxlId extends AbstractRequest
{
    public function sendData($data)
    {
        return new RefundByFxlIdResponse($this, $this->soapClient->RefundByFxlId($data));
    }

    public function getData()
    {
        return [
            'FXLID' => $this->parameters->get('transactionReference'),
            'Amount' => intval($this->parameters->get('amount') * 100),
            'Currency' => $this->parameters->get('currency'),
        ];
    }

    public function setHpsid($value)
    {
        $this->parameters->set('HPSID', $value);
    }
}
