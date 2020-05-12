<?php

namespace Olbe19\TextFilter;

use Anax\Commons\AppInjectableInterface;
use Anax\Commons\AppInjectableTrait;

/**
 * A sample controller to show how a controller class can be implemented.
 * The controller will be injected with $app if implementing the interface
 * AppInjectableInterface, like this sample class does.
 * The controller is mounted on a particular route and can then handle all
 * requests for that mount point.
 *
 * @SuppressWarnings(PHPMD.CyclomaticComplexity)
 *
 */
class TextFilterController implements AppInjectableInterface
{
    use AppInjectableTrait;

    /**
     * The initialize method is optional and will always be called before the
     * target method/action. This is a convienient method where you could
     * setup internal properties that are commonly used by several methods.
     *
     * @return void
     */
    public function initialize(): void
    {
        // Creates filter object
        $this->textfilter = new MyTextFilter();

        // Stores text as string
        $this->text = file_get_contents(__DIR__ . "/doc/bbcode.txt");
    }

    /**
     * This method is handler for the route:
     * GET mountpoint/markdown
     *
     * @return object
     *
     */
    public function textActionGet(): object
    {
        // Calls parse method and stores return in variable
        $textFiltered = $this->textfilter->parse($this->text, ["bbcode", "link", "markdown", "nl2br"]);

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
