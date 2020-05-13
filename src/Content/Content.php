<?php

namespace Olbe19\Content;

/**
 * Filter and format text content.
 *
 */
class Content
{
    /**
     * @var array $filters Supported filters with method names of
     * their respective handler.
     */
    private $filters = [
        "bbcode"    => "bbcode2html",
        "link"      => "makeClickable",
        "markdown"  => "markdown",
        "nl2br"     => "nl2br",
        "strip" => "striptags",
        "escape" => "esc"
    ];



    /**
     * Call each filter on the text and return the processed text.
     *
     * @param string $text   The text to filter.
     * @param array  $filter Array of filters to use.
     *
     * @return string with the formatted text.
     */
    public function parse($text, $filter)
    {
        foreach ($filter as $functionName) {
            $filteredText = call_user_func_array([$this, $this->filters[$functionName]], [$text]);
        }

        return $filteredText;
    }
}
