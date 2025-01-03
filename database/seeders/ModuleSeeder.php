<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Modules;

class ModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $modules      = [];
        $modulesArr[] = ['code'=>'pages', 'name'=>'CMS Pages'];
        $modulesArr[] = ['code'=>'blocks', 'name'=>'Block'];
        $modulesArr[] = ['code'=>'emailtemplates', 'name'=>'Email Template'];
        $modulesArr[] = ['code'=>'settings', 'name'=>'Settings'];
        $modulesArr[] = ['code'=>'faq', 'name'=>'Faq'];
        $modulesArr[] = ['code'=>'contact', 'name'=>'Contacts'];
        $modulesArr[] = ['code'=>'services', 'name'=>'Services'];

        foreach($modulesArr as $val){
            $table = new Modules;
            $table->code=$val['code'] ?? '';   
            $table->name=$val['name'] ?? ''; 
            $table->save();
        }
    }
}
