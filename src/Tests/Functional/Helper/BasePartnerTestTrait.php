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

namespace Evrinoma\PartnerBundle\Tests\Functional\Helper;

use Evrinoma\PartnerBundle\Dto\PartnerApiDtoInterface;
use Evrinoma\UtilsBundle\Model\Rest\PayloadModel;
use PHPUnit\Framework\Assert;

trait BasePartnerTestTrait
{
    protected function assertGet(string $id): array
    {
        $find = $this->get($id);
        $this->testResponseStatusOK();

        $this->checkResult($find);

        return $find;
    }

    protected function createPartner(): array
    {
        $query = static::getDefault();

        return $this->post($query);
    }

    protected function createConstraintBlankName(): array
    {
        $query = static::getDefault([PartnerApiDtoInterface::NAME => '']);

        return $this->post($query);
    }

    protected function createConstraintBlankUrl(): array
    {
        $query = static::getDefault([PartnerApiDtoInterface::URL => '']);

        return $this->post($query);
    }

    protected function checkResult($entity): void
    {
        Assert::assertArrayHasKey(PayloadModel::PAYLOAD, $entity);
        Assert::assertCount(1, $entity[PayloadModel::PAYLOAD]);
        $this->checkPartner($entity[PayloadModel::PAYLOAD][0]);
    }

    protected function checkPartner($entity): void
    {
        Assert::assertArrayHasKey(PartnerApiDtoInterface::ID, $entity);
        Assert::assertArrayHasKey(PartnerApiDtoInterface::NAME, $entity);
        Assert::assertArrayHasKey(PartnerApiDtoInterface::URL, $entity);
        Assert::assertArrayHasKey(PartnerApiDtoInterface::ACTIVE, $entity);
        Assert::assertArrayHasKey(PartnerApiDtoInterface::POSITION, $entity);
    }
}
