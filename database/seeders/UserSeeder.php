<?php
namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $password = Hash::make('123456'); // $2y$10$mBCoirn5/B7NHUa4CSRl3erqUR9e/ztlOblTvYSgmm0NnOnKyaIeG
        //$password = md5('123456'); // e10adc3949ba59abbe56e057f20f883e

        $table = new User;        
        $table->name = 'admin';        
        $table->email = 'admin@admin.com';        
        $table->password = $password;
        $table->phone_number ='9876543210';
        $table->profile_image ='';
        $table->usertype_id =1;            
        $table->status = 1;  
        $table->login_status= 0;         
        $table->save(); 
    }
}
