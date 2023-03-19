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

namespace Evrinoma\PartnerBundle\Repository\Orm\Partner;

use Doctrine\Persistence\ManagerRegistry;
use Evrinoma\PartnerBundle\Mediator\QueryMediatorInterface;
use Evrinoma\PartnerBundle\Repository\Partner\PartnerRepositoryInterface;
use Evrinoma\PartnerBundle\Repository\Partner\PartnerRepositoryTrait;
use Evrinoma\UtilsBundle\Repository\Orm\RepositoryWrapper;
use Evrinoma\UtilsBundle\Repository\RepositoryWrapperInterface;

class PartnerRepository extends RepositoryWrapper implements PartnerRepositoryInterface, RepositoryWrapperInterface
{
    use PartnerRepositoryTrait;

    /**
     * @param ManagerRegistry        $registry
     * @param string                 $entityClass
     * @param QueryMediatorInterface $mediator
     */
    public function __construct(ManagerRegistry $registry, string $entityClass, QueryMediatorInterface $mediator)
    {
        parent::__construct($registry, $entityClass);
        $this->mediator = $mediator;
    }
}
