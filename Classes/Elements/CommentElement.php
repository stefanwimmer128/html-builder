<?php
/**
 * stefanwimmer128/html-builder - Classes/Elements/CommentElement.php
 * @author Stefan Wimmer <info@stefanwimmer128.eu>
 * @license ISC
 * @copyright Copyright (c) 2020, Stefan Wimmer
 */

namespace Stefanwimmer128\HtmlBuilder\Elements;

use Stefanwimmer128\HtmlBuilder\HtmlTag;

/**
 * Class CommentElement
 * @package Stefanwimmer128\HtmlBuilder\Elements
 */
class CommentElement extends HtmlTag {
    /**
     * Create CommentElement
     * @param mixed ...$children
     */
    public function __construct(...$children) {
        parent::__construct('comment', [], ...$children);
    }
    
    /**
     * Render comment as HTML
     * @return string
     */
    public function render(): string {
        return sprintf('<!-- %s -->', $this->renderChildren());
    }
}
