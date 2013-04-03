# Installation

## Composer

Installing Tagger with composer is super easy, just add the following requirement to your composer.json:

```
"bryantebeek/tagger": "v1.0.*"
```

# Usage

You can start using Tagger by calling the desired tag name as a static method on the Tag class.
```php
Tagger\Tag::div();

Tagger\Tag::img();
```

### Adding content
It is possible to pass the content of a tag right when you initialize it.
```php
Tagger\Tag::div('Hello World!');
```

Instead of passing the content in directly, content can be set after the tag has already been initialized.
```php
Tagger\Tag::div()->content('Hello World!');
```

The content of a tag can also be set using an anonymous function.
```php
Tagger\Tag::div(function ($tag) {
    return 'Hello World!';
});
```

### Adding attributes
Attributes can be set in a variety of different ways.


```php
// <div id="main"></div>
Tagger\Tag::div()->id('main');

$tag = Tagger\Tag::div();
$tag->id = 'main';
```

Please note that some HTML attributes can't be set using dynamic accessors because they contain, for example, a hyphen.

```php
// <div data-title="Hello World!">
Tagger\Tag::div()->setAttribute('data-title', 'Hello World!');
```

It is also possible to set multiple attributes at the same time.

```php
$attributes = array(
	'id' => 'main',
	'data-title' => 'Hello World!',
);

Tagger\Tag::div()->setAttributes($attributes);
```

__Please note that all ways of setting attributes return the object to allow for chaining.__

### Rendering a Tag
There are three possible ways to render a tag to HTML.

```php
$tag = Tagger\Tag::div();

// All following lines will output: <div></div>
echo $tag;
echo $tag->render();
echo $tag->open() . $tag->close();

```

### Checking attributes
It is possible to check if a tag has certain attributes.

```php
$tag = Tagger\Tag::div()->id('main')->class('container');

$tag->hasAttribute('id'); // true
$tag->hasAttributes(array('id', 'class')); // true
$tag->hasAttributes(array('class', 'title')); // false
```

[![Build Status](https://secure.travis-ci.org/bryantebeek/html-tagger.png)](http://travis-ci.org/bryantebeek/html-tagger)
