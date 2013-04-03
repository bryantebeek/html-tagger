<?php namespace Tagger;

use Closure;

/**
 * Class to generate HTML tags easily
 *
 * <code>
 *   Tag::div('content')->class('foo')->id('bar')
 * </code>
 *
 * @package  Tagger
 * @author   Bryan te Beek <bryantebeek@gmail.com>
 * @license  MIT <http://www.github.com/MIT>
 * @version  1.1.0
 * @link     http://www.github.com/bryantebeek/html-tagger
 *
 */
class Tag
{
    /**
     * The identifier of the tag. (e.g. `a` for <a></a>)
     *
     * @var string
     */
    protected $identifier;

    /**
     * The attributes to be rendered.
     *
     * @var array
     */
    protected $attributes = array();

    /**
     * The content to be placed between the opening and the closing tag.
     *
     * @var Closure|string
     */
    protected $content;

    /**
     * Create a new Tag object.
     *
     * @param Closure|string $content
     */
    public function __construct($content = null)
    {
        $this->setContent($content);
    }

    /**
     * Render as a HTML string.
     *
     * @return string
     */
    public function render()
    {
        return $this->open() . $this->content . $this->close();
    }

    /**
     * Generate the opening tag.
     *
     * @return string
     */
    public function open()
    {
        return "<{$this->identifier}{$this->renderAttributes()}>";
    }

    /**
     * Generate the closing tag.
     *
     * @return string
     */
    public function close()
    {
        return "</{$this->identifier}>";
    }

    /**
     * Set an attribute.
     *
     * @param string $attribute
     * @param string $value
     *
     * @return self
     */
    public function setAttribute($attribute, $value)
    {
        if ($value instanceof Closure) {
            $this->attributes[$attribute] = call_user_func_array($value, array($this));
        }

        if (! empty($value)) {
            $this->attributes[$attribute] = $value;
        }

        return $this;
    }

    /**
     * Get an attribute.
     *
     * @param  string $attribute
     *
     * @return string
     */
    public function getAttribute($attribute)
    {
        return $this->attributes[$attribute];
    }

    /**
     * Set multiple attributes.
     *
     * @param array $attributes
     *
     * @return self
     */
    public function setAttributes(array $attributes)
    {
        foreach ($attributes as $attribute => $value) {
            $this->setAttribute($attribute, $value);
        }

        return $this;
    }

    /**
     * Get an array of all the attributes.
     *
     * @return array
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * Fluent version to set the content.
     *
     * @param  Closure|string $content
     *
     * @return self
     */
    public function content($content)
    {
        return $this->setContent($content);
    }

    /**
     * Get the content.
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set the content.
     *
     * @param  Closure|string $content
     *
     * @return self
     */
    public function setContent($content)
    {
        if ($content instanceof Closure) {
            $this->content = call_user_func_array($content, array($this));
        } else {
            $this->content = $content;
        }

        return $this;
    }

    /**
     * Render all the attributes for usage in a html tag.
     *
     * @return string
     */
    protected function renderAttributes()
    {
        $attributesHTML = "";

        foreach ($this->attributes as $key => $attribute) {
            if ($attribute instanceof Closure) {
                $attribute = call_user_func_array($attribute, array($this));
            }

            $attributesHTML .= " {$key}=\"{$attribute}\"";
        }

        return $attributesHTML;
    }

    /**
     * Check if the Tag has an attribute.
     *
     * @param  string  $attribute
     *
     * @return boolean
     */
    public function hasAttribute($attribute)
    {
        return array_key_exists($attribute, $this->attributes);
    }

    /**
     * Check if the Tag has multiple attributes.
     *
     * @param  array  $attributes
     *
     * @return boolean
     */
    public function hasAttributes($attributes)
    {
        foreach ($attributes as $attribute) {
            if (! $this->hasAttribute($attribute)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Create a new Tag object and set it's identifier and content if applicable.
     *
     * @param  string $method
     * @param  array  $parameters
     *
     * @return self
     */
    public static function __callStatic($method, $parameters)
    {
        $tag = count($parameters) > 0 ? new static($parameters[0]) : new static;
        $tag->identifier = $method;

        return $tag;
    }

    /**
     * Dynamically set attributes on the Tag.
     *
     * @param  string $method
     * @param  array $parameters
     *
     * @return self
     */
    public function __call($method, $parameters)
    {
        if (empty($parameters)) {
            throw new \InvalidArgumentException("Can't set the {$method} attribute with zero arguments.");
        } elseif (count($parameters) > 1) {
            throw new \InvalidArgumentException("Can't set the {$method} attribute with two or more arguments");
        }

        $this->setAttribute($method, $parameters[0]);

        return $this;
    }

    /**
     * Create the string representation of the Tag.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->render();
    }

    /**
     * Dynamically set an attribute.
     *
     * @param string $attribute
     * @param string $value
     */
    public function __set($attribute, $value)
    {
        $this->setAttribute($attribute, $value);
    }

    /**
     * Dynamically get an attribute.
     *
     * @param  string $attribute
     *
     * @return mixed
     */
    public function __get($attribute)
    {
        return $this->getAttribute($attribute);
    }
}
