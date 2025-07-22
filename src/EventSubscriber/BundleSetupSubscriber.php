<?php

declare(strict_types=1);

/**
 * OpenDXP
 *
 * This source file is licensed under the GNU General Public License version 3 (GPLv3).
 *
 * Full copyright and license information is available in
 * LICENSE.md which is distributed with this source code.
 *
 * @copyright  Copyright (c) Pimcore GmbH (https://pimcore.com)
 * @copyright  Modification Copyright (c) OpenDXP (https://www.opendxp.ch)
 * @license    https://www.gnu.org/licenses/gpl-3.0.html  GNU General Public License version 3 (GPLv3)
 */

namespace App\EventSubscriber;

use OpenDxp\Bundle\AdminBundle\OpenDxpAdminBundle;
use OpenDxp\Bundle\InstallBundle\Event\BundleSetupEvent;
use OpenDxp\Bundle\InstallBundle\Event\InstallEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class BundleSetupSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            InstallEvents::EVENT_BUNDLE_SETUP => [
                ['bundleSetup'],
            ],
        ];
    }

    public function bundleSetup(BundleSetupEvent $event): void
    {
        // add required OpenDxpAdminBundle
        if (class_exists(OpenDxpAdminBundle::class)) {
            $event->addRequiredBundle(
                'OpenDxpAdminBundle',
                OpenDxpAdminBundle::class,
                true
            );
        }
    }
}
