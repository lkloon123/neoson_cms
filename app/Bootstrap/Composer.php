<?php
/**
 * Created by PhpStorm.
 * User: Neoson Lam
 * Date: 5/9/2019
 * Time: 5:25 PM.
 */

namespace App\Bootstrap;


class Composer extends \Illuminate\Support\Composer
{
    public function updateAndLock()
    {
        $command = array_merge($this->findComposer(), ['update'], ['--lock']);

        $process = $this->getProcess($command);

        $process->run();
    }
}
