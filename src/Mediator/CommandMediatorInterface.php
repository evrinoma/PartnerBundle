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
use Evrinoma\PartnerBundle\Exception\PartnerCannotBeCreatedException;
use Evrinoma\PartnerBundle\Exception\PartnerCannotBeRemovedException;
use Evrinoma\PartnerBundle\Exception\PartnerCannotBeSavedException;
use Evrinoma\PartnerBundle\Model\Partner\PartnerInterface;

interface CommandMediatorInterface
{
    /**
     * @param PartnerApiDtoInterface $dto
     * @param PartnerInterface       $entity
     *
     * @return PartnerInterface
     *
     * @throws PartnerCannotBeSavedException
     */
    public function onUpdate(PartnerApiDtoInterface $dto, PartnerInterface $entity): PartnerInterface;

    /**
     * @param PartnerApiDtoInterface $dto
     * @param PartnerInterface       $entity
     *
     * @throws PartnerCannotBeRemovedException
     */
    public function onDelete(PartnerApiDtoInterface $dto, PartnerInterface $entity): void;

    /**
     * @param PartnerApiDtoInterface $dto
     * @param PartnerInterface       $entity
     *
     * @return PartnerInterface
     *
     * @throws PartnerCannotBeSavedException
     * @throws PartnerCannotBeCreatedException
     */
    public function onCreate(PartnerApiDtoInterface $dto, PartnerInterface $entity): PartnerInterface;
}
