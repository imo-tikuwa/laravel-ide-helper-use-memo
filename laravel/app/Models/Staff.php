<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Staff
 *
 * @property int $id スタッフID
 * @property int $company_id 会社ID
 * @property string $col1 カラム1
 * @property string|null $col2 カラム2
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Company|null $company
 * @method static \Database\Factories\StaffFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Staff newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Staff newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Staff onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Staff query()
 * @method static \Illuminate\Database\Eloquent\Builder|Staff whereCol1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Staff whereCol2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Staff whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Staff whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Staff whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Staff whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Staff whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Staff withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Staff withoutTrashed()
 * @mixin \Eloquent
 */
class Staff extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'staffs';

    /**
     * @return BelongsTo<Company, Staff>
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
}
