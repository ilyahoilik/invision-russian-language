<?php

const ROOT = __DIR__ . '/../../';

dataset('translations', function () {
    if (! file_exists(ROOT . 'tests/Words.txt')) {
        throw new \OutOfRangeException;
    }

    $file = fopen(ROOT . 'tests/Words.txt', 'r');

    while (($line = fgets($file)) !== false) {
        yield json_decode($line, true);
    }

    fclose($file);
});