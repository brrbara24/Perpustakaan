<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Loan extends Model
{
    protected $fillable = [
        'user_id', 'book_id', 'loan_date', 'due_date',
        'returned_at', 'status', 'fine',
    ];

    protected $casts = [
        'loan_date' => 'date',
        'due_date' => 'date',
        'returned_at' => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }

    public function returnBook(): void
    {
        $terlambat = (int) max(0, floor($this->due_date->diffInDays(now(), false)));

        $this->update([
            'status' => 'dikembalikan',
            'returned_at' => now(),
            'fine' =>$terlambat * 1000,
        ]);
    }

    protected static function booted(): void
    {
        static::created(function (Loan $loan) {
            if ($loan->status === 'dipinjam')  {
                Book::whereKey($loan->book_id)->decrement('stock');
            }
        });

        static::updated(function (Loan $loan) {
            if ($loan->status === 'dipinjam') {
                Book::whereKey($loan->book_id)->increment('stock');
            } else {
                Book::whereKey($loan->book_id)->decrement('stock');
            }
        });

        static::deleted(function (Loan $loan) {
            if ($loan->status === 'dipinjam') {
                Book::whereKey($loan->book_id)->increment('stock');
            }
        });
    }
}
