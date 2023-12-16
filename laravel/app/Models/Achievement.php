<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Achievement
 *
 * @property int $id 実績ID
 * @property int $company_id 会社ID
 * @property string $col1 カラム1
 * @property string|null $col2 カラム2
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Company|null $company
 * @method static \Database\Factories\AchievementFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Achievement newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Achievement newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Achievement onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Achievement query()
 * @method static \Illuminate\Database\Eloquent\Builder|Achievement whereCol1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Achievement whereCol2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Achievement whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Achievement whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Achievement whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Achievement whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Achievement whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Achievement withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Achievement withoutTrashed()
 * @mixin \Eloquent
 */
class Achievement extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'achievements';

    /**
     * @return BelongsTo<Company, Achievement>
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
}
