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
use Evrinoma\PartnerBundle\Exception\PartnerCannotBeCreatedException;
use Evrinoma\PartnerBundle\Exception\PartnerCannotBeRemovedException;
use Evrinoma\PartnerBundle\Exception\PartnerCannotBeSavedException;
use Evrinoma\PartnerBundle\Exception\PartnerInvalidException;
use Evrinoma\PartnerBundle\Exception\PartnerNotFoundException;
use Evrinoma\PartnerBundle\Factory\Partner\FactoryInterface;
use Evrinoma\PartnerBundle\Mediator\CommandMediatorInterface;
use Evrinoma\PartnerBundle\Model\Partner\PartnerInterface;
use Evrinoma\PartnerBundle\Repository\Partner\PartnerRepositoryInterface;
use Evrinoma\UtilsBundle\Validator\ValidatorInterface;

final class CommandManager implements CommandManagerInterface
{
    private PartnerRepositoryInterface $repository;
    private ValidatorInterface            $validator;
    private FactoryInterface           $factory;
    private CommandMediatorInterface      $mediator;

    /**
     * @param ValidatorInterface         $validator
     * @param PartnerRepositoryInterface $repository
     * @param FactoryInterface           $factory
     * @param CommandMediatorInterface   $mediator
     */
    public function __construct(ValidatorInterface $validator, PartnerRepositoryInterface $repository, FactoryInterface $factory, CommandMediatorInterface $mediator)
    {
        $this->validator = $validator;
        $this->repository = $repository;
        $this->factory = $factory;
        $this->mediator = $mediator;
    }

    /**
     * @param PartnerApiDtoInterface $dto
     *
     * @return PartnerInterface
     *
     * @throws PartnerInvalidException
     * @throws PartnerCannotBeCreatedException
     * @throws PartnerCannotBeSavedException
     */
    public function post(PartnerApiDtoInterface $dto): PartnerInterface
    {
        $partner = $this->factory->create($dto);

        $this->mediator->onCreate($dto, $partner);

        $errors = $this->validator->validate($partner);

        if (\count($errors) > 0) {
            $errorsString = (string) $errors;

            throw new PartnerInvalidException($errorsString);
        }

        $this->repository->save($partner);

        return $partner;
    }

    /**
     * @param PartnerApiDtoInterface $dto
     *
     * @return PartnerInterface
     *
     * @throws PartnerInvalidException
     * @throws PartnerNotFoundException
     * @throws PartnerCannotBeSavedException
     */
    public function put(PartnerApiDtoInterface $dto): PartnerInterface
    {
        try {
            $partner = $this->repository->find($dto->idToString());
        } catch (PartnerNotFoundException $e) {
            throw $e;
        }

        $this->mediator->onUpdate($dto, $partner);

        $errors = $this->validator->validate($partner);

        if (\count($errors) > 0) {
            $errorsString = (string) $errors;

            throw new PartnerInvalidException($errorsString);
        }

        $this->repository->save($partner);

        return $partner;
    }

    /**
     * @param PartnerApiDtoInterface $dto
     *
     * @throws PartnerCannotBeRemovedException
     * @throws PartnerNotFoundException
     */
    public function delete(PartnerApiDtoInterface $dto): void
    {
        try {
            $partner = $this->repository->find($dto->idToString());
        } catch (PartnerNotFoundException $e) {
            throw $e;
        }
        $this->mediator->onDelete($dto, $partner);
        try {
            $this->repository->remove($partner);
        } catch (PartnerCannotBeRemovedException $e) {
            throw $e;
        }
    }
}
