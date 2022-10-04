<?php

namespace Mnemesong\ComposerEditorTestUnit\testInner;

use Mnemesong\ComposerEditor\ComposerEditor;
use PHPUnit\Framework\TestCase;

class ComposerEditorInnerTest extends TestCase
{
    public function testConstruct(): void
    {
        $cje = new ComposerEditor(__DIR__);
        $ds = DIRECTORY_SEPARATOR;
        $checkPathParts = explode($ds, __DIR__);
        $this->assertEquals(implode($ds, $checkPathParts), $cje->getComposerJsonDirPath());
        $this->assertEquals(implode($ds, $checkPathParts) . $ds . 'composer.json', $cje->getComposerJsonFilePath());
    }


}