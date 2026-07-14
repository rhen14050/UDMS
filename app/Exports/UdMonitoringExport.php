<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class UdMonitoringExport implements FromArray, WithEvents, WithCustomStartCell
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    /*
    |--------------------------------------------------------------------------
    | START DATA ROW
    |--------------------------------------------------------------------------
    */
    public function startCell(): string
    {
        return 'A7';
    }

    /*
    |--------------------------------------------------------------------------
    | DATA
    |--------------------------------------------------------------------------
    */
    public function array(): array
    {
        $rows = [];

        foreach ($this->data as $item) {

            $rows[] = [

                $item['date_from_yec'],
                $item['sent_by_from_yec'],
                $item['attention_to_pmi_ppc'],
                $item['ud_ctrlno'],
                $item['revision'],
                $item['p_name'],
                $item['qty'],
                $item['po_num'],
                $item['date_coverage'],
                $item['content_of_ud'],
                $item['date_posted_rapid'],

                $item['date_ud_review'],
                $item['result_ud_review'],

                $item['fd_ppc_date'],
                $item['fd_ppc_risk_ctrl_no'],

                $item['second_discussion_details']['date'] ?? '',
                $item['second_discussion_details']['attendees'] ?? '',
                $item['second_discussion_details']['cp_sei'] ?? '',
                $item['second_discussion_details']['cp_special_runcard'] ?? '',
                $item['second_discussion_details']['cp_inspection_data'] ?? '',
                $item['second_discussion_details']['cp_orientation'] ?? '',

                $item['closing_details']['production_date'] ?? '',
                $item['closing_details']['shipment_date'] ?? '',
                $item['closing_details']['qty'] ?? '',
                $item['closing_details']['ppc_incharge'] ?? '',
                strip_tags($item['status'])

            ];
        }

        return $rows;
    }

    /*
    |--------------------------------------------------------------------------
    | SHEET DESIGN
    |--------------------------------------------------------------------------
    */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {

                $sheet = $event->sheet->getDelegate();


                /*
                TITLE
                */
                $sheet->mergeCells('A1:AA1');
                $sheet->setCellValue('A1','TS-F3 URGENT DIRECTION / SPECIAL INSTRUCTION SUMMARY LIST');

                $sheet->mergeCells('A2:AA2');
                $sheet->setCellValue('A2','UD Monitoring');

                /*
                SOURCE ROW
                */

                /*
                MAIN HEADER
                */
                $sheet->mergeCells('A4:A6');
                $sheet->setCellValue('A4','Date of Information from YEC');

                $sheet->mergeCells('B4:B6');
                $sheet->setCellValue('B4',"Sent by\n(from YEC)");

                $sheet->mergeCells('C4:C6');
                $sheet->setCellValue('C4',"Attention to\n(PMI-PPC)");

                $sheet->mergeCells('D4:D6');
                $sheet->setCellValue('D4','UD Control #');

                $sheet->mergeCells('E4:E6');
                $sheet->setCellValue('E4','Revision');

                $sheet->mergeCells('F4:F6');
                $sheet->setCellValue('F4','Parts / Product Name');

                $sheet->mergeCells('G4:G6');
                $sheet->setCellValue('G4','Qty.');

                $sheet->mergeCells('H4:H6');
                $sheet->setCellValue('H4','PO#');

                $sheet->mergeCells('I4:I6');
                $sheet->setCellValue('I4','Date Coverage');

                $sheet->mergeCells('J4:J6');
                $sheet->setCellValue('J4','Content of UD / Special Instruction');

                /*
                POSTED RAPID
                */
                $sheet->mergeCells('K4:K5');
                $sheet->setCellValue('K4','Posted in Rapid');
                $sheet->setCellValue('K6','Date');

                /*
                UD REVIEW
                */
                $sheet->mergeCells('L4:N4');
                $sheet->setCellValue('L4','UD Review');
                $sheet->setCellValue('L5','Date');
                $sheet->setCellValue('M5','Date');
                $sheet->setCellValue('N5','Result');

                /*
                1ST DISCUSSION
                */
                $sheet->mergeCells('O4:P4');
                $sheet->setCellValue('O4','1st Discussion (PPC)');
                $sheet->setCellValue('O5','Date');
                $sheet->setCellValue('P5','Risk Assessment Ctrl. No');

                /*
                2ND DISCUSSION
                */
                $sheet->mergeCells('Q4:V4');
                $sheet->setCellValue('Q4','2nd Discussion (PRODUCTION)');
                $sheet->setCellValue('Q5','Date');
                $sheet->setCellValue('R5',"Attendee/s\n(Prod'n/Eng'g/QC)");

                /*
                CHECKPOINTS
                */
                $sheet->mergeCells('S5:V5');
                $sheet->setCellValue('S5','Checkpoints');
                $sheet->setCellValue('S6','SEI');
                $sheet->setCellValue('T6','SPECIAL RUNCARD');
                $sheet->setCellValue('U6','INSPECTION DATA SHEET');
                $sheet->setCellValue('V6','ORIENTATION');

                /*
                FINAL COLUMNS
                */
                $sheet->mergeCells('W4:W6');
                $sheet->setCellValue('W4','Production Date');

                $sheet->mergeCells('X4:X6');
                $sheet->setCellValue('X4','Shipment Date');

                $sheet->mergeCells('Y4:Y6');
                $sheet->setCellValue('Y4','Qty.');

                $sheet->mergeCells('Z4:Z6');
                $sheet->setCellValue('Z4','PPC-in-charge');

                $sheet->mergeCells('AA4:AA6');
                $sheet->setCellValue('AA4','Status');

                /*
                HEADER STYLING
                */
                $sheet->getStyle('A1:AA6')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('A1:AA6')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
                $sheet->getStyle('A1:AA6')->getFont()->setBold(true);
                $sheet->getStyle('A4:AA6')->getAlignment()->setWrapText(true);

                /*
                DATA ROW STYLING
                */
                $highestRow = $sheet->getHighestRow();
                $sheet->getStyle('A7:AA' . $highestRow)
                    ->getAlignment()
                    ->setWrapText(true)
                    ->setVertical(Alignment::VERTICAL_TOP);

                $sheet->getStyle('H7:H' . $highestRow)
                ->getNumberFormat()
                ->setFormatCode(NumberFormat::FORMAT_TEXT);

                /*
                BORDERS
                */
                $sheet->getStyle('A4:AA' . $highestRow)->applyFromArray([
                    'borders'=>[
                        'allBorders'=>[
                            'borderStyle'=>Border::BORDER_THIN
                        ]
                    ]
                ]);

                /*
                COLUMN WIDTHS
                */
                $sheet->getColumnDimension('A')->setWidth(20);
                $sheet->getColumnDimension('B')->setWidth(18);
                $sheet->getColumnDimension('C')->setWidth(20);
                $sheet->getColumnDimension('D')->setWidth(15);
                $sheet->getColumnDimension('E')->setWidth(12);
                $sheet->getColumnDimension('F')->setWidth(30);
                $sheet->getColumnDimension('G')->setWidth(8);
                $sheet->getColumnDimension('H')->setWidth(15);
                $sheet->getColumnDimension('I')->setWidth(15);
                $sheet->getColumnDimension('J')->setWidth(60); // Long text
                $sheet->getColumnDimension('K')->setWidth(15);
                $sheet->getColumnDimension('L')->setWidth(12);
                $sheet->getColumnDimension('M')->setWidth(12);
                $sheet->getColumnDimension('N')->setWidth(15);
                $sheet->getColumnDimension('O')->setWidth(12);
                $sheet->getColumnDimension('P')->setWidth(18);
                $sheet->getColumnDimension('Q')->setWidth(12);
                $sheet->getColumnDimension('R')->setWidth(28);
                $sheet->getColumnDimension('S')->setWidth(15);
                $sheet->getColumnDimension('T')->setWidth(18);
                $sheet->getColumnDimension('U')->setWidth(20);
                $sheet->getColumnDimension('V')->setWidth(15);
                $sheet->getColumnDimension('W')->setWidth(15);
                $sheet->getColumnDimension('X')->setWidth(15);
                $sheet->getColumnDimension('Y')->setWidth(10);
                $sheet->getColumnDimension('Z')->setWidth(18);
                $sheet->getColumnDimension('AA')->setWidth(18);

                /*
                FREEZE HEADER
                */
                $sheet->freezePane('A7');

            }
        ];
    }
}