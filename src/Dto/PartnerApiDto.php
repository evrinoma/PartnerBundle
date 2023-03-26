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

namespace Evrinoma\PartnerBundle\Dto;

use Evrinoma\DtoBundle\Dto\AbstractDto;
use Evrinoma\DtoBundle\Dto\DtoInterface;
use Evrinoma\DtoCommon\ValueObject\Mutable\ActiveTrait;
use Evrinoma\DtoCommon\ValueObject\Mutable\IdTrait;
use Evrinoma\DtoCommon\ValueObject\Mutable\LogoTrait;
use Evrinoma\DtoCommon\ValueObject\Mutable\NameTrait;
use Evrinoma\DtoCommon\ValueObject\Mutable\PositionTrait;
use Evrinoma\DtoCommon\ValueObject\Mutable\UrlTrait;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Request;

class PartnerApiDto extends AbstractDto implements PartnerApiDtoInterface
{
    use ActiveTrait;
    use IdTrait;
    use LogoTrait;
    use NameTrait;
    use PositionTrait;
    use UrlTrait;

    public function toDto(Request $request): DtoInterface
    {
        $class = $request->get(DtoInterface::DTO_CLASS);

        if ($class === $this->getClass()) {
            $active = $request->get(PartnerApiDtoInterface::ACTIVE);
            $id = $request->get(PartnerApiDtoInterface::ID);
            $name = $request->get(PartnerApiDtoInterface::NAME);
            $url = $request->get(PartnerApiDtoInterface::URL);
            $position = $request->get(PartnerApiDtoInterface::POSITION);

            $files = ($request->files->has($this->getClass())) ? $request->files->get($this->getClass()) : [];

            try {
                if (\array_key_exists(PartnerApiDtoInterface::LOGO, $files)) {
                    $logo = $files[PartnerApiDtoInterface::LOGO];
                } else {
                    $logo = $request->get(PartnerApiDtoInterface::LOGO);
                    if (null !== $logo) {
                        $logo = new File($logo);
                    }
                }
            } catch (\Exception $e) {
                $logo = null;
            }

            if ($active) {
                $this->setActive($active);
            }
            if ($id) {
                $this->setId($id);
            }
            if ($position) {
                $this->setPosition($position);
            }
            if ($name) {
                $this->setName($name);
            }
            if ($url) {
                $this->setUrl($url);
            }
            if ($logo) {
                $this->setLogo($logo);
            }
        }

        return $this;
    }
}
