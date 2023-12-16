# laravel-ide-helper-use-memo
PHP8.2 + Laravel 10.x + Postgresql 16.x の開発環境において、laravel-ide-helperを使ったモデルクラスへのPHPDocの補完を行う際に詰まった内容についてまとめる

## テーブル構成

- User
  - Company
    - Achievement
    - Staff

- UserとCompanyは`hasOne(1:1)`の関係
- CompanyとAchievementは`hasMany(1:n)`の関係
- CompanyとStaffは`hasMany(1:n)`の関係
- AchievementとStaffはテーブル名以外は全く同一の構造

それぞれのテーブルを作成するマイグレーションは以下の通り
```php:create_companies_table.php
Schema::create('companies', function (Blueprint $table) {
    $table->comment('会社');
    $table->bigIncrements('id')->comment('会社ID');
    $table->foreignId('user_id')->comment('ユーザーID')->constrained('users')->onDelete('cascade');
    $table->integer('col1')->comment('カラム1');
    $table->integer('col2')->nullable()->comment('カラム2');
    $table->timestamps();
    $table->softDeletes();
});
```
```php:create_achievements_table.php
Schema::create('achievements', function (Blueprint $table) {
    $table->comment('実績');
    $table->bigIncrements('id')->comment('実績ID');

    // ↓not foreign key. just a relation column.
    $table->bigInteger('company_id')->comment('会社ID');

    // ↓foreign key.
    // $table->foreignId('company_id')->comment('会社ID')->constrained('companies')->onDelete('cascade');

    $table->string('col1')->comment('カラム1');
    $table->string('col2')->nullable()->comment('カラム2');
    $table->timestamps();
    $table->softDeletes();
});
```
```php:create_staffs_table.php
Schema::create('staffs', function (Blueprint $table) {
    $table->comment('スタッフ');
    $table->bigIncrements('id')->comment('スタッフID');

    // ↓not foreign key. just a relation column.
    $table->bigInteger('company_id')->comment('会社ID');

    // ↓foreign key.
    // $table->foreignId('company_id')->comment('会社ID')->constrained('companies')->onDelete('cascade');

    $table->string('col1')->comment('カラム1');
    $table->string('col2')->nullable()->comment('カラム2');
    $table->timestamps();
    $table->softDeletes();
});
```

このとき `php artisan ide-helper:models --write --reset` によって各モデルのPHPDocを補完を行ったところ以下のようになった

```php:Achievement.php
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
```
```php:Staff.php
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
```

- それぞれテーブルのカラムに対応する適切な@propertyのアノテーションがついている
- 親(Company)を参照する@property-readのアノテーションについて従属するテーブルでありながらnullを取りうる状態`\App\Models\Company|null`となっている

`↑で挙げた状態は当リポジトリのmasterブランチで確認できます。`

## 検証1 - Achievementのマイグレーションについて正しく外部キーを貼る

1. `create_achievements_table.php` について以下のとおり修正
```diff
Schema::create('achievements', function (Blueprint $table) {
    $table->comment('実績');
    $table->bigIncrements('id')->comment('実績ID');

    // ↓not foreign key. just a relation column.
-   $table->bigInteger('company_id')->comment('会社ID');
+   // $table->bigInteger('company_id')->comment('会社ID');

    // ↓foreign key.
-   // $table->foreignId('company_id')->comment('会社ID')->constrained('companies')->onDelete('cascade');
+   $table->foreignId('company_id')->comment('会社ID')->constrained('companies')->onDelete('cascade');

    $table->string('col1')->comment('カラム1');
    $table->string('col2')->nullable()->comment('カラム2');
    $table->timestamps();
    $table->softDeletes();
});
```
2. `php artisan ide-helper:models --write --reset` 実行後のモデル差異
```diff
/**
 * App\Models\Achievement
 *
 * @property int $id 実績ID
~~~省略~~~
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
- * @property-read \App\Models\Company|null $company
+ * @property-read \App\Models\Company $company
 * @method static \Database\Factories\AchievementFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Achievement newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Achievement newQuery()
~~~省略~~~
```
```diff
/**
 * App\Models\Staff
 *
 * @property int $id スタッフID
~~~省略~~~
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
- * @property-read \App\Models\Company|null $company
+ * @property-read \App\Models\Company $company
 * @method static \Database\Factories\StaffFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Staff newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Staff newQuery()
~~~省略~~~
```

- 外部キーを貼ったAchievementについて@property-readアノテーションが「Company|null → Company」となった
- 修正を加えていないStaffについて@property-readアノテーションが「Company|null → Company」となった

