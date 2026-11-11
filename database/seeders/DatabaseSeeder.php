<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@perpus.test',
            'password' => 'admin123',
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Siswa',
            'email' => 'siswa@perpus.test',
            'password' => 'siswa123',
            'role' => 'siswa',
            'kelas' => 'XII RPL 1',
        ]);

        $buku = [
            ['Laskar Pelangi', 'Bara', 'Bentang Pustaka', 2005, 5],
            ['Pemrograman PHP Dasar', 'Bara2nd', 'Informatika', 2020, 3],
            ['Basis Data MySQL', 'Bara3d', 'Andi Offset', 2019, 4],
            ['Matematika Kelas XII', 'Bara4th', 'Erlangga', 2021, 10],
            ['Bumi', 'Bara5th', 'Gramedia', 2014, 2],
        ];

        foreach ($buku as [$title, $author, $publisher, $year, $stock]) {
            Book::create(compact('title', 'author', 'publisher', 'year', 'stock'));
        }
    }
}
