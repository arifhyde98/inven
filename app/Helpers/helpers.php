<?php

if (!function_exists('rupiah')) {
    function rupiah($angka)
    {
        return number_format((float) $angka, 0, ',', '.');
    }
}

if (!function_exists('rupiah2')) {
    function rupiah2($angka)
    {
        return number_format((float) $angka, 0, ',', '.');
    }
}

if (!function_exists('bad_word_filter')) {
    function bad_word_filter()
    {
        return [
            'anjing', 'kontol', 'memek', 'memec', 'jembud', 'tolol',
            'babi', 'goblog', 'nigga', 'nigger', 'nibbas', 'hideng',
            'hideung', 'hiddeng', 'isis'
        ];
    }
}
