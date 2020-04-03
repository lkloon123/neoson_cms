<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static HookActions PermissionFilter()
 * @method static HookActions FormSubmitValidating()
 * @method static HookActions FormSubmitValidated()
 * @method static HookActions PluginEnabling()
 * @method static HookActions PluginEnabled()
 * @method static HookActions PluginDisabling()
 * @method static HookActions PluginDisabled()
 * @method static HookActions PluginInstalling()
 * @method static HookActions PluginInstalled()
 * @method static HookActions PluginUninstalling()
 * @method static HookActions PluginUninstalled()
 */
final class HookActions extends Enum
{
    const PermissionFilter = 'permission.filter';

    const FormSubmitValidating = 'form.submit.validating';
    const FormSubmitValidated = 'form.submit.validated';

    const PluginEnabling = 'plugin.enabling';
    const PluginEnabled = 'plugin.enabled';
    const PluginDisabling = 'plugin.disabling';
    const PluginDisabled = 'plugin.disabled';
    const PluginInstalling = 'plugin.installing';
    const PluginInstalled = 'plugin.installed';
    const PluginUninstalling = 'plugin.uninstalling';
    const PluginUninstalled = 'plugin.uninstalled';
}
