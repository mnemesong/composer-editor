<?php

namespace Mnemesong\ComposerEditor;

use Webmozart\Assert\Assert;

class ComposerEditor
{
    protected string $composerJsonFilePath = '';
    protected string $composerJsonDirPath = '';

    public function __construct(string $path)
    {
        $ds = DIRECTORY_SEPARATOR;
        $pathStruct = explode($ds, $path);
        while(count($pathStruct) > 0)
        {
            if(file_exists(implode($ds, $pathStruct) . $ds . 'composer.json'))
            {
                $this->composerJsonFilePath = implode($ds, $pathStruct) . $ds . 'composer.json';
                $this->composerJsonDirPath = implode($ds, $pathStruct);
                break;
            }
            array_pop($pathStruct);
        }
        Assert::notEmpty($this->composerJsonFilePath);
        Assert::notEmpty($this->composerJsonDirPath);
    }

    /**
     * @return string
     */
    public function getComposerJsonFilePath(): string
    {
        return $this->composerJsonFilePath;
    }

    /**
     * @return string
     */
    public function getComposerJsonDirPath(): string
    {
        return $this->composerJsonDirPath;
    }

    /**
     * @return object
     */
    public function getComposerJsonContent(): object
    {
        $content = file_get_contents($this->composerJsonFilePath);
        return json_decode($content);
    }

}