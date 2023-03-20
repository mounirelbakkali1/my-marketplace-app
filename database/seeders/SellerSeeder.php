<?php

namespace Database\Seeders;

use App\Models\Seller;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class SellerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // create a seller without using factory
        $seller = new Seller();
        $seller->name = 'John Doe';
        $seller->email ='john@gmail.com';
        $seller->password = Hash::make('azer1234');
        $seller->image = 'https://picsum.photos/200/300';
        $seller->assignRole('seller');
        $seller->save();
    }
}
