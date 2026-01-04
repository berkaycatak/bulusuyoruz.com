<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Process Provinces from province_coordinates.json (includes lat/lng)
        $provincesPath = database_path('data/province_coordinates.json');
        
        if (!File::exists($provincesPath)) {
            $this->command->error('Province coordinates file not found!');
            return;
        }
        
        $this->command->info('Seeding provinces with coordinates...');
        
        // Disable foreign key checks to allow truncation
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('provinces')->truncate();
        
        $provincesData = json_decode(File::get($provincesPath), true);
        $provinces = [];
        
        foreach ($provincesData as $row) {
            $provinces[] = [
                'id' => $row['id'],
                'name' => $row['name'],
                'latitude' => $row['latitude'],
                'longitude' => $row['longitude'],
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        
        // Insert in chunks to avoid memory limits
        foreach (array_chunk($provinces, 100) as $chunk) {
            DB::table('provinces')->insert($chunk);
        }
        
        $this->command->info("Seeded " . count($provinces) . " provinces with coordinates.");

        // 2. Process Districts (ilce.json)
        $jsonIlce = File::get(database_path('data/ilce.json'));
        $dataIlce = json_decode($jsonIlce, true);

        // Find the table data
        $ilceTable = collect($dataIlce)->firstWhere('name', 'ilce');

        if ($ilceTable && isset($ilceTable['data'])) {
            $this->command->info('Seeding districts...');
            
            DB::table('districts')->truncate();
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');

            $districts = [];
            foreach ($ilceTable['data'] as $row) {
                $districts[] = [
                    'id' => $row['id'],
                    'province_id' => $row['il_id'],
                    'name' => $row['name'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            foreach (array_chunk($districts, 100) as $chunk) {
                DB::table('districts')->insert($chunk);
            }
            
            $this->command->info("Seeded " . count($districts) . " districts.");
        }
        
        $this->command->info('Location seeding completed!');
    }
}


