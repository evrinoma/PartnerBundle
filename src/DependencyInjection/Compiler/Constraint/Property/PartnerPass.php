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

namespace Evrinoma\PartnerBundle\DependencyInjection\Compiler\Constraint\Property;

use Evrinoma\PartnerBundle\Validator\PartnerValidator;
use Evrinoma\UtilsBundle\DependencyInjection\Compiler\AbstractConstraint;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;

class PartnerPass extends AbstractConstraint implements CompilerPassInterface
{
    public const PARTNER_CONSTRAINT = 'evrinoma.partner.constraint.property';

    protected static string $alias = self::PARTNER_CONSTRAINT;
    protected static string $class = PartnerValidator::class;
    protected static string $methodCall = 'addPropertyConstraint';
}
