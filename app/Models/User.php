<?php
/**
 * Budi Prastyo <budi@prastyo.com>
 * created_at : 2024-10-10 17:36:07
 */

namespace App\Models;

use Carbon\Carbon;
use App\Traits\HasUserStamp;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasRoles; // To add role-based authorization functionality to the class.
    use HasFactory; // To enable model factories for creating model instances easily during testing or seeding.
    use Notifiable; // To allow the class to send notifications, such as email or SMS notifications.
    use SoftDeletes; // allows you to 'mark' data as deleted without permanently removing it from the database
    use HasUserStamp; // Automatically sets created_by and updated_by fields based on the authenticated user during model creation and updates

    /**
     * The table associated with the model.
     * By default, Laravel assumes the table name is the plural form of the model's class name.
     */
    protected $table    = 'users';

    /**
     * The attributes that are eligible for mass assignment without explicitly 
     * defining request or database column names (e.g., during `create()` or `update()` operations).
     */
    protected $fillable = [
                            'bio',
                            'name',
                            'email',
                            'username',
                            'password'
                        ];

    // The attributes that should be hidden for arrays.
    protected $hidden = [
                            'password',
                            'remember_token'
                        ];

    // Defines how attributes should be converted when retrieving or setting data
    protected function casts(): array
    {
        return [
                'password'             => 'hashed',
                'email_verified_at'    => 'datetime'
            ];
    }

    /**
     * Define a belongsTo relationship between the current model and the related model.
     * This indicates that the current model holds the foreign key of the related model.
     */

    public function created_by(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updated_by(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function deleted_by(): BelongsTo
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }

    /**
     * Define a hasMany relationship between the current model and the related model.
     * This indicates that the current model can have multiple instances of the related model.
     */

    public function dataAgama(): hasMany
    {
        return $this->hasMany(DataAgama::class, 'deleted_by');
    }

    public function dataAkseptorKb(): hasMany
    {
        return $this->hasMany(DataAkseptorKb::class, 'deleted_by');
    }

    public function dataAsuransi(): hasMany
    {
        return $this->hasMany(DataAsuransi::class, 'deleted_by');
    }

    public function dataBahasa(): hasMany
    {
        return $this->hasMany(DataBahasa::class, 'deleted_by');
    }

    public function dataCacat(): hasMany
    {
        return $this->hasMany(DataCacat::class, 'deleted_by');
    }

    public function dataGolonganDarah(): hasMany
    {
        return $this->hasMany(DataGolonganDarah::class, 'deleted_by');
    }

    public function dataHubunganKeluarga(): hasMany
    {
        return $this->hasMany(DataHubunganKeluarga::class, 'deleted_by');
    }

    public function dataJabatan(): hasMany
    {
        return $this->hasMany(DataJabatan::class, 'deleted_by');
    }

    public function dataJenisPersalinan(): hasMany
    {
        return $this->hasMany(DataJenisPersalinan::class, 'deleted_by');
    }

    public function dataKawin(): hasMany
    {
        return $this->hasMany(DataKawin::class, 'deleted_by');
    }

    public function dataKursu(): hasMany
    {
        return $this->hasMany(DataKursu::class, 'deleted_by');
    }

    public function dataPekerjaan(): hasMany
    {
        return $this->hasMany(DataPekerjaan::class, 'deleted_by');
    }

    public function dataPendidikan(): hasMany
    {
        return $this->hasMany(DataPendidikan::class, 'deleted_by');
    }

    public function dataPenolongKelahiran(): hasMany
    {
        return $this->hasMany(DataPenolongKelahiran::class, 'deleted_by');
    }

    public function dataSakitMenahun(): hasMany
    {
        return $this->hasMany(DataSakitMenahun::class, 'deleted_by');
    }

    public function dataStatusDasar(): hasMany
    {
        return $this->hasMany(DataStatusDasar::class, 'deleted_by');
    }

    public function dataSuku(): hasMany
    {
        return $this->hasMany(DataSuku::class, 'deleted_by');
    }

    public function dataTempatDilahirkan(): hasMany
    {
        return $this->hasMany(DataTempatDilahirkan::class, 'deleted_by');
    }

    public function dataWarganegara(): hasMany
    {
        return $this->hasMany(DataWarganegara::class, 'deleted_by');
    }

    public function kelahiran(): hasMany
    {
        return $this->hasMany(Kelahiran::class, 'deleted_by');
    }

    public function keuangan(): hasMany
    {
        return $this->hasMany(Keuangan::class, 'deleted_by');
    }

    public function penduduk(): hasMany
    {
        return $this->hasMany(Penduduk::class, 'deleted_by');
    }

    public function perangkat(): hasMany
    {
        return $this->hasMany(Perangkat::class, 'deleted_by');
    }

    public function user(): hasMany
    {
        return $this->hasMany(User::class, 'deleted_by');
    }

    //Change the date format to make it easier for the user to understand
    protected function createdAt(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value ? Carbon::parse($value)->locale(app()->getLocale())->isoFormat('D MMMM YYYY H:mm') : null,
        );
    }

    protected function updatedAt(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value ? Carbon::parse($value)->locale(app()->getLocale())->isoFormat('D MMMM YYYY H:mm') : null,
        );
    }

    // deleted_at serves as an indicator that the record has been temporarily removed from the database
    protected function deletedAt(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value ? Carbon::parse($value)->locale(app()->getLocale())->isoFormat('D MMMM YYYY H:mm') : null,
        );
    }
}