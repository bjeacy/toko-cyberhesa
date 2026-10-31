<?php

// Terjemahan pesan validasi untuk aturan yang dipakai ItemController@store.
// Ringkas saja: hanya rule dan atribut yang benar-benar digunakan.
return [
    'required' => 'Kolom :attribute wajib diisi.',
    'string' => 'Kolom :attribute harus berupa teks.',
    'integer' => 'Kolom :attribute harus berupa angka bulat.',
    'min' => [
        'numeric' => 'Kolom :attribute minimal :min.',
        'string' => 'Kolom :attribute minimal :min karakter.',
    ],
    'max' => [
        'numeric' => 'Kolom :attribute maksimal :max.',
        'string' => 'Kolom :attribute maksimal :max karakter.',
    ],
    'unique' => ':attribute sudah terdaftar, gunakan kode lain.',
    'exists' => ':attribute yang dipilih tidak valid.',

    'attributes' => [
        'category_id' => 'Kategori',
        'kode_sku' => 'Kode SKU',
        'nama_barang' => 'Nama Barang',
        'merk' => 'Merk',
        'stok' => 'Stok',
        'harga' => 'Harga',
    ],
];
