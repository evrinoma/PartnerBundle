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

use Evrinoma\DtoBundle\Dto\DtoInterface;
use Evrinoma\PartnerBundle\Dto\PartnerApiDtoInterface;
use Evrinoma\PartnerBundle\Model\Partner\PartnerInterface;
use Evrinoma\PartnerBundle\System\FileSystemInterface;
use Evrinoma\UtilsBundle\Mediator\AbstractCommandMediator;

class CommandMediator extends AbstractCommandMediator implements CommandMediatorInterface
{
    private FileSystemInterface $fileSystem;

    public function __construct(FileSystemInterface $fileSystem)
    {
        $this->fileSystem = $fileSystem;
    }

    public function onUpdate(DtoInterface $dto, $entity): PartnerInterface
    {
        /* @var $dto PartnerApiDtoInterface */
        $file = $this->fileSystem->save($dto->getLogo());

        $entity
            ->setTitle($dto->getTitle())
            ->setName($dto->getName())
            ->setUrl($dto->getUrl())
            ->setLogo($file->getPathname())
            ->setPosition($dto->getPosition())
            ->setUpdatedAt(new \DateTimeImmutable())
            ->setActive($dto->getActive());

        return $entity;
    }

    public function onDelete(DtoInterface $dto, $entity): void
    {
        $entity
            ->setUpdatedAt(new \DateTimeImmutable())
            ->setActiveToDelete();
    }

    public function onCreate(DtoInterface $dto, $entity): PartnerInterface
    {
        /* @var $dto PartnerApiDtoInterface */
        $file = $this->fileSystem->save($dto->getLogo());
        $entity
            ->setTitle($dto->getTitle())
            ->setName($dto->getName())
            ->setUrl($dto->getUrl())
            ->setLogo($file->getPathname())
            ->setPosition($dto->getPosition())
            ->setCreatedAt(new \DateTimeImmutable())
            ->setActiveToActive();

        return $entity;
    }
}
