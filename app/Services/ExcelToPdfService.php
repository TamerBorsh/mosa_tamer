<?php

namespace App\Services;

use PhpOffice\PhpSpreadsheet\IOFactory;
use Mpdf\Mpdf;

class ExcelToPdfService
{
    public function exportExcelToPdf($excelFilePath, $outputFilename = 'document.pdf')
    {
        // Load the Excel file using PhpSpreadsheet
        $spreadsheet = IOFactory::load($excelFilePath);

        // Convert Excel to HTML
        $htmlWriter = IOFactory::createWriter($spreadsheet, 'Html');
        ob_start();
        $htmlWriter->save('php://output');
        $htmlContent = ob_get_clean();

        // Create an instance of mPDF
        $mpdf = new Mpdf();

        // Write HTML content to mPDF
        $mpdf->WriteHTML($htmlContent);

        // Output the generated PDF (force download)
        $mpdf->Output($outputFilename, 'D'); // 'D' for download, 'I' for inline
    }
}
