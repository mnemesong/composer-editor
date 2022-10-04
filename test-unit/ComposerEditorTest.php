<?php

namespace Mnemesong\ComposerEditorTestUnit;

use Mnemesong\ComposerEditor\ComposerEditor;
use PHPUnit\Framework\TestCase;

class ComposerEditorTest extends TestCase
{
    public function testConstruct()
    {
        $cje = new ComposerEditor(__DIR__);
        $ds = DIRECTORY_SEPARATOR;
        $checkPathParts = explode($ds, __DIR__);
        array_pop($checkPathParts);
        $this->assertEquals(implode($ds, $checkPathParts), $cje->getComposerJsonDirPath());
        $this->assertEquals(implode($ds, $checkPathParts) . $ds . 'composer.json', $cje->getComposerJsonFilePath());
    }
}