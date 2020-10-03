<?php
/**
 * stefanwimmer128/html-builder - Classes/Parser/ParserException.php
 * @author Stefan Wimmer <info@stefanwimmer128.eu>
 * @license ISC
 * @copyright Copyright (c) 2020, Stefan Wimmer
 */

namespace Stefanwimmer128\HtmlBuilder\Parser;

use RuntimeException;
use Throwable;

/**
 * Class ParserException
 * @package Stefanwimmer128\HtmlBuilder\Parser
 */
class ParserException extends RuntimeException {
    /**
     * ParserException constructor.
     * @param string $input
     * @param Throwable|null $previous
     */
    public function __construct($input = "", Throwable $previous = null) {
        parent::__construct(sprintf($this->getMessageTemplate(), $input), 0, $previous);
    }
    
    /**
     * Get message template
     * @return string
     */
    public function getMessageTemplate(): string {
        return 'Could not parse: `%s`';
    }
}
