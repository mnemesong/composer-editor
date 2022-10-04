<?php

namespace Mnemesong\ComposerEditor;

use Webmozart\Assert\Assert;

class ComposerEditor
{
    protected string $composerJsonPath = '';
    protected string $composerJsonDir = '';

    public function __construct(string $path)
    {
        $ds = DIRECTORY_SEPARATOR;
        $pathStruct = explode($ds, $path);
        while(count($pathStruct) > 0)
        {
            if(file_exists(implode($ds, $pathStruct) . $ds . 'composer.json'))
            {
                $this->composerJsonPath = implode($ds, $pathStruct) . $ds . 'composer.json';
                $this->composerJsonDir = implode($ds, $pathStruct);
                break;
            }
            array_pop($pathStruct);
        }
        Assert::notEmpty($this->composerJsonPath);
        Assert::notEmpty($this->composerJsonDir);
    }

    /**
     * @return string
     */
    public function getComposerJsonFilePath(): string
    {
        return $this->composerJsonPath;
    }

    /**
     * @return string
     */
    public function getComposerJsonDirPath(): string
    {
        return $this->composerJsonDir;
    }

}