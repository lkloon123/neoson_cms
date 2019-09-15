<?php
/**
 * Created by PhpStorm.
 * User: Neoson Lam
 * Date: 5/2/2019
 * Time: 5:35 PM.
 */

namespace App\Hook;


class HookManager
{
    protected $hooks;

    public function __construct(Hooks $hooks)
    {
        $this->hooks = $hooks;
    }

    public function add($hook, $callback, $priority = 20)
    {
        $this->hooks->add($hook, $callback, $priority);
    }

    public function dispatch($hook, ...$args)
    {
        $this->hooks->dispatch($hook, array_values($args));
    }

    public function applyFilter($hook, ...$args)
    {
        return $this->hooks->applyFilter($hook, array_values($args));
    }

    public function getHooks($hook)
    {
        return $this->hooks->getAll($hook);
    }

    public function removeAll($hook = null)
    {
        $this->hooks->removeAll($hook);
    }
}
