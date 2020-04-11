<?php


namespace App\Service;


use Illuminate\Support\Str;
use Illuminate\Translation\Translator;

class TranslatorService extends Translator
{
    protected function makeReplacements($line, array $replace)
    {
        if (empty($replace)) {
            return $line;
        }

        $replace = $this->sortReplacements($replace);

        foreach ($replace as $key => $value) {
            $line = str_replace(
                ['{' . $key . '}', '{' . Str::upper($key) . '}', '{' . Str::ucfirst($key) . '}'],
                [$value, Str::upper($value), Str::ucfirst($value)],
                $line
            );
        }

        return $line;
    }
}
