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
use Evrinoma\PartnerBundle\Exception\PartnerCannotBeRemovedException;
use Evrinoma\PartnerBundle\Exception\PartnerInvalidException;
use Evrinoma\PartnerBundle\Exception\PartnerNotFoundException;
use Evrinoma\PartnerBundle\Model\Partner\PartnerInterface;

interface CommandManagerInterface
{
    /**
     * @param PartnerApiDtoInterface $dto
     *
     * @return PartnerInterface
     *
     * @throws PartnerInvalidException
     */
    public function post(PartnerApiDtoInterface $dto): PartnerInterface;

    /**
     * @param PartnerApiDtoInterface $dto
     *
     * @return PartnerInterface
     *
     * @throws PartnerInvalidException
     * @throws PartnerNotFoundException
     */
    public function put(PartnerApiDtoInterface $dto): PartnerInterface;

    /**
     * @param PartnerApiDtoInterface $dto
     *
     * @throws PartnerCannotBeRemovedException
     * @throws PartnerNotFoundException
     */
    public function delete(PartnerApiDtoInterface $dto): void;
}
