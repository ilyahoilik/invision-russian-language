<?php

const ROOT = __DIR__ . '/../';

$words = [];

foreach (new DirectoryIterator(ROOT . 'src/defaults') as $file) {
    if ($file->getExtension() === 'xml') {
        parseXmlFile($words, ROOT . 'src/defaults/' . $file->getFilename(), true);
    }
}

foreach (new DirectoryIterator(ROOT . 'src') as $file) {
    if ($file->getExtension() === 'xml') {
        parseXmlFile($words, ROOT . 'src/' . $file->getFilename());
    }
}

function parseXmlFile(array &$words, string $filepath, bool $is_default = false)
{
    $xml = new XMLReader;
    $xml->open($filepath);

    $xml->read();
    $xml->read();

    while ($xml->read()) {
        $xml->read();

        while ($xml->read() and $xml->name == 'word') {
            $word_key = $xml->getAttribute('key');
            $word_js = (int) $xml->getAttribute('js');

            $words[$word_key][$is_default ? 'default' : 'custom'] ??= [
                'word_key' => $word_key,
                'word_default' => $is_default ? $xml->readString() : null,
                'word_custom' => $is_default ? null : $xml->readString(),
                'word_js' => $word_js,
            ];

            $xml->next();
        }
    }

    $xml->close();
}

if (is_writable(ROOT . 'tests')) {
    if (file_exists(ROOT . 'tests/Words.txt')) {
        unlink(ROOT . 'tests/Words.txt');
    }

    foreach ($words as $word) {
        file_put_contents(ROOT . 'tests/Words.txt', json_encode($word) . "\n", FILE_APPEND);
    }
} else {
    throw new \RuntimeException;
}
