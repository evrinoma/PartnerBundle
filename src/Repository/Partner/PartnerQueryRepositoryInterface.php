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

use Doctrine\ORM\Exception\ORMException;
use Evrinoma\PartnerBundle\Dto\PartnerApiDtoInterface;
use Evrinoma\PartnerBundle\Exception\PartnerNotFoundException;
use Evrinoma\PartnerBundle\Exception\PartnerProxyException;
use Evrinoma\PartnerBundle\Model\Partner\PartnerInterface;

interface PartnerQueryRepositoryInterface
{
    /**
     * @param PartnerApiDtoInterface $dto
     *
     * @return array
     *
     * @throws PartnerNotFoundException
     */
    public function findByCriteria(PartnerApiDtoInterface $dto): array;

    /**
     * @param string $id
     * @param null   $lockMode
     * @param null   $lockVersion
     *
     * @return PartnerInterface
     *
     * @throws PartnerNotFoundException
     */
    public function find(string $id, $lockMode = null, $lockVersion = null): PartnerInterface;

    /**
     * @param string $id
     *
     * @return PartnerInterface
     *
     * @throws PartnerProxyException
     * @throws ORMException
     */
    public function proxy(string $id): PartnerInterface;
}
