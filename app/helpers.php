<?php

if (!function_exists('image_url')) {
    function image_url($path)
    {
        if (!$path) return null;

        // cek apakah URL eksternal (http/https)
        if (filter_var($path, FILTER_VALIDATE_URL)) {
            return $path;
        }

        // jika lokal → ambil dari storage
        return asset('storage/' . $path);
    }
}
