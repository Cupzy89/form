<?php

require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;


$host = "localhost";
$username = "root";
$password = "";
$database = "nama_database";
$conn = mysqli_connect($host, $username, $password, $database);

if(isset($_POST['upload'])){
    $file_excel = $_FILES['file_excel']['name'];
    $ekstensi = pathinfo($file_excel, PATHINFO_EXTENSION);
    $tmp_file = $_FILES['file_excel']['tmp_name'];

    
    if($ekstensi == 'xls' || $ekstensi == 'xlsx'){
        
        $target_dir = "temp_uploads/";
        $target_file = $target_dir . basename($file_excel);
        move_uploaded_file($tmp_file, $target_file);

        
        $spreadsheet = IOFactory::load($target_file);
        $sheet = $spreadsheet->getActiveSheet();
        $row_terbaca = $sheet->getHighestRow();

        $success_count = 0;
        for ($row = 2; $row <= $row_terbaca; $row++) {
            
            $nama = $sheet->getCell('A'.$row)->getValue();
            $email = $sheet->getCell('B'.$row)->getValue();
            $telepon = $sheet->getCell('C'.$row)->getValue();

            
            $sql = "INSERT INTO nama_tabel (nama, email, telepon) VALUES ('$nama', '$email', '$telepon')";
            if (mysqli_query($conn, $sql)) {
                $success_count++;
            }
        }

        unlink($target_file);

        echo "Data berhasil diimpor. Jumlah baris yang berhasil diunggah: " . $success_count;
    } else {
        echo "Format file tidak valid. Harap unggah file Excel (.xls atau .xlsx).";
    }
}
?>
