<?php

namespace Omnipay\Transactium;

use SoapClient;
use SoapHeader;

class TransactiumClientFactory
{
    const LIVE_WSDL_URL = "https://psp.transactium.com/hps/webservice/hpws/v1501.asmx?WSDL";

    const STAGING_WSDL_URL = "https://psp.stg.transactium.com/hps/webservice/hpws/v1501.asmx?WSDL";

    const SOAP_NAMESPACE = 'http://transactium.com/HPP/';

    public static function createClient($username, $password, $testMode)
    {
        $client = new SoapClient(
            $testMode ? self::STAGING_WSDL_URL : self::LIVE_WSDL_URL,
            ['trace' => 1]
        );
        
        $client->__setSoapHeaders(
            new SoapHeader(
                self::SOAP_NAMESPACE,
                'HPSAuthHeader',
                ['Username' => $username, 'Password' => $password]
            )
        );

        return $client;
    }
}
