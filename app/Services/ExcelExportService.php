<?php

namespace App\Services;

use Illuminate\Support\Facades\Response;

class ExcelExportService
{
    public function exportKeuanganPelapor(array $data, $totalPemasukan, $totalPengeluaran, $totalLaporan)
    {
        $filename = 'laporan-keuangan-pelapor-' . now()->format('Y-m-d') . '.xlsx';

        // Create XML content for Excel
        $xmlContent = $this->generateExcelXml($data, $totalPemasukan, $totalPengeluaran, $totalLaporan);

        $headers = [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0'
        ];

        return Response::make($xmlContent, 200, $headers);
    }

    protected function generateExcelXml(array $data, $totalPemasukan, $totalPengeluaran, $totalLaporan)
    {
        $xml = '<?xml version="1.0"?>
<?mso-application progid="Excel.Sheet"?>
<Workbook xmlns="urn:schemas-microsoft-com:office:spreadsheet"
 xmlns:o="urn:schemas-microsoft-com:office:office"
 xmlns:x="urn:schemas-microsoft-com:office:excel"
 xmlns:ss="urn:schemas-microsoft-com:office:spreadsheet"
 xmlns:html="http://www.w3.org/TR/REC-html40">
 <Styles>
  <Style ss:ID="Default" ss:Name="Normal">
   <Alignment ss:Vertical="Center"/>
   <Borders/>
   <Font ss:FontName="Calibri" ss:Size="12" ss:Color="#000000"/>
   <Interior/>
   <NumberFormat/>
   <Protection/>
  </Style>
  <Style ss:ID="Header">
   <Font ss:FontName="Calibri" ss:Size="12" ss:Color="#FFFFFF" ss:Bold="1"/>
   <Interior ss:Color="#2C3E50" ss:Pattern="Solid"/>
   <Alignment ss:Horizontal="Center" ss:Vertical="Center"/>
   <Borders>
    <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1"/>
   </Borders>
  </Style>
  <Style ss:ID="Total">
   <Font ss:FontName="Calibri" ss:Size="12" ss:Color="#FFFFFF" ss:Bold="1"/>
   <Interior ss:Color="#34495E" ss:Pattern="Solid"/>
   <Alignment ss:Horizontal="Center" ss:Vertical="Center"/>
   <Borders>
    <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1"/>
   </Borders>
  </Style>
  <Style ss:ID="Data">
   <Borders>
    <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1"/>
   </Borders>
   <Alignment ss:Vertical="Center"/>
  </Style>
  <Style ss:ID="Center">
   <Alignment ss:Horizontal="Center" ss:Vertical="Center"/>
   <Borders>
    <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1"/>
   </Borders>
  </Style>
  <Style ss:ID="Right">
   <Alignment ss:Horizontal="Right" ss:Vertical="Center"/>
   <Borders>
    <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1"/>
   </Borders>
  </Style>
  <Style ss:ID="Positive">
   <Font ss:FontName="Calibri" ss:Size="12" ss:Color="#17ad37" ss:Bold="1"/>
   <Alignment ss:Horizontal="Center" ss:Vertical="Center"/>
   <Borders>
    <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1"/>
   </Borders>
  </Style>
  <Style ss:ID="Negative">
   <Font ss:FontName="Calibri" ss:Size="12" ss:Color="#ea0606" ss:Bold="1"/>
   <Alignment ss:Horizontal="Center" ss:Vertical="Center"/>
   <Borders>
    <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1"/>
   </Borders>
  </Style>
 </Styles>
 <Worksheet ss:Name="Laporan Keuangan">
  <Table>';

        // Header
        $xml .= '
   <Row>
    <Cell ss:StyleID="Header"><Data ss:Type="String">No</Data></Cell>
    <Cell ss:StyleID="Header"><Data ss:Type="String">Nama Pelapor</Data></Cell>
    <Cell ss:StyleID="Header"><Data ss:Type="String">Jumlah Laporan</Data></Cell>
    <Cell ss:StyleID="Header"><Data ss:Type="String">Total Pemasukan</Data></Cell>
    <Cell ss:StyleID="Header"><Data ss:Type="String">Total Pengeluaran</Data></Cell>
    <Cell ss:StyleID="Header"><Data ss:Type="String">Saldo</Data></Cell>
    <Cell ss:StyleID="Header"><Data ss:Type="String">Status Saldo</Data></Cell>
   </Row>';

        // Data
        $counter = 1;
        foreach ($data as $nama => $item) {
            $statusStyle = $item['saldo'] >= 0 ? 'Positive' : 'Negative';

            $xml .= '
   <Row>
    <Cell ss:StyleID="Center"><Data ss:Type="Number">' . $counter . '</Data></Cell>
    <Cell ss:StyleID="Data"><Data ss:Type="String">' . htmlspecialchars($nama) . '</Data></Cell>
    <Cell ss:StyleID="Center"><Data ss:Type="Number">' . $item['jumlah_laporan'] . '</Data></Cell>
    <Cell ss:StyleID="Right"><Data ss:Type="String">Rp ' . number_format($item['pemasukan'], 0, ',', '.') . '</Data></Cell>
    <Cell ss:StyleID="Right"><Data ss:Type="String">Rp ' . number_format($item['pengeluaran'], 0, ',', '.') . '</Data></Cell>
    <Cell ss:StyleID="Right"><Data ss:Type="String">Rp ' . number_format($item['saldo'], 0, ',', '.') . '</Data></Cell>
    <Cell ss:StyleID="' . $statusStyle . '"><Data ss:Type="String">' . ($item['saldo'] >= 0 ? 'Positif' : 'Negatif') . '</Data></Cell>
   </Row>';
            $counter++;
        }

        // Total
        $totalSaldo = $totalPemasukan - $totalPengeluaran;
        $totalStatusStyle = $totalSaldo >= 0 ? 'Positive' : 'Negative';

        $xml .= '
   <Row>
    <Cell ss:StyleID="Total"><Data ss:Type="String">TOTAL</Data></Cell>
    <Cell ss:StyleID="Total"><Data ss:Type="String"></Data></Cell>
    <Cell ss:StyleID="Total"><Data ss:Type="Number">' . $totalLaporan . '</Data></Cell>
    <Cell ss:StyleID="Total"><Data ss:Type="String">Rp ' . number_format($totalPemasukan, 0, ',', '.') . '</Data></Cell>
    <Cell ss:StyleID="Total"><Data ss:Type="String">Rp ' . number_format($totalPengeluaran, 0, ',', '.') . '</Data></Cell>
    <Cell ss:StyleID="Total"><Data ss:Type="String">Rp ' . number_format($totalSaldo, 0, ',', '.') . '</Data></Cell>
    <Cell ss:StyleID="' . $totalStatusStyle . '"><Data ss:Type="String">' . ($totalSaldo >= 0 ? 'Positif' : 'Negatif') . '</Data></Cell>
   </Row>';

        $xml .= '
  </Table>
 </Worksheet>
</Workbook>';

        return $xml;
    }
}
