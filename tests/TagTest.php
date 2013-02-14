<?php

use Tagger\Tag;

class TagTest extends PHPUnit_Framework_TestCase
{
    public function testTag()
    {
        $tag = Tag::foo()->__toString();
        $this->assertEquals('<foo></foo>', $tag);
    }

    public function testTagWithContent()
    {
        $tag = Tag::foo("test")->__toString();
        $this->assertEquals('<foo>test</foo>', $tag);
    }

    public function testTagWithAttribute()
    {
        $tag = Tag::foo()->href("#")->__toString();
        $this->assertEquals('<foo href="#"></foo>', $tag);
    }

    public function testTagWithAttributeAndContent()
    {
        $tag = Tag::foo("test")->href("#")->__toString();
        $this->assertEquals('<foo href="#">test</foo>', $tag);
    }

    public function testTagWithMultipleAttributes()
    {
        $tag = Tag::foo()->href("#")->title("test")->__toString();
        $this->assertEquals('<foo href="#" title="test"></foo>', $tag);
    }

    public function testTagWithMultipleAttributesAndContent()
    {
        $tag = Tag::foo("test")->href("#")->title("test")->__toString();
        $this->assertEquals('<foo href="#" title="test">test</foo>', $tag);
    }

    public function testTagWithContentClosure()
    {
        $tag = Tag::foo(function($tag) {
            return "test";
        });
        $this->assertEquals('<foo>test</foo>', $tag);
    }

    public function testTagWithAttributeClosure()
    {
        $tag = Tag::foo()->title(function($tag) {
            return "test";
        });
        $this->assertEquals('<foo title="test"></foo>', $tag);
    }

    public function testTagWithContentFunction() {
        $tag = Tag::foo()->content('test');
        $this->assertEquals('<foo>test</foo>', $tag);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testToManyArgumentsThrowsException()
    {
        $tag = Tag::foo()->href("#", "test");
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testNoArgumentsThrowsException()
    {
        $tag = Tag::foo()->href();
    }

    public function testGetAttribute()
    {
        $tag = Tag::div()->id('foo');
        $this->assertEquals('foo', $tag->getAttribute('id'));
    }

    public function testGetAttributes()
    {
        $tag = Tag::div()->id('foo')->class('bar');
        $this->assertEquals(array('id' => 'foo', 'class' => 'bar'), $tag->getAttributes());
    }

    public function testGetContent()
    {
        $tag = Tag::div('foo');
        $this->assertEquals('foo', $tag->getContent());
    }

    public function testSetAttributes()
    {
        $tag = Tag::div();
        $tag->setAttributes(array('href' => 'foo', 'title' => 'bar'));

        $attributes = $tag->getAttributes();
        $this->assertArrayHasKey('href', $attributes);
        $this->assertArrayHasKey('title', $attributes);
        $this->assertEquals('foo', $attributes['href']);
        $this->assertEquals('bar', $attributes['title']);
    }

    public function testHasAttributeAndHasAttributes()
    {
        $tag = Tag::div();
        $tag->class('foo')->id('bar');

        $this->assertTrue($tag->hasAttribute('class'));
        $this->assertFalse($tag->hasAttribute('title'));

        $this->assertTrue($tag->hasAttributes(array('class', 'id')));
        $this->assertFalse($tag->hasAttributes(array('class', 'id', 'title')));
    }

    public function testMagicSetterAndGetter()
    {
        $tag = Tag::div()->class('foo');

        $tag->class = 'foo';
        $this->assertEquals('foo', $tag->getAttribute('class'));
        $this->assertEquals('foo', $tag->class);
    }
}
