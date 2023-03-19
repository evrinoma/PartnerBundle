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

namespace Evrinoma\PartnerBundle\Tests\Functional\Action;

use Evrinoma\PartnerBundle\Dto\PartnerApiDto;
use Evrinoma\PartnerBundle\Dto\PartnerApiDtoInterface;
use Evrinoma\PartnerBundle\Tests\Functional\Helper\BasePartnerTestTrait;
use Evrinoma\PartnerBundle\Tests\Functional\ValueObject\Partner\Active;
use Evrinoma\PartnerBundle\Tests\Functional\ValueObject\Partner\Id;
use Evrinoma\PartnerBundle\Tests\Functional\ValueObject\Partner\Name;
use Evrinoma\PartnerBundle\Tests\Functional\ValueObject\Partner\Position;
use Evrinoma\PartnerBundle\Tests\Functional\ValueObject\Partner\Url;
use Evrinoma\TestUtilsBundle\Action\AbstractServiceTest;
use Evrinoma\UtilsBundle\Model\ActiveModel;
use Evrinoma\UtilsBundle\Model\Rest\PayloadModel;
use PHPUnit\Framework\Assert;

class BasePartner extends AbstractServiceTest implements BasePartnerTestInterface
{
    use BasePartnerTestTrait;

    public const API_GET = 'evrinoma/api/partner';
    public const API_CRITERIA = 'evrinoma/api/partner/criteria';
    public const API_DELETE = 'evrinoma/api/partner/delete';
    public const API_PUT = 'evrinoma/api/partner/save';
    public const API_POST = 'evrinoma/api/partner/create';

    protected static function getDtoClass(): string
    {
        return PartnerApiDto::class;
    }

    protected static function defaultData(): array
    {
        return [
            PartnerApiDtoInterface::DTO_CLASS => static::getDtoClass(),
            PartnerApiDtoInterface::ID => Id::default(),
            PartnerApiDtoInterface::NAME => Name::default(),
            PartnerApiDtoInterface::ACTIVE => Active::value(),
            PartnerApiDtoInterface::URL => Url::default(),
            PartnerApiDtoInterface::POSITION => Position::value(),
        ];
    }

    public function actionPost(): void
    {
        $this->createPartner();
        $this->testResponseStatusCreated();
    }

    public function actionCriteriaNotFound(): void
    {
        $find = $this->criteria([
            PartnerApiDtoInterface::DTO_CLASS => static::getDtoClass(),
            PartnerApiDtoInterface::ACTIVE => Active::wrong(),
        ]);
        $this->testResponseStatusNotFound();
        Assert::assertArrayHasKey(PayloadModel::PAYLOAD, $find);

        $find = $this->criteria([
            PartnerApiDtoInterface::DTO_CLASS => static::getDtoClass(),
            PartnerApiDtoInterface::ID => Id::value(),
            PartnerApiDtoInterface::ACTIVE => Active::block(),
            PartnerApiDtoInterface::NAME => Name::wrong(),
        ]);
        $this->testResponseStatusNotFound();
        Assert::assertArrayHasKey(PayloadModel::PAYLOAD, $find);
    }

    public function actionCriteria(): void
    {
        $find = $this->criteria([
            PartnerApiDtoInterface::DTO_CLASS => static::getDtoClass(),
            PartnerApiDtoInterface::ACTIVE => Active::value(),
            PartnerApiDtoInterface::ID => Id::value(),
        ]);
        $this->testResponseStatusOK();
        Assert::assertCount(1, $find[PayloadModel::PAYLOAD]);

        $find = $this->criteria([
            PartnerApiDtoInterface::DTO_CLASS => static::getDtoClass(),
            PartnerApiDtoInterface::ACTIVE => Active::delete(),
        ]);
        $this->testResponseStatusOK();
        Assert::assertCount(3, $find[PayloadModel::PAYLOAD]);

        $find = $this->criteria([
            PartnerApiDtoInterface::DTO_CLASS => static::getDtoClass(),
            PartnerApiDtoInterface::ACTIVE => Active::delete(),
            PartnerApiDtoInterface::NAME => Name::value(),
        ]);
        $this->testResponseStatusOK();
        Assert::assertCount(2, $find[PayloadModel::PAYLOAD]);
    }

