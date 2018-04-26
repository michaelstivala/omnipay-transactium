<?php

namespace Omnipay\Transactium\Api\Responses;

use Omnipay\Common\Message\AbstractResponse;

class RefundByFxlIdResponse extends AbstractResponse
{
    public function isSuccessful()
    {
        return $this->data
            ->RefundByFXLIdResult
            ->TransactionResponse
            ->Status == "Approved";
    }

    /**
     * Gateway Reference
     *
     * @return null|string A reference provided by the gateway to represent this transaction
     */
    public function getTransactionReference()
    {
        if (! $this->isSuccessful()) {
            return null;
        }

        return $this->data
            ->RefundByFXLIdResult
            ->TransactionResponse
            ->TransactionID;
    }

    /**
     * Response Message
     *
     * @return null|string A response message from the payment gateway
     */
    public function getMessage()
    {
        return $this->data
            ->RefundByFXLIdResult
            ->TransactionResponse
            ->Status;
    }
}
