<?php declare(strict_types=1);

namespace App\Http\Controllers;

use App\DTO\Search\SearchDTO;
use App\Http\Requests\SearchRequest;
use App\Services\SearchService;


class SearchController extends Controller
{
    public function __construct(private readonly SearchService $service) {}

    public function searchAuthors(SearchRequest $request)
    {
        $dto = SearchDTO::fromArray($request->validated());

        return view('components.item-search-results', [
            'items' => $this->service->authors($dto)
        ]);
    }

    public function searchBooks(SearchRequest $request)
    {
        $dto = SearchDTO::fromArray($request->validated());

        return view('components.item-search-results', [
            'items' => $this->service->books($dto),
        ]);
    }

    public function searchReaders(SearchRequest $request)
    {
        $dto = SearchDTO::fromArray($request->validated());

        return view('components.item-search-results', [
            'items' => $this->service->readers($dto),
        ]);
    }
}
