<?php
/*
 * Copyright (C) 2024 SYSTOPIA GmbH
 *
 *  This program is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU Affero General Public License as published by
 *  the Free Software Foundation in version 3.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU Affero General Public License for more details.
 *
 *  You should have received a copy of the GNU Affero General Public License
 *  along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

declare(strict_types = 1);

namespace Civi\RemoteCase;

use Civi\RemoteCase\Api4\Permissions;
use Civi\Test;
use Civi\Test\CiviEnvBuilder;
use Civi\Test\HeadlessInterface;
use Civi\Test\TransactionalInterface;
use PHPUnit\Framework\TestCase;

// phpcs:disable Generic.Files.LineLength.TooLong
abstract class AbstractRemoteCaseHeadlessTestCase extends TestCase implements HeadlessInterface, TransactionalInterface {
// phpcs:enable
  public function setUpHeadless(): CiviEnvBuilder {
    return Test::headless()
      ->install('civi_case')
      ->install('de.systopia.identitytracker')
      ->install('de.systopia.remotetools')
      ->installMe(__DIR__)
      ->apply();
  }

  protected function setUp(): void {
    parent::setUp();
    // @phpstan-ignore-next-line
    \CRM_Core_Config::singleton()->userFrameworkBaseURL = 'http://localhost/';
    // @phpstan-ignore-next-line
    \CRM_Core_Config::singleton()->cleanURL = 1;
    $this->setUserPermissions([Permissions::ACCESS_REMOTE_CASE]);
  }

  /**
   * @phpstan-param array<string>|null $permissions
   */
  protected function setUserPermissions(?array $permissions): void {
    $userPermissions = \CRM_Core_Config::singleton()->userPermissionClass;
    // @phpstan-ignore-next-line
    $userPermissions->permissions = $permissions;
  }

}
