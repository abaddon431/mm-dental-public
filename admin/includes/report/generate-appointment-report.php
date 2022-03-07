<?php

session_start();
if(isset($_SESSION['patient_rec_edit']))
{
    if($_SESSION['patient_rec_edit']==1)
    {
        include_once '../../classes/autoloader.php';
        require('../../includes/fpdf184/fpdf.php');
        date_default_timezone_set('Asia/Singapore');
        $off_set=0;
        $previous_id=0;
        $id=0;
        $type="Monthly";
        //////
        $month=date("m");
        $year=date("Y");
        ////
        $generate_report_obj=new DBOpController();
        $data=$generate_report_obj->report_month_appointment($month,$year);
        $data_size=sizeof($data);
        class PDF extends FPDF
        {
            // Page header
            function Header()
            {
                // Arial bold 15
                $this->Image('../../images/mediatrix-main-logo.png',74,10,59.27,9.99,'PNG');
                $this->SetFont('Times','B',15);
                // Line break
                $this->Ln(15);
            }

            // Page footer
            function Footer()
            {
                // Position at 1.5 cm from bottom
                $this->SetY(-15);
                // Arial italic 8
                $this->SetFont('Times','I',8);
                // Page number
                $this->Cell(0,0,'Page '.$this->PageNo().' of {nb}',0,1,'C');
                $this->Cell(0,10,'Generated: '.date('M-d-Y'),0,0,'R');
            }
            var $widths;
            var $aligns;
            var $lineHeight;

            //Set the array of column widths
            function SetWidths($w){
                $this->widths=$w;
            }

            //Set the array of column alignments
            function SetAligns($a){
                $this->aligns=$a;
            }

            //Set line height
            function SetLineHeight($h){
                $this->lineHeight=$h;
            }

            //Calculate the height of the row
            function Row($data)
            {
                // number of line
                $nb=0;

                // loop each data to find out greatest line number in a row.
                for($i=0;$i<count($data);$i++){
                    // NbLines will calculate how many lines needed to display text wrapped in specified width.
                    // then max function will compare the result with current $nb. Returning the greatest one. And reassign the $nb.
                    $nb=max($nb,$this->NbLines($this->widths[$i],$data[$i]));
                }
                
                //multiply number of line with line height. This will be the height of current row
                $h=$this->lineHeight * $nb;

                //Issue a page break first if needed
                $this->CheckPageBreak($h);

                //Draw the cells of current row
                for($i=0;$i<count($data);$i++)
                {
                    // width of the current col
                    $w=$this->widths[$i];
                    // alignment of the current col. if unset, make it left.
                    $a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
                    //Save the current position
                    $x=$this->GetX();
                    $y=$this->GetY();
                    //Draw the border
                    //Print the text
                    $this->MultiCell($w,5,$data[$i],0,$a);
                    //Put the position to the right of the cell
                    $this->SetXY($x+$w,$y);
                }
                //Go to the next line
                $this->Ln($h);
            }

            function CheckPageBreak($h)
            {
                //If the height h would cause an overflow, add a new page immediately
                if($this->GetY()+$h>$this->PageBreakTrigger)
                    $this->AddPage($this->CurOrientation);
            }

            function NbLines($w,$txt)
            {
                //calculate the number of lines a MultiCell of width w will take
                $cw=&$this->CurrentFont['cw'];
                if($w==0)
                    $w=$this->w-$this->rMargin-$this->x;
                $wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
                $s=str_replace("\r",'',$txt);
                $nb=strlen($s);
                if($nb>0 and $s[$nb-1]=="\n")
                    $nb--;
                $sep=-1;
                $i=0;
                $j=0;
                $l=0;
                $nl=1;
                while($i<$nb)
                {
                    $c=$s[$i];
                    if($c=="\n")
                    {
                        $i++;
                        $sep=-1;
                        $j=$i;
                        $l=0;
                        $nl++;
                        continue;
                    }
                    if($c==' ')
                        $sep=$i;
                    $l+=$cw[$c];
                    if($l>$wmax)
                    {
                        if($sep==-1)
                        {
                            if($i==$j)
                                $i++;
                        }
                        else
                            $i=$sep+1;
                        $sep=-1;
                        $j=$i;
                        $l=0;
                        $nl++;
                    }
                    else
                        $i++;
                }
                return $nl;
            }
        }


        // Instanciation of inherited class
        $pdf = new PDF('P','mm','A4');
        $pdf->SetWidths(Array(10,155,25));
        $pdf->SetLineHeight(5);
        $pdf->AddPage();
        $pdf->AliasNbPages();
        $pdf->SetFont('Times','B',12);
        $pdf->Cell(190,0,'',1,1,'C');
        $pdf->Cell(190,5,'',0,1,);
        $pdf->Cell(190,0,$type.' Appointment Summary Report',0,1,'C');
        $pdf->Cell(190,5,'',0,1);

        $pdf->SetFont('Times','B',12);
        $pdf->Cell(190,5,'Accepted',0,1,'L');
        for($i=0;$i<$data_size;$i++)
        {
            if($data[$i]['status']==7)
            {
                $pdf->SetFont('Times','',11);
                $pdf->Row(Array(
                    '',
                    chr(149).' '.$data[$i]['name'].' - '.$data[$i]['email'],
                    date('M d, Y',strtotime($data[$i]['date_recieved']))
                ));
                $pdf->Cell(189	,1,'',0,1);//end of line
            }
        }
        $pdf->SetFont('Times','B',12);
        $pdf->Cell(190,5,'Denied',0,1,'L');
        for($i=0;$i<$data_size;$i++)
        {
            if($data[$i]['status']==8)
            {
                $pdf->SetFont('Times','',11);
                $pdf->Row(Array(
                    '',
                    chr(149).' '.$data[$i]['name'].' - '.$data[$i]['email'],
                    date('M d, Y',strtotime($data[$i]['date_recieved']))
                ));
                $pdf->Cell(189	,1,'',0,1);//end of line
            }
        }
        $filename=strtolower($type).'-report'.date('m-d-y').'.pdf';
        $pdf->Output('I',$filename);
    }
    else
    {
        echo "You cannot access this feature :(";
    }
}
else
{
    header('location: ../../index.php');
}
?>
