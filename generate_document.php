<?php

require_once('config.php');

$htmlContent = $_POST['htmlContent'] ?? '';

$dom = new DOMDocument;
libxml_use_internal_errors(true); 

$dom->loadHTML($htmlContent);

$phpWord = new \PhpOffice\PhpWord\PhpWord();

$section = $phpWord->addSection();

extractTextContent($dom, $section);

$generated_fname = generate_activation_code();
$filename = __DIR__ . "/tmp/$generated_fname.docx";
try {
    $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
    $objWriter->save($filename);

    echo json_encode(['filename' => "tmp/$generated_fname.docx"]);
} catch (\Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
function extractTextContent($node, $section)
{
    foreach ($node->childNodes as $child) {
        if ($child instanceof DOMText) {
            $section->addText($child->nodeValue);
        } elseif ($child instanceof DOMElement && $child->nodeName !== 'style') {
            extractTextContent($child, $section);
        }
    }
}

function generate_activation_code(): string
{
    return bin2hex(random_bytes(16));
}
?>