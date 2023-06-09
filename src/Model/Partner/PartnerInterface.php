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

namespace Evrinoma\PartnerBundle\Model\Partner;

use Evrinoma\UtilsBundle\Entity\ActiveInterface;
use Evrinoma\UtilsBundle\Entity\CreateUpdateAtInterface;
use Evrinoma\UtilsBundle\Entity\IdInterface;
use Evrinoma\UtilsBundle\Entity\LogoInterface;
use Evrinoma\UtilsBundle\Entity\NameInterface;
use Evrinoma\UtilsBundle\Entity\PositionInterface;
use Evrinoma\UtilsBundle\Entity\TitleInterface;
use Evrinoma\UtilsBundle\Entity\UrlInterface;

interface PartnerInterface extends ActiveInterface, CreateUpdateAtInterface, IdInterface, UrlInterface, NameInterface, PositionInterface, LogoInterface, TitleInterface
{
}
