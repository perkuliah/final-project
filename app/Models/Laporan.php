<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'judul',
        'pemasukan',
        'pengeluaran',
        'deskripsi',
        'tanggal',
        'gambar',
        'status',
        'respon',
        'lokasi' // Tambahkan lokasi
    ];

    protected $casts = [
        'tanggal' => 'date',
        'pemasukan' => 'integer',
        'pengeluaran' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Definisikan konstanta untuk status
    const STATUS_MENUNGGU = 'menunggu';
    const STATUS_Selesai = 'Selesai';
    const STATUS_Diproses = 'Diproses';

    // Definisikan daftar lokasi yang tersedia
    public static function getLokasiOptions()
    {
        return [
            'Salem',
            'Bentar',
            'Bentarsari',
            'Bumiayu',
            'Cilacap'
        ];
    }

    public static function getStatusOptions()
    {
        return [
            self::STATUS_MENUNGGU => 'Menunggu',
            self::STATUS_Selesai => 'Selesai',
            self::STATUS_Diproses => 'Diproses',
        ];
    }

    // Accessor untuk gambar
    protected function gambar(): Attribute
    {
        return Attribute::make(
            get: fn ($gambar) => $gambar ? asset('storage/laporan/' . $gambar) : asset('/images/no-image.png'),
        );
    }

    // Accessor untuk format lokasi
    protected function lokasiFormatted(): Attribute
    {
        return Attribute::make(
            get: fn ($value, $attributes) => $attributes['lokasi'] ?? 'Belum ditentukan',
        );
    }

    // Accessor untuk saldo (pemasukan - pengeluaran)
    protected function saldo(): Attribute
    {
        return Attribute::make(
            get: fn () => ($this->pemasukan ?? 0) - ($this->pengeluaran ?? 0),
        );
    }

    // Accessor untuk pemasukan formatted
    protected function pemasukanFormatted(): Attribute
    {
        return Attribute::make(
            get: fn () => 'Rp ' . number_format($this->pemasukan ?? 0, 0, ',', '.'),
        );
    }

    // Accessor untuk pengeluaran formatted
    protected function pengeluaranFormatted(): Attribute
    {
        return Attribute::make(
            get: fn () => 'Rp ' . number_format($this->pengeluaran ?? 0, 0, ',', '.'),
        );
    }

    // Accessor untuk saldo formatted
    protected function saldoFormatted(): Attribute
    {
        return Attribute::make(
            get: fn () => 'Rp ' . number_format($this->saldo, 0, ',', '.'),
        );
    }

    // Accessor untuk status formatted
    protected function statusFormatted(): Attribute
    {
        return Attribute::make(
            get: function () {
                return match($this->status) {
                    self::STATUS_Selesai => 'Selesai',
                    self::STATUS_Diproses => 'Diproses',
                    default => 'Menunggu',
                };
            }
        );
    }

    // Accessor untuk status badge color
    protected function statusColor(): Attribute
    {
        return Attribute::make(
            get: function () {
                return match($this->status) {
                    self::STATUS_Selesai => 'green',
                    self::STATUS_Diproses => 'red',
                    default => 'yellow',
                };
            }
        );
    }

    // Accessor untuk tanggal formatted
    protected function tanggalFormatted(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->tanggal->translatedFormat('d F Y'),
        );
    }

    // Scope untuk filtering
    public function scopeMenunggu($query)
    {
        return $query->where('status', self::STATUS_MENUNGGU);
    }

    public function scopeSelesai($query)
    {
        return $query->where('status', self::STATUS_Selesai);
    }

    public function scopeDiproses($query)
    {
        return $query->where('status', self::STATUS_Diproses);
    }

    public function scopeByLokasi($query, $lokasi)
    {
        return $query->where('lokasi', $lokasi);
    }

    public function scopeByBulan($query, $bulan, $tahun = null)
    {
        $tahun = $tahun ?? date('Y');
        return $query->whereYear('tanggal', $tahun)
                    ->whereMonth('tanggal', $bulan);
    }

    public function scopeSearch($query, $search)
    {
        return $query->where('judul', 'like', "%{$search}%")
                    ->orWhere('deskripsi', 'like', "%{$search}%")
                    ->orWhere('lokasi', 'like', "%{$search}%");
    }

    // Method untuk mengecek status
    public function isMenunggu(): bool
    {
        return $this->status === self::STATUS_MENUNGGU;
    }

    public function isSelesai(): bool
    {
        return $this->status === self::STATUS_Selesai;
    }

    public function isDiproses(): bool
    {
        return $this->status === self::STATUS_Diproses;
    }

    // Method untuk mendapatkan badge status
    public function getStatusBadgeAttribute(): string
    {
        $colors = [
            'menunggu' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300',
            'Selesai' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300',
            'Diproses' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300',
        ];

        $statusText = [
            'menunggu' => 'Menunggu',
            'Selesai' => 'Selesai',
            'Diproses' => 'Diproses',
        ];

        $color = $colors[$this->status] ?? $colors['menunggu'];
        $text = $statusText[$this->status] ?? $statusText['menunggu'];

        return "<span class='px-2 py-1 text-xs font-medium rounded-full {$color}'>{$text}</span>";
    }

    // Relationship
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Method untuk verifikasi laporan
    public function verifikasi(string $status, string $respon = null): bool
    {
        if (!in_array($status, [self::STATUS_Selesai, self::STATUS_Diproses])) {
            return false;
        }

        return $this->update([
            'status' => $status,
            'respon' => $respon,
        ]);
    }

    // Method untuk mendapatkan statistik
    public static function getStatistik($userId = null)
    {
        $query = self::query();

        if ($userId) {
            $query->where('user_id', $userId);
        }

        return [
            'total' => $query->count(),
            'menunggu' => $query->clone()->menunggu()->count(),
            'Selesai' => $query->clone()->Selesai()->count(),
            'Diproses' => $query->clone()->Diproses()->count(),
            'total_pemasukan' => $query->clone()->Selesai()->sum('pemasukan'),
            'total_pengeluaran' => $query->clone()->Selesai()->sum('pengeluaran'),
        ];
    }

    // Method untuk mendapatkan laporan per lokasi
    public static function getLaporanByLokasi($userId = null)
    {
        $query = self::query()->Selesai();

        if ($userId) {
            $query->where('user_id', $userId);
        }

        return $query->selectRaw('lokasi, COUNT(*) as total, SUM(pemasukan) as total_pemasukan, SUM(pengeluaran) as total_pengeluaran')
                    ->groupBy('lokasi')
                    ->get();
    }
}
