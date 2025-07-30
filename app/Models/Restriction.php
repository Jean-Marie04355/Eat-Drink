<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Restriction extends Model
{
    use HasFactory;

    protected $fillable = [
        'entrepreneur_id',
        'type',
        'duration',
        'start_date',
        'end_date',
        'motif',
        'is_active',
        'admin_id'
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'is_active' => 'boolean'
    ];

    // Relations
    public function entrepreneur()
    {
        return $this->belongsTo(User::class, 'entrepreneur_id');
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeExpired($query)
    {
        return $query->where('end_date', '<', now());
    }

    public function scopeExpiringToday($query)
    {
        return $query->whereDate('end_date', today());
    }

    // Méthodes
    public function isExpired()
    {
        return $this->end_date->isPast();
    }

    public function daysLeft()
    {
        return now()->diffInDays($this->end_date, false);
    }

    public function activate()
    {
        $this->update(['is_active' => false]);
    }

    public function deactivate()
    {
        $this->update(['is_active' => true]);
    }

    public function extend($additionalDays, $motif = null)
    {
        $this->update([
            'end_date' => $this->end_date->addDays($additionalDays),
            'duration' => $this->duration + $additionalDays,
            'motif' => $this->motif . "\n\nProlongation: " . $motif
        ]);
    }

    // Boot method pour calculer automatiquement la date de fin
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($restriction) {
            if (!$restriction->end_date) {
                $restriction->end_date = $restriction->start_date->addDays($restriction->duration);
            }
        });
    }
} 