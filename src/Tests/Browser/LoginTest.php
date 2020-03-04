<?php

namespace WebReinvent\VaahCms\Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class LoginTest extends DuskTestCase
{

    //-----------------------------------------------------------------------
    public function testValidation()
    {
        $list = @file_get_contents(__DIR__.'/Data/login.json');
        $list = json_decode($list);

        $this->browse(function (Browser $browser) use ($list) {

            foreach($list as $case) {
                $browser->visit('/admin')->maximize();
                foreach ($case->inputs as $input)
                {
                    $browser->type($input->selector, $input->value);
                }
                $browser->click($case->action->selector);
                $browser->waitFor('.toast');
                $browser->assertSee($case->assert);
            }
        });
    }
    //-----------------------------------------------------------------------
    //-----------------------------------------------------------------------
    //-----------------------------------------------------------------------
}
