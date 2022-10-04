<?php

namespace Mnemesong\ComposerEditorTestUnit;

use Mnemesong\ComposerEditor\ComposerEditor;
use PHPUnit\Framework\TestCase;

class ComposerEditorTest extends TestCase
{
    public function testConstruct(): void
    {
        $cje = new ComposerEditor(__DIR__);
        $ds = DIRECTORY_SEPARATOR;
        $checkPathParts = explode($ds, __DIR__);
        array_pop($checkPathParts);
        $this->assertEquals(implode($ds, $checkPathParts), $cje->getComposerJsonDirPath());
        $this->assertEquals(implode($ds, $checkPathParts) . $ds . 'composer.json', $cje->getComposerJsonFilePath());
    }

    public function testGetContentAsObj(): void
    {
        $cje = new ComposerEditor(__DIR__);
        $composerObj = $cje->getComposerJsonAsObj();
        $this->assertEquals("mnemesong/composer-editor", $composerObj->name);
    }

    public function testGetContentAsStr(): void
    {
        $cje = new ComposerEditor(__DIR__);
        $composerStr = $cje->getComposerJsonAsStr();
        $this->assertNotEmpty($composerStr);
    }

    public function testWrite(): void
    {
        $cje = new ComposerEditor(__DIR__);
        $composerObj = $cje->getComposerJsonAsObj();
        $this->assertEquals(false, isset($composerObj->aboba));
        $composerObj->aboba = '111';
        $cje->saveContent($composerObj);
        $composerObj = $cje->getComposerJsonAsObj();
        $this->assertEquals('111', $composerObj->aboba);
        unset($composerObj->aboba);
        $cje->saveContent($composerObj);
    }
}