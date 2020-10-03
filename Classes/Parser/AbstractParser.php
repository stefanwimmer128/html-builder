<?php
/**
 * stefanwimmer128/html-builder - Classes/Parser/AbstractParser.php
 * @author Stefan Wimmer <info@stefanwimmer128.eu>
 * @license ISC
 * @copyright Copyright (c) 2020, Stefan Wimmer
 */

namespace Stefanwimmer128\HtmlBuilder\Parser;

use Stefanwimmer128\HtmlBuilder\HtmlElement;
use Stefanwimmer128\HtmlBuilder\Parser\Emmet\EmmetParser;
use Throwable;

/**
 * Class AbstractParser
 * @package Stefanwimmer128\HtmlBuilder\Parser
 */
abstract class AbstractParser {
    public static string $DEFAULT_PARSER = EmmetParser::class;
    
    /**
     * Parse input
     * @param string $input
     * @param string|null $parser
     * @return AbstractParser
     */
    public static function parse(string $input, ?string $parser = null): AbstractParser {
        $parser ??= self::$DEFAULT_PARSER;
        try {
            return new $parser($input);
        } catch (Throwable $e) {
            throw new ParserException($input, $e);
        }
    }
    
    /**
     * Get parsed tag
     * @return string
     */
    abstract public function getTag(): string;
    
    /**
     * Get parsed attributes
     * @return array
     */
    abstract public function getAttributes(): array;
    
    /**
     * Get parsed classes
     * @return array
     */
    abstract public function getClasses(): array;
    
    /**
     * Get parsed id
     * @return string|null
     */
    abstract public function getId(): ?string;
    
    /**
     * Get parsed text
     * @return string|null
     */
    abstract public function getText(): ?string;
    
    /**
     * Get parsed child
     * @return AbstractParser|null
     */
    abstract public function getChild(): ?AbstractParser;
    
    /**
     * Get parsed self-closing flag
     * @return bool|null
     */
    abstract public function isSelfclosing(): ?bool;
    
    /**
     * Create HtmlElement from parsed data
     * @param mixed ...$args
     * @return HtmlElement
     */
    public function toElement(...$args): HtmlElement {
        $element = HtmlElement::create($this->getTag(), ...$args);
        
        if ($element instanceof ParserCompatibleElement) {
            $this->applyTo($element);
        }
        
        return $element;
    }
    
    /**
     * Apply parsed data to $element
     * @param ParserCompatibleElement $element
     */
    public function applyTo(ParserCompatibleElement $element): void {
        $element->addAttributes($this->getAttributes());
        
        $element->addClasses($this->getClasses());
        
        if (($id = $this->getId()) !== null) {
            $element->setId($id);
        }
        
        if (($text = $this->getText()) !== null) {
            $element->setChildren([$text]);
        }
        
        if (($child = $this->getChild()) !== null) {
            $element->setChildren([$child->toElement()]);
        }
        
        if (($isSelfclosing = $this->isSelfclosing()) !== null) {
            $element->setSelfclosing($isSelfclosing);
        }
    }
}
