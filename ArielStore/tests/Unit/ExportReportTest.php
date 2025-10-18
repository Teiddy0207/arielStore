<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class ExportReportTest extends TestCase
{
    /**
     * Test validation định dạng PDF
     */
    public function test_validate_pdf_format()
    {
        $this->assertTrue($this->validateExportFormat('pdf'));
        $this->assertTrue($this->validateExportFormat('PDF'));
        $this->assertFalse($this->validateExportFormat('doc'));
        $this->assertFalse($this->validateExportFormat(''));
        $this->assertFalse($this->validateExportFormat(null));
    }

    /**
     * Test validation định dạng Excel
     */
    public function test_validate_excel_format()
    {
        $this->assertTrue($this->validateExportFormat('excel'));
        $this->assertTrue($this->validateExportFormat('xlsx'));
        $this->assertTrue($this->validateExportFormat('xls'));
        $this->assertFalse($this->validateExportFormat('csv'));
        $this->assertFalse($this->validateExportFormat('txt'));
    }

    /**
     * Test validation dữ liệu báo cáo
     */
    public function test_validate_report_data()
    {
        $validData = [
            'title' => 'Báo cáo bán hàng tháng 1/2023',
            'data' => [
                ['date' => '2023-01-01', 'sales' => 1000000],
                ['date' => '2023-01-02', 'sales' => 1500000]
            ],
            'summary' => [
                'total_sales' => 2500000,
                'total_orders' => 2
            ]
        ];
        
        $this->assertTrue($this->validateReportData($validData));
        
        $invalidData = [
            'title' => '',
            'data' => [],
            'summary' => []
        ];
        
        $this->assertFalse($this->validateReportData($invalidData));
    }

    /**
     * Test validation kích thước dữ liệu
     */
    public function test_validate_data_size()
    {
        $smallData = array_fill(0, 100, ['test' => 'data']);
        $largeData = array_fill(0, 10000, ['test' => 'data']);
        
        $this->assertTrue($this->validateDataSize($smallData));
        $this->assertFalse($this->validateDataSize($largeData));
    }

    /**
     * Test validation tên file
     */
    public function test_validate_filename()
    {
        $this->assertTrue($this->validateFilename('bao_cao_ban_hang_2023.pdf'));
        $this->assertTrue($this->validateFilename('report_2023-01-01.xlsx'));
        $this->assertFalse($this->validateFilename(''));
        $this->assertFalse($this->validateFilename('file with spaces.pdf'));
        $this->assertFalse($this->validateFilename('file<>invalid.pdf'));
    }

    /**
     * Test tạo tên file tự động
     */
    public function test_generate_filename()
    {
        $filename = $this->generateFilename('sales_report', 'pdf', '2023-01-01');
        $this->assertStringContainsString('sales_report', $filename);
        $this->assertStringContainsString('2023-01-01', $filename);
        $this->assertStringEndsWith('.pdf', $filename);
    }

    /**
     * Test tính toán kích thước file
     */
    public function test_calculate_file_size()
    {
        $data = [
            'title' => 'Test Report',
            'data' => array_fill(0, 100, ['col1' => 'value1', 'col2' => 'value2'])
        ];
        
        $pdfSize = $this->calculateFileSize($data, 'pdf');
        $excelSize = $this->calculateFileSize($data, 'excel');
        
        $this->assertGreaterThan(0, $pdfSize);
        $this->assertGreaterThan(0, $excelSize);
        $this->assertNotEquals($pdfSize, $excelSize);
    }

    /**
     * Test validation với dữ liệu null
     */
    public function test_validate_with_null_data()
    {
        $this->assertFalse($this->validateExportFormat(null));
        $this->assertFalse($this->validateReportData(null));
        $this->assertFalse($this->validateDataSize(null));
        $this->assertFalse($this->validateFilename(null));
    }

    /**
     * Test validation với dữ liệu không hợp lệ
     */
    public function test_validate_invalid_data()
    {
        $invalidData = [
            'title' => str_repeat('a', 1000), // Quá dài
            'data' => 'not_an_array',
            'summary' => null
        ];
        
        $this->assertFalse($this->validateReportData($invalidData));
    }

    /**
     * Helper method validation định dạng export
     */
    private function validateExportFormat($format)
    {
        if (empty($format)) {
            return false;
        }
        
        $validFormats = ['pdf', 'excel', 'xlsx', 'xls'];
        return in_array(strtolower($format), $validFormats);
    }

    /**
     * Helper method validation dữ liệu báo cáo
     */
    private function validateReportData($data)
    {
        if (!is_array($data)) {
            return false;
        }
        
        if (empty($data['title']) || strlen($data['title']) > 500) {
            return false;
        }
        
        if (!is_array($data['data'])) {
            return false;
        }
        
        if (!is_array($data['summary'])) {
            return false;
        }
        
        return true;
    }

    /**
     * Helper method validation kích thước dữ liệu
     */
    private function validateDataSize($data)
    {
        if (!is_array($data)) {
            return false;
        }
        
        return count($data) <= 5000; // Giới hạn 5000 records
    }

    /**
     * Helper method validation tên file
     */
    private function validateFilename($filename)
    {
        if (empty($filename)) {
            return false;
        }
        
        // Kiểm tra ký tự không hợp lệ
        if (preg_match('/[<>:"|?*]/', $filename)) {
            return false;
        }
        
        // Kiểm tra khoảng trắng
        if (strpos($filename, ' ') !== false) {
            return false;
        }
        
        return true;
    }

    /**
     * Helper method tạo tên file
     */
    private function generateFilename($prefix, $format, $date)
    {
        $timestamp = date('Y-m-d_H-i-s');
        return "{$prefix}_{$date}_{$timestamp}.{$format}";
    }

    /**
     * Helper method tính kích thước file
     */
    private function calculateFileSize($data, $format)
    {
        $baseSize = strlen(json_encode($data));
        
        switch (strtolower($format)) {
            case 'pdf':
                return $baseSize * 1.5; // PDF thường lớn hơn
            case 'excel':
            case 'xlsx':
            case 'xls':
                return $baseSize * 1.2; // Excel nhỏ hơn PDF
            default:
                return $baseSize;
        }
    }
}
