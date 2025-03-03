<?php

namespace App\Controllers;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

use App\Models\UserModel;
use App\Models\RoleModel;
use App\Models\TimeModel;
use App\Models\NewsModel;

class ExportController extends BaseController
{

public function exportUsers()
{
    $newsModel = new UserModel();

    $data = $newsModel->findAll();


    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    $sheet->setCellValue('A1', 'ID');
    $sheet->setCellValue('B1', 'Name');
    $sheet->setCellValue('C1', 'Timezone');
    $sheet->setCellValue('D1', 'Role');
    $sheet->setCellValue('E1', 'Deletion Date');

    $row = 2;  // Start from the second row
    foreach ($data as $user) {
        $sheet->setCellValue('A' . $row, $user['id']);
        $sheet->setCellValue('B' . $row, $user['nombre']);
        $sheet->setCellValue('C' . $row, $user['epoca']);
        $sheet->setCellValue('D' . $row, $user['rol']);
        $sheet->setCellValue('E' . $row, $user['borrado_en']);
        $row++;
    }

    $writer = new Xlsx($spreadsheet);

    $filename = 'users_data.xlsx';

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    header('Cache-Control: max-age=0');

    // 
    $writer->save('php://output');
    exit;


}

public function exportTimezones()
{
    $newsModel = new TimeModel();

    $data = $newsModel->findAll();


    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    $sheet->setCellValue('A1', 'ID');
    $sheet->setCellValue('B1', 'Year');
    $sheet->setCellValue('C1', 'Age');
    $sheet->setCellValue('D1', 'Significant_Event');
    $sheet->setCellValue('E1', 'Deletion_Date');

    $row = 2;  // Start from the second row
    foreach ($data as $timezone) {
        $sheet->setCellValue('A' . $row, $timezone['id']);
        $sheet->setCellValue('B' . $row, $timezone['Year']);
        $sheet->setCellValue('C' . $row, $timezone['Age']);
        $sheet->setCellValue('D' . $row, $timezone['Significant_Event']);
        $sheet->setCellValue('E' . $row, $timezone['Deletion_Date']);
        $row++;
    }

    $writer = new Xlsx($spreadsheet);

    $filename = 'timezone_data.xlsx';

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    header('Cache-Control: max-age=0');

    // 
    $writer->save('php://output');
    exit;


}

public function exportRoles()
{
    $newsModel = new RoleModel();

    $data = $newsModel->findAll();


    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    $sheet->setCellValue('A1', 'ID');
    $sheet->setCellValue('B1', 'Name');
    $sheet->setCellValue('C1', 'Privileges');
    $sheet->setCellValue('D1', 'Deletion Date');
 

    $row = 2;  // Start from the second row
    foreach ($data as $roles) {
        $sheet->setCellValue('A' . $row, $roles['id']);
        $sheet->setCellValue('B' . $row, $roles['Name']);
        $sheet->setCellValue('C' . $row, $roles['Privileges']);
        $sheet->setCellValue('D' . $row, $roles['Deletion_Date']);
 
        $row++;
    }

    $writer = new Xlsx($spreadsheet);

    $filename = 'role_data.xlsx';

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    header('Cache-Control: max-age=0');

    // 
    $writer->save('php://output');
    exit;


}

public function exportNews()
{
    $newsModel = new NewsModel();

    $data = $newsModel->findAll();


    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    $sheet->setCellValue('A1', 'ID');
    $sheet->setCellValue('B1', 'Title');
    $sheet->setCellValue('C1', 'Year');
    $sheet->setCellValue('D1', 'Level of Controversy');
    $sheet->setCellValue('E1', 'Deletion Date');
 

    $row = 2;  // Start from the second row
    foreach ($data as $news) {
        $sheet->setCellValue('A' . $row, $news['id']);
        $sheet->setCellValue('B' . $row, $news['Title']);
        $sheet->setCellValue('C' . $row, $news['Year']);
        $sheet->setCellValue('D' . $row, $news['Level_Controversy']);
        $sheet->setCellValue('D' . $row, $news['Deletion_Time']);
 
        $row++;
    }

    $writer = new Xlsx($spreadsheet);

    $filename = 'news_data.xlsx';

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    header('Cache-Control: max-age=0');

    // 
    $writer->save('php://output');
    exit;


}






}