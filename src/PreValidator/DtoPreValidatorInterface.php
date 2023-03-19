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

namespace Evrinoma\PartnerBundle\PreValidator;

use Evrinoma\PartnerBundle\Dto\PartnerApiDtoInterface;
use Evrinoma\PartnerBundle\Exception\PartnerInvalidException;

interface DtoPreValidatorInterface
{
    /**
     * @param PartnerApiDtoInterface $dto
     *
     * @throws PartnerInvalidException
     */
    public function onPost(PartnerApiDtoInterface $dto): void;

    /**
     * @param PartnerApiDtoInterface $dto
     *
     * @throws PartnerInvalidException
     */
    public function onPut(PartnerApiDtoInterface $dto): void;

    /**
     * @param PartnerApiDtoInterface $dto
     *
     * @throws PartnerInvalidException
     */
    public function onDelete(PartnerApiDtoInterface $dto): void;
}
