<?php
require('FPDF/fpdf.php');

class Rechnung extends FPDF {

    // Header
    function Header() {
        $this->SetFont('Arial', 'B', 16);
        $this->Cell(80);
        $this->Cell(30,10, 'AVPlus', 1, 0, 'C');

        $this->SetFont('Arial', 'B', 12);
        $this->Cell(80, 10, date('d.m.Y'), 0, 0, 'R');

        $this->Ln(7);
        $this->SetFont('Arial', 'B', 7);
        $this->Cell(80, 10, utf8_decode("AVPlus Mülheim, Kluse 24-42, 45472 Mülheim an der Ruhr"));

        $this->Line(10, 70, 200, 70);

        $this->Ln(25);
    }

    // Footer
    function Footer() {

    }

    function PrintTable($header, $data)
    {
        // Farbe, Schrift, usw...
        $this->SetTextColor(255);
        $this->SetFillColor(255,0,0);
        $this->SetDrawColor(128,0,0);
        $this->SetLineWidth(.4);
        $this->SetFont('','B');

        // Tabellen Überschrift
        $w = array(40, 35, 40, 45);
        for($i=0;$i<count($header);$i++)
            $this->Cell($w[$i],7,$header[$i],1,0,'C',true);
        $this->Ln();
        // Color and font restoration
        $this->SetFillColor(224,235,255);
        $this->SetTextColor(0);
        $this->SetFont('');
        // Data
        $fill = false;
        foreach($data as $row)
        {
            $this->Cell($w[0],6,$row[0],'LR',0,'L',$fill);
            $this->Cell($w[1],6,$row[1],'LR',0,'L',$fill);
            $this->Cell($w[2],6,$row[2],'LR',0,'R',$fill);
            $this->Cell($w[3],6,$row[3],'LR',0,'R',$fill);
            $this->Ln();
            $fill = !$fill;
        }
        // Closing line
        $this->Cell(array_sum($w),0,'','T');
    }

}
?>
