<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Service;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Super Admin
        User::create([
            'name' => 'Super Admin',
            'email' => 'admin@laundrypos.com',
            'password' => Hash::make('password'),
            'role' => 'super_admin',
            'is_active' => true,
        ]);

        // Tenant 1: Laundry Bersih
        $t1 = Tenant::create([
            'name' => 'Laundry Bersih Kilat',
            'slug' => 'laundry-bersih-kilat',
            'phone' => '081234567890',
            'address' => 'Jl. Merdeka No. 10, Jakarta',
            'status' => 'active',
            'plan' => 'free',
        ]);

        User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi@laundry.com',
            'password' => Hash::make('password'),
            'role' => 'owner',
            'tenant_id' => $t1->id,
            'phone' => '081234567890',
            'is_active' => true,
        ]);

        User::create([
            'name' => 'Siti Kasir',
            'email' => 'siti@laundry.com',
            'password' => Hash::make('password'),
            'role' => 'kasir',
            'tenant_id' => $t1->id,
            'is_active' => true,
        ]);

        // Services for Tenant 1
        $services = [
            ['name' => 'Cuci Setrika Reguler', 'type' => 'kiloan', 'speed' => 'reguler', 'price' => 7000, 'unit' => 'kg', 'estimated_hours' => 48],
            ['name' => 'Cuci Setrika Kilat', 'type' => 'kiloan', 'speed' => 'kilat', 'price' => 12000, 'unit' => 'kg', 'estimated_hours' => 24],
            ['name' => 'Cuci Setrika Express', 'type' => 'kiloan', 'speed' => 'express', 'price' => 20000, 'unit' => 'kg', 'estimated_hours' => 6],
            ['name' => 'Setrika Saja', 'type' => 'kiloan', 'speed' => 'reguler', 'price' => 5000, 'unit' => 'kg', 'estimated_hours' => 24],
            ['name' => 'Cuci Karpet', 'type' => 'satuan', 'speed' => 'reguler', 'price' => 35000, 'unit' => 'pcs', 'estimated_hours' => 72],
            ['name' => 'Cuci Sepatu', 'type' => 'satuan', 'speed' => 'reguler', 'price' => 30000, 'unit' => 'pcs', 'estimated_hours' => 48],
            ['name' => 'Cuci Selimut', 'type' => 'satuan', 'speed' => 'reguler', 'price' => 25000, 'unit' => 'pcs', 'estimated_hours' => 48],
            ['name' => 'Dry Clean Jas', 'type' => 'satuan', 'speed' => 'reguler', 'price' => 50000, 'unit' => 'pcs', 'estimated_hours' => 72],
        ];

        foreach ($services as $s) {
            Service::create(['tenant_id' => $t1->id, ...$s]);
        }

        // Customers for Tenant 1
        $customers = [
            ['name' => 'Ahmad Fadli', 'phone' => '081111222333', 'address' => 'Jl. Anggrek No. 5'],
            ['name' => 'Dewi Sari', 'phone' => '082222333444', 'address' => 'Jl. Mawar No. 12'],
            ['name' => 'Rini Wulandari', 'phone' => '083333444555', 'address' => 'Jl. Melati No. 8'],
        ];

        foreach ($customers as $c) {
            Customer::create(['tenant_id' => $t1->id, ...$c]);
        }

        // Tenant 2: Fresh Clean Laundry
        $t2 = Tenant::create([
            'name' => 'Fresh Clean Laundry',
            'slug' => 'fresh-clean-laundry',
            'phone' => '089876543210',
            'address' => 'Jl. Sudirman No. 25, Bandung',
            'status' => 'active',
            'plan' => 'free',
        ]);

        User::create([
            'name' => 'Andi Pratama',
            'email' => 'andi@freshclean.com',
            'password' => Hash::make('password'),
            'role' => 'owner',
            'tenant_id' => $t2->id,
            'phone' => '089876543210',
            'is_active' => true,
        ]);

        foreach ($services as $s) {
            Service::create(['tenant_id' => $t2->id, ...$s]);
        }
    }
}
