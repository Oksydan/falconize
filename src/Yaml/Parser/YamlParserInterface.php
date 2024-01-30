<?php

namespace Oksydan\Falconize\Yaml\Parser;

use Oksydan\Falconize\Exception\YamlFileException;
use Oksydan\Falconize\Yaml\DTO\ParsedResult;

interface YamlParserInterface
{
    /**
     * @param \SplFileInfo $file
     * @return ParsedResult
     * @throws YamlFileException
     */
    public function parse(\SplFileInfo $file): ParsedResult;
}
