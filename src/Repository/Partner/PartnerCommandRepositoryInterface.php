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

namespace Evrinoma\PartnerBundle\Repository\Partner;

use Evrinoma\PartnerBundle\Exception\PartnerCannotBeRemovedException;
use Evrinoma\PartnerBundle\Exception\PartnerCannotBeSavedException;
use Evrinoma\PartnerBundle\Model\Partner\PartnerInterface;

interface PartnerCommandRepositoryInterface
{
    /**
     * @param PartnerInterface $partner
     *
     * @return bool
     *
     * @throws PartnerCannotBeSavedException
     */
    public function save(PartnerInterface $partner): bool;

    /**
     * @param PartnerInterface $partner
     *
     * @return bool
     *
     * @throws PartnerCannotBeRemovedException
     */
    public function remove(PartnerInterface $partner): bool;
}
