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
use Evrinoma\PartnerBundle\Repository\Partner\PartnerQueryRepositoryInterface;

final class QueryManager implements QueryManagerInterface
{
    private PartnerQueryRepositoryInterface $repository;

    public function __construct(PartnerQueryRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param PartnerApiDtoInterface $dto
     *
     * @return array
     *
     * @throws PartnerNotFoundException
     */
    public function criteria(PartnerApiDtoInterface $dto): array
    {
        try {
            $partner = $this->repository->findByCriteria($dto);
        } catch (PartnerNotFoundException $e) {
            throw $e;
        }

        return $partner;
    }

    /**
     * @param PartnerApiDtoInterface $dto
     *
     * @return PartnerInterface
     *
     * @throws PartnerProxyException
     */
    public function proxy(PartnerApiDtoInterface $dto): PartnerInterface
    {
        try {
            if ($dto->hasId()) {
                $partner = $this->repository->proxy($dto->idToString());
            } else {
                throw new PartnerProxyException('Id value is not set while trying get proxy object');
            }
        } catch (PartnerProxyException $e) {
            throw $e;
        }

        return $partner;
    }

    /**
     * @param PartnerApiDtoInterface $dto
     *
     * @return PartnerInterface
     *
     * @throws PartnerNotFoundException
     */
    public function get(PartnerApiDtoInterface $dto): PartnerInterface
    {
        try {
            $partner = $this->repository->find($dto->idToString());
        } catch (PartnerNotFoundException $e) {
            throw $e;
        }

        return $partner;
    }
}
