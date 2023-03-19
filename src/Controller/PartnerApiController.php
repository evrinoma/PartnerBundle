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

namespace Evrinoma\PartnerBundle\Controller;

use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Evrinoma\DtoBundle\Factory\FactoryDtoInterface;
use Evrinoma\PartnerBundle\Dto\PartnerApiDtoInterface;
use Evrinoma\PartnerBundle\Exception\PartnerCannotBeSavedException;
use Evrinoma\PartnerBundle\Exception\PartnerInvalidException;
use Evrinoma\PartnerBundle\Exception\PartnerNotFoundException;
use Evrinoma\PartnerBundle\Facade\Partner\FacadeInterface;
use Evrinoma\PartnerBundle\Serializer\GroupInterface;
use Evrinoma\UtilsBundle\Controller\AbstractWrappedApiController;
use Evrinoma\UtilsBundle\Controller\ApiControllerInterface;
use FOS\RestBundle\Controller\Annotations as Rest;
use JMS\Serializer\SerializerInterface;
use OpenApi\Annotations as OA;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

final class PartnerApiController extends AbstractWrappedApiController implements ApiControllerInterface
{
    private string $dtoClass;

    private ?Request $request;

    private FactoryDtoInterface $factoryDto;

    private FacadeInterface $facade;

    public function __construct(
        SerializerInterface $serializer,
        RequestStack $requestStack,
        FactoryDtoInterface $factoryDto,
        FacadeInterface $facade,
        string $dtoClass
    ) {
        parent::__construct($serializer);
        $this->request = $requestStack->getCurrentRequest();
        $this->factoryDto = $factoryDto;
        $this->dtoClass = $dtoClass;
        $this->facade = $facade;
    }

    /**
     * @Rest\Post("/api/partner/create", options={"expose": true}, name="api_partner_create")
     *
     * @OA\Post(
     *     tags={"partner"},
     *     description="the method perform create partner",
     *
     *     @OA\RequestBody(
     *
     *         @OA\MediaType(
     *             mediaType="application/json",
     *
     *             @OA\Schema(
     *                 example={
     *                     "class": "Evrinoma\PartnerBundle\Dto\PartnerApiDto",
     *                     "id": "48",
     *                     "name": "Instagram",
     *                     "url": "http://www.instagram.com/intertechelectro",
     *                     "position": "1",
     *                 },
     *                 type="object",
     *
     *                 @OA\Property(property="class", type="string", default="Evrinoma\PartnerBundle\Dto\PartnerApiDto"),
     *                 @OA\Property(property="id", type="string"),
     *                 @OA\Property(property="name", type="string"),
     *                 @OA\Property(property="url", type="string"),
     *                 @OA\Property(property="position", type="int"),
     *             )
     *         )
     *     )
     * )
     *
     * @OA\Response(response=200, description="Create partner")
     *
     * @return JsonResponse
     */
    public function postAction(): JsonResponse
    {
        /** @var PartnerApiDtoInterface $partnerApiDto */
        $partnerApiDto = $this->factoryDto->setRequest($this->request)->createDto($this->dtoClass);

        $this->setStatusCreated();

        $json = [];
        $error = [];
        $group = GroupInterface::API_POST_PARTNER;

        try {
            $this->facade->post($partnerApiDto, $group, $json);
        } catch (\Exception $e) {
            $json = [];
            $error = $this->setRestStatus($e);
        }

        return $this->setSerializeGroup($group)->JsonResponse('Create partner', $json, $error);
    }

    /**
     * @Rest\Put("/api/partner/save", options={"expose": true}, name="api_partner_save")
     *
     * @OA\Put(
     *     tags={"partner"},
     *     description="the method perform save partner for current entity",
     *
     *     @OA\RequestBody(
     *
     *         @OA\MediaType(
     *             mediaType="application/json",
     *
     *             @OA\Schema(
     *                 example={
     *                     "class": "Evrinoma\PartnerBundle\Dto\PartnerApiDto",
     *                     "active": "b",
     *                     "id": "48",
     *                     "name": "Instagram",
     *                     "url": "http://www.instagram.com/intertechelectro",
     *                     "position": "1",
     *                 },
     *                 type="object",
     *
     *                 @OA\Property(property="class", type="string", default="Evrinoma\PartnerBundle\Dto\PartnerApiDto"),
     *                 @OA\Property(property="id", type="string"),
     *                 @OA\Property(property="name", type="string"),
     *                 @OA\Property(property="url", type="string"),
     *                 @OA\Property(property="active", type="string"),
     *                 @OA\Property(property="position", type="int"),
     *             )
     *         )
     *     )
     * )
     *
     * @OA\Response(response=200, description="Save partner")
     *
     * @return JsonResponse
     */
    public function putAction(): JsonResponse
    {
        /** @var PartnerApiDtoInterface $partnerApiDto */
        $partnerApiDto = $this->factoryDto->setRequest($this->request)->createDto($this->dtoClass);

        $json = [];
        $error = [];
        $group = GroupInterface::API_PUT_PARTNER;

        try {
            $this->facade->put($partnerApiDto, $group, $json);
        } catch (\Exception $e) {
            $json = [];
            $error = $this->setRestStatus($e);
        }

        return $this->setSerializeGroup($group)->JsonResponse('Save partner', $json, $error);
    }

