<?php declare(strict_types=1);

namespace App\Models;

use App\Enums\Gender;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

/**
 * Class Author
 * @package App\Models
 * @property int id
 * @property string first_name
 * @property string second_name
 * @property Gender gender
 * @property Carbon deleted_at
 * @property Carbon created_at
 * @property Carbon updated_at
 * @property string full_name
 * @property string search_value
 * @property string pic
 * @property Collection books
 */
class Author extends Model
{
    /** @use HasFactory<\Database\Factories\AuthorFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'first_name',
        'second_name',
        'gender',
    ];

    protected $appends = ['full_name', 'pic'];

    protected $casts = ['gender' => Gender::class];

    public function books(): BelongsToMany
    {
        return $this->belongsToMany(Book::class);
    }

    public function getFullNameAttribute(): string
    {
        return trim("{$this->first_name} {$this->second_name}");
    }

    public function getPicAttribute(): string
    {
        $path = $this->gender === Gender::MALE ? 'img/male.png' : 'img/female.png';
        return Storage::disk('public')->url($path);
    }
}
