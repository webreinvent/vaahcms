<?php

namespace WebReinvent\VaahCms\Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ExampleTest extends DuskTestCase
{
    /**
     * A basic browser test example.
     *
     * @return void
     */
    public function testBasicExample()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/admin')
                ->type(' @signin-username_or_email', "we@webreinvent.com")
                ->assertSee('Home Page');
            ;
        });
    }
}
