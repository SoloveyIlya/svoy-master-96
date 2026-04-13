<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class MissingBrandsSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            'remont-telefonov' => [
                'Meizu', 'ZTE', 'Lenovo', 'ASUS', 'Sony', 'realme', 'Oppo', 'Vivo', 'OnePlus', 
                'Nokia', 'Motorola', 'LG', 'HTC', 'Tecno', 'Infinix', 'Poco', 'Blackview', 
                'Ulefone', 'Doogee', 'Cubot', 'Alcatel', 'Philips', 'Fly', 'DEXP', 'BQ', 
                'Texet', 'Oukitel', 'Umidigi', 'Vertu'
            ],
            'remont-planshetov' => [
                'Lenovo', 'ASUS', 'Meizu', 'Sony', 'LG', 'Nokia', 'realme', 'Oppo', 'Teclast', 
                'Blackview', 'Digma', 'Prestigio', 'Irbis', 'DEXP', 'BQ', 'Texet', 
                'Amazon Kindle', 'Microsoft Surface'
            ],
            'remont-noutbukov' => [
                'Samsung', 'Sony', 'Toshiba', 'Huawei', 'Honor', 'Xiaomi', 'Gigabyte', 
                'Razer', 'Irbis', 'DEXP', 'Digma', 'Prestigio', 'Fujitsu', 'Packard Bell', 'eMachines'
            ],
            'remont-smart-chasov' => [
                'Honor Watch', 'Realme Watch'
            ],
        ];

        foreach ($data as $categorySlug => $brands) {
            $category = Category::where('slug', $categorySlug)->first();
            
            if (!$category) {
                $this->command->error("Category not found: $categorySlug");
                continue;
            }

            foreach ($brands as $brandName) {
                $brandSlug = Str::slug($brandName);
                
                // Создаем или обновляем бренд
                $brand = Brand::updateOrCreate(
                    ['slug' => $brandSlug],
                    [
                        'name' => $brandName,
                        'status' => 'active',
                    ]
                );

                // Привязываем к категории
                $category->brands()->syncWithoutDetaching([$brand->id]);
            }
            
            $this->command->info("Category $categorySlug: brands synchronized.");
        }
    }
}
