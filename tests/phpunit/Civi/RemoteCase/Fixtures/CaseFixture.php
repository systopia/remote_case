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

namespace Civi\RemoteCase\Fixtures;

use Civi\Api4\CiviCase;

final class CaseFixture {

  /**
   * @phpstan-param array<string, scalar|null> $values
   *
   * @phpstan-return array{id: int}&array<string, scalar|null>
   *
   * @throws \CRM_Core_Exception
   */
  public static function addFixture(int $contactId, array $values = []): array {
    // @phpstan-ignore-next-line
    return CiviCase::create(FALSE)->setValues([
      'case_type_id' => 1,
      'contact_id' => $contactId,
      'creator_id' => \CRM_Core_BAO_Domain::getDomain()->contact_id,
    ] + $values)->execute()->single();
  }

}
