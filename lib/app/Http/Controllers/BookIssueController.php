<?php declare(strict_types=1);

namespace App\Http\Controllers;

use App\DTO\BookIssues\BookIssueFilterDTO;
use App\DTO\BookIssues\RenderIssueModalDTO;
use App\DTO\BookIssues\StoreBookIssueDTO;
use App\DTO\BookIssues\UpdateBookIssueDTO;
use App\Http\Requests\BookIssueIndexRequest;
use App\Http\Requests\RenderIssueModalRequest;
use App\Http\Requests\StoreBookIssueRequest;
use App\Http\Requests\UpdateBookIssueRequest;
use App\Models\BookIssue;
use App\Services\BookIssueService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class BookIssueController extends Controller
{
    private int $perPage = 15;
    private string $page = 'issues';

    public function __construct(private readonly BookIssueService $service){}

    /**
     * Display a listing of the resource.
     */
    public function index(BookIssueIndexRequest $request): Factory|View
    {
        $filters = BookIssueFilterDTO::fromRequest($request);
        $issues = $this->service->index($filters, $this->perPage);

        return view('issues.index', ['issues' => $issues, 'pageLabel' => $this->page]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBookIssueRequest $request)
    {
        $dto = StoreBookIssueDTO::fromArray($request->validated());

        $this->service->store($dto);

        return back()->with('status', 'Выдача книги оформлена.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBookIssueRequest $request, BookIssue $issue)
    {
        $dto = UpdateBookIssueDTO::fromArray($request->validated());
        $this->service->update($issue, $dto);
        return redirect()
            ->back()
            ->with('status', 'Выдача книги обновлена.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BookIssue $issue)
    {
        $bookName = $this->service->destroy($issue);

        return back()->with(
            'status',
            "Книга «{$bookName}» возвращена в библиотеку, запись о выдаче удалена из списка и отправлена в архив."
        );
    }

    public function renderModal(RenderIssueModalRequest $request)
    {
        $dto = RenderIssueModalDTO::fromArray($request->validated());

        $data = $this->service->renderModal($dto);

        return view('components.issue-book-modal', $data);
    }
}
