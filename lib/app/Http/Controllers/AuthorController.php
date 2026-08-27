<?php declare(strict_types=1);

namespace App\Http\Controllers;

use App\DTO\Authors\AuthorDTO;
use App\Http\Requests\StoreAuthorRequest;
use App\Http\Requests\UpdateAuthorRequest;
use App\Models\Author;
use App\Services\AuthorService;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    private int $perPage = 15;
    private string $page = 'authors';

    public function __construct(private readonly AuthorService $service) {}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('authors.index', [
            'authors' => $this->service->index(),
            'pageLabel' => $this->page,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        return view('authors.create', [
            'pageLabel' => $this->page,
            'books' => $this->service->getBooksForCreate($request->old('books_ids', [])),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAuthorRequest $request)
    {
        $dto = AuthorDTO::fromArray($request->validated());

        $author = $this->service->create($dto);

        return redirect()
            ->route('authors.show', $author)
            ->with(
                'status',
                "Автор «{$author->full_name}» добавлен."
            );
    }

    /**
     * Display the specified resource.
     */
    public function show(Author $author)
    {
        return view('authors.show', [
            'author' => $author->load('books'),
            'pageLabel' => $this->page
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Author $author)
    {
        return view('authors.edit', [
            'pageLabel' => $this->page,
            'author' => $author,
            'books' => $this->service->getBooksForEdit($author, $request->old('books_ids', [])),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAuthorRequest $request, Author $author)
    {
        $dto = AuthorDTO::fromArray($request->validated());
        $updatedAuthor = $this->service->update($author, $dto);

        return redirect()
            ->route('authors.show', $updatedAuthor)
            ->with(
                'status',
                "Автор «{$updatedAuthor->full_name}» обновлен."
            );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Author $author)
    {
        $this->service->destroy($author);

        return redirect()
            ->route('authors.index')
            ->with(
                'status',
                "Автор «{$author->full_name}» удален."
            );
    }
}
