<?php
function getplaintextintrofromhtml($html) {

    // Remove the HTML tags
    $html = strip_tags($html);

    // Convert HTML entities to single characters
    $html = html_entity_decode($html, ENT_QUOTES, 'UTF-8');
    return $html;
}

echo getplaintextintrofromhtml("<title>aaaa</title>");
