<?php
/**
 * stefanwimmer128/html-builder - Classes/Components/ElementList.php
 * @author Stefan Wimmer <info@stefanwimmer128.eu>
 * @license ISC
 * @copyright Copyright (c) 2020, Stefan Wimmer
 */

namespace Stefanwimmer128\HtmlBuilder\Components;

use Stefanwimmer128\HtmlBuilder\HtmlElement;
use Stefanwimmer128\HtmlBuilder\HtmlText;
use Stefanwimmer128\HtmlBuilder\Utilities\HtmlBuilderUtility;

/**
 * Class ElementList
 * @package Stefanwimmer128\HtmlBuilder\Components
 */
class ElementList  {
    /**
     * @var HtmlElement[]
     */
    protected array $elements = [];
    
    /**
     * Create ElementList
     * @param array $elements Elements to initialize ElementList with
     */
    public function __construct(array $elements) {
        $this->add($elements);
    }
    
    /**
     * Add elements to list
     * @param mixed $elements
     */
    public function add(...$elements): void {
        foreach ($elements as $element) {
            if (is_array($element)) {
                $this->add(...$element);
            } else if ($element instanceof self) {
                $this->add(...$element->elements);
            } else if ($element instanceof HtmlElement) {
                $this->elements[] = $element;
            } else {
                $this->add(new HtmlText($element));
            }
        }
    }
    
    /**
     * array_map with key
     * @param callable $callable
     * @return array
     */
    public function map(callable $callable): array {
        return HtmlBuilderUtility::map($this->elements, $callable);
    }
    
    /**
     * Renders elements as HTML
     * @return string
     */
    public function render(): string {
        return implode('', $this->map(function (HtmlElement $child) {
            return $child->render();
        }));
    }
}
