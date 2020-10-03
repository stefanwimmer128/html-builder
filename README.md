# stefanwimmer128/html-builder

A fully extensible HTML-Builder supporting emmet input

## Documentation

- [`h(string $input, ...$args): HtmlElement`](#documentation_h) Create element from input using parser (default: Emmet)
- [`tag(string $tag = 'div', ...$args): HtmlTag`](#documentation_tag) Create tag element
- [`text(string $text): HtmlText`](#documentation_text) Create text element
- [`raw(string $value): RawString`](#documentation_raw) Create raw string
- [`capture(callable $callable, ...$args): RawString`](#documentation_capture) Captures output (echo) and returns it as raw string
- [`map(array $array, callable $callable): array`](#documentation_map) array_map with keys
- [`render(...$elements): string`](#documentation_render) Render elements as HTML

### <a name="documentation_h"></a> [`h(string $input, ...$args): HtmlElement`](#documentation_h)

Create element from input using parser (default: Emmet)

Also works like [`tag()`](#documentation_tag).

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

### <a name="documentation_tag"></a> [`tag(string $tag = 'div', ...$args): HtmlTag`](#documentation_tag)

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

### <a name="documentation_text"></a> [`text(string $text): HtmlText`](#documentation_text)

Create text element

This is automatically applied to strings that are passed as children to [`h()`](#documentation_h) or [`tag()`](#documentation_tag).

```php
use function Stefanwimmer128\HtmlBuilder\render;
use function Stefanwimmer128\HtmlBuilder\text;

render(text('Some text <b>with html</b>'));
```

```html
Some text &amp;lt;p&amp;gt;with html&amp;lt;/b&amp;gt;
```

### <a name="documentation_raw"></a> [`raw(string $value): RawString`](#documentation_raw)

Create raw string

```php
use function Stefanwimmer128\HtmlBuilder\render;
use function Stefanwimmer128\HtmlBuilder\raw;

render(raw('Some text <b>with html</b>'));
```

```html
Some text <b>with html</b>
```

### <a name="documentation_capture"></a> [`capture(callable $callable, ...$args): RawString`](#documentation_capture)

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

### <a name="documentation_map"></a> [`map(array $array, callable $callable): array`](#documentation_map)

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

### <a name="documentation_render"></a> [`render(...$elements): string`](#documentation_render)

Render elements as HTML

See all the above.
