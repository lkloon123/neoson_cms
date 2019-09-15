<?php
/**
 * Created by PhpStorm.
 * User: Neoson Lam
 * Date: 5/2/2019
 * Time: 5:36 PM.
 */

namespace App\Hook;


use Illuminate\Support\Arr;

class Hooks
{
    protected $listeners;

    public function __construct()
    {
        $this->listeners = collect();
    }

    public function add($hook, $callback, $priority = 20)
    {
        $this->listeners->push([
            'hook' => $hook,
            'callback' => $callback,
            'priority' => $priority
        ]);

        return $this;
    }

    public function dispatch($hook, $args)
    {
        if ($this->getSortedListener()->isNotEmpty()) {
            $this->getSortedListener()
                ->where('hook', $hook)
                ->each(function ($listener) use ($args) {
                    if (\is_callable($listener['callback'])) {
                        return \call_user_func_array($listener['callback'], $args);
                    }
                });
        }
    }

    public function applyFilter($hook, $args)
    {
        $rtnValue = $args[0] ?? '';

        if ($this->getSortedListener()->isNotEmpty()) {
            $this->getSortedListener()
                ->where('hook', $hook)
                ->each(function ($listener) use ($args, &$rtnValue) {
                    if (\is_callable($listener['callback'])) {
                        $args[0] = $rtnValue;
                        $rtn = \call_user_func_array($listener['callback'], $args);

                        if ($rtn !== null) {
                            if ($rtn === false) {
                                return false;
                            }

                            $rtnValue = $rtn;
                        }
                    }
                });
        }

        return $rtnValue;
    }

    public function getAll($hook)
    {
        return $this->getSortedListener()->where('hook', $hook)->map(function ($h) {
            return Arr::except($h, 'hook');
        });
    }

    public function removeAll($hook = null)
    {
        if ($hook) {
            if ($this->listeners) {
                $this->listeners->where('hook', $hook)->each(function ($listener, $key) {
                    $this->listeners->forget($key);
                });
            }
        } else {
            $this->listeners = collect();
        }
    }

    protected function getSortedListener()
    {
        return $this->listeners->sortBy('priority');
    }
}
