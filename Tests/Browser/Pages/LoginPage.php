<?php

namespace WebReinvent\VaahCms\Tests\Browser\Pages;

use Laravel\Dusk\Browser;

class LoginPage extends Page
{

    public function url()
    {
        return '/admin';
    }


    public function assert(Browser $browser)
    {
        //
    }

    public function attemptSignIn(Browser $browser, $inputs)
    {
        /*
        echo "\n"."==========Inputs============"."\n";
        print_r($inputs);
        echo "==========End of Inputs====="."\n";
        */

        $browser->waitForText('Sign In');
        $browser->type('@signin-username_or_email', $inputs['email']);
        $browser->type('@signin-password', $inputs['password']);
        $browser->press('@signin-signin');
        $browser->waitFor('.toast', 1);
    }


}
