<?php
if (!isset($_POST) || empty($_POST['email']) || empty($_POST['phone']) || empty($_POST['name']) || empty($_POST['companyname'])) {
    echo "<script>window.close();</script>";
   return ;
}

require_once('../../../../wp-load.php');


$name = sanitize_text_field($_POST['name']);
$email = sanitize_text_field($_POST['email']);
$phone = sanitize_text_field($_POST['phone']);
$compnay_name = sanitize_text_field($_POST['companyname']);


$to = site_url()=='https://fmla.sterlingadministration.com' ? ["shavee.kapoor@sterlingadministration.com", "Duarte.Batista@sterlingadministration.com", "fmlasales@sterlingadministration.com","marketing@heigh10.com"] : ['heigh10.deepak@gmail.com'];
	
$subject = 'FMLA - Report Download';
$message = '<body><b>Name</b>: '.$name.'<br><b>Email</b>: '.$email.'<br><b>Phone</b>: '.$phone.'<br><b>Company</b>: '.$compnay_name.'<br><br><br>---<br>Page URL: https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].'</body>';
$headers[] = 'From: FMLA <no-reply@sterlingadministration.com>';
$headers[] = 'Content-Type: text/html; charset=UTF-8';



require_once('tcpdf/tcpdf.php');
// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF {

    //Page header
    public function Header() {

        $this->ln(2);
        // Logo
         $this->Image('logo.jpg', NULL, NULL, NULL, NULL, 'JPG', '', 'T', false, 300, 'C', false, false, 0, false, false, false);

        // set some text to print
        $this->ln(30);
        $this->SetFont('helvetica', 'B', 25);
        $txt = 'FAMILY MEDICAL LEAVE ACT (FMLA)';
        $this->Cell(0, 0, $txt, 0, 2, 'C', 0, '', 1, false, 'C', 'M');
        $this->ln(5);
        $this->SetTextColor(219, 105, 38);
        $this->Cell(0, 0, 'LEAVE CALCULATOR', 0, 2, 'C', 0, '', 1, false, 'C', 'M');
        $this->Line(0, $this->y, $this->w , $this->y);
        
    }

    // Page footer
    public function Footer() {
        // Position at 15 mm from bottom
        $this->SetY(-16);
        // Set font
        $this->SetFont('helvetica','', 10);
        // Page number
        $this->Cell(0, 15, '(800) 617 4729 x860 | fmlasales@sterlingadministration.com | fmla.sterlingadministration.com', 0, false, 'C', 0, '', 0, false, 'T', 'M');
        // $this->ln(6);
        // $this->Cell(0, 10, '', 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }
}

