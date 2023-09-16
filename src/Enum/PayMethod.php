<?php

declare(strict_types=1);

namespace Omnipay\EuPago\Enum;

use Omnipay\EuPago\Request\CardRequest;
use Omnipay\EuPago\Request\MBWayRequest;
use Omnipay\EuPago\Request\MultibancoRequest;

enum PayMethod: string
{
    case Card       = 'card';
    case MBWay      = 'mbway';
    case Multibanco = 'multibanco';

    public function defaultParameters(): array
    {
        return match ($this) {
            self::Card => [
                'key'            => '',     // Required
                'id'             => '',     // Optional
                'currency'       => '',     // Required
                'amount'         => '',     // Required
                'successUrl'     => '',     // Required
                'errorUrl'       => '',     // Required
                'cancelUrl'      => '',     // Required
                'notify'         => 1,      // Required
                'language'       => 'EN',   // Required
                'clientEmail'    => ''      // Required
            ],
            self::MBWay => [
                'key'            => '',     // Required
                'amount'         => '',     // Required
                'clientPhone'    => '',     // Optional
                'id'             => '',     // Optional
                'clientEmail'    => '',     // Optional
                'failOver'       => 1,      // Optional
                'description'    => '',     // Optional
                'paymentPhone'   => '',     // Required
            ],
            self::Multibanco => [
                'key'            => '',     // Required
                'amount'         => '',     // Required
                'id'             => '',     // Optional
                'clientEmail'    => '',     // Optional
                'clientPhone'    => '',     // Optional
                'perDup'         => 0,      // Required
                'startDate'      => '',     // Optional
                'endDate'        => '',     // Optional
                'maxAmount'      => 0.0,    // Optional
                'minAmount'      => 0.0,    // Optional
                'failOver'       => 0,      // Optional
                'extraFields'    => [],     // Optional
                'testMode'       => false   // Optional
            ],
        };
    }

    public function requestClass(): string
    {
        return match ($this) {
            self::Card       => CardRequest::class,
            self::MBWay      => MBWayRequest::class,
            self::Multibanco => MultibancoRequest::class,
        };
    }
}
