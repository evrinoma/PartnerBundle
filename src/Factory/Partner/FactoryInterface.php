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

namespace Evrinoma\PartnerBundle\Factory\Partner;

use Evrinoma\PartnerBundle\Dto\PartnerApiDtoInterface;
use Evrinoma\PartnerBundle\Model\Partner\PartnerInterface;

interface FactoryInterface
{
    /**
     * @param PartnerApiDtoInterface $dto
     *
     * @return PartnerInterface
     */
    public function create(PartnerApiDtoInterface $dto): PartnerInterface;
}
