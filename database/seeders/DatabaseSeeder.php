<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Item;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $kategoris = [
            [
                'nama_kategori' => 'Processor',
                'kode_rak' => 'RAK-A1',
                'deskripsi' => 'CPU desktop dan workstation dari Intel serta AMD.',
                'items' => [
                    ['kode_sku' => 'CPU-INT-13400F', 'nama_barang' => 'Intel Core i5-13400F', 'merk' => 'Intel', 'stok' => 12, 'harga' => 2850000],
                    ['kode_sku' => 'CPU-AMD-7600', 'nama_barang' => 'AMD Ryzen 5 7600', 'merk' => 'AMD', 'stok' => 4, 'harga' => 3350000],
                ],
            ],
            [
                'nama_kategori' => 'VGA/GPU',
                'kode_rak' => 'RAK-B2',
                'deskripsi' => 'Kartu grafis untuk gaming, rendering, dan komputasi.',
                'items' => [
                    ['kode_sku' => 'VGA-ASU-4060', 'nama_barang' => 'ASUS Dual GeForce RTX 4060 8GB', 'merk' => 'ASUS', 'stok' => 10, 'harga' => 5250000],
                    ['kode_sku' => 'VGA-SAP-7800', 'nama_barang' => 'Sapphire PULSE Radeon RX 7800 XT 16GB', 'merk' => 'Sapphire', 'stok' => 12, 'harga' => 8750000],
                ],
            ],
            [
                'nama_kategori' => 'RAM & Storage',
                'kode_rak' => 'RAK-C3',
                'deskripsi' => 'Memory DDR4/DDR5, SSD NVMe, dan media penyimpanan.',
                'items' => [
                    ['kode_sku' => 'RAM-CRG-16D5', 'nama_barang' => 'Corsair Vengeance DDR5 16GB 5600MHz', 'merk' => 'Corsair', 'stok' => 20, 'harga' => 1150000],
                    ['kode_sku' => 'RAM-KNG-32D4', 'nama_barang' => 'Kingston Fury Beast DDR4 32GB 3200MHz', 'merk' => 'Kingston', 'stok' => 14, 'harga' => 1425000],
                    ['kode_sku' => 'SSD-SMS-9801T', 'nama_barang' => 'Samsung 980 PRO NVMe 1TB', 'merk' => 'Samsung', 'stok' => 9, 'harga' => 1890000],
                ],
            ],
            [
                'nama_kategori' => 'Gaming Gear',
                'kode_rak' => 'RAK-D4',
                'deskripsi' => 'Periferal gaming: mouse, keyboard, dan headset.',
                'items' => [
                    ['kode_sku' => 'GR-LOG-G502', 'nama_barang' => 'Logitech G502 Hero Gaming Mouse', 'merk' => 'Logitech', 'stok' => 25, 'harga' => 620000],
                    ['kode_sku' => 'GR-RZR-BWKV3', 'nama_barang' => 'Razer BlackWidow V3 Mechanical Keyboard', 'merk' => 'Razer', 'stok' => 15, 'harga' => 1450000],
                    ['kode_sku' => 'GR-HYP-CL2', 'nama_barang' => 'HyperX Cloud II Gaming Headset', 'merk' => 'HyperX', 'stok' => 11, 'harga' => 1280000],
                    ['kode_sku' => 'GR-LOGITECH-SUPERLIGHT', 'nama_barang' => 'Logitech GPRO Superlight', 'merk' => 'Logitech', 'stok' => 3, 'harga' => 1000000],
                ],
            ],
        ];

        foreach ($kategoris as $kategori) {
            $items = $kategori['items'];
            unset($kategori['items']);

            $category = Category::create($kategori);

            foreach ($items as $item) {
                $category->items()->create($item);
            }
        }
    }
}
