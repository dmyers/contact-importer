<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Http\Testing\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class ContactTest extends TestCase
{
    use WithFaker;

    /**
     * Test uploading a CSV file and importing
     * contacts from mapped fields.
     *
     * @return void
     */
    public function testImport()
    {
        Storage::fake();

        $contactCount = 100;
        $fileName = 'contacts.csv';
        $fileData = [
            ['First Name', 'Last Name', 'Email', 'Phone'],
        ];
        $fileData = array_merge($fileData, $this->fakeContacts($contactCount));

        $file = $this->fakeCsvFile($fileName, $fileData);

        $response = $this->post('contacts/upload', compact('file'));
        $response->assertStatus(200);
        $response->assertJsonPath('fileName', $fileName);
        $response->assertJsonPath('itemCount', $contactCount);

        $fileId = $response->json('fileId');
        $fields = $response->json('fields');
        Storage::assertExists('uploads/'.$fileId.'.csv');

        $response = $this->post('contacts/import', compact('fileId', 'fields'));
        $response->assertStatus(200);
        $response->assertJsonPath('import', true);

        Storage::assertMissing('uploads/'.$fileId.'.csv');

        $this->assertDatabaseHas('contacts', [
            'phone' => $fileData[1][3],
        ]);
    }

    /**
     * Create list of fake contacts.
     *
     * @param  int  $count
     * @return array
     */
    protected function fakeContacts($count = 100)
    {
        $contacts = [];

        for ($i = 0; $i < $count; $i++) {
            $contacts[] = $this->fakeContact();
        }

        return $contacts;
    }

    /**
     * Create a fake contact.
     *
     * @return array
     */
    protected function fakeContact()
    {
        return [
            0 => $this->faker->firstName(),
            1 => $this->faker->lastName(),
            2 => $this->faker->email(),
            3 => $this->faker->phoneNumber(),
        ];
    }

    /**
     * Create a new fake CSV file.
     *
     * @param  string  $name
     * @param  array  $data
     * @return \Illuminate\Http\Testing\File
     */
    protected function fakeCsvFile($name, array $data)
    {
        return new File($name, $this->generateCsv($data));
    }

    /**
     * Generate a dummy CSV with the given data.
     *
     * @param  array  $data
     * @return resource
     */
    protected function generateCsv(array $data)
    {
        return tap(tmpfile(), function ($temp) use ($data) {
            // Write out the CSV field headers first
            $headers = $data[0];
            $headerCsv = implode(',', $headers);
            unset($data[0]);
            fwrite($temp, $headerCsv);

            // Write out the CSV field values
            collect($data)->each(function ($values) use ($temp) {
                fwrite($temp, "\n");
                $valueCsv = implode(',', $values);
                fwrite($temp, $valueCsv);
            });
        });
    }
}