    public function actionDelete(): void
    {
        $find = $this->assertGet(Id::value());

        Assert::assertEquals(ActiveModel::ACTIVE, $find[PayloadModel::PAYLOAD][0][PartnerApiDtoInterface::ACTIVE]);

        $this->delete(Id::value());
        $this->testResponseStatusAccepted();

        $delete = $this->assertGet(Id::value());

        Assert::assertEquals(ActiveModel::DELETED, $delete[PayloadModel::PAYLOAD][0][PartnerApiDtoInterface::ACTIVE]);
    }

    public function actionPut(): void
    {
        $find = $this->assertGet(Id::value());

        $updated = $this->put(static::getDefault([
            PartnerApiDtoInterface::ID => Id::value(),
            PartnerApiDtoInterface::NAME => Name::value(),
            PartnerApiDtoInterface::URL => Url::value(),
            PartnerApiDtoInterface::POSITION => Position::value(),
        ]));
        $this->testResponseStatusOK();

        Assert::assertEquals($find[PayloadModel::PAYLOAD][0][PartnerApiDtoInterface::ID], $updated[PayloadModel::PAYLOAD][0][PartnerApiDtoInterface::ID]);
        Assert::assertEquals(Name::value(), $updated[PayloadModel::PAYLOAD][0][PartnerApiDtoInterface::NAME]);
        Assert::assertEquals(Url::value(), $updated[PayloadModel::PAYLOAD][0][PartnerApiDtoInterface::URL]);
        Assert::assertEquals(Position::value(), $updated[PayloadModel::PAYLOAD][0][PartnerApiDtoInterface::POSITION]);
    }

    public function actionGet(): void
    {
        $find = $this->assertGet(Id::value());
    }

    public function actionGetNotFound(): void
    {
        $response = $this->get(Id::wrong());
        Assert::assertArrayHasKey(PayloadModel::PAYLOAD, $response);
        $this->testResponseStatusNotFound();
    }

    public function actionDeleteNotFound(): void
    {
        $response = $this->delete(Id::wrong());
        Assert::assertArrayHasKey(PayloadModel::PAYLOAD, $response);
        $this->testResponseStatusNotFound();
    }

    public function actionDeleteUnprocessable(): void
    {
        $response = $this->delete(Id::blank());
        Assert::assertArrayHasKey(PayloadModel::PAYLOAD, $response);
        $this->testResponseStatusUnprocessable();
    }

    public function actionPutNotFound(): void
    {
        $this->put(static::getDefault([
            PartnerApiDtoInterface::ID => Id::wrong(),
            PartnerApiDtoInterface::NAME => Name::wrong(),
            PartnerApiDtoInterface::URL => Url::wrong(),
            PartnerApiDtoInterface::POSITION => Position::wrong(),
        ]));
        $this->testResponseStatusNotFound();
    }

    public function actionPutUnprocessable(): void
    {
        $created = $this->createPartner();
        $this->testResponseStatusCreated();
        $this->checkResult($created);

        $query = static::getDefault([
            PartnerApiDtoInterface::ID => $created[PayloadModel::PAYLOAD][0][PartnerApiDtoInterface::ID],
            PartnerApiDtoInterface::NAME => Name::blank(),
        ]);

        $this->put($query);
        $this->testResponseStatusUnprocessable();

        $query = static::getDefault([
            PartnerApiDtoInterface::ID => $created[PayloadModel::PAYLOAD][0][PartnerApiDtoInterface::ID],
            PartnerApiDtoInterface::URL => URL::blank(),
        ]);

        $this->put($query);
        $this->testResponseStatusUnprocessable();

        $query = static::getDefault([
            PartnerApiDtoInterface::ID => $created[PayloadModel::PAYLOAD][0][PartnerApiDtoInterface::ID],
            PartnerApiDtoInterface::POSITION => Position::blank(),
        ]);

        $this->put($query);
        $this->testResponseStatusUnprocessable();
    }

    public function actionPostDuplicate(): void
    {
        $this->createPartner();
        $this->testResponseStatusCreated();
        Assert::markTestIncomplete('This test has not been implemented yet.');
    }

    public function actionPostUnprocessable(): void
    {
        $this->postWrong();
        $this->testResponseStatusUnprocessable();

        $this->createConstraintBlankName();
        $this->testResponseStatusUnprocessable();

        $this->createConstraintBlankUrl();
        $this->testResponseStatusUnprocessable();
    }
}
