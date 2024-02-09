<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Food; // Sesuaikan dengan model yang Anda gunakan
use Illuminate\Foundation\Testing\RefreshDatabase;

class AddLikeToItemTest extends TestCase
{
    use RefreshDatabase; // Hanya jika Anda ingin database di-reset setiap kali test dijalankan

    /** @test */
    public function an_item_receives_a_like()
    {
        // Buat sebuah item untuk di-test
        $food = Food::create([
            'name' => 'Test Food',
            'price' => 10000,
            'likes' => 0, // Pastikan nilai awal adalah 0
        ]);

        // Panggil fungsi yang menambahkan like
        // Misalnya, jika Anda memiliki fungsi addLikeToItem() pada sebuah controller atau service
        // Anda perlu memastikan fungsi tersebut bisa diakses dari sini, mungkin dengan membuatnya public atau menggunakan teknik lain

        // Tambahkan logika untuk menambahkan like ke $food
        // Misalnya: $response = $this->get('/route-to-add-like/'.$food->id); // Sesuaikan dengan aplikasi Anda

        // Verifikasi bahwa jumlah likes bertambah
        $this->assertEquals(1, $food->fresh()->likes);
    }
}
