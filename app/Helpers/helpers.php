<?php

use App\Models\Translation;

if (!function_exists('env_asset')) {
    function env_asset($path)
    {       
        return (env('HTTPS', false) ? secure_asset($path) : asset($path));
    }
}

if (!function_exists('___')) {
    function ___($key, $locale = null)
    {
        $locale = $locale ?? app()->getLocale(); // Get the current locale
        $translation = Translation::where('key', $key)->where('locale', $locale)->first();

        return $translation->value ?? $key; // Return key if no translation found
    }
}

