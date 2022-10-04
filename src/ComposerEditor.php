<?php
declare(strict_types=1);

namespace Mnemesong\ComposerEditor;

use Webmozart\Assert\Assert;

class ComposerEditor
{
    protected string $composerJsonFilePath = '';
    protected string $composerJsonDirPath = '';

    /**
     * @param string $path
     */
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
    public function getComposerJsonAsObj(): object
    {
        $content = file_get_contents($this->composerJsonFilePath);
        Assert::notFalse($content);
        $result = json_decode($content);
        Assert::object($result);
        return $result;
    }

    /**
     * @return string
     */
    public function getComposerJsonAsStr(): string
    {
        $result = file_get_contents($this->composerJsonFilePath);
        Assert::notFalse($result);
        return $result;
    }

    /**
     * @param object $contentObj
     * @return void
     */
    public function saveContent(object $contentObj): void
    {
        $content = json_encode($contentObj, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        Assert::notFalse($content);
        $content = str_replace(":\"", ": \"", $content);
        $content = str_replace(",", ",\n", $content);
        $content = str_replace(":{", ": {", $content);
        $content = str_replace("{", "{\n", $content);
        $content = str_replace("}", "}\n", $content);
        $content = str_replace("}\n,\n", "},\n", $content);
        $content = str_replace("\"}", "\"\n}", $content);
        $content = str_replace(":[", ": [", $content);
        $content = str_replace("[", "[\n", $content);
        $content = str_replace("]", "]\n", $content);
        $content = str_replace("]\n,\n", "],\n", $content);
        $content = str_replace("\"]", "\"\n]", $content);
        $content = $this->setTabsToJsonContent($content);
        Assert::notFalse(file_put_contents($this->composerJsonFilePath, $content));
    }

    /**
     * @param string $jsonContent
     * @return string
     */
    protected function setTabsToJsonContent(string $jsonContent): string
    {
        $lines = explode("\n", $jsonContent);
        $level = 0;
        foreach ($lines as &$line)
        {
            if(mb_strpos($line, "}") !== false) {
                $level--;
            }
            if(mb_strpos($line, "]") !== false) {
                $level--;
            }
            $line = str_repeat(" ", $level * 4) . $line;
            if(mb_strpos($line, "{") !== false) {
                $level++;
            }
            if(mb_strpos($line, "[") !== false) {
                $level++;
            }
        }
        return implode("\n", $lines);
    }

}