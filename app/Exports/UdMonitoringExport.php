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
    protected $result;

    public function __construct($data, $result)
    {
        $this->data = $data;
        $this->result = $result;
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

         $sentBy = [
            '1' => 'YEC - Goto-san',
            '2' => 'YEC - Chie-san',
            '3' => 'YEC - Yanagawa-san',
            '4' => 'YEC - Kondo-san',
            '5' => 'YEC - Kenta-san',
        ];

        $attentionTo = [
            1 => 'Ms. Jessa',
            2 => 'Mr. Oyama',
            3 => 'Mr. Tomura',
            4 => 'Ms. Shibuki',
            5 => 'Mr. Yanagawa',
            6 => 'Mr. Goto',
            7 => 'Mr. Darwin',
            8 => 'Mr. TJ',
        ];

        $ppcIncharge = [
            1 => 'Ms. Jeng',
            2 => 'Ms. Jessa',
        ];

        $status = [
            0 => 'For Production Update(2nd Discussion)',
            1 => 'For Production Update(SEI)',
            2 => 'For Production Update(Special Runcard)',
            3 => 'For Production Update(Inspection Data Sheet)',
            4 => 'For Production Update(Orientation)',
            5 => 'For Closing',
            6 => 'Closed',
        ];

        // $attendeesPerUd = collect($this->result)->keyBy('id');
        // dd($this->result);
        $attendeesPerUd = collect($this->result)->keyBy('ppc_input_id');

        foreach ($this->data as $item) {
             $attendees = '';

            if (isset($attendeesPerUd[$item['id']])) {
                $attendees = $attendeesPerUd[$item['id']]['attendees'];
            }

            $rows[] = [

                $item['date_from_yec'], // Date of Information from YEC
                $sentBy[$item['sent_by_from_yec']] ?? '', // "Sent by(from YEC)"
                $attentionTo[$item['attention_to_pmi_ppc']] ?? '', // Attention to
                $item['ud_ctrlno'], // ctrl #
                $item['revision'], // rev
                $item['p_name'], //  pname
                $item['qty'], // qty
                // (string) $item['po_num'], // po_num
                "'" . $item['po_num'],// po_num
                $item['date_coverage'], // date coverage
                $item['content_of_ud'], // content
                $item['date_posted_rapid'], // date posted

                $item['date_ud_review'], // ud date
                $item['date_ud_review'], // ud date
                $item['result_ud_review'], // result


                $item['fd_ppc_date'],
                $item['fd_ppc_risk_ctrl_no'],

                $item['second_discussion_details']['date'] ?? '', // date
                // $item['second_discussion_details']['attendees'] ?? '', // attendess
                $attendees,
                $item['second_discussion_details']['cp_sei'] ?? '', // sei
                $item['second_discussion_details']['cp_special_runcard'] ?? '', // special_runcard
                $item['second_discussion_details']['cp_inspection_data'] ?? '', // inspection data
                $item['second_discussion_details']['cp_orientation'] ?? '', // orientation

                $item['closing_details']['production_date'] ?? '',
                $item['closing_details']['shipment_date'] ?? '',
                $item['closing_details']['qty'] ?? '',
                // $item['closing_details']['ppc_incharge'] ?? '',
                $ppcIncharge[$item['closing_details']['ppc_incharge']] ?? '',
                 $status[$item['status']] ?? '', // Attention to

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

                // Auto-fit row height for all data rows
                for ($row = 7; $row <= $highestRow; $row++) {
                    $sheet->getRowDimension($row)->setRowHeight(-1);
                }

                $sheet->getStyle('R7:R' . $highestRow)
                ->getAlignment()
                ->setWrapText(true);

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
