<?php
/**
 * stefanwimmer128/html-builder - Classes/Parser/Emmet/EmmetParser.php
 * @author Stefan Wimmer <info@stefanwimmer128.eu>
 * @license ISC
 * @copyright Copyright (c) 2020, Stefan Wimmer
 */

namespace Stefanwimmer128\HtmlBuilder\Parser\Emmet;

use Stefanwimmer128\HtmlBuilder\Parser\AbstractParser;

/**
 * Class EmmetParser
 * @package Stefanwimmer128\HtmlBuilder\Parser\Emmet
 */
class EmmetParser extends AbstractParser {
    public const EMMET = '/^(?<emmet>(?=.)(?<tag>[\w-]+)?(?(?<=.)(?=\S)(?<attributes>(?:\[[\w-]+(?:=[\w-]+|="[^"]*")?(?: +[\w-]+(?:=[\w-]+|="[^"]*")?)*])*))?(?<classes>(?:\.[\w-]+)+)?(?<id>#[\w-]+)?(?:(?<=.)(?:(?<text> *{[^{}]*})| *> *(?<child>(?&emmet))))?)$/';
    
    public static string $DEFAULT_TAG = 'div';
    public static array $IMPLICIT_TAGS = [
        'p' => 'span',
        'ul' => 'li',
        'ol' => 'li',
        'table' => 'tr',
        'tr' => 'td',
        'tbody' => 'tr',
        'thead' => 'tr',
        'tfoot' => 'tr',
        'colgroup' => 'col',
        'select' => 'option',
        'optgroup' => 'option',
        'audio' => 'source',
        'video' => 'source',
        'object' => 'param',
        'map' => 'area',
    ];
    
    /**
     * Get implicit tag by parent
     * @param string|EmmetParser|null $parent
     * @return string|null
     */
    public static function getImplicitTag($parent): ?string {
        return $parent && array_key_exists($parent = $parent instanceof self ? $parent->getTag() : $parent, self::$IMPLICIT_TAGS) ? self::$IMPLICIT_TAGS[$parent] : null;
    }
    
    protected string $tag;
    protected array $attributes = [];
    protected array $classes = [];
    protected ?string $id = null;
    protected ?string $text = null;
    protected ?EmmetParser $child = null;
    
    /**
     * Parse emmet
     * @param string $emmet
     * @param EmmetParser|null $parent
     */
    public function __construct(string $emmet, ?EmmetParser $parent = null) {
        if (preg_match(self::EMMET, $emmet, $matches)) {
            $this->tag = ($tag = $matches['tag'] ?? '') !== '' ? $tag : self::getImplicitTag($parent) ?? self::$DEFAULT_TAG;
            
            if (preg_match_all('/([\w-]+)(?:=([\w-]+|"[^"]*"))?/', $matches['attributes'] ?? '', $attributes, PREG_SET_ORDER)) {
                foreach ($attributes as $attribute) {
                    $key = $attribute[1];
                    if (isset($attribute[2])) {
                        $value = $attribute[2];
                        if (preg_match('/^"([^"]*)"$/', $value, $unquoted)) {
                            $this->attributes[$key] = htmlspecialchars_decode($unquoted[1]);
                        } else {
                            $this->attributes[$key] = $value;
                        }
                    } else {
                        $this->attributes[$key] = true;
                    }
                }
            }
            
            if (preg_match_all('/(?<=\.)[\w-]+/', $matches['classes'] ?? '', $classes)) {
                $this->classes = $classes[0];
            }
            
            $this->id = ($id = $matches['id'] ?? '') !== '' ? substr($id, 1) : null;
            
            $this->text = ($text = $matches['text'] ?? '') !== '' ? substr($text, 1, -1) : null;
            
            $this->child = ($child = $matches['child'] ?? '') !== '' ? new self($child, $this) : null;
        } else {
            throw new EmmetParserException($emmet);
        }
    }
    
    public function getTag(): string {
        return $this->tag;
    }
    
    public function getAttributes(): array {
        return $this->attributes;
    }
    
    public function getClasses(): array {
        return $this->classes;
    }
    
    public function getId(): ?string {
        return $this->id;
    }
    
    public function getText(): ?string {
        return $this->text;
    }
    
    public function getChild(): ?EmmetParser {
        return $this->child;
    }
    
    public function isSelfclosing(): ?bool {
        return null;
    }
}
