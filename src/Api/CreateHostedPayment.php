<?php

namespace Omnipay\Transactium\Api;

use Craft;
use SoapVar;
use DateTime;
use SoapClient;
use DateTimeZone;
use DateInterval;
use Omnipay\Transactium\TransactiumClientFactory;
use Omnipay\Transactium\Api\Responses\CreateHostedPaymentResponse;

class CreateHostedPayment extends AbstractRequest
{
    public function sendData($data)
    {
        try {
            return new CreateHostedPaymentResponse($this, $this->soapClient->CreateHostedPayment($data));
        } finally {
            Craft::getLogger()->log($this->soapClient->__getLastRequest() . " - Original: " . print_r($data, true), 0x01);
        }
    }

    public function getData()
    {
        $data = [
            'Transactions' => [
                'TransactionRequest' => [
                    [
                        'BusinessUnitID' => '0',
                        'Amount' => $this->getAmountInteger(),
                    ],
                ],
            ],
            'Tag' => $this->parameters->get('tag'),
            'TotalAmount' => $this->getAmountInteger(),
            'Type' => 'Sale',
            'RequireAllApproved' => false,
            // 10 minutes from now
            'ValidUntil' => $this->now()->add(new DateInterval("PT10M"))->format('Y-m-d\TH:i:s'),
            'Currency' => $this->parameters->get('currency'),
            'URLs' => [
                'ApprovedURL' => $this->parameters->get('returnUrl'),
                'DeclinedURL' => $this->parameters->get('returnUrl'),
            ],
            'Client' => [
                'CardHolderName' => $this->parameters->get('card')->getBillingName(),
                'ClientReference' => $this->parameters->get('card')->getEmail(),
                'OrderReference' => $this->parameters->get('transactionReference'),
            ],
            'Billing' => [
                'FullName' => $this->parameters->get('card')->getBillingName(),
                'Email' => $this->parameters->get('card')->getEmail(),
                'CountryCode' => $this->parameters->get('card')->getBillingCountry(),
                'CityName' => $this->parameters->get('card')->getBillingCity(),
                'Phone' => $this->parameters->get('card')->getBillingPhone(),
                'PostalCode' => $this->parameters->get('card')->getBillingPostcode(),
                'StreetNumber' => $this->parameters->get('card')->getBillingAddress1(),
                'StreetName' => $this->parameters->get('card')->getBillingAddress2(),
                'BusinessName' => $this->parameters->get('card')->getBillingCompany(),
            ],
            'Shipping' => [
                'FullName' => $this->parameters->get('card')->getShippingName(),
                'Email' => $this->parameters->get('card')->getEmail(),
                'CountryCode' => $this->parameters->get('card')->getShippingCountry(),
                'CityName' => $this->parameters->get('card')->getShippingCity(),
                'Phone' => $this->parameters->get('card')->getShippingPhone(),
                'PostalCode' => $this->parameters->get('card')->getShippingPostcode(),
                'StreetNumber' => $this->parameters->get('card')->getShippingAddress1(),
                'StreetName' => $this->parameters->get('card')->getShippingAddress2(),
                'BusinessName' => $this->parameters->get('card')->getShippingCompany(),
            ],
            'Behaviour' => [
                'DynamicAmount' => 'Fixed',
                'ProcessWithFixedCard' => '1',
                'ProcessWithSavePI' => '1',
                'ProcessWithRandomCode' => '1',
                'IFrame' => '1',
                'ReceiptPage' => '0',
            ],
        ];

        return [
            'Request' => new SoapVar(
                $data,
                SOAP_ENC_OBJECT,
                'HPPCreateRequest',
                TransactiumClientFactory::SOAP_NAMESPACE
            )
        ];
    }

    private function now()
    {
        return new DateTime("now", new DateTimeZone('Europe/Malta'));
    }
}
