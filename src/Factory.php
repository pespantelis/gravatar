<?php

namespace Peslis\Gravatar;

class Factory
{
    const HTTPS_URL = 'https://secure.gravatar.com/avatar/';

    const HTTP_URL = 'http://gravatar.com/avatar/';

    /**
     * @var boolean
     */
    private $secure = false;

    /**
     * @var string
     */
    private $email;

    /**
     * @var array
     */
    private $options;

    /**
     * @param  array  $options
     * @return void
     */
    public function __construct($options = null)
    {
        empty($options['secure']) ?: $this->secure();
        empty($options['size']) ?: $this->size($options['size']);
        empty($options['rating']) ?: $this->rating($options['rating']);
        empty($options['default-image']) ?: $this->defaultImage($options['default-image']);
        empty($options['force-default']) ?: $this->forceDefault();
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->build();
    }

    /**
     * @param  string  $email
     * @param  string  $size
     * @return static
     */
    public function url($email, $size = null)
    {
        $this->email = $email;

        if ($size) $this->size($size);

        return $this;
    }

    /**
     * @param  boolean  $secure
     * @return static
     */
    public function secure($secure = true)
    {
        $this->secure = $secure;

        return $this;
    }

    /**
     * @param  integer $size
     * @return static
     * @throws InvalidSizeException
     */
    public function size($size)
    {
        if ( ! is_int($size)) {
            throw new InvalidSizeException('Size must be an integer');
        }

        if ($size > 2048 || $size < 1) {
            throw new InvalidSizeException('Size must be within 1px and 2048px');
        }

        $this->options['s'] = $size;

        return $this;
    }

    /**
     * @param  string  $default
     * @return static
     */
    public function defaultImage($default)
    {
        $this->options['d'] = urlencode(strtolower($default));

        return $this;
    }

    /**
     * @param  boolean  $force
     * @return static
     */
    public function forceDefault($force = true)
    {
        if ($force) {
            $this->options['f'] = 'y';
        } else {
            unset($this->options['f']);
        }

        return $this;
    }

    /**
     * @param  string  $rating
     * @return static
     */
    public function rating($rating)
    {
        $this->options['r'] = $rating;

        return $this;
    }

    /**
     * @param  string  $email
     * @return bool
     */
    public function exists($email = null)
    {
        if ($email) $this->url($email);

        $this->defaultImage('404');

        $url = $this->build();

        $status = get_headers($url)[0];

        return $status === 'HTTP/1.1 200 OK';
    }

    /**
     * @return string
     */
    private function build()
    {
        $url = $this->secure ? static::HTTPS_URL : static::HTTP_URL;

        $params = $this->options ? '?' . http_build_query($this->options) : null;

        return $url . md5($this->email) . $params;
    }
}
