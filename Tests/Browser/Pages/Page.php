<?php

namespace WebReinvent\VaahCms\Tests\Browser\Pages;

use Laravel\Dusk\Page as BasePage;

abstract class Page extends BasePage
{
    /**
     * Get the global element shortcuts for the site.
     *
     * @return array
     */
    public static function siteElements()
    {
        return [
            '@signin-username_or_email' => '@signin-username_or_email',
            '@signin-password' => '@signin-password',
        ];
    }
}
