<?php declare(strict_types=1);

namespace App\Models;

use App\Enums\BookIssueStatus;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class BookIssue
 * @package App\Models
 * @property int id
 * @property Carbon return_to
 * @property Carbon deleted_at
 * @property Carbon created_at
 * @property Carbon updated_at
 * @property BookIssueStatus status
 * @property Book book
 * @property User reader
 */
class BookIssue extends Model
{
    /** @use HasFactory<\Database\Factories\BookIssueFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'book_id',
        'user_id',
        'return_to',
        'status'
    ];

    protected $casts = [
        'status' => BookIssueStatus::class,
        'return_to' => 'datetime',
        'created_at' => 'datetime'
    ];

    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }

    public function reader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
