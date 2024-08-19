<?php

function generateUniqueCode($entityType)
{
    // Mengambil 3 huruf pertama dari nama toko dan mengubahnya menjadi huruf kapital
    $storeCode = "TPM";

    // Menentukan kode entitas
    $entityCode = '';
    switch (strtolower($entityType)) {
        case 'customer':
            $entityCode = 'CST';
            break;
        case 'service':
            $entityCode = 'SV';
            break;
        case 'mekanik':
            $entityCode = 'MK';
            break;
        default:
            throw new \InvalidArgumentException("Tipe entitas tidak dikenal: $entityType");
    }

    // Menghasilkan 6 digit random yang terdiri dari angka dan huruf kapital
    $randomPart = '';
    do {
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomPart = '';
        for ($i = 0; $i < 6; $i++) {
            $randomPart .= $characters[rand(0, strlen($characters) - 1)];
        }
    } while (!preg_match('/^(?=.*[A-Z])(?=.*\d).+$/', $randomPart));

    // Menggabungkan semua bagian untuk membentuk kode unik
    return $storeCode . $entityCode .'-'. $randomPart;
}

?>