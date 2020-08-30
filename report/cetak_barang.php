<?php
 require_once('../config/koneksi.php');
 require_once('../models/database.php');
include "../models/m_barang.php";
 $connection =  new Database($host, $user, $pass, $database);
    $brg =  new Barang($connection);

$content = '
<style>

</style
';

$content .= '
<page>
    <div style="padding: 4mm; border:1px solid;" align="center">
        <span style="font-size:25px;> report barang </span>
    </div>
    <div style="padding: 20px 0 10px 0; font-size: 15px;">
        laporan data barang
    </div>

</page>
';


require_once('.../assets/html2pdf/html2pdf.class.php');
$html2pdf = new HTML2PDF('P','A4','en');
$html2pdf->WriteHTML($content);
$html2pdf->Output('exemple.pdf');



?>