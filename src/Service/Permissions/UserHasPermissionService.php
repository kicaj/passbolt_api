<?php
/**
 * Passbolt ~ Open source password manager for teams
 * Copyright (c) Passbolt SA (https://www.passbolt.com)
 *
 * Licensed under GNU Affero General Public License version 3 of the or any later version.
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Passbolt SA (https://www.passbolt.com)
 * @license       https://opensource.org/licenses/AGPL-3.0 AGPL License
 * @link          https://www.passbolt.com Passbolt(tm)
 * @since         2.14.0
 */

namespace App\Service\Permissions;

use App\Model\Entity\Permission;
use App\Model\Table\PermissionsTable;
use Cake\ORM\TableRegistry;

/**
 * This service determine if a user has a given permission on an ACO
 * @package App\Service\Permissions
 */
class UserHasPermissionService
{
    /**
     * @var PermissionsTable
     */
    private $permissionsTable;

    /**
     * @param PermissionsTable $permissionsTable PermissionsTable instance
     */
    public function __construct(PermissionsTable $permissionsTable = null)
    {
        $this->permissionsTable = $permissionsTable;
        if (is_null($this->permissionsTable)) {
            $this->permissionsTable = TableRegistry::getTableLocator()->get('Permissions');
        }
    }

    /**
     * Check if the user has at least the requested permission.
     *
     * It will check direct and inherited permissions.
     *
     * @param string $aco The target aco type. By instance a Resource or a Folder.
     * @param string $acoForeignKey The target aco id. By instance a resource or a folder id.
     * @param string $aroForeignKey The target aro id. By instance a user or a group id.
     * @param int $permissionType The minimum permission type
     * @return bool
     */
    public function check(string $aco, string $acoForeignKey, string $aroForeignKey, int $permissionType = Permission::READ)
    {
        return $this->permissionsTable->hasAccess($aco, $acoForeignKey, $aroForeignKey, $permissionType);
    }
}