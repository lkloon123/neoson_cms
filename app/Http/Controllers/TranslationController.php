<?php

namespace App\Http\Controllers;

use App\Http\Requests\Translation\CreateRequest;
use App\Http\Requests\Translation\UpdateRequest;
use App\Model\Language;
use App\Model\Translation;
use Symfony\Component\HttpKernel\Exception\ConflictHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class TranslationController extends Controller
{
    public function store(CreateRequest $request)
    {

        $isKeyExist = Translation::whereGroup($request->input('group'))
            ->whereKey($request->input('key'))
            ->exists();

        if ($isKeyExist) {
            throw new ConflictHttpException(
                '[' . $request->input('group') . '.' . $request->input('key') . '] already exist'
            );
        }

        $languages = Language::all(['id']);

        foreach ($languages as $language) {
            $language->translations()->create([
                'group' => $request->input('group'),
                'key' => $request->input('key'),
                'text' => $request->input('text'),
            ]);
        }

        return response()->json([], 201);
    }

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
