<?php

declare(strict_types=1);

namespace Omnipay\EuPago\Request;

use DomainException;
use LengthException;
use Omnipay\Common\Message\AbstractRequest as BaseAbstractRequest;

abstract class AbstractRequest extends BaseAbstractRequest
{
    protected $zeroAmountAllowed = false;

    /**
     * @return ?string
     */
    public function getKey(): ?string
    {
        return $this->getParameter('key');
    }

    /**
     * @param  string  $value
     * @return self
     */
    public function setKey(string $value): self
    {
        return $this->setParameter('key', $value);
    }

    /**
     * @return ?string
     */
    public function getReference(): ?string
    {
        return $this->getParameter('reference');
    }

    /**
     * @return ?string
     */
    public function getClientPhone(): ?string
    {
        return $this->getParameter('clientPhone');
    }

    /**
     * @param  string  $value
     * @return self
     */
    public function setClientPhone(string $value): self
    {
        if (mb_strlen($value) > 200) {
            throw new LengthException('The client phone value must not exceed 200 characters');
        }

        return $this->setParameter('clientPhone', $value);
    }

    /**
     * @return ?string
     */
    public function getClientEmail(): ?string
    {
        return $this->getParameter('clientEmail');
    }

    /**
     * @param  string  $value
     * @return self
     */
    public function setClientEmail(string $value): self
    {
        if (mb_strlen($value) > 200) {
            throw new LengthException('The client email value must not exceed 200 characters');
        }

        if (filter_var($value, FILTER_VALIDATE_EMAIL) === false) {
            throw new DomainException('Invalid client email');
        }

        return $this->setParameter('clientEmail', $value);
    }

    /**
     * @param  string  $value
     * @return self
     */
    public function setId(string $value): self
    {
        if (mb_strlen($value) > 200) {
            throw new LengthException('The identifier value must not exceed 200 characters');
        }

        return $this->setParameter('id', $value);
    }

    /**
     * @return ?string
     */
    public function getId(): ?string
    {
        return $this->getParameter('id');
    }

    /**
     * @param  int  $value
     * @return self
     */
    public function setFailOver(int $value): self
    {
        return $this->setParameter('failOver', $value);
    }

    /**
     * @return ?int
     */
    public function getFailOver(): ?int
    {
        return $this->getParameter('failOver');
    }


    /**
     * @param  string  $baseURL
     * @param  string  ...$path
     * @return string
     */
    protected function buildURL(string $baseURL, mixed ...$path): string
    {
        return sprintf('%s/%s', $baseURL, implode('/', $path));
    }
}
