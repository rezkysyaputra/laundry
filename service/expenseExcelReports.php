<?php
require '../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

include("../includes/db_connect.php");

$search = isset($_GET['search']) ? mysqli_real_escape_string($db, $_GET['search']) : '';
$month = isset($_GET['month']) ? (int)$_GET['month'] : '';
$year = isset($_GET['year']) ? (int)$_GET['year'] : '';

$search_query = "WHERE 1=1";
if ($search) {
    $search_query .= " AND e.name LIKE '%$search%'";
}
if ($month && $year) {
    $search_query .= " AND MONTH(e.created_at) = $month AND YEAR(e.created_at) = $year";
} elseif ($year) {
    $search_query .= " AND YEAR(e.created_at) = $year";
}

// Membuat objek spreadsheet baru
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Mengisi header tabel
$sheet->setCellValue('A1', 'No.');
$sheet->setCellValue('B1', 'Nama Barang');
$sheet->setCellValue('C1', 'Jumlah Barang');
$sheet->setCellValue('D1', 'Harga Barang');
$sheet->setCellValue('E1', 'Total');

// Mengambil data dari database
$sqlSearchReportsExpense = "SELECT  
                                e.created_at,
                                e.quantity,
                                e.name, 
                                e.total, 
                                e.price,
                                (e.quantity * e.price) AS total
                            FROM 
                                expense e
                            $search_query";
$queryReportsExpense = mysqli_query($db, $sqlSearchReportsExpense);

$rowNum = 2; // Dimulai dari baris ke-2
$no = 1;
$totalOverall = 0; // Total keseluruhan dari semua transaksi

// Fungsi untuk format ke rupiah
function formatRupiah($angka)
{
    $rupiah = "Rp " . number_format($angka, 0, ',', '.');
    return $rupiah;
}

while ($expenseReport = mysqli_fetch_array($queryReportsExpense)) {
    $sheet->setCellValue('A' . $rowNum, $no++);
    $sheet->setCellValue('B' . $rowNum, $expenseReport['name']);
    $sheet->setCellValue('C' . $rowNum, $expenseReport['quantity']);
    $sheet->setCellValue('D' . $rowNum, formatRupiah($expenseReport['price']));
    $sheet->setCellValue('E' . $rowNum, formatRupiah($expenseReport['total']));
    $totalOverall += $expenseReport['total']; // Menambahkan ke total keseluruhan
    $rowNum++;
}

// Format total keseluruhan ke rupiah
$totalOverallFormatted = formatRupiah($totalOverall);

// Menambahkan total keseluruhan ke spreadsheet
$rowNum++; // Pindahkan ke baris berikutnya setelah data
$sheet->setCellValue('E' . $rowNum, 'Total Keseluruhan');
$sheet->setCellValue('F' . $rowNum, $totalOverallFormatted);

// Menulis file Excel ke output
$writer = new Xlsx($spreadsheet);

// Mengatur header untuk mengunduh file
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="ExpenseReports.xlsx"');
header('Cache-Control: max-age=0');

$writer->save('php://output');
exit;
