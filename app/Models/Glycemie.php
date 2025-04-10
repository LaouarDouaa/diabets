<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Glycemie extends Model
{
    use HasFactory;

    /**
     * Les attributs qui sont mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'patient_id',
        'valeur',
        'date_mesure',
        'heure_mesure',
        'moment',
        'commentaire'
    ];

    /**
     * Les attributs qui doivent être castés.
     *
     * @var array
     */
    protected $casts = [
        'date_mesure' => 'date',
        'heure_mesure' => 'datetime:H:i',
        'valeur' => 'decimal:1'
    ];

    /**
     * Formatage pour l'affichage
     */
    public function getValeurFormateeAttribute(): string
    {
        return "{$this->valeur} mmol/L";
    }

    /**
     * Scope pour les mesures du jour
     */
    public function scopeAujourdhui($query)
    {
        return $query->whereDate('date_mesure', today());
    }
    public function patient()
    {
        return $this->belongsTo(User::class, 'patient_id');
    }
}
