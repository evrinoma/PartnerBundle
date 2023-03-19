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

namespace Evrinoma\PartnerBundle\Mediator;

use Evrinoma\PartnerBundle\Dto\PartnerApiDtoInterface;
use Evrinoma\UtilsBundle\QueryBuilder\QueryBuilderInterface;

interface QueryMediatorInterface
{
    /**
     * @return string
     */
    public function alias(): string;

    /**
     * @param PartnerApiDtoInterface $dto
     * @param QueryBuilderInterface  $builder
     *
     * @return mixed
     */
    public function createQuery(PartnerApiDtoInterface $dto, QueryBuilderInterface $builder): void;

    /**
     * @param PartnerApiDtoInterface $dto
     * @param QueryBuilderInterface  $builder
     *
     * @return array
     */
    public function getResult(PartnerApiDtoInterface $dto, QueryBuilderInterface $builder): array;
}
