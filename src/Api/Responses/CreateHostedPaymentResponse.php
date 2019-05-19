<?php

namespace Omnipay\Transactium\Api\Responses;

use Omnipay\Common\Message\AbstractResponse;

class CreateHostedPaymentResponse extends AbstractResponse
{
    public function isSuccessful()
    {
        return false;
    }

    public function isRedirect()
    {
        return true;
    }

    public function getRedirectMethod()
    {
        return 'GET';
    }

    public function getRedirectUrl()
    {
        if (! property_exists($this->data->CreateHostedPaymentResult, 'URL')) {
            return null;
        }

        return $this->data
            ->CreateHostedPaymentResult
            ->URL;
    }

    /**
     * Gateway Reference
     *
     * @return null|string A reference provided by the gateway to represent this transaction
     */
    public function getTransactionReference()
    {
        return $this->data
            ->CreateHostedPaymentResult
            ->ID;
    }



    public function getMessage()
    {
        if (!! $this->getRedirectUrl()) {
            return "Success";
        }

        return $this->data
            ->CreateHostedPaymentResult
            ->Transactions
            ->TransactionResponse
            ->Response;
    }
}
