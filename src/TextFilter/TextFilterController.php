<?php

namespace Olbe19\TextFilter;

use Anax\Commons\AppInjectableInterface;
use Anax\Commons\AppInjectableTrait;

/**
 * A TextFilterController Class
 */
class TextFilterController implements AppInjectableInterface
{
    use AppInjectableTrait;

    /**
     * Initialize method
     * Called before the target method/action
     * Setups internal properties that are commonly used by several methods
     *
     * @return void
     */
    public function initialize(): void
    {
        // Creates filter object
        $this->textfilter = new MyTextFilter();

        // Stores text as string
        $this->text = file_get_contents(__DIR__ . "/doc/text.txt");
    }

    /**
     * This method is handler for the route:
     * GET mountpoint/text
     *
     * @return object
     *
     */
    public function indexActionGet(): object
    {
        // Calls parse method and stores return in variable
        $textFiltered = $this->textfilter->parse($this->text, ["bbcode", "nl2br"]);

        // Data array
        $data = [
            "title" => "Textfilter - oophp",
            "text" => $this->text,
            "textFiltered" => $textFiltered
        ];

        // Adds route and sends array to view
        $this->app->page->add("textfilter/index", $data);

        // Renders page
        return $this->app->page->render($data);
    }
}
