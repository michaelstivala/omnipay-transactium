<?php

namespace Omnipay\Transactium;

use Guzzle\Http\ClientInterface;
use Omnipay\Common\AbstractGateway;
use Omnipay\Transactium\Api\RefundByFxlId;
use Omnipay\Transactium\Api\GetHostedPayment;
use Omnipay\Transactium\Api\CreateHostedPayment;
use Symfony\Component\HttpFoundation\Request as HttpRequest;

class Gateway extends AbstractGateway
{
    protected $client;

    public function __construct(ClientInterface $httpClient = null, HttpRequest $httpRequest = null, TransactiumClientFactory $client = null)
    {
        $this->client = $client;

        parent::__construct($httpClient, $httpRequest);
    }

    protected function getClient()
    {
        return TransactiumClientFactory::createClient($this->getUsername(), $this->getPassword(), $this->getTestMode());
    }
    
    /**
     * {@inheritdoc}
     */
    protected function createRequest($class, array $parameters)
    {
        $obj = new $class($this->getClient(), $this->httpRequest);

        return $obj->initialize($parameters);
    }

    public function getName()
    {
        return 'Transactium';
    }

    public function getDefaultParameters()
    {
        return array(
            'username' => '',
            'password' => '',
            'tag' => 'HPSTag',
            'testMode' => false,
        );
    }

    public function getUsername()
    {
        return $this->getParameter('username');
    }

    public function setUsername($value)
    {
        return $this->setParameter('username', $value);
    }

    public function getPassword()
    {
        return $this->getParameter('password');
    }

    public function setPassword($value)
    {
        return $this->setParameter('password', $value);
    }

    public function getTag()
    {
        return $this->getParameter('tag');
    }

    public function setTag($value)
    {
        return $this->setParameter('tag', $value);
    }

    public function getHostedPayment(string $transactiumId)
    {
        return $this->createRequest(GetHostedPayment::class, ['HPSID' => $transactiumId]);
    }

    /**
     * @param array $parameters
     * @return Message\AuthorizeRequest
     */
    public function authorize(array $parameters = array())
    {
        return $this->purchase($parameters);
    }

    /**
     * @param array $parameters
     * @return Message\PurchaseRequest
     */
    public function purchase(array $parameters = array())
    {
        $parameters['tag'] = $this->getTag();
        
        return $this->createRequest(CreateHostedPayment::class, $parameters);
    }

    /**
     * @param array $parameters
     * @return Message\PurchaseRequest
     */
    public function refund(array $parameters = array())
    {
        return $this->createRequest(RefundByFxlId::class, $parameters);
    }
}
