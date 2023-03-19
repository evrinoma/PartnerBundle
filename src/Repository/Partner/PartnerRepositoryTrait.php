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
use Doctrine\ORM\ORMInvalidArgumentException;
use Evrinoma\PartnerBundle\Dto\PartnerApiDtoInterface;
use Evrinoma\PartnerBundle\Exception\PartnerCannotBeSavedException;
use Evrinoma\PartnerBundle\Exception\PartnerNotFoundException;
use Evrinoma\PartnerBundle\Exception\PartnerProxyException;
use Evrinoma\PartnerBundle\Mediator\QueryMediatorInterface;
use Evrinoma\PartnerBundle\Model\Partner\PartnerInterface;

trait PartnerRepositoryTrait
{
    private QueryMediatorInterface $mediator;

    /**
     * @param PartnerInterface $partner
     *
     * @return bool
     *
     * @throws PartnerCannotBeSavedException
     * @throws ORMException
     */
    public function save(PartnerInterface $partner): bool
    {
        try {
            $this->persistWrapped($partner);
        } catch (ORMInvalidArgumentException $e) {
            throw new PartnerCannotBeSavedException($e->getMessage());
        }

        return true;
    }

    /**
     * @param PartnerInterface $partner
     *
     * @return bool
     */
    public function remove(PartnerInterface $partner): bool
    {
        return true;
    }

    /**
     * @param PartnerApiDtoInterface $dto
     *
     * @return array
     *
     * @throws PartnerNotFoundException
     */
    public function findByCriteria(PartnerApiDtoInterface $dto): array
    {
        $builder = $this->createQueryBuilderWrapped($this->mediator->alias());

        $this->mediator->createQuery($dto, $builder);

        $partners = $this->mediator->getResult($dto, $builder);

        if (0 === \count($partners)) {
            throw new PartnerNotFoundException('Cannot find partner by findByCriteria');
        }

        return $partners;
    }

    /**
     * @param      $id
     * @param null $lockMode
     * @param null $lockVersion
     *
     * @return mixed
     *
     * @throws PartnerNotFoundException
     */
    public function find($id, $lockMode = null, $lockVersion = null): PartnerInterface
    {
        /** @var PartnerInterface $partner */
        $partner = $this->findWrapped($id);

        if (null === $partner) {
            throw new PartnerNotFoundException("Cannot find partner with id $id");
        }

        return $partner;
    }

    /**
     * @param string $id
     *
     * @return PartnerInterface
     *
     * @throws PartnerProxyException
     * @throws ORMException
     */
    public function proxy(string $id): PartnerInterface
    {
        $partner = $this->referenceWrapped($id);

        if (!$this->containsWrapped($partner)) {
            throw new PartnerProxyException("Proxy doesn't exist with $id");
        }

        return $partner;
    }
}
