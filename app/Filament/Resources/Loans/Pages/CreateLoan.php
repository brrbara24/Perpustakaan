<?php

namespace App\Filament\Resources\Loans\Pages;

use App\Models\Book;
use Filament\Notifications\Notification;
use App\Filament\Resources\Loans\LoanResource;
use Filament\Resources\Pages\CreateRecord;

class CreateLoan extends CreateRecord
{
    protected static string $resource = LoanResource::class;

    protected function beforeCreate(): void
    {
        $book = Book::find($this->data['Book_id']);

        if ($book && $book->stock < 1) {
            Notification::make()->title('Stok buku habis')->danger()->send();
            $this->halt();
        }
    }
}
