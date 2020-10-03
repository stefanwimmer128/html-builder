<?php
/**
 * stefanwimmer128/html-builder - Classes/CustomTagElement.php
 * @author Stefan Wimmer <info@stefanwimmer128.eu>
 * @license ISC
 * @copyright Copyright (c) 2020, Stefan Wimmer
 */

namespace Stefanwimmer128\HtmlBuilder;

/**
 * Interface CustomTagElement
 * @package Stefanwimmer128\HtmlBuilder
 */
interface CustomTagElement {
    /**
     * Set tag of element
     * @param string $tag
     */
    public function setTag(string $tag): void;
}
