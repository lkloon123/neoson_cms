<?php

namespace App\Observers;

use Illuminate\Support\Str;

class ObserverForHooks
{
    public function retrieved($model)
    {
        \HookManager::dispatch('model.' . Str::snake(class_basename($model)) . '.retrieved', $model);
    }

    public function creating($model)
    {
        \HookManager::dispatch('model.' . Str::snake(class_basename($model)) . '.creating', $model);
    }

    public function created($model)
    {
        \HookManager::dispatch('model.' . Str::snake(class_basename($model)) . '.created', $model);
    }

    public function updating($model)
    {
        \HookManager::dispatch('model.' . Str::snake(class_basename($model)) . '.updating', $model);
    }

    public function updated($model)
    {
        \HookManager::dispatch('model.' . Str::snake(class_basename($model)) . '.updated', $model);
    }

    public function saving($model)
    {
        \HookManager::dispatch('model.' . Str::snake(class_basename($model)) . '.saving', $model);
    }

    public function saved($model)
    {
        \HookManager::dispatch('model.' . Str::snake(class_basename($model)) . '.saved', $model);
    }

    public function deleting($model)
    {
        \HookManager::dispatch('model.' . Str::snake(class_basename($model)) . '.deleting', $model);
    }

    public function deleted($model)
    {
        \HookManager::dispatch('model.' . Str::snake(class_basename($model)) . '.deleted', $model);
    }

    public function restoring($model)
    {
        \HookManager::dispatch('model.' . Str::snake(class_basename($model)) . '.restoring', $model);
    }

    public function restored($model)
    {
        \HookManager::dispatch('model.' . Str::snake(class_basename($model)) . '.restored', $model);
    }
}
