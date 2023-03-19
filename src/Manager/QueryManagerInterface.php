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

namespace Evrinoma\PartnerBundle\Manager;

use Evrinoma\PartnerBundle\Dto\PartnerApiDtoInterface;
use Evrinoma\PartnerBundle\Exception\PartnerNotFoundException;
use Evrinoma\PartnerBundle\Exception\PartnerProxyException;
use Evrinoma\PartnerBundle\Model\Partner\PartnerInterface;

interface QueryManagerInterface
{
    /**
     * @param PartnerApiDtoInterface $dto
     *
     * @return array
     *
     * @throws PartnerNotFoundException
     */
    public function criteria(PartnerApiDtoInterface $dto): array;

    /**
     * @param PartnerApiDtoInterface $dto
     *
     * @return PartnerInterface
     *
     * @throws PartnerNotFoundException
     */
    public function get(PartnerApiDtoInterface $dto): PartnerInterface;

    /**
     * @param PartnerApiDtoInterface $dto
     *
     * @return PartnerInterface
     *
     * @throws PartnerProxyException
     */
    public function proxy(PartnerApiDtoInterface $dto): PartnerInterface;
}
