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

use Evrinoma\DtoBundle\Dto\DtoInterface;
use Evrinoma\PartnerBundle\Dto\PartnerApiDtoInterface;
use Evrinoma\PartnerBundle\Exception\PartnerInvalidException;
use Evrinoma\UtilsBundle\PreValidator\AbstractPreValidator;

class DtoPreValidator extends AbstractPreValidator implements DtoPreValidatorInterface
{
    public function onPost(DtoInterface $dto): void
    {
        $this
            ->checkUrl($dto)
            ->checkLogo($dto)
            ->checkName($dto)
            ->checkPosition($dto);
    }

    public function onPut(DtoInterface $dto): void
    {
        $this
            ->checkId($dto)
            ->checkLogo($dto)
            ->checkUrl($dto)
            ->checkName($dto)
            ->checkActive($dto)
            ->checkPosition($dto);
    }

    public function onDelete(DtoInterface $dto): void
    {
        $this->checkId($dto);
    }

    private function checkPosition(DtoInterface $dto): self
    {
        /** @var PartnerApiDtoInterface $dto */
        if (!$dto->hasPosition()) {
            throw new PartnerInvalidException('The Dto has\'t position');
        }

        return $this;
    }

    private function checkLogo(DtoInterface $dto): self
    {
        /** @var PartnerApiDtoInterface $dto */
        if (!$dto->hasLogo()) {
            throw new PartnerInvalidException('The Dto has\'t Logo file');
        }

        return $this;
    }

    private function checkUrl(DtoInterface $dto): self
    {
        /** @var PartnerApiDtoInterface $dto */
        if (!$dto->hasUrl()) {
            throw new PartnerInvalidException('The Dto has\'t url');
        }

        return $this;
    }

    private function checkName(DtoInterface $dto): self
    {
        /** @var PartnerApiDtoInterface $dto */
        if (!$dto->hasName()) {
            throw new PartnerInvalidException('The Dto has\'t name');
        }

        return $this;
    }

    private function checkActive(DtoInterface $dto): self
    {
        /** @var PartnerApiDtoInterface $dto */
        if (!$dto->hasActive()) {
            throw new PartnerInvalidException('The Dto has\'t active');
        }

        return $this;
    }

    private function checkId(DtoInterface $dto): self
    {
        /** @var PartnerApiDtoInterface $dto */
        if (!$dto->hasId()) {
            throw new PartnerInvalidException('The Dto has\'t ID or class invalid');
        }

        return $this;
    }
}
