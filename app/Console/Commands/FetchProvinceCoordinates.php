<?php

namespace App\Console\Commands;

use App\Models\Province;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class FetchProvinceCoordinates extends Command
{
    protected $signature = 'provinces:fetch-coordinates {--force : Update all provinces even if they already have coordinates}';

    protected $description = 'Fetch latitude and longitude for all provinces from Open-Meteo Geocoding API';

    public function handle(): int
    {
        $provinces = Province::query()
            ->when(!$this->option('force'), fn($q) => $q->whereNull('latitude'))
            ->get();

        if ($provinces->isEmpty()) {
            $this->info('All provinces already have coordinates. Use --force to update all.');
            return Command::SUCCESS;
        }

        $this->info("Fetching coordinates for {$provinces->count()} provinces...");
        $progressBar = $this->output->createProgressBar($provinces->count());

        $success = 0;
        $failed = 0;

        foreach ($provinces as $province) {
            $normalizedName = $this->normalizeTurkish($province->name);
            
            try {
                $response = Http::timeout(10)
                    ->get('https://geocoding-api.open-meteo.com/v1/search', [
                        'name' => $normalizedName,
                        'count' => 1,
                        'language' => 'en',
                    ]);

                if ($response->successful()) {
                    $data = $response->json();
                    
                    if (!empty($data['results'])) {
                        $result = $data['results'][0];
                        $province->update([
                            'latitude' => $result['latitude'],
                            'longitude' => $result['longitude'],
                        ]);
                        $success++;
                    } else {
                        $this->newLine();
                        $this->warn("No results for: {$province->name}");
                        $failed++;
                    }
                } else {
                    $this->newLine();
                    $this->error("API error for: {$province->name}");
                    $failed++;
                }
            } catch (\Exception $e) {
                $this->newLine();
                $this->error("Exception for {$province->name}: {$e->getMessage()}");
                $failed++;
            }

            $progressBar->advance();
            
            // Rate limiting - wait 100ms between requests
            usleep(100000);
        }

        $progressBar->finish();
        $this->newLine(2);

        $this->info("✅ Successfully updated: {$success} provinces");
        if ($failed > 0) {
            $this->warn("⚠️ Failed: {$failed} provinces");
        }

        return Command::SUCCESS;
    }

    private function normalizeTurkish(string $str): string
    {
        return str_replace(
            ['İ', 'ı', 'Ğ', 'ğ', 'Ü', 'ü', 'Ş', 'ş', 'Ö', 'ö', 'Ç', 'ç'],
            ['I', 'i', 'G', 'g', 'U', 'u', 'S', 's', 'O', 'o', 'C', 'c'],
            $str
        );
    }
}
