<?php
/**
 * Budi Prastyo <budi@prastyo.com>
 * created_at : 2024-10-10 17:36:07
 */

namespace App\Models;

use Carbon\Carbon;
use App\Traits\HasUserStamp;
use App\Enums\JenisKelaminEnum;
use App\Enums\AkteKelahiranEnum;
use App\Enums\StatusPendudukEnum;
use App\Enums\IdentitasElektronikEnum;
use App\Enums\KelainanFisikMentalEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Penduduk extends Model
{
    /** @use HasFactory<\Database\Factories\PendudukFactory> */
    use HasFactory; // To enable model factories for creating model instances easily during testing or seeding.
    use SoftDeletes; // allows you to 'mark' data as deleted without permanently removing it from the database
    use HasUserStamp; // Automatically sets created_by and updated_by fields based on the authenticated user during model creation and updates

    /**
     * The table associated with the model.
     * By default, Laravel assumes the table name is the plural form of the model's class name.
     */
    protected $table    = 'penduduk';

    /**
     * The attributes that are eligible for mass assignment without explicitly 
     * defining request or database column names (e.g., during `create()` or `update()` operations).
     */
    protected $fillable = [
                            'rt',
                            'rw',
                            'nik',
                            'nama',
                            'email',
                            'alamat',
                            'telepon',
                            'kodepos',
                            'nik_ibu',
                            'suku_id',
                            'agama_id',
                            'nik_ayah',
                            'nama_ibu',
                            'kawin_id',
                            'cacat_id',
                            'nama_ayah',
                            'kursus_id',
                            'bahasa_id',
                            'asuransi_id',
                            'tempat_lahir',
                            'pekerjaan_id',
                            'tanggal_lahir',
                            'jenis_kelamin',
                            'pendidikan_id',
                            'akte_kelahiran',
                            'akseptor_kb_id',
                            'warganegara_id',
                            'status_penduduk',
                            'status_dasar_id',
                            'sakit_menahun_id',
                            'golongan_darah_id',
                            'identitas_elektronik',
                            'hubungan_keluarga_id',
                            'kelainan_fisik_mental'
                        ];

    // Defines how attributes should be converted when retrieving or setting data
    protected function casts(): array
    {
        return [
                'tanggal_lahir'            => 'date',
                'jenis_kelamin'            => JenisKelaminEnum::class,
                'akte_kelahiran'           => AkteKelahiranEnum::class,
                'status_penduduk'          => StatusPendudukEnum::class,
                'identitas_elektronik'     => IdentitasElektronikEnum::class,
                'kelainan_fisik_mental'    => KelainanFisikMentalEnum::class
            ];
    }

    /**
     * Define a belongsTo relationship between the current model and the related model.
     * This indicates that the current model holds the foreign key of the related model.
     */

    public function agama(): BelongsTo
    {
        return $this->belongsTo(DataAgama::class, 'agama_id');
    }

    public function hubungan_keluarga(): BelongsTo
    {
        return $this->belongsTo(DataHubunganKeluarga::class, 'hubungan_keluarga_id');
    }

    public function pendidikan(): BelongsTo
    {
        return $this->belongsTo(DataPendidikan::class, 'pendidikan_id');
    }

    public function kawin(): BelongsTo
    {
        return $this->belongsTo(DataKawin::class, 'kawin_id');
    }

    public function akseptor_kb(): BelongsTo
    {
        return $this->belongsTo(DataAkseptorKb::class, 'akseptor_kb_id');
    }

    public function pekerjaan(): BelongsTo
    {
        return $this->belongsTo(DataPekerjaan::class, 'pekerjaan_id');
    }

    public function sakit_menahun(): BelongsTo
    {
        return $this->belongsTo(DataSakitMenahun::class, 'sakit_menahun_id');
    }

    public function cacat(): BelongsTo
    {
        return $this->belongsTo(DataCacat::class, 'cacat_id');
    }

    public function golongan_darah(): BelongsTo
    {
        return $this->belongsTo(DataGolonganDarah::class, 'golongan_darah_id');
    }

    public function warganegara(): BelongsTo
    {
        return $this->belongsTo(DataWarganegara::class, 'warganegara_id');
    }

    public function asuransi(): BelongsTo
    {
        return $this->belongsTo(DataAsuransi::class, 'asuransi_id');
    }

    public function status_dasar(): BelongsTo
    {
        return $this->belongsTo(DataStatusDasar::class, 'status_dasar_id');
    }

    public function suku(): BelongsTo
    {
        return $this->belongsTo(DataSuku::class, 'suku_id');
    }

    public function kursus(): BelongsTo
    {
        return $this->belongsTo(DataKursu::class, 'kursus_id');
    }

    public function bahasa(): BelongsTo
    {
        return $this->belongsTo(DataBahasa::class, 'bahasa_id');
    }

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

    public function kelahiran(): hasMany
    {
        return $this->hasMany(Kelahiran::class, 'ibu_id');
    }

    public function perangkat(): hasMany
    {
        return $this->hasMany(Perangkat::class, 'penduduk_id');
    }

    // Mutator Accessor to change date format when data is retrieved and edited
    protected function tanggalLahir(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value ? Carbon::parse($value)->locale(app()->getLocale())->isoFormat('D MMMM YYYY') : null, //to display the day, full month name, and year (e.g., "5 September 2024")
            set: fn ($value) => $value ? Carbon::createFromFormat('d-m-Y', $value)->format('Y-m-d') : null // Store in the database using the Y-m-d format
        );
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