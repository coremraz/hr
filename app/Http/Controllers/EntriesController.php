<?php

namespace App\Http\Controllers;

use App\Models\Entry;
use Illuminate\Http\Request;

//TODO зарефакторить

class EntriesController
{
    public function addEntry(Request $request)
    {

        $phone = $request->input('phone');
        $type = $request->input('type');

        $entry = new Entry();
        $entry->phone = "7" . $phone;
        $entry->type = $type;
        $entry->save();

        return response()->json(['message' => 'Successfully saved']);
    }

    public function deleteEntry(Request $request)
    {
        $entry = Entry::findOrFail($request->input('entryId'));
        $entry->delete();

        return response()->json(['message' => 'Successfully deleted']);
    }

    public function getEntries()
    {
        $entries = Entry::all();
        $deletedEntries = Entry::onlyTrashed()->get();

        return response()->json([
            'message' => 'Successfully saved',
            'entries' => $entries,
            'deletedEntries' => $deletedEntries
        ]);
    }
}
