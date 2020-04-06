<?php


namespace App\Service;


use App\Model\Language;
use Illuminate\Translation\FileLoader;

class TranslationLoaderService extends FileLoader
{
    public function load($locale, $group, $namespace = null)
    {
        $fileTranslations = parent::load($locale, $group, $namespace);

        if ($namespace !== null && $namespace !== '*') {
            return $fileTranslations;
        }

        return array_replace_recursive($fileTranslations, $this->getTranslations($locale, $group));
    }

    protected function getTranslations($locale, $group)
    {
        /** @var Language $language */
        $language = Language::whereCode($locale)->with(['translations' => function ($query) use ($group) {
            $query->where('group', $group);
        }])->first();

        if (!$language) {
            return [];
        }

        $formatted = $language->getFormattedTranslationsGroup();

        return $formatted[$group] ?? [];
    }
}
