<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Users_type;
class UserTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userTypeArr = [
            'Super Administrator',
            'Administrator',            
            'Editor',
            'Tech Support', 
        ];

        foreach($userTypeArr as $val){
            $table = new users_type;
            $table->user_type=$val;        
            $table->save();
        }
    }
}
