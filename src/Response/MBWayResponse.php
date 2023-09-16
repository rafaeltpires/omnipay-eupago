<?php

declare(strict_types=1);

namespace Omnipay\EuPago\Response;

use DateTimeImmutable;
use Omnipay\Common\Message\AbstractResponse;

final class MBWayResponse extends AbstractResponse
{

    /**
     * The amount being charged.
     *
     * @return ?string
     */
    public function getAmount(): ?string
    {
        return $this->data['valor'];
    }

    /**
     * Payment gateway response reference.
     *
     * @return ?int
     */
    public function getReference(): ?int
    {
        return $this->data['referencia'];
    }

    /**
     * Payment gateway response message.
     *
     * @return ?string
     */
    public function getMessage(): ?string
    {
        return $this->data['resposta'];
    }

    /**
     * Is the response successful?
     *
     * @return boolean
     */
    public function isSuccessful(): bool
    {
        return $this->data['sucesso'];
    }

}
