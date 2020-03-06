<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static HookActions PermissionFilter()
 */
final class HookActions extends Enum
{
    const PermissionFilter = 'permission.filter';

    const PluginInstalled = 'plugin.installed';
    const PluginUninstalling = 'plugin.uninstalling';
    const PluginUninstalled = 'plugin.uninstalled';
}
