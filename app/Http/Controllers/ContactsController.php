<?php

namespace App\Http\Controllers;

use App\Contact;
use Illuminate\Http\File;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File as Storage;

class ContactsController extends Controller
{
    /**
     * Uploads a list of contacts into storage
     * for processing field mapping later.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function upload(Request $request)
    {
        if (!$request->hasFile('file')) {
            abort(400, 'Missing required file upload to import contacts.');
        }

        $file = $request->file('file');
        $fileName = $file->getClientOriginalName();
        $stream = $file->openFile();

        // Get the list of header fields
        $fieldNames = $stream->fgetcsv();

        // Count the number of contacts to import
        $itemCount = 0;
        while (!$stream->eof()) {
            if ($stream->fgetcsv() !== false) {
                $itemCount++;
            }
        }

        // Move the file to temporary storage folder
        $fileId = md5(time().$fileName);
        $file->storeAs('uploads', $fileId.'.csv');

        // Build up the initial field mapping for the import
        $fields = [];
        $coreFields = array_keys(Contact::CORE_FIELDS);
        foreach ($fieldNames as $fieldKey => $fieldName) {
            $fieldName = trim($fieldName);
            $fieldSlug = strtolower(str_replace(' ', '_', $fieldName));
            $fieldSlug = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $fieldSlug);
            $fieldMap = 'custom';

            if (in_array($fieldSlug, $coreFields)) {
                $fieldMap = $fieldSlug;
            }

            $fields[] = [
                'key'  => $fieldKey,
                'slug' => $fieldSlug,
                'name' => $fieldName,
                'map'  => $fieldMap,
            ];
        }

        return response()->json(compact('fileId', 'fileName', 'itemCount', 'fields'));
    }

    /**
     * Import a list of contacts using the stored
     * file and field mapping from the user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function import(Request $request)
    {
        if (!$request->has(['fileId', 'fields'])) {
            abort(400, 'Missing required input to import contacts.');
        }

        $fileId = $request->input('fileId');
        $filePath = storage_path('app/uploads').'/'.$fileId.'.csv';
        $file = new File($filePath);
        $stream = $file->openFile();
        $coreFields = array_keys(Contact::CORE_FIELDS);
        $fields = $request->input('fields');

        $count = 0;
        while (!$stream->eof()) {
            $count++;
            $data = $stream->fgetcsv();
            if ($data !== false) {
                if ($count === 1) {
                    // Skip the field headers from being imported
                    continue;
                }

                // Map the contact data to the proper fields
                $coreAttributes = [];
                $customAttributes = [];
                foreach ($fields as $field) {
                    $fieldKey = Arr::get($field, 'key');
                    $fieldSlug = Arr::get($field, 'slug');
                    $fieldName = Arr::get($field, 'name');
                    $fieldMap = Arr::get($field, 'map');
                    $fieldValue = Arr::get($data, $fieldKey);

                    if ($fieldMap !== 'custom') {
                        $coreAttributes[$fieldMap] = $fieldValue;
                    } else {
                        $customAttributes[$fieldName] = $fieldValue;
                    }
                }

                // Skip already imported contacts
                $phone = Arr::get($coreAttributes, 'phone');
                if (Contact::where('phone', $phone)->first()) {
                    continue;
                }

                $contact = Contact::create($coreAttributes);
                $contact->createCustomAttributes($customAttributes);
            }
        }

        // Delete the temporary file upload
        Storage::delete($filePath);

        return response()->json(['import' => true]);
    }
}
