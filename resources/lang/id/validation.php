<?php

return [
    'required' => ':attribute wajib diisi.',
    'email' => ':attribute harus berupa email yang valid.',
    'string' => ':attribute harus berupa teks.',
    'max' => ':attribute tidak boleh lebih dari :max karakter.',
    'min' => ':attribute minimal harus :min karakter.',
    'confirmed' => 'Konfirmasi :attribute tidak cocok.',
    'unique' => ':attribute sudah ada.',
    'numeric' => ':attribute harus berupa angka.',
    'integer' => ':attribute harus berupa bilangan bulat.',
    'nullable' => ':attribute opsional.',

    'attributes' => [
        'name' => 'nama',
        'email' => 'email',
        'password' => 'kata sandi',
        'device_name' => 'nama perangkat',
        'fan_threshold' => 'ambang batas kipas',
        'soil_threshold' => 'ambang batas tanah',
    ],
];
