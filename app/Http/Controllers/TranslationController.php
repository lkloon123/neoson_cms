<?php

namespace App\Http\Controllers;

use App\Http\Requests\Translation\UpdateRequest;
use App\Model\Language;
use App\Model\Translation;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class TranslationController extends Controller
{
    public function update(UpdateRequest $request, $id)
    {
        $validated = $request->validated();

        $translation = Translation::find($id);

        if (!$translation) {
            throw new NotFoundHttpException('translation not found');
        }

        $translation->update($validated);

        return response()->json([
            'id' => $translation->id,
            'updated_at' => $translation->updated_at->format('Y-m-d H:i:s')
        ]);
    }

    public function formattedTranslation($language)
    {
        $language = Language::whereCode($language)->with('translations')->first();

        return $language->getFormattedTranslationsGroup();
    }
}
