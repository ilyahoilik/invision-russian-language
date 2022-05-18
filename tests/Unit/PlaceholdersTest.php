<?php

it('contains identical number of %s', function (array $default = [], array $custom = []) {
    $word_default = $default['word_default'] ?? null;
    $word_custom = $custom['word_custom'] ?? null;

    $default_count = preg_match_all("/(%s|%\d+\$s)/", $word_default ?: '');
    $custom_count = preg_match_all("/(%s|%\d+\$s)/", $word_custom ?: '');

    expect($default_count)->toEqual($custom_count);
})->with('translations');

it('contains identical number of %d', function (array $default = [], array $custom = []) {
    $word_default = $default['word_default'] ?? null;
    $word_custom = $custom['word_custom'] ?? null;

    $default_count = preg_match_all("/(%d|%\d+\$d)/", $word_default ?: '');
    $custom_count = preg_match_all("/(%d|%\d+\$d)/", $word_custom ?: '');

    expect($default_count)->toEqual($custom_count);
})->with('translations');