<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class LegacyDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sqlPath = base_path('db_inven.sql');
        if (!File::exists($sqlPath)) {
            $this->command?->warn('db_inven.sql not found at ' . $sqlPath);
            return;
        }

        $content = File::get($sqlPath);
        $lines = explode("\n", $content);

        $currentInsert = '';
        $inInsert = false;

        foreach ($lines as $line) {
            $trimmed = trim($line);

            if (str_starts_with($trimmed, 'INSERT INTO')) {
                $inInsert = true;
                $currentInsert = $line . "\n";
            } elseif ($inInsert) {
                $currentInsert .= $line . "\n";
            }

            if ($inInsert && str_ends_with($trimmed, ';')) {
                $inInsert = false;
                
                // Map table `user` to `users`
                $stmt = preg_replace('/INSERT INTO `user` \(/i', 'INSERT INTO `users` (', $currentInsert);
                $stmt = preg_replace('/INSERT INTO user \(/i', 'INSERT INTO users (', $stmt);

                try {
                    DB::unprepared($stmt);
                } catch (\Throwable $e) {
                    $this->command?->warn("Warning inserting statement: " . substr($stmt, 0, 50) . "... Error: " . $e->getMessage());
                }
                $currentInsert = '';
            }
        }

        // Ensure default admin & superadmin password hashes work with 'asd'
        $users = DB::table('users')->get();
        foreach ($users as $user) {
            DB::table('users')->where('id', $user->id)->update([
                'password' => Hash::make('asd'),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Ensure superadmin exists if not imported
        if (!DB::table('users')->where('username', 'sadmin')->exists()) {
            DB::table('users')->insert([
                'id' => 1,
                'nama' => 'Bill Superadmin',
                'username' => 'sadmin',
                'email' => 'cep@gmail.com',
                'jenis_kelamin' => 'l',
                'password' => Hash::make('asd'),
                'foto_profile' => 'default.png',
                'penempatan_cabang' => 1,
                'role_id' => 1,
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Ensure admin1 exists if not imported
        if (!DB::table('users')->where('username', 'admin1')->exists()) {
            DB::table('users')->insert([
                'id' => 106,
                'nama' => 'Izzy Admin',
                'username' => 'admin1',
                'email' => 'ab@gmail.com',
                'jenis_kelamin' => 'p',
                'password' => Hash::make('asd'),
                'foto_profile' => 'default.png',
                'penempatan_cabang' => 8,
                'role_id' => 2,
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Ensure roles exist
        if (DB::table('role_user')->count() === 0) {
            DB::table('role_user')->insert([
                ['id' => 1, 'role' => 'Super Admin', 'created_at' => now(), 'updated_at' => now()],
                ['id' => 2, 'role' => 'Admin', 'created_at' => now(), 'updated_at' => now()],
            ]);
        }

        // Ensure settings exist
        if (DB::table('pengaturan_umum')->count() === 0) {
            DB::table('pengaturan_umum')->insert([
                'id' => 1,
                'nama_perusahaan' => 'Joona InventoryX',
                'pemilik' => 'Cep Guna',
                'alamat_perusahaan' => 'Kp. Jelekong Rt01/04, Kec. Baleendah, Kab. Bandung',
                'title' => 'JInventory',
                'footer' => 'Copyright © 2026 Joona Code | Developed By Cep Guna Widodo',
                'favicon' => '62755567b61840c84f1b3471e048e69b.png',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
