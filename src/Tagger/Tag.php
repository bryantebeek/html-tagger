<?php namespace Tagger;

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
 * @version  1.0.0
 * @link     http://www.github.com/bryantebeek/tagger
 *
 */
class Tag
{
    /**
     * The identifier of the tag.
     *
     * @var string
     */
    protected $identifier;

    /**
     * An array of the tag attributes stored as ['attribute' => 'value'].
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
     * Initialize a new Tag object, if an argument is given we use it to be the content of the tag.
     *
     * @param string $content
     */
    public function __construct($content = null)
    {
        $this->content = is_callable($content) ? $content($this) : $content;
    }

    /**
     * Render the Tag as an HTML string.
     *
     * @return string
     */
    public function render()
    {
        return $this->open() . $this->content . $this->close();
    }

    /**
     * Generates the opening tag.
     *
     * @return string
     */
    public function open()
    {
        return "<{$this->identifier}{$this->renderAttributes()}>";
    }

    /**
     * Generates the closing tag.
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
     * @return Tagger\Tag
     */
    public function setAttribute($attribute, $value)
    {
        if (! empty($value)) {
            $this->attributes[$attribute] = $value;
        }

        return $this;
    }

    /**
     * Get an attribute
     *
     * @param  string $attribute The name of the attribute to get
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
     * @param array $attributes An array of attributes to be set
     *
     * @return Tagger\Tag
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
     * Set the content.
     *
     * @param  Closure|string $content The content
     *
     * @return Tagger\Tag
     */
    public function content($content)
    {
        $this->content = is_callable($content) ? $content($this) : $content;

        return $this;
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
     * Render all the attributes for usage in a html tag.
     *
     * @return string
     */
    protected function renderAttributes()
    {
        $attributesHTML = "";
        foreach ($this->attributes as $key => $attribute) {
            if (is_callable($attribute)) {
                $attribute = $attribute();
            }

            $attributesHTML .= " {$key}=\"{$attribute}\"";
        }

        return $attributesHTML;
    }

    /**
     * Check if the Tag has an attribute.
     *
     * @param  string  $attribute The attribute name
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
     * @param  array  $attributes An array of attribute names
     *
     * @return boolean
     */
    public function hasAttributes($attributes)
    {
        foreach ($attributes as $attribute)
        {
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
     * @return Tagger\Tag
     */
    public static function __callStatic($method, $parameters)
    {
        $tag = count($parameters) > 0 ? new static($parameters[0]) : new static;
        $tag->identifier = $tag->identifier ?: $method;

        return $tag;
    }

    /**
     * Dynamically set attributes on the Tag.
     *
     * @param  string $method
     * @param  array $parameters
     *
     * @return mixed
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
     * @return string
     */
    public function __get($attribute)
    {
        return $this->getAttribute($attribute);
    }
}
