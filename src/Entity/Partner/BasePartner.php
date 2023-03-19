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

namespace Evrinoma\PartnerBundle\Entity\Partner;

use Doctrine\ORM\Mapping as ORM;
use Evrinoma\PartnerBundle\Model\Partner\AbstractPartner;

/**
 * @ORM\Table(name="e_partner")
 *
 * @ORM\Entity
 */
class BasePartner extends AbstractPartner
{
}