// create new PDF document
$pdf = new MYPDF('landscape', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetAuthor('FMLA');
$pdf->SetTitle('FMLA Absence Report');
$pdf->SetSubject('FMLA Report');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(FALSE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
    require_once(dirname(__FILE__).'/lang/eng.php');
    $pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set font
$pdf->SetFont('helvetica', '', 14);

// add a page
$pdf->AddPage();

$pdf->ln(40);

// function sanitize_text_field($var){
// return $var;
// }

$html = "
<h1 style='text-align:center'>".sanitize_text_field( $_POST['name'] )."</h1>";

$pdf-> writeHTML($html,false,0,false,false,'C');

$pdf->ln(10);

$html = "<div>
<p>&nbsp;&nbsp;&nbsp;<b>Date</b>: ".date('m/d/Y',strtotime(sanitize_text_field( $_POST['start_date'] )))." to ".date('m/d/Y',strtotime(sanitize_text_field( $_POST['end_date'] )))."</p>
<p>&nbsp;&nbsp;&nbsp;<b>Average Hours</b>: ".sanitize_text_field( $_POST['avg_hours'] )."</p>
<p>&nbsp;&nbsp;&nbsp;<b>Total Available Hours</b>: ".(floatval(sanitize_text_field( $_POST['avg_hours'] ))*12)-floatval(sanitize_text_field( $_POST['used'] ))."</p>
<p>&nbsp;&nbsp;&nbsp;<b>Total Used Hours</b>: ".sanitize_text_field( $_POST['used'] )."</p></div>
";

$pdf->writeHTMLCell(110, '', 25, '', $html, 1, 0, 0, true, 'L', true);

require_once ('svggraph/autoloader.php');

$settings = [
  'auto_fit' => true,
  'back_colour' => '#eee',
  'back_stroke_width' => 0,
  'back_stroke_colour' => '#eee',
  'stroke_colour' => '#000',
  'pad_right' => 10,
  'pad_left' => 10,
  'legend_entry_height' => 10,
  // 'legend_title' => 'Legend',
  'legend_text_side' => 'right',
  'legend_position' => 'outer bottom 80 30',
  'legend_stroke_width' => 0,
  'legend_shadow_opacity' => 0,
  'link_base' => '/',
  'link_target' => '_top',
  'sort' => false,
  'show_labels' => false,
  'show_label_amount' => true,
  'label_font' => 'Arial',
  'label_font_size' => '11',
  'legend_entries' => [
    'FMLA Used Hours','FMLA Available Hours'],
  // 'inner_text' => "Sugar-free!",
];

$width = 300;
$height = 200;
$type = 'DonutGraph';
$data = json_decode(sanitize_text_field($_POST['chart']));
$values = ['FMLA Used Hours' => $data[0], 'FMLA Available Hours' => $data[1]];
$colours = ['#db6926','#16163f'];
$graph = new Goat1000\SVGGraph\SVGGraph($width, $height, $settings);
$graph->colours($colours);
$graph->values($values);

$output = $graph->fetch($type);

$pdf->ImageSVG('@' . $output, $x=180, $y=70, $w=90, $h='', $link='', $align='C', $palign='M', $border=0, $fitonpage=false);

$pdf->ln(80);

$table = json_decode(sanitize_text_field($_POST['each_month_total']));

for($i=0;$i<=11;$i++) {
    if(empty($table[$i])) $table[$i] = '';
}

$start_month = intval(explode('-',$_POST['start_date'])[1]);
$end_month = intval(explode('-',$_POST['end_date'])[1]);
$months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
$tbl = 
'<table cellspacing="0" cellpadding="1" border="1" style="width:1000px">
    <tr bgcolor="#173e64" style="color:#fff">
   <td></td>';
  
   for ($i= $start_month-1; $i < $end_month; $i++) { 
    $tbl .= '<td>'.$months[$i].'</td>';
}

  $tbl.= '</tr>
    <tr>
    <td>FMLA Used Hours</td>';
    for ($i= $start_month-1; $i < $end_month; $i++) { 
        $tbl .= '<td>'.$table[$i].'</td>';
    }

   $tbl.= '</tr>
</table>
';
$pdf->setX(5);
$pdf->setFont('','',14);
$pdf->writeHTML($tbl, true, false, false, TRUE, 'C');
//---------------------------------------------------------
$pdf->SetDisplayMode('fullwidth');
//Close and output PDF document
$pdf->Output('FMLA Leave Report.pdf', 'I');


##########################################################################################################
//SEND EMAIL
wp_mail($to, $subject,$message,$headers);

//INSERT INTO ELEMENTOR DB --start
global $wpdb, $table_prefix;
$main_table = $table_prefix.'e_submissions';
$value_table = $table_prefix.'e_submissions_values';

$exist_id = $wpdb->get_results("SELECT submission_id FROM $value_table WHERE value LIKE '$email'");

if(empty($exist_id)){
$wpdb-> query(sprintf("INSERT INTO %s (type,hash_id,main_meta_id,post_id,referer,referer_title,element_id,form_name,campaign_id,user_ip,user_agent,status,is_read,created_at_gmt,updated_at_gmt,created_at,updated_at) VALUES('%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s',%d,'%s','%s','%s','%s')",$main_table,'submission',sha1(date('Y-m-d H:i:s')),'','',$_SERVER['HTTP_REFERER'],'Calculator','618795e5','Calculator Popup','',$_SERVER['REMOTE_ADDR'],$_SERVER['HTTP_USER_AGENT'],'new',0,gmdate('Y-m-d H:i:s'),gmdate('Y-m-d H:i:s'),gmdate('Y-m-d H:i:s'),gmdate('Y-m-d H:i:s')));
$sub_id = $wpdb->insert_id;

$values = ['Name'=>$name,'Email'=>$email,'Phone'=>$phone,'Company Name'=>$compnay_name];
foreach ($values as $column => $value) {
    $arr = ['submission_id'=>$sub_id,'key'=>$column,'value'=>$value];
	$wpdb->insert($value_table,$arr);
}

 $wpdb->update($main_table,['main_meta_id'=>$wpdb->insert_id],['id'=>$sub_id]);

}
/** --END */
