<?php declare(strict_types=1);

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Book
 * @package App\Models
 * @property int id
 * @property string name
 * @property string isbn
 * @property int total
 * @property int publish_year
 * @property Carbon deleted_at
 * @property Carbon created_at
 * @property Carbon updated_at
 * @property string search_value
 * @property bool is_issued
 * @property Collection authors
 * @property Collection issues
 */
class Book extends Model
{
    /** @use HasFactory<\Database\Factories\BookFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'publish_year',
        'isbn',
        'total',
    ];

    protected $appends = ['is_issued'];

    protected $casts = ['publish_year' => 'integer'];

    public function authors(): BelongsToMany
    {
        return $this->belongsToMany(Author::class);
    }

    public function issues(): HasMany
    {
        return $this->hasMany(BookIssue::class);
    }

    public function getIsIssuedAttribute(): bool
    {
        return $this->total < 1;
    }
}
