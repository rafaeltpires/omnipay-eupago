<?php

declare(strict_types=1);

namespace Omnipay\EuPago\Request;

use DomainException;
use LengthException;
use Omnipay\Common\Exception\InvalidRequestException;
use Omnipay\EuPago\Response\CardResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * @link https://helpdesk.EuPago.com/pt-PT/support/solutions/articles/79000123125-api-cart%C3%B5es-de-cr%C3%A9dito
 */
final class CardRequest extends AbstractRequest
{
    private const SANDBOX_BASE_URL = 'https://sandbox.eupago.pt';
    private const PRODUCTION_BASE_URL = 'https://clientes.eupago.pt';
    private const ENDPOINT = 'api/v1.02/creditcard/create';
    private const MEDIA_TYPE = 'application/json';
    private const LANGUAGES  = [
        'EN',
        'PT',
        'FR',
        'ES'
    ];

    /**
     * @param  int  $value
     * @return self
     */
    public function setNotify(int $value): self
    {
        return $this->setParameter('notify', $value);
    }

    /**
     * @return ?int
     */
    public function getNotify(): ?int
    {
        return $this->getParameter('notify');
    }


    /**
     * @param  string  $value
     * @return self
     */
    public function setReference(string $value): self
    {
        if (mb_strlen($value) > 15) {
            throw new LengthException('The reference value must not exceed 15 characters');
        }

        return $this->setParameter('reference', $value);
    }

    /**
     * @return ?string
     */
    public function getSuccessUrl(): ?string
    {
        return $this->getParameter('successUrl');
    }

    /**
     * @param  string  $value
     * @return self
     */
    public function setSuccessUrl(string $value): self
    {
        if (filter_var($value, FILTER_VALIDATE_URL) === false) {
            throw new DomainException('Invalid success URL');
        }

        return $this->setParameter('successUrl', $value);
    }

    /**
     * @return ?string
     */
    public function getErrorUrl(): ?string
    {
        return $this->getParameter('errorUrl');
    }

    /**
     * @param  string  $value
     * @return self
     */
    public function setErrorUrl(string $value): self
    {
        if (filter_var($value, FILTER_VALIDATE_URL) === false) {
            throw new DomainException('Invalid error URL');
        }

        return $this->setParameter('errorUrl', $value);
    }

    /**
     * @param  string  $value
     * @return self
     */
    public function setCancelUrl($value): self
    {
        if (filter_var($value, FILTER_VALIDATE_URL) === false) {
            throw new DomainException('Invalid cancel URL');
        }

        return $this->setParameter('cancelUrl', $value);
    }

    /**
     * @return ?string
     */
    public function getLanguage(): ?string
    {
        return $this->getParameter('language');
    }

    /**
     * @param  string  $value
     * @return self
     */
    public function setLanguage(string $value): self
    {
        if (! in_array($value, self::LANGUAGES, true)) {
            throw new DomainException(sprintf('The language value must be one of: %s', implode(', ', self::LANGUAGES)));
        }

        return $this->setParameter('language', $value);
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
                  'currency',
                  'amount',
                  'successUrl',
                  'errorUrl',
                  'cancelUrl',
                  'notify',
                  'language',
                  'clientEmail',
        );

         return [
             "payment" => [
                 "amount" => [
                     "currency" => $this->getCurrency(),
                     "value" => $this->getAmount(),
                 ],
                 "lang" => $this->getLanguage(),
                 "successUrl" => $this->getSuccessUrl(),
                 "failUrl" => $this->getErrorUrl(),
                 "backUrl" => $this->getCancelUrl(),
                 "identifier" => $this->getId(),
             ],
             "customer" => [
                 "notify" => $this->getNotify(),
                 "email" => $this->getClientEmail(),
             ]
         ];


    }

    /**
     * @param  mixed  $data
     * @return CardResponse
     */
    public function sendData($data): CardResponse
    {
        $headers = [
            'Authorization' => 'ApiKey ' . $this->getKey(),
            'content-Type' => self::MEDIA_TYPE,
            'accept' => self::MEDIA_TYPE
        ];

        $response = $this->httpClient->request(
            Request::METHOD_POST,
            $this->buildURL($this->getTestMode() ? self::SANDBOX_BASE_URL : self::PRODUCTION_BASE_URL, self::ENDPOINT),
            $headers,
            json_encode($data),
        );

        return new CardResponse($this, json_decode($response->getBody()->getContents(), true));
    }
}
