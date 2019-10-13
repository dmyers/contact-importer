<?php

namespace Tests\Browser\Pages;

use Laravel\Dusk\Browser;

class HomePage extends Page
{
    /**
     * Get the URL for the page.
     *
     * @return string
     */
    public function url()
    {
        return '/';
    }

    /**
     * Assert that the browser is on the page.
     *
     * @param  \Laravel\Dusk\Browser  $browser
     * @return void
     */
    public function assert(Browser $browser)
    {
        $browser->assertSee('Contact Importer');
    }

    /**
     * Get the element shortcuts for the page.
     *
     * @return array
     */
    public function elements()
    {
        return [
            '@element' => '#selector',
        ];
    }

    /**
     * Import contacts from a CSV file.
     *
     * @param  \Laravel\Dusk\Browser  $browser
     * @return void
     */
    public function importContacts(Browser $browser)
    {
        $browser->attach('file', base_path('tests/fixtures/contacts.csv'));
    }

    /**
     * Map contact fields to finish import.
     *
     * @param  \Laravel\Dusk\Browser  $browser
     * @return void
     */
    public function mapContactFields(Browser $browser)
    {
        $browser->waitForText('Map Contact Fields', 1)
            ->press('Import Contacts');
    }
}
