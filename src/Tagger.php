<?php namespace Tagger;

/**
 * Class to generate HTML tags easily
 *
 * @package  Tagger
 * @author   Bryan te Beek <bryantebeek@gmail.com>
 * @license  MIT <http://www.github.com/MIT>
 * @version  1.0.0
 * @link     http://www.github.com/bryantebeek/test
 *
 */
class Tagger
{
    protected $identifier;
    protected $attributes = array();
    protected $content;

    /**
     * Initialize a new Tag object
     *
     * @param string $content The content of this tag
     */
    public function __construct($content = null)
    {
        $this->content = $content;
    }

    public static function __callStatic($name, $arguments)
    {
        $tag = static::getClassObject($name, $arguments);
        $tag->identifier = $tag->identifier ?: $name;

        return $tag;
    }

    public function __call($attribute, $arguments)
    {
        if (empty($arguments) || count($arguments) > 1) {
            throw new \InvalidArgumentException("Call to ".__CLASS__."::{$attribute} with zero or more than one argument.");
        }

        $this->setAttribute($attribute, $arguments[0]);

        return $this;
    }

    public function __toString()
    {
        return $this->open() . $this->content . $this->close();
    }

    /**
     * Generate the opening tag
     * @return string The opening tag
     */
    public function open()
    {
        return "<{$this->identifier}{$this->renderAttributes()}>";
    }

    /**
     * Generate the closing tag
     * @return string The closing tag
     */
    public function close()
    {
        return "</{$this->identifier}>";
    }

    /**
     * Set an attribute
     *
     * @param string $attribute The attribute name
     * @param string $value     The attribute value
     */
    public function setAttribute($attribute, $value)
    {
        if (!is_null($value)) {
            $this->attributes[$attribute] = $value;
        }

        return $this;
    }

    /**
     * Get an attribute
     * @param  string $attribute The name of the attribute to get
     * @return string            The value of the attribute
     */
    public function getAttribute($attribute)
    {
        return $this->attributes[$attribute];
    }

    /**
     * Set multiple attributes
     * @param array $attributes An array of attributes to be set
     */
    public function setAttributes(array $attributes)
    {
        foreach($attributes as $attribute => $value)
        {
            $this->setAttribute($attribute, $value);
        }

        return $this;
    }

    /**
     * Get an array all the attributes
     * @return array All attributes
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * Set the content
     * @param  Closure|string $content The content
     * @return Goforit\Doit\Tag          The current tag, used for chaining
     */
    public function content($content)
    {
        $this->content = is_callable($content) ? $content() : $content;

        return $this;
    }

    /**
     * Get the content
     * @return string The content
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Render all the attributes for usage in a html tag
     * @return string All the attributes in a string
     */
    protected function renderAttributes()
    {
        $attributesHTML = "";
        foreach ($this->attributes as $key => $attribute) {
            if(is_callable($attribute)) $attribute = $attribute();

            $attributesHTML .= " {$key}=\"{$attribute}\"";
        }

        return $attributesHTML;
    }

    /**
     * Find the right class to use, either Tag itself or a subclass of Tag
     * @param  string $name      The name of the function that was called
     * @param  array $arguments  An array of arguments of the function that was called
     * @return Object            The right object
     */
    protected static function getClassObject($name, $arguments)
    {
        $class = __CLASS__.'\\'.ucfirst($name);

        if (class_exists($class)) {
            if (count($arguments) > 0) {
                return new $class($arguments[0]);
            }
            return new $class;
        }

        return count($arguments) > 0 ? new static($arguments[0]) : new static;
    }
}
