<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Generation;

class GenerationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create 5 generations using the factory
        Generation::factory()->count(5)->create();
    }
}