    /**
     * @Rest\Delete("/api/partner/delete", options={"expose": true}, name="api_partner_delete")
     *
     * @OA\Delete(
     *     tags={"partner"},
     *
     *     @OA\Parameter(
     *         description="class",
     *         in="query",
     *         name="class",
     *         required=true,
     *
     *         @OA\Schema(
     *             type="string",
     *             default="Evrinoma\PartnerBundle\Dto\PartnerApiDto",
     *             readOnly=true
     *         )
     *     ),
     *
     *     @OA\Parameter(
     *         description="id Entity",
     *         in="query",
     *         name="id",
     *         required=true,
     *
     *         @OA\Schema(
     *             type="string",
     *             default="3",
     *         )
     *     )
     * )
     *
     * @OA\Response(response=200, description="Delete partner")
     *
     * @return JsonResponse
     */
    public function deleteAction(): JsonResponse
    {
        /** @var PartnerApiDtoInterface $partnerApiDto */
        $partnerApiDto = $this->factoryDto->setRequest($this->request)->createDto($this->dtoClass);

        $this->setStatusAccepted();

        $json = [];
        $error = [];

        try {
            $this->facade->delete($partnerApiDto, '', $json);
        } catch (\Exception $e) {
            $json = [];
            $error = $this->setRestStatus($e);
        }

        return $this->JsonResponse('Delete partner', $json, $error);
    }

    /**
     * @Rest\Get("/api/partner/criteria", options={"expose": true}, name="api_partner_criteria")
     *
     * @OA\Get(
     *     tags={"partner"},
     *
     *     @OA\Parameter(
     *         description="class",
     *         in="query",
     *         name="class",
     *         required=true,
     *
     *         @OA\Schema(
     *             type="string",
     *             default="Evrinoma\PartnerBundle\Dto\PartnerApiDto",
     *             readOnly=true
     *         )
     *     ),
     *
     *     @OA\Parameter(
     *         description="id Entity",
     *         in="query",
     *         name="id",
     *
     *         @OA\Schema(
     *             type="string",
     *         )
     *     ),
     *
     *     @OA\Parameter(
     *         description="position",
     *         in="query",
     *         name="position",
     *
     *         @OA\Schema(
     *             type="string",
     *         )
     *     ),
     *
     *     @OA\Parameter(
     *         description="name",
     *         in="query",
     *         name="name",
     *
     *         @OA\Schema(
     *             type="string",
     *         )
     *     ),
     *
     *     @OA\Parameter(
     *         description="url",
     *         in="query",
     *         name="url",
     *
     *         @OA\Schema(
     *             type="string",
     *         )
     *     )
     * )
     *
     * @OA\Response(response=200, description="Return partner")
     *
     * @return JsonResponse
     */
    public function criteriaAction(): JsonResponse
    {
        /** @var PartnerApiDtoInterface $partnerApiDto */
        $partnerApiDto = $this->factoryDto->setRequest($this->request)->createDto($this->dtoClass);

        $json = [];
        $error = [];
        $group = GroupInterface::API_CRITERIA_PARTNER;

        try {
            $this->facade->criteria($partnerApiDto, $group, $json);
        } catch (\Exception $e) {
            $json = [];
            $error = $this->setRestStatus($e);
        }

        return $this->setSerializeGroup($group)->JsonResponse('Get partner', $json, $error);
    }

    /**
     * @Rest\Get("/api/partner", options={"expose": true}, name="api_partner")
     *
     * @OA\Get(
     *     tags={"partner"},
     *
     *     @OA\Parameter(
     *         description="class",
     *         in="query",
     *         name="class",
     *         required=true,
     *
     *         @OA\Schema(
     *             type="string",
     *             default="Evrinoma\PartnerBundle\Dto\PartnerApiDto",
     *             readOnly=true
     *         )
     *     ),
     *
     *     @OA\Parameter(
     *         description="id Entity",
     *         in="query",
     *         name="id",
     *         required=true,
     *
     *         @OA\Schema(
     *             type="string",
     *             default="3",
     *         )
     *     )
     * )
     *
     * @OA\Response(response=200, description="Return partner")
     *
     * @return JsonResponse
     */
    public function getAction(): JsonResponse
    {
        /** @var PartnerApiDtoInterface $partnerApiDto */
        $partnerApiDto = $this->factoryDto->setRequest($this->request)->createDto($this->dtoClass);

        $json = [];
        $error = [];
        $group = GroupInterface::API_GET_PARTNER;

        try {
            $this->facade->get($partnerApiDto, $group, $json);
        } catch (\Exception $e) {
            $json = [];
            $error = $this->setRestStatus($e);
        }

        return $this->setSerializeGroup($group)->JsonResponse('Get partner', $json, $error);
    }

    /**
     * @param \Exception $e
     *
     * @return array
     */
    public function setRestStatus(\Exception $e): array
    {
        switch (true) {
            case $e instanceof PartnerCannotBeSavedException:
                $this->setStatusNotImplemented();
                break;
            case $e instanceof UniqueConstraintViolationException:
                $this->setStatusConflict();
                break;
            case $e instanceof PartnerNotFoundException:
                $this->setStatusNotFound();
                break;
            case $e instanceof PartnerInvalidException:
                $this->setStatusUnprocessableEntity();
                break;
            default:
                $this->setStatusBadRequest();
        }

        return [$e->getMessage()];
    }
}
