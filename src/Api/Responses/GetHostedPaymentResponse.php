<?php

namespace Omnipay\Transactium\Api\Responses;

use Omnipay\Common\Message\AbstractResponse;

class GetHostedPaymentResponse extends AbstractResponse
{
    private function getStatus()
    {
        return $this->data
            ->GetHostedPaymentResult
            ->Status;
    }

    private function isStatus($status)
    {
        if (is_array($status)) {
            return in_array($this->getStatus(), $status);
        }

        return $this->getStatus() == $status;
    }

    public function isSuccessful()
    {
        return $this->isStatus("Success");
    }

    public function getOrderReference()
    {
        return $this->data
            ->GetHostedPaymentResult
            ->SubmittedRequest
            ->Client
            ->OrderReference;
    }

    /**
     * Is the transaction cancelled by the user?
     *
     * @return boolean
     */
    public function isCancelled()
    {
        $this->isStatus("Cancelled");
    }

    /**
     * Response Message
     *
     * @return null|string A response message from the payment gateway
     */
    public function getMessage()
    {
        return $this->data
            ->GetHostedPaymentResult
            ->HPPMessage;
    }

    /**
     * Gateway Reference
     *
     * @return null|string A reference provided by the gateway to represent this transaction
     */
    public function getTransactionReference()
    {
        if ($this->isStatus(["Timeout", "Cancelled"])) {
            return null;
        }

        return $this->data
            ->GetHostedPaymentResult
            ->Transactions
            ->TransactionResponse
            ->TransactionID;
    }
}
