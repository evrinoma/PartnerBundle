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

namespace Evrinoma\PartnerBundle\Dto\Preserve;

use Evrinoma\DtoCommon\ValueObject\Mutable\ActiveInterface;
use Evrinoma\DtoCommon\ValueObject\Mutable\IdInterface;
use Evrinoma\DtoCommon\ValueObject\Mutable\LogoInterface;
use Evrinoma\DtoCommon\ValueObject\Mutable\NameInterface;
use Evrinoma\DtoCommon\ValueObject\Mutable\PositionInterface;
use Evrinoma\DtoCommon\ValueObject\Mutable\TitleInterface;
use Evrinoma\DtoCommon\ValueObject\Mutable\UrlInterface;
use Evrinoma\FcrBundle\DtoCommon\ValueObject\Mutable\FcrsApiDtoInterface;

interface PartnerApiDtoInterface extends IdInterface, ActiveInterface, NameInterface, UrlInterface, LogoInterface, PositionInterface, TitleInterface, FcrsApiDtoInterface
{
}
