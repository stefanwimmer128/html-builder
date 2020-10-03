# stefanwimmer128/html-builder

A fully extensible HTML-Builder supporting emmet input

- [Installation](#installation)
- [Example](#example)
- [Special Elements](#special-elements)
- [API Documentation](#api-documentation)
- [Writing extensions](#writing-extensions)

## [Installation](#installation)

```shell script
composer require stefanwimmer128/html-builder
```

## [Example](#example)

```php
use function Stefanwimmer128\HtmlBuilder\render;
use function Stefanwimmer128\HtmlBuilder\h;
use function Stefanwimmer128\HtmlBuilder\capture;
use function Stefanwimmer128\HtmlBuilder\map;

$test = '<p>TEST</p>';

$values = [
    'a' => 0,
    'b' => 1,
    'c' => 2,
];

render(h('xml[version="1.0" standalone=yes]', [], [
   h('doctype', 'html', [
       h('html[lang=en]', [], [
           h('head > title{Hello World!}'),
           h('body', [], [
               h('.container.container-content#container-content-main', [], [
                   h('a[href="#"][disabled]', 'LINK'),
                   '<p>TEST</p>',
                   capture('printf', '%s', $test)
               ]),
               h('comment', 'COMMENT'),
               h('p', ['data-values' => json_encode($values, JSON_THROW_ON_ERROR)], [
                   h('b', 'LIST:'),
                   h('br'),
                   map($values, fn($value, $key) => h('span', ['data-key' => $key], $value))
               ])
           ])
       ])
   ])
]));
```

```html
<?xml version="1.0" standalone="yes" ?><!DOCTYPE html><html lang="en"><head><title>Hello World!</title></head><body><div class="container container-content" id="container-content-main"><a href="#" disabled>LINK</a>&lt;p&gt;TEST&lt;/p&gt;<p>TEST</p></div><!-- COMMENT --><p data-values="{&quot;a&quot;:0,&quot;b&quot;:1,&quot;c&quot;:2}"><b>LIST:</b><br /><span data-key="a">0</span><span data-key="b">1</span><span data-key="c">2</span></p></body></html>
```

## [Special Elements](#special-elements)

- [`comment`](#comment)
- [`doctype`](#doctype)
- [`lorem` / `lipsum`](#lorem--lipsum)
- [`xml`](#xml)

The following elements are special.

Thus, if you want to use the keywords as simple tags, you will have to use the special `tag` function:

```php
use function Stefanwimmer128\HtmlBuilder\render;
use function Stefanwimmer128\HtmlBuilder\h;
use function Stefanwimmer128\HtmlBuilder\tag;

render(h('comment', 'Test'));
render(tag('comment', 'Test'));
```

```html
<!-- Test -->
<comment>Test</comment>
```

### [`comment`](#comment)

Generate HTML comment. Any string(s) or `HtmlElement`(s) can be used as children.

```php
use function Stefanwimmer128\HtmlBuilder\render;
use function Stefanwimmer128\HtmlBuilder\h;

render(h('comment', 'Test'));
```

```html
<!-- Test -->
```

### [`doctype`](#doctype)

Generate HTML doctype. Can receive children, that will be rendered after tag.

```php
use function Stefanwimmer128\HtmlBuilder\render;
use function Stefanwimmer128\HtmlBuilder\h;

render(h('doctype', 'html', ...$children));
```

```html
<!DOCTYPE html>...children...
```

### [`lorem` / `lipsum`](#lorem--lipsum)

Generates lorem ipsum text (default: 30 words).

To set the number of words to generate append it to the tag: `lorem20` generates 20 words, `lipsum40` generates 40 words.

```php
use function Stefanwimmer128\HtmlBuilder\render;
use function Stefanwimmer128\HtmlBuilder\h;

render(h('lorem50'));
```

Generates 50 words of lorem ipsum.

### [`xml`](#xml)

Create XML header. Works pretty similar to a html tag.

```php
use function Stefanwimmer128\HtmlBuilder\render;
use function Stefanwimmer128\HtmlBuilder\h;

render(h('xml[version="1.0"]', [], ...$children));
```

```html
<?xml version="1.0" ?>...children...
```

## [API Documentation](#api-documentation)

- [`h(string $input, ...$args): HtmlElement`](#hstring-input-args-htmlelement) Create element from input using parser (default: Emmet)
- [`tag(string $tag = 'div', ...$args): HtmlTag`](#tagstring-tag--div-args-htmltag) Create tag element
- [`text(string $text): HtmlText`](#textstring-text-htmltext) Create text element
- [`raw(string $value): RawString`](#rawstring-value-rawstring) Create raw string
- [`capture(callable $callable, ...$args): RawString`](#capturecallable-callable-args-rawstring) Captures output (echo) and returns it as raw string
- [`map(array $array, callable $callable): array`](#maparray-array-callable-callable-array) array_map with keys
- [`render(...$elements): string`](#renderelements-string) Render elements as HTML

### [`h(string $input, ...$args): HtmlElement`](#hstring-input-args-htmlelement)

Create element from input using parser (default: Emmet)

Also works like [`tag()`](#tagstring-tag--div-args-htmltag).

```php
use function Stefanwimmer128\HtmlBuilder\render;
use function Stefanwimmer128\HtmlBuilder\h;

render(h('table[border=0] > thead > .row > .col', 'Content'));
render(h('div', [], 'Some text <b>with html</b>'));
```

```html
<table border="0"><thead><tr class="row"><td class="col">Content</td></tr></thead></table>
<div>Some text &lt;p&gt;with html&lt;/b&gt;</div>
```

### [`tag(string $tag = 'div', ...$args): HtmlTag`](#tagstring-tag--div-args-htmltag)

Create tag element

```php
use function Stefanwimmer128\HtmlBuilder\render;
use function Stefanwimmer128\HtmlBuilder\tag;

render(tag('div', ['class' => 'container'], [
    'Text',
    tag('p', 'Some text <b>with html</b>')
]));
```

```html
<div class="container">Text<p>Some text &lt;p&gt;with html&lt;/b&gt;</p></div>
```

### [`text(string $text): HtmlText`](#textstring-text-htmltext)

Create text element

This is automatically applied to strings that are passed as children to [`h()`](#hstring-input-args-htmlelement) or [`tag()`](#tagstring-tag--div-args-htmltag).

```php
use function Stefanwimmer128\HtmlBuilder\render;
use function Stefanwimmer128\HtmlBuilder\text;

render(text('Some text <b>with html</b>'));
```

```html
Some text &lt;p&gt;with html&lt;/b&gt;
```

### [`raw(string $value): RawString`](#rawstring-value-rawstring)

Create raw string

```php
use function Stefanwimmer128\HtmlBuilder\render;
use function Stefanwimmer128\HtmlBuilder\raw;

render(raw('Some text <b>with html</b>'));
```

```html
Some text <b>with html</b>
```

### [`capture(callable $callable, ...$args): RawString`](#capturecallable-callable-args-rawstring)

Captures output (echo) and returns it as raw string

Useful with functions that instead of returning the markup directly output it (eg. Wordpress).

```php
use function Stefanwimmer128\HtmlBuilder\render;
use function Stefanwimmer128\HtmlBuilder\tag;
use function Stefanwimmer128\HtmlBuilder\capture;

render(tag('div', [], capture('the_widget', 'widget')));
```

```html
<div>...widget markup...</div>
```

### [`map(array $array, callable $callable): array`](#maparray-array-callable-callable-array)

array_map with keys

```php
use function Stefanwimmer128\HtmlBuilder\render;
use function Stefanwimmer128\HtmlBuilder\tag;
use function Stefanwimmer128\HtmlBuilder\map;

$values = [
    'key0' => 'value0',
    'key1' => 'value1',
];

render(tag('ul', [], map($values, fn($value, $key) => tag('li', ['id' => $key], $value))));
```

```html
<ul><li id="key0">value0</li><li id="key1">value1</li></ul>
```

### [`render(...$elements): string`](#renderelements-string)

Render elements as HTML

See all the above.

## [Writing extensions](#writing-extensions)

- [Creating a custom element](#creating-a-custom-element)
- [Creating a custom parser](#creating-a-custom-parser)

### [Creating a custom element](#creating-a-custom-element)

Any custom element must extend `\Stefanwimmer128\HtmlBuilder\HtmlElement`.

First you create your element class:

```php
use Stefanwimmer128\HtmlBuilder\HtmlElement;

class CustomElement extends HtmlElement {
    private string $someData;
    
    public function __construct(string $someData) {
        $this->someData = $someData;
    }
    
    public function render(): string {
        return sprintf('(%s)', $this->someData);
    }
}
```

If your element is tag-like, you might want to extend `\Stefanwimmer128\HtmlBuilder\HtmlTag`:

```php
use Stefanwimmer128\HtmlBuilder\HtmlTag;

class CustomElement extends HtmlTag {
    public function __construct(...$args) {
        parent::__construct('custom', ...$args);
    }
    
    public function render(): string {
        return sprintf('(%s)%s', $this->renderAttributes(), $this->renderChildren());
    }
}
```

If your custom element should receive parsed information, your element must implement `\Stefanwimmer128\HtmlBuilder\Parser\ParserCompatibleElement`.

After which you have to register your element, by putting this code before your usage of the element:

```php
use Stefanwimmer128\HtmlBuilder\HtmlElement;

HtmlElement::$ELEMENTS['custom'] = CustomElement::class;
```

If you want to add an element that has 

### [Creating a custom parser](#creating-a-custom-parser)

Any parser must extend `\Stefanwimmer128\HtmlBuilder\Parser\AbstractParser`.

Since creating a custom parser is very much tied to what you want to parse, please orientate yourself using the included `\Stefanwimmer128\HtmlBuilder\Parser\Emmet\EmmetParser`.

```php
use Stefanwimmer128\HtmlBuilder\Parser\AbstractParser;

class CustomParser extends AbstractParser {
    public function __construct(string $input) {
        // your parsing logic goes here
    }
    
    public function getTag(): string {
        // return tag here
    }
    
    public function getAttributes(): array {
        // return attributes here
    }
    
    public function getClasses(): array {
        // return classes here
    }
    
    public function getId(): ?string {
        // return id here if provided or null
    }
    
    public function getText() : ?string {
        // return text here if provided or null
    }
    
    public function getChild() : ?AbstractParser {
        // return child here if provided or null
    }
    
    public function isSelfclosing() : ?bool{
        // return whether tag self-closes if provided or null
    }
}
```

After which you can set your parser by:

```php
use Stefanwimmer128\HtmlBuilder\Parser\AbstractParser;

AbstractParser::$DEFAULT_PARSER = CustomParser::class;
```
