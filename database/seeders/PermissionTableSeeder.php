<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //مسافه بين كوتيشن وكلمه بتفرق وانت بتكتب can
        $permissions = [
            //sidebar: 

            "invoices",
            'invoices list',
            'paid invoices',
            'unpaid invoices',
            'partial paid invoices',
            'archived invoices',

            "reports",
            "invoices reports",
            "customers reports",

            "users",
            "users list", // عرض مستخدمين - index
            "users roles",

            "settings",
            "sections",
            "products",

            //actions :

            //invoice
            "add invoice",
            "excel export",
            "edit invoice",
            "delete Invoice",
            "change payment status",
            "move to archive",
            "print invoice",
            "view file",
            "download file",
            "delete file",
     
            //users 
            "show user",
            "add user",
            "edit user",
            "delete user",

            //roles 
            "view role",
            "add role",
            "edit role",
            "delete role",

            //sections
            "add section",
            "edit section",
            "delete section",

            //products
            "add products",
            "edit products",
            "delete products",
         

            "notifications",

        ];

        foreach ($permissions as $permission) {

            Permission::create(['name' => $permission]);
        }

    }
}
