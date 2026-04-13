<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use App\Models\User;

class UserSyncService
{
    public function sync()
    {
        // ================= HIT API =================
        $response = Http::get('https://fakerapi.it/api/v1/persons?_quantity=2');

        // Cek kalau request gagal
        if (!$response->successful()) {
            throw new \Exception('Failed to fetch API');
        }

        // Ambil data dari response JSON
        $data = $response->json()['data'];

        // Counter untuk statistik
        $created = 0;
        $updated = 0;

        // ================= LOOP DATA =================
        foreach ($data as $person) {

            // updateOrCreate:
            // - kalau email sudah ada → update
            // - kalau belum ada → create baru
            $user = User::updateOrCreate(
                ['email' => $person['email']], // unique key

                [
                    // Mapping data API → database
                    'first_name' => $person['firstname'],
                    'last_name' => $person['lastname'],
                    'phone' => $person['phone'],
                    'gender' => $person['gender'],
                    'birthday' => $person['birthday'],

                    // Nested address
                    'street' => $person['address']['street'],
                    'city' => $person['address']['city'],
                    'country' => $person['address']['country'],
                    'zipcode' => $person['address']['zipcode'],

                    // Metadata
                    'last_synced_at' => now(),
                    'source' => 'fakerapi'
                ]
            );

            // ================= HITUNG RESULT =================
            if ($user->wasRecentlyCreated) {
                $created++; // data baru
            } else {
                $updated++; // data lama diupdate
            }
        }

        // ================= RETURN RESULT =================
        return [
            'created' => $created,
            'updated' => $updated,
            'total' => count($data),
            'last_sync' => now()
        ];
    }
}