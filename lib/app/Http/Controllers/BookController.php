<?php declare(strict_types=1);

namespace App\Http\Controllers;

use App\DTO\Books\BookDTO;
use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;
use App\Models\Book;
use App\Services\BookService;
use Illuminate\Http\Request;

class BookController extends Controller
{
    private int $perPage = 15;
    private string $page = 'books';

    public function __construct(private readonly BookService $service) {}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('books.index', [
            'books' => $this->service->index(),
            'pageLabel' => $this->page,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        return view('books.create', [
            'authors' => $this->service->getAuthorsForCreate($request->old('author_ids', [])),
            'pageLabel' => $this->page,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBookRequest $request)
    {
        $dto = BookDTO::fromArray($request->validated());
        $book = $this->service->create($dto);

        return redirect()
            ->route('books.show', $book)
            ->with(
                'status',
                "Книга «{$book->name}» добавлена."
            );
    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book)
    {
        return view('books.show', [
            'book' => $book->load('authors'),
            'pageLabel' => $this->page
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Book $book)
    {
        return view('books.edit', [
            'book' => $book,
            'authors' => $this->service->getAuthorsForEdit($book, $request->old('author_ids', [])),
            'pageLabel' => $this->page,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBookRequest $request, Book $book)
    {
        $dto = BookDTO::fromArray($request->validated());
        $updatedBook = $this->service->update($book, $dto);

        return redirect()
            ->route('books.show', $updatedBook)
            ->with('status', "Книга «{$updatedBook->name}» обновлена.");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        $bookName = $book->name;

        $this->service->destroy($book);

        return redirect()
            ->route('books.index')
            ->with(
                'status',
                "Книга «{$bookName}» удалена."
            );
    }
}
