<?php
/**
 * stefanwimmer128/html-builder - Classes/Parser/Emmet/EmmetParserException.php
 * @author Stefan Wimmer <info@stefanwimmer128.eu>
 * @license ISC
 * @copyright Copyright (c) 2020, Stefan Wimmer
 */

namespace Stefanwimmer128\HtmlBuilder\Parser\Emmet;

use Stefanwimmer128\HtmlBuilder\Parser\ParserException;

/**
 * Class EmmetParserException
 * @package Stefanwimmer128\HtmlBuilder\Parser\Emmet
 */
class EmmetParserException extends ParserException {
    /**
     * 
     * @return string
     */
    public function getMessageTemplate(): string {
        return 'Could not parse emmet: `%s`';
    }
}
