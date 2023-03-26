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

namespace Evrinoma\PartnerBundle\Fixtures;

use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Evrinoma\PartnerBundle\Dto\PartnerApiDtoInterface;
use Evrinoma\PartnerBundle\Entity\Partner\BasePartner;
use Evrinoma\TestUtilsBundle\Fixtures\AbstractFixture;

class PartnerFixtures extends AbstractFixture implements FixtureGroupInterface, OrderedFixtureInterface
{
    protected static array $data = [
        [
            PartnerApiDtoInterface::NAME => 'ite',
            PartnerApiDtoInterface::URL => 'http://ite',
            PartnerApiDtoInterface::ACTIVE => 'a',
            PartnerApiDtoInterface::POSITION => 1,
            'created_at' => '2008-10-23 10:21:50',
            PartnerApiDtoInterface::LOGO => 'PATH://TO_LOGO',
        ],
        [
            PartnerApiDtoInterface::NAME => 'kzkt',
            PartnerApiDtoInterface::URL => 'http://kzkt',
            PartnerApiDtoInterface::ACTIVE => 'a',
            PartnerApiDtoInterface::POSITION => 2,
            'created_at' => '2015-10-23 10:21:50',
            PartnerApiDtoInterface::LOGO => 'PATH://TO_LOGO',
        ],
        [
            PartnerApiDtoInterface::NAME => 'c2m',
            PartnerApiDtoInterface::URL => 'http://c2m',
            PartnerApiDtoInterface::ACTIVE => 'a',
            PartnerApiDtoInterface::POSITION => 3,
            'created_at' => '2020-10-23 10:21:50',
            PartnerApiDtoInterface::LOGO => 'PATH://TO_LOGO',
        ],
        [
            PartnerApiDtoInterface::NAME => 'kzkt2',
            PartnerApiDtoInterface::URL => 'http://kzkt2',
            PartnerApiDtoInterface::ACTIVE => 'd',
            PartnerApiDtoInterface::POSITION => 1,
            'created_at' => '2015-10-23 10:21:50',
            PartnerApiDtoInterface::LOGO => 'PATH://TO_LOGO',
            ],
        [
            PartnerApiDtoInterface::NAME => 'nvr',
            PartnerApiDtoInterface::URL => 'http://nvr',
            PartnerApiDtoInterface::ACTIVE => 'b',
            PartnerApiDtoInterface::POSITION => 2,
            'created_at' => '2010-10-23 10:21:50',
            PartnerApiDtoInterface::LOGO => 'PATH://TO_LOGO',
        ],
        [
            PartnerApiDtoInterface::NAME => 'nvr2',
            PartnerApiDtoInterface::URL => 'http://nvr2',
            PartnerApiDtoInterface::ACTIVE => 'd',
            PartnerApiDtoInterface::POSITION => 3,
            'created_at' => '2010-10-23 10:21:50',
            PartnerApiDtoInterface::LOGO => 'PATH://TO_LOGO',
            ],
        [
            PartnerApiDtoInterface::NAME => 'nvr3',
            PartnerApiDtoInterface::URL => 'http://nvr3',
            PartnerApiDtoInterface::ACTIVE => 'd',
            PartnerApiDtoInterface::POSITION => 1,
            'created_at' => '2011-10-23 10:21:50',
            PartnerApiDtoInterface::LOGO => 'PATH://TO_LOGO',
        ],
    ];

    protected static string $class = BasePartner::class;

    /**
     * @param ObjectManager $manager
     *
     * @return $this
     *
     * @throws \Exception
     */
    protected function create(ObjectManager $manager): self
    {
        $short = static::getReferenceName();
        $i = 0;

        foreach ($this->getData() as $record) {
            $entity = $this->getEntity();
            $entity
                ->setLogo($record[PartnerApiDtoInterface::LOGO])
                ->setName($record[PartnerApiDtoInterface::NAME])
                ->setUrl($record[PartnerApiDtoInterface::URL])
                ->setPosition($record[PartnerApiDtoInterface::POSITION])
                ->setCreatedAt(new \DateTimeImmutable($record['created_at']))
                ->setActive($record[PartnerApiDtoInterface::ACTIVE]);

            $this->expandEntity($entity, $record);

            $this->addReference($short.$i, $entity);
            $manager->persist($entity);
            ++$i;
        }

        return $this;
    }

    public static function getGroups(): array
    {
        return [
            FixtureInterface::PARTNER_FIXTURES,
        ];
    }

    public function getOrder()
    {
        return 0;
    }
}
