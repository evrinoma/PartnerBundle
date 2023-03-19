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

use Evrinoma\PartnerBundle\DependencyInjection\EvrinomaPartnerExtension;
use Evrinoma\PartnerBundle\Model\Partner\PartnerInterface;
use Evrinoma\UtilsBundle\DependencyInjection\Compiler\AbstractMapEntity;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class MapEntityPass extends AbstractMapEntity implements CompilerPassInterface
{
    /**
     * {@inheritDoc}
     */
    public function process(ContainerBuilder $container)
    {
        if ('orm' === $container->getParameter('evrinoma.partner.storage')) {
            $this->setContainer($container);

            $driver = $container->findDefinition('doctrine.orm.default_metadata_driver');
            $referenceAnnotationReader = new Reference('annotations.reader');

            $this->cleanMetadata($driver, [EvrinomaPartnerExtension::ENTITY]);

            $entityPartner = $container->getParameter('evrinoma.partner.entity');
            if (str_contains($entityPartner, EvrinomaPartnerExtension::ENTITY)) {
                $this->loadMetadata($driver, $referenceAnnotationReader, '%s/Model/Partner', '%s/Entity/Partner');
            }
            $this->addResolveTargetEntity([$entityPartner => [PartnerInterface::class => []]], false);
        }
    }
}
