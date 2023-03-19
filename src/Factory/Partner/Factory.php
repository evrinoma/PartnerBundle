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

namespace Evrinoma\PartnerBundle\Factory\Partner;

use Evrinoma\PartnerBundle\Dto\PartnerApiDtoInterface;
use Evrinoma\PartnerBundle\Entity\Partner\BasePartner;
use Evrinoma\PartnerBundle\Model\Partner\PartnerInterface;

class Factory implements FactoryInterface
{
    private static string $entityClass = BasePartner::class;

    public function __construct(string $entityClass)
    {
        self::$entityClass = $entityClass;
    }

    /**
     * @param PartnerApiDtoInterface $dto
     *
     * @return PartnerInterface
     */
    public function create(PartnerApiDtoInterface $dto): PartnerInterface
    {
        /* @var BasePartner $partner */
        return new self::$entityClass();
    }
}
