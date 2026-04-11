<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Tank;
use App\Models\Pump;
use App\Models\FuelConfig;
use App\Models\Product;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // --- 1. USERS ---
        User::create([
            'name' => 'Admin Manager',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'), 
            'role' => 'Manager',
            'is_active' => true,
        ]);

        User::create([
            'name' => 'Juan Dela Cruz',
            'email' => 'juan@ecogazz.com',
            'password' => Hash::make('1234'),
            'role' => 'Pump Attendant',
            'is_active' => true,
        ]);

        // --- 2. TANKS (Inventory) ---
        $tankDiesel = Tank::create([
            'name' => 'Diesel Main Tank',
            'fuel_type' => 'Diesel',
            'capacity' => 20000,
            'current_stock' => 15000,
        ]);

        $tankPremium = Tank::create([
            'name' => 'Premium Main Tank',
            'fuel_type' => 'Premium',
            'capacity' => 15000,
            'current_stock' => 8000,
        ]);

        // --- 3. PUMPS (Physical Islands) ---
        $pump1 = Pump::create(['name' => 'Island 1', 'type' => 'Digital']);
        $pump2 = Pump::create(['name' => 'Island 2', 'type' => 'Mechanical']);

        // --- 4. FUEL CONFIGS (Nozzles/Prices) ---
        // Island 1 Nozzles
        FuelConfig::create([
            'pump_id' => $pump1->id,
            'tank_id' => $tankDiesel->id,
            'fuel_type' => 'Diesel',
            'cost_price' => 52.00,
            'selling_price' => 58.50,
            'current_meter' => 1000.00,
        ]);

        FuelConfig::create([
            'pump_id' => $pump1->id,
            'tank_id' => $tankPremium->id,
            'fuel_type' => 'Premium',
            'cost_price' => 58.00,
            'selling_price' => 64.25,
            'current_meter' => 500.00,
        ]);

        // --- 5. RETAIL PRODUCTS (Oil/LPG) ---
        Product::create([
            'category' => 'Engine Oil',
            'brand' => 'EcoGazz',
            'name' => 'Elite 4T 1L',
            'cost_price' => 180.00,
            'selling_price' => 250.00,
            'stock_quantity' => 24,
        ]);

        Product::create([
            'category' => 'LPG',
            'brand' => 'Solane',
            'name' => '11kg Refill',
            'cost_price' => 850.00,
            'selling_price' => 1050.00,
            'stock_quantity' => 10,
        ]);
    }
}