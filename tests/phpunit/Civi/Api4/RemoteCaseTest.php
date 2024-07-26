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

namespace Civi\Api4;

use Civi\API\Exception\UnauthorizedException;
use Civi\RemoteCase\AbstractRemoteCaseHeadlessTestCase;
use Civi\RemoteCase\Fixtures\CaseFixture;
use Civi\RemoteCase\Fixtures\ContactFixture;

/**
 * @covers \Civi\Api4\RemoteCase
 * @covers \Civi\RemoteCase\RemoteCaseDefaultEntityProfile
 *
 * @group headless
 */
final class RemoteCaseTest extends AbstractRemoteCaseHeadlessTestCase {

  public function testDelete(): void {
    $contact = ContactFixture::addIndividual();
    $case = CaseFixture::addFixture($contact['id']);
    $result = RemoteCase::delete()
      ->setProfile('default')
      ->addWhere('id', '=', $case['id'])
      ->execute();

    static::assertCount(0, $result);
  }

  public function testGet(): void {
    $result = RemoteCase::get()
      ->setProfile('default')
      ->execute();

    static::assertCount(0, $result);

    $contact = ContactFixture::addIndividual();
    $case = CaseFixture::addFixture($contact['id']);
    $result = RemoteCase::get()
      ->setProfile('default')
      ->addSelect('*', 'CAN_delete', 'CAN_update')
      ->execute();

    static::assertCount(1, $result);
    static::assertSame($case['id'], $result->single()['id']);
    static::assertFalse($result->single()['CAN_delete']);
    static::assertFalse($result->single()['CAN_update']);

    $result = RemoteCase::get()
      ->setProfile('default')
      ->addWhere('id', '!=', $case['id'])
      ->execute();

    static::assertCount(0, $result);
  }

  public function testGetActions(): void {
    $result = RemoteCase::getActions()->execute();
    $actions = $result->indexBy('name')->getArrayCopy();
    static::assertArrayHasKey('get', $actions);
  }

  public function testGetCreateForm(): void {
    $this->expectException(UnauthorizedException::class);
    RemoteCase::getCreateForm()
      ->setProfile('default')
      ->execute();
  }

  public function testGetFields(): void {
    $result = RemoteCase::getFields()
      ->setProfile('default')
      ->addSelect('*', 'CAN_delete', 'CAN_update')
      ->execute();

    $fields = $result->indexBy('name')->getArrayCopy();
    static::assertArrayHasKey('case_type_id', $fields);
    static::assertArrayHasKey('CAN_delete', $fields);
    static::assertArrayHasKey('CAN_update', $fields);
  }

  public function testGetUpdateForm(): void {
    $contact = ContactFixture::addIndividual();
    $case = CaseFixture::addFixture($contact['id']);
    $this->expectException(UnauthorizedException::class);
    RemoteCase::getUpdateForm()
      ->setProfile('default')
      ->setId($case['id'])
      ->execute();
  }

}
