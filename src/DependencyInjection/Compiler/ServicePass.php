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

namespace Evrinoma\PartnerBundle\DependencyInjection\Compiler;

use Evrinoma\PartnerBundle\EvrinomaPartnerBundle;
use Symfony\Component\DependencyInjection\Compiler\AbstractRecursivePass;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class ServicePass extends AbstractRecursivePass
{
    /**
     * {@inheritDoc}
     */
    public function process(ContainerBuilder $container)
    {
        $servicePreValidator = $container->hasParameter('evrinoma.'.EvrinomaPartnerBundle::BUNDLE.'.services.pre.validator');
        if ($servicePreValidator) {
            $servicePreValidator = $container->getParameter('evrinoma.'.EvrinomaPartnerBundle::BUNDLE.'.services.pre.validator');
            $preValidator = $container->getDefinition($servicePreValidator);
            $facade = $container->getDefinition('evrinoma.'.EvrinomaPartnerBundle::BUNDLE.'.facade');
            $facade->setArgument(3, $preValidator);
        }
        $serviceHandler = $container->hasParameter('evrinoma.'.EvrinomaPartnerBundle::BUNDLE.'.services.handler');
        if ($serviceHandler) {
            $serviceHandler = $container->getParameter('evrinoma.'.EvrinomaPartnerBundle::BUNDLE.'.services.handler');
            $handler = $container->getDefinition($serviceHandler);
            $facade = $container->getDefinition('evrinoma.'.EvrinomaPartnerBundle::BUNDLE.'.facade');
            $facade->setArgument(4, $handler);
        }
        $serviceFileSystem = $container->hasParameter('evrinoma.'.EvrinomaPartnerBundle::BUNDLE.'.services.system.file_system');
        if ($serviceFileSystem) {
            $serviceFileSystem = $container->getParameter('evrinoma.'.EvrinomaPartnerBundle::BUNDLE.'.services.system.file_system');
            $fileSystem = $container->getDefinition($serviceFileSystem);
            $commandMediator = $container->getDefinition('evrinoma.'.EvrinomaPartnerBundle::BUNDLE.'.command.mediator');
            $commandMediator->setArgument(0, $fileSystem);
        }
    }
}
