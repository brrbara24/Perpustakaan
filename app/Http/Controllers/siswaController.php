<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Loan;
use Illuminate\Http\Request;

class SiswaController extends Controller
{
    public function dashboard()
    {
        $user = auth()->user();

        return view('siswa.dashboard', [
            'dipinjam' => $user->loans()->where('status', 'dipinjam')->count(),
            'total' => $user->loans()->count(),
            'tersedia' => Book::where('stock', '>', 0)->count(),
            'denda' => $user->loans()->sum('fine'),
            'riwayat' => $user->loans()->with('book')->latest()->take(5)->get(),
        ]);
    }

    public function peminjaman(Request $request)
    {
        $books = Book::where('stock', '>', 0)
            ->when($request->q, function ($query, $cari) {
                $query->where(function ($w) use ($cari) {
                    $w->where('title', 'like', "%{$cari}%")
                      ->orWhere('author', 'like', "%{$cari}%");
                });
            })
            ->orderBy('title')
            ->get();

        return view('siswa.peminjaman', compact('books'));
    }

    public function pinjam(Request $request)
    {
        $request->validate(['book_id' => 'required|exists:books,id']);

        $book = Book::findOrFail($request->book_id);
        $userId = auth()->id();

        if ($book->stock < 1) {
            return back()->with('error', 'Stok buku habis.');
        }

        $aktif = Loan::where('user_id', $userId)->where('status', 'dipinjam');

        if ((clone $aktif)->where('book_id', $book->id)->exists()) {
            return back()->with('error', 'Kamu masih meminjam buku ini.');
        }

        if ((clone $aktif)->count() >= 3) {
            return back()->with('error', 'Maksimal 3 buku dipinjam sekaligus.');
        }

        Loan::create([
            'user_id' => $userId,
            'book_id' => $book->id,
            'loan_date' => now(),
            'due_date' => now()->addDays(7),
            'status' => 'dipinjam',
        ]);

        return redirect()->route('siswa.pengembalian')
            ->with('success', 'Buku berhasil dipinjam. Jatuh tempo 7 hari lagi.');
    }

    public function pengembalian()
    {
        $user = auth()->user();

        return view('siswa.pengembalian', [
            'aktif' => $user->loans()->with('book')->where('status', 'dipinjam')->get(),
            'riwayat' => $user->loans()->with('book')->where('status', 'dikembalikan')->latest()->get(),
        ]);
    }

    public function kembalikan(Loan $loan)
    {
        abort_unless($loan->user_id === auth()->id(), 403);

        if ($loan->status === 'dipinjam') {
            $loan->returnBook();
        }

        return back()->with('success', 'Buku berhasil dikembalikan.');
    }
}