<?php

namespace App\Http\Controllers;

use App\Models\Entry;
use App\Services\SearchService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SearchController
{
    public function handleSearch (Request $request)
    {
        $searchService = new SearchService();

        return $searchService->index($request);
    }
}
