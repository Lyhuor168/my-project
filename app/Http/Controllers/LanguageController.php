<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LanguageController extends Controller
{
    public function switch(Request $request, $locale)
    {
        // Only allow supported locales
        if (in_array($locale, ['en', 'km'])) {
            session(['locale' => $locale]);
        }

        return redirect()->back();
    }
}
