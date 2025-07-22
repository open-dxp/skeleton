<?php

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

namespace App;

use OpenDxp\Bundle\AdminBundle\OpenDxpAdminBundle;
use OpenDxp\HttpKernel\BundleCollection\BundleCollection;
use OpenDxp\Kernel as OpenDxpKernel;

class Kernel extends OpenDxpKernel
{
    /**
     * Adds bundles to register to the bundle collection. The collection is able
     * to handle priorities and environment specific bundles.
     *
     */
    public function registerBundlesToCollection(BundleCollection $collection): void
    {
        if (class_exists(OpenDxpAdminBundle::class)) {
            $collection->addBundle(new OpenDxpAdminBundle(), 60);
        }
    }
}
