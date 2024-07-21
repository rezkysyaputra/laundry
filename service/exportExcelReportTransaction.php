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
    $search_query .= " AND c.name LIKE '%$search%'";
}
if ($month && $year) {
    $search_query .= " AND MONTH(t.created_at) = $month AND YEAR(t.created_at) = $year";
} elseif ($year) {
    $search_query .= " AND YEAR(t.created_at) = $year";
}

// Membuat objek spreadsheet baru
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Mengisi header tabel
$sheet->setCellValue('A1', 'No.');
$sheet->setCellValue('B1', 'Tanggal');
$sheet->setCellValue('C1', 'Nama Pelanggan');
$sheet->setCellValue('D1', 'Paket');
$sheet->setCellValue('E1', 'Kg');
$sheet->setCellValue('F1', 'Status');
$sheet->setCellValue('G1', 'Diskon');
$sheet->setCellValue('H1', 'Total');

// Mengambil data dari database
$sqlReportsTransaction = "SELECT  
                            t.created_at,
                            c.name AS customer_name, 
                            pckt.name AS packet_name, 
                            t.weight, 
                            t.status, 
                            t.amount, 
                            t.discount
                        FROM 
                            transaction t
                        INNER JOIN 
                            customer c ON t.customer_id = c.id
                        INNER JOIN 
                            packet pckt ON t.packet_id = pckt.id
                        $search_query";
$queryReportsTransaction = mysqli_query($db, $sqlReportsTransaction);

$rowNum = 2; // Dimulai dari baris ke-2
$no = 1;
$totalOverall = 0; // Total keseluruhan dari semua transaksi

// Fungsi untuk format ke rupiah
function formatRupiah($angka)
{
    $rupiah = "Rp " . number_format($angka, 0, ',', '.');
    return $rupiah;
}

while ($transactionReport = mysqli_fetch_array($queryReportsTransaction)) {
    $sheet->setCellValue('A' . $rowNum, $no++);
    $sheet->setCellValue('B' . $rowNum, $transactionReport['created_at']);
    $sheet->setCellValue('C' . $rowNum, $transactionReport['customer_name']);
    $sheet->setCellValue('D' . $rowNum, $transactionReport['packet_name']);
    $sheet->setCellValue('E' . $rowNum, $transactionReport['weight']);
    $sheet->setCellValue('F' . $rowNum, $transactionReport['status']);

    // Format diskon dan total ke Rupiah
    $diskon_rp = formatRupiah($transactionReport['discount']);
    $total_rp = formatRupiah($transactionReport['amount']);

    $sheet->setCellValue('G' . $rowNum, $diskon_rp);
    $sheet->setCellValue('H' . $rowNum, $total_rp);

    $totalOverall += $transactionReport['amount']; // Menambahkan ke total keseluruhan
    $rowNum++;
}

// Format total keseluruhan ke rupiah
$totalOverallFormatted = formatRupiah($totalOverall);

// Menambahkan total keseluruhan ke spreadsheet
$rowNum++; // Pindahkan ke baris berikutnya setelah data
$sheet->setCellValue('I' . $rowNum, 'Total Keseluruhan');
$sheet->setCellValue('J' . $rowNum, $totalOverallFormatted);

// Menulis file Excel ke output
$writer = new Xlsx($spreadsheet);

// Mengatur header untuk mengunduh file
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="TransactionReports.xlsx"');
header('Cache-Control: max-age=0');

$writer->save('php://output');
exit;
