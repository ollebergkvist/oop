<?php

namespace Olbe19\Dice;

use Anax\DI\DIMagic;
use Anax\Response\ResponseUtility;
use PHPUnit\Framework\TestCase;

/**
 * Test the controller like it would be used from the router,
 * simulating the actual router paths and calling it directly.
 */
class DiceControllerTest extends TestCase
{
    private $controller;


    // /**
    //  * Setup the controller, before each testcase, just like the router
    //  * would set it up.
    //  */
    protected function setUp(): void
    {
        // Init service container $di to contain $app as a service
        $di = new DIMagic();
        $di->loadServices(ANAX_INSTALL_PATH . "/config/di");
        $app = $di;
        $di->set("app", $app);

        // Create and initiate the controller
        $this->controller = new DiceController();
        $this->controller->setApp($app);
    }

    /**
     * Call the controller init action.
     */
    public function testInitAction()
    {
        $res = $this->controller->initAction();
        $this->assertInstanceOf(ResponseUtility::class, $res);
    }


    // /**
    //  * Call the controller create action GET.
    //  */
    // public function testCreateActionGet()
    // {
    //     $res = $this->controller->createActionGet();
    //     $this->assertIsString($res);
    //     $this->assertStringEndsWith("active", $res);
    // }


    // /**
    //  * Call the controller create action POST.
    //  */
    // public function testCreateActionPost()
    // {
    //     $res = $this->controller->createActionPost();
    //     $this->assertIsString($res);
    //     $this->assertStringEndsWith("active", $res);
    // }
}
