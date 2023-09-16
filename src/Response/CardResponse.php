<?php

declare(strict_types=1);

namespace Omnipay\EuPago\Response;

use Omnipay\Common\Message\AbstractResponse;

final class CardResponse extends AbstractResponse
{

    /**
     * The Gateway's transaction ID.
     *
     * @return ?string
     */
    public function getTransactionId(): ?string
    {
        if (! empty($this->data['transactionID'])) {
            return $this->data['transactionID'];
        }

        return null;
    }

    /**
     * The Gateway's reference.
     *
     * @return ?string
     */
    public function getReference(): ?string
    {
        if (! empty($this->data['reference'])) {
            return $this->data['reference'];
        }

        return null;
    }

    /**
     * Is the response successful?
     *
     * @return boolean
     */
    public function isSuccessful(): bool
    {
        return isset($this->data['transactionStatus']) && $this->data['transactionStatus'] == 'Success';
    }

    /**
     * Payment gateway redirect URL.
     *
     * @return ?string
     */
    public function getRedirectUrl(): ?string
    {
        return $this->data['redirectUrl'];
    }

    /**
     * Is the response a redirect?
     *
     * @return boolean
     */
    public function isRedirect(): bool
    {
        return true;
    }
}
