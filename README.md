# stefanwimmer128/html-builder

A fully extensible HTML-Builder supporting emmet input

## Installation

```shell script
composer require stefanwimmer128/html-builder
```

## Documentation

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
<div>Some text &amp;lt;p&amp;gt;with html&amp;lt;/b&amp;gt;</div>
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
<div class="container">Text<p>Some text &amp;lt;p&amp;gt;with html&amp;lt;/b&amp;gt;</p></div>
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
Some text &amp;lt;p&amp;gt;with html&amp;lt;/b&amp;gt;
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