---
- `↑で挙げた状態はfix-achievement-foreign-keyブランチで実際に確認できます。` → [fix-achievement-foreign-key](https://github.com/imo-tikuwa/laravel-ide-helper-use-memo/tree/fix-achievement-foreign-key)
- あるいは以下のリンクのコミットの差分からも確認できます。 → [compare master&fix-achievement-foreign-key](https://github.com/imo-tikuwa/laravel-ide-helper-use-memo/compare/cb56abd9d8ddc43a42ac1faa56d27defb78a22e3...fix-achievement-foreign-key?diff=unified&w=)

## 検証2 - Staffのマイグレーションについて正しく外部キーを貼る

1. `create_staffs_table.php` について以下のとおり修正
```diff
Schema::create('staffs', function (Blueprint $table) {
    $table->comment('スタッフ');
    $table->bigIncrements('id')->comment('スタッフID');

    // ↓not foreign key. just a relation column.
-   $table->bigInteger('company_id')->comment('会社ID');
+   // $table->bigInteger('company_id')->comment('会社ID');

    // ↓foreign key.
-   // $table->foreignId('company_id')->comment('会社ID')->constrained('companies')->onDelete('cascade');
+   $table->foreignId('company_id')->comment('会社ID')->constrained('companies')->onDelete('cascade');

    $table->string('col1')->comment('カラム1');
    $table->string('col2')->nullable()->comment('カラム2');
    $table->timestamps();
    $table->softDeletes();
});
```
2. `php artisan ide-helper:models --write --reset` 実行後のモデル差異
```diff
/**
 * App\Models\Staff
 *
 * @property int $id スタッフID
~~~省略~~~
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
- * @property-read \App\Models\Company|null $company
+ * @property-read \App\Models\Company $company
 * @method static \Database\Factories\StaffFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Staff newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Staff newQuery()
~~~省略~~~
```

- 外部キーを貼ったStaffについて@property-readアノテーションが「Company|null → Company」となった
- 検証1とは異なり、修正を加えていないAchievementの@property-readアノテーションは「Company|null」のままとなった

---
- `↑で挙げた状態はfix-staff-foreign-keyブランチで実際に確認できます。` → [fix-staff-foreign-key](https://github.com/imo-tikuwa/laravel-ide-helper-use-memo/tree/fix-staff-foreign-key)
- あるいは以下のリンクのコミットの差分からも確認できます。 → [compare master&fix-staff-foreign-key](https://github.com/imo-tikuwa/laravel-ide-helper-use-memo/compare/cb56abd9d8ddc43a42ac1faa56d27defb78a22e3...fix-staff-foreign-key?diff=unified&w=)

## 検証3 - Achievementのマイグレーションについて正しく外部キーを貼った状態で、ide-helper.phpでAchievementについて補完の対象外とする
1. マイグレーションファイルを検証1の状態としたうえで、laravel-ide-helperの設定ファイル(config/ide-helper.php)を以下の通り修正
```diff
return [
    // 省略

    /*
    |--------------------------------------------------------------------------
    | Models to ignore
    |--------------------------------------------------------------------------
    |
    | Define which models should be ignored.
    |
    */

    'ignored_models' => [
        // User::class,
        // Company::class,
-        // Achievement::class,
+        Achievement::class,
        // Staff::class
    ],

    // 省略
]
```
2. `php artisan ide-helper:models --write --reset` 実行後のモデル差異
```diff
/**
 * App\Models\Staff
 *
 * @property int $id スタッフID
~~~省略~~~
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
- * @property-read \App\Models\Company|null $company
+ * @property-read \App\Models\Company $company
 * @method static \Database\Factories\StaffFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Staff newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Staff newQuery()
~~~省略~~~
```

- 外部キーを貼ったAchievementはide-helper.phpで補完の対象外としているため変化なし
- 修正を加えていないStaffについて@property-readアノテーションが「Company|null → Company」となった

---
- `↑で挙げた状態はfix-achievement-foreign-key2ブランチで実際に確認できます。` → [fix-achievement-foreign-key2](https://github.com/imo-tikuwa/laravel-ide-helper-use-memo/tree/fix-achievement-foreign-key2)
- あるいは以下のリンクのコミットの差分からも確認できます。 → [compare master&fix-achievement-foreign-key2](https://github.com/imo-tikuwa/laravel-ide-helper-use-memo/compare/cb56abd9d8ddc43a42ac1faa56d27defb78a22e3...fix-achievement-foreign-key2?diff=unified&w=)

## 検証1~3についてまとめ、どうするべきか等
- ここまでの検証結果を経て、外部キーを適切に貼っていないモデルについて従属(子)する側のモデルの@property-readアノテーションがあってほしい形にならないことを確認
- また、laravel-ide-helperのModelCommandの中で先に処理したモデルから外部キーに関する設定を検知した場合に、別のモデルに対してもその設定を反映するキャッシュのような仕組みが存在することを確認
- いずれにしても各テーブルのマイグレーションについて外部キーをしっかり設定することでlaravel-ide-helperはあってほしい形の@property-readアノテーションを貼ってくれる
  - 各テーブルの`〇〇_id`カラムについて外部キーを設定していなかった理由はそれはそれであったはず（おそらくartisan migrateやファクトリーによるテストデータの作成が複雑化し、いいかげんなテストデータの生成が許容できなくなるあたり）
  - ファクトリーを使用したテストデータの作成について考慮すべき点が増えるが、DBのカスケードデリートなどを使用した、不要なデータが残り続けない開発を行えるという明確なメリットが存在する。そのためどうしてもという理由が無い限りは”外部キー風”のカラムは作らずに正しく外部キーを貼るべき、と思った
