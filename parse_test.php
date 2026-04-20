<?php
$html = file_get_contents('c:\laragon\www\laravel-roles\resources\views\livewire\forms\land-details.blade.php');

// Replace blade directives with empty strings or comments to avoid parsing errors
$html = preg_replace('/@if\b.*?@endif/s', '', $html);
$html = preg_replace('/@switch\b.*?@endswitch/s', '', $html);
$html = preg_replace('/@forelse\b.*?@empty.*?@endforelse/s', '', $html);
$html = preg_replace('/@error.*?@enderror/s', '', $html);

$dom = new DOMDocument();
libxml_use_internal_errors(true);
$dom->loadHTML('<?xml encoding="UTF-8">' . $html, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
$errors = libxml_get_errors();
foreach($errors as $err) {
    if ($err->level == LIBXML_ERR_FATAL) {
        echo "Fatal: " . $err->message . " at line " . $err->line . "\n";
    }
}
$count = 0;
foreach($dom->childNodes as $node) {
    if ($node->nodeType === XML_ELEMENT_NODE) {
        $count++;
        echo "Root element found: " . $node->nodeName . "\n";
    } elseif ($node->nodeType === XML_TEXT_NODE && trim($node->textContent) !== '') {
        $count++;
        echo "Root text found: " . trim($node->textContent) . "\n";
    }
}
echo "Total roots: " . $count . "\n";
