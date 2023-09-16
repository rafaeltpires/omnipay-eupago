<?php

declare(strict_types=1);

namespace Omnipay\EuPago\Request;

use Omnipay\Common\Exception\InvalidRequestException;
use Omnipay\EuPago\Response\MultibancoResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * @link https://eupago.readme.io/reference/multibanco
 */
final class MultibancoRequest extends AbstractRequest
{
    private const SANDBOX_BASE_URL            = 'https://sandbox.eupago.pt';
    private const PRODUCTION_BASE_URL            = 'https://clientes.eupago.pt';
    private const ENDPOINT = 'clientes/rest_api/multibanco/create';
    // private const ENDPOINT_PRODUCTION = 'api/multibanco/reference/init';
    private const MEDIA_TYPE          = 'application/json';

    /**
     * @param  int  $value
     * @return self
     */
    public function setPerDup(int $value): self
    {
        return $this->setParameter('perDup', $value);
    }

    /**
     * @return ?int
     */
    public function getPerDup(): ?int
    {
        return $this->getParameter('perDup');
    }

    /**
     * @param  string  $value
     * @return self
     */
    public function setStartDate(string $value): self
    {
        return $this->setParameter('startDate', $value);
    }

    /**
     * @return ?string
     */
    public function getStartDate(): ?string
    {
        return $this->getParameter('startDate');
    }

    /**
     * @param  string  $value
     * @return self
     */
    public function setEndDate(string $value): self
    {
        return $this->setParameter('endDate', $value);
    }

    /**
     * @return ?string
     */
    public function getEndDate(): ?string
    {
        return $this->getParameter('endDate');
    }

    /**
     * @param  float  $value
     * @return self
     */
    public function setMaxAmount(float $value): self
    {
        return $this->setParameter('maxAmount', $value);
    }

    /**
     * @return ?float
     */
    public function getMaxAmount(): ?float
    {
        return $this->getParameter('maxAmount');
    }

    /**
     * @param  float  $value
     * @return self
     */
    public function setMinAmount(float $value): self
    {
        return $this->setParameter('minAmount', $value);
    }

    /**
     * @return ?float
     */
    public function getMinAmount(): ?float
    {
        return $this->getParameter('minAmount');
    }

    /**
     * @param  array  $value
     * @return self
     */
    public function setExtraFields(array $value): self
    {
        return $this->setParameter('extraFields', $value);
    }

    /**
     * @return ?array
     */
    public function getExtraFields(): ?array
    {
        return $this->getParameter('extraFields');
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
            'perDup'
        );

        return [
            'chave'          => $this->getKey(),
            'valor'         => $this->getAmount(),
            'id'   => $this->getId(),
            'email'    => $this->getClientEmail(),
            'contacto'    => $this->getClientPhone(),
            'per_dup' => $this->getPerDup(),
            'data_inicio' => $this->getStartDate(),
            'data_fim' => $this->getEndDate(),
            'valor_maximo' => $this->getMaxAmount(),
            'valor_minimo' => $this->getMinAmount(),
            'failOver' => $this->getFailOver(),
            'campos_extra' => $this->getExtraFields(),
        ];
    }

    /**
     * @param  mixed  $data
     * @return MultibancoResponse
     */
    public function sendData($data): MultibancoResponse
    {
        $headers = [
            'Content-Type' => self::MEDIA_TYPE,
        ];

        $response = $this->httpClient->request(
            Request::METHOD_POST,
            $this->buildURL($this->getTestMode() ? self::SANDBOX_BASE_URL : self::PRODUCTION_BASE_URL,  self::ENDPOINT),
            $headers,
            json_encode($data),
        );

        return new MultibancoResponse($this, json_decode($response->getBody()->getContents(), true));
    }
}
