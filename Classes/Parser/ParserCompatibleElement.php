<?php
/**
 * stefanwimmer128/html-builder - Classes/Parser/ParserCompatibleElement.php
 * @author Stefan Wimmer <info@stefanwimmer128.eu>
 * @license ISC
 * @copyright Copyright (c) 2020, Stefan Wimmer
 */

namespace Stefanwimmer128\HtmlBuilder\Parser;

/**
 * Interface ParserCompatibleElement
 * @package Stefanwimmer128\HtmlBuilder\Parser
 */
interface ParserCompatibleElement {
    /**
     * Add attributes to element
     * @param array $attributes
     */
    public function addAttributes(array $attributes): void;
    
    /**
     * Add classes to element
     * @param array $classes
     */
    public function addClasses(array $classes): void;
    
    /**
     * Set id of element
     * @param string $id
     */
    public function setId(string $id): void;
    
    /**
     * Set children of element
     * @param array $children
     */
    public function setChildren(array $children): void;
    
    /**
     * Sets whether the tag self-closes 
     * @param bool $isSelfclosing
     */
    public function setSelfclosing(bool $isSelfclosing): void;
}
