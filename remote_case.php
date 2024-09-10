<?php
declare(strict_types = 1);

// phpcs:disable PSR1.Files.SideEffects
require_once 'remote_case.civix.php';
// phpcs:enable

use Civi\RemoteCase\Api4\Permissions;
use CRM_RemoteCase_ExtensionUtil as E;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Implements hook_civicrm_config().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_config/
 */
function remote_case_civicrm_config(\CRM_Core_Config $config): void {
  _remote_case_civix_civicrm_config($config);
}

/**
 * Implements hook_civicrm_container().
 */
function remote_case_civicrm_container(ContainerBuilder $container): void {
  if (function_exists('_remote_case_test_civicrm_container')) {
    _remote_case_test_civicrm_container($container);
  }
}

/**
 * Implements hook_civicrm_permission().
 *
 * @phpstan-param array<string, string|array{string, string}> $permissions
 */
function remote_case_civicrm_permission(array &$permissions): void {
  $permissions[Permissions::ACCESS_REMOTE_CASE] = [
    'label' => E::ts('CiviRemote: remote access to Case'),
    'description' => E::ts('Access remote API of the Case entity'),
  ];
}

/**
 * Implements hook_civicrm_install().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_install
 */
function remote_case_civicrm_install(): void {
  _remote_case_civix_civicrm_install();
}

/**
 * Implements hook_civicrm_enable().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_enable
 */
function remote_case_civicrm_enable(): void {
  _remote_case_civix_civicrm_enable();
}
