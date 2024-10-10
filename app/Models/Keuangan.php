<?php
/**
 * Budi Prastyo <budi@prastyo.com>
 * created_at : 2024-10-10 17:36:07
 */

namespace App\Models;

use Carbon\Carbon;
use App\Traits\HasUserStamp;
use App\Enums\JenisKeuanganEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Keuangan extends Model
{
    /** @use HasFactory<\Database\Factories\KeuanganFactory> */
    use HasFactory; // To enable model factories for creating model instances easily during testing or seeding.
    use SoftDeletes; // allows you to 'mark' data as deleted without permanently removing it from the database
    use HasUserStamp; // Automatically sets created_by and updated_by fields based on the authenticated user during model creation and updates

    /**
     * The table associated with the model.
     * By default, Laravel assumes the table name is the plural form of the model's class name.
     */
    protected $table    = 'keuangan';

    /**
     * The attributes that are eligible for mass assignment without explicitly 
     * defining request or database column names (e.g., during `create()` or `update()` operations).
     */
    protected $fillable = [
                            'keterangan',
                            'tahun_anggaran',
                            'jenis_keuangan',
                            'nilai_anggaran',
                            'nilai_realisasi',
                            'tanggal_kuitansi'
                        ];

    // Defines how attributes should be converted when retrieving or setting data
    protected function casts(): array
    {
        return [
                'tanggal_kuitansi'    => 'date',
                'jenis_keuangan'      => JenisKeuanganEnum::class
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

    // deleted_at serves as an indicator that the record has been temporarily removed from the database
    protected function nilaiAnggaran(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => number_format($value, 0, ',', '.')
        );
    }

    // deleted_at serves as an indicator that the record has been temporarily removed from the database
    protected function nilaiRealisasi(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => number_format($value, 0, ',', '.')
        );
    }

    // Mutator Accessor to change date format when data is retrieved and edited
    protected function tanggalKuitansi(): Attribute
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