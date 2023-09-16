<?php

declare(strict_types=1);

namespace Omnipay\EuPago;

use Omnipay\Common\Http\ClientInterface;
use Omnipay\EuPago\Enum\PayMethod;
use Symfony\Component\HttpFoundation\Request as SymfonyRequest;

final class MultibancoGateway extends CommonGateway
{
    /**
     * @param  ?ClientInterface  $httpClient
     * @param  ?SymfonyRequest  $httpRequest
     */
    public function __construct(ClientInterface $httpClient = null, SymfonyRequest $httpRequest = null)
    {
        parent::__construct(PayMethod::Multibanco, $httpClient, $httpRequest);
    }

    /**
     * The gateway display name.
     *
     * @return string
     */
    public function getName(): string
    {
        return 'EuPago Multibanco Gateway';
    }
}
