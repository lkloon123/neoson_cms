<?php

namespace App\Http\Controllers;

use App\Http\Requests\Translation\UpdateRequest;
use App\Http\Resources\LanguageResource;
use App\Model\Language;
use Illuminate\Database\Eloquent\Builder;

class LanguageController extends Controller
{
    public function index()
    {
        return LanguageResource::collection(
            Language::withCount(['translations' => function (Builder $query) {
                $query->whereNotNull('text');
            }])->get()
        );
    }

    public function show(UpdateRequest $request, $id)
    {
        $language = Language::with('translations')->find($id);

        return response()->json(array_merge(
            (new LanguageResource($language))->resolve(),
            ['translations' => $language->getTranslationsGroups()]
        ));
    }

    public function setLocale($lang)
    {
        return tap(
            request()->wantsJson() ? response()->json() : redirect()->back(),
            function ($response) use ($lang) {
                $response->withCookie(
                    cookie()->forever('locale', $lang, null, null, null, false)
                );
            }
        );
    }
}
