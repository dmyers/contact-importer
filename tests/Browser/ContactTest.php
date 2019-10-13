<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\HomePage;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ContactTest extends DuskTestCase
{
    /**
     * Test uploading a CSV file and importing
     * contacts from mapped fields.
     *
     * @return void
     */
    public function testImport()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new HomePage)
                ->importContacts()
                ->mapContactFields()
                ->waitForText('Contacts Imported', 1)
                ->assertSee('Contacts Imported');
        });
    }
}
