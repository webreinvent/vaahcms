<?php

namespace WebReinvent\VaahCms\Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use WebReinvent\VaahCms\Tests\Browser\Pages\LoginPage;

class LoginTest extends DuskTestCase
{

    //-----------------------------------------------------------------------
    public function runValidation($inputs)
    {
        $this->browse(function (Browser $browser) use ($inputs) {
            $browser->visit(new LoginPage())->maximize();
            $browser->attemptSignIn($inputs);
            $browser->assertSee($inputs['assert']);
        });
    }
    //-----------------------------------------------------------------------
    public function test_01_no_password()
    {
        $inputs = [
            'email' => "we@asdaf.com",
            'password' => "",
            'assert' => "The password field is required.",
        ];
        $this->runValidation($inputs);
    }
    //-----------------------------------------------------------------------
    public function test_02_invalid_email()
    {
        $inputs = [
            'email' => "we@asdaf.com",
            'password' => "Demo",
            'assert' => "No User Exist.",
        ];
        $this->runValidation($inputs);
    }
    //-----------------------------------------------------------------------
    //-----------------------------------------------------------------------
    //-----------------------------------------------------------------------
    //-----------------------------------------------------------------------
    //-----------------------------------------------------------------------
}
