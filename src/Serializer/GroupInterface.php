<?php

declare(strict_types=1);

/*
 * This file is part of the package.
 *
 * (c) Nikolay Nikolaev <evrinoma@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Evrinoma\PartnerBundle\Serializer;

interface GroupInterface
{
    public const API_POST_PARTNER = 'API_POST_PARTNER';
    public const API_PUT_PARTNER = 'API_PUT_PARTNER';
    public const API_GET_PARTNER = 'API_GET_PARTNER';
    public const API_CRITERIA_PARTNER = self::API_GET_PARTNER;
    public const APP_GET_BASIC_PARTNER = 'APP_GET_BASIC_PARTNER';
}
