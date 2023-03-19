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

namespace Evrinoma\PartnerBundle;

use Evrinoma\PartnerBundle\DependencyInjection\Compiler\Constraint\Property\PartnerPass;
use Evrinoma\PartnerBundle\DependencyInjection\Compiler\DecoratorPass;
use Evrinoma\PartnerBundle\DependencyInjection\Compiler\MapEntityPass;
use Evrinoma\PartnerBundle\DependencyInjection\Compiler\ServicePass;
use Evrinoma\PartnerBundle\DependencyInjection\EvrinomaPartnerExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class EvrinomaPartnerBundle extends Bundle
{
    public const BUNDLE = 'partner';

    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        $container
            ->addCompilerPass(new MapEntityPass($this->getNamespace(), $this->getPath()))
            ->addCompilerPass(new DecoratorPass())
            ->addCompilerPass(new ServicePass())
            ->addCompilerPass(new PartnerPass())
        ;
    }

    public function getContainerExtension()
    {
        if (null === $this->extension) {
            $this->extension = new EvrinomaPartnerExtension();
        }

        return $this->extension;
    }
}
