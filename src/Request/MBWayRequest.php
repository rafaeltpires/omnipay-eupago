<?php

declare(strict_types=1);

namespace Omnipay\EuPago\Request;

use LengthException;
use Omnipay\Common\Exception\InvalidRequestException;
use Omnipay\EuPago\Response\MBWayResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * @link https://helpdesk.EuPago.com/en/support/solutions/articles/79000086376-api-mbway
 */
final class MBWayRequest extends AbstractRequest
{
    private const SANDBOX_BASE_URL            = 'https://sandbox.eupago.pt';
    private const PRODUCTION_BASE_URL = 'https://clientes.eupago.pt';
    private const ENDPOINT   = 'clientes/rest_api/mbway/create';
    private const MEDIA_TYPE = 'application/json';

    /**
     * @param  string  $value
     * @return self
     */
    public function setPaymentPhone($value): self
    {
        if (mb_strlen($value) != 9) {
            throw new LengthException('The phone number value must have 9 characters');
        }

        return $this->setParameter('paymentPhone', $value);
    }

    /**
     * @return string
     */
    public function getPaymentPhone() : string
    {
        return $this->getParameter('paymentPhone');
    }


    /**
     * @param  string  $value
     * @return self
     */
    public function setDescription($value): self
    {
        if (mb_strlen($value) > 50) {
            throw new LengthException('The description value must not exceed 50 characters');
        }

        return $this->setParameter('description', $value);
    }

    /**
     * @return array
     * @throws InvalidRequestException
     */
    public function getData(): array
    {
        // Required properties
        $this->validate(
            'key',
            'amount',
            'paymentPhone',
        );

        return [
            'chave'   => $this->getKey(),
            'valor'      => (float)$this->getAmount(),
            'id' => $this->getId(),
            'alias'    => $this->getPaymentPhone(),
            'descricao'  => $this->getDescription(),
            'contacto'      => $this->getClientPhone(),
            'email'      => $this->getClientEmail(),
            'failOver'  => $this->getFailOver()
        ];
    }

    /**
     * @param  mixed  $data
     * @return MBWayResponse
     */
    public function sendData($data): MBWayResponse
    {

        $headers = [
            'Content-Type' => self::MEDIA_TYPE,
        ];

        $response = $this->httpClient->request(
            Request::METHOD_POST,
            $this->buildURL($this->getTestMode() ? self::SANDBOX_BASE_URL : self::PRODUCTION_BASE_URL, self::ENDPOINT),
            $headers,
            json_encode($data),
        );

        return new MBWayResponse($this, json_decode($response->getBody()->getContents(), true));
    }
}
