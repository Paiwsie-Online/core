<?php
/*
This file is part of Trust Anchor Groups Smartadmin core
Do not change this file unless you know what you are doing.
*/
namespace common\models\core;

use TCPDF;
use Yii;

class CustomPdf extends TCPDF {

    protected array $headerContent = [];

    public function setHeaderContent(array $data) {
        $this->headerContent = $data;
    }

    public function Header() {
        $header = '<table style="width: 100%; padding-top: 10mm; padding-bottom: 5mm; text-align: center">
                        <tr>
                            <td style="border-bottom-color: black"><img src="' . ($this->headerContent['logo'] ?? Yii::$app->params['branding']['pdflogo']) . '" width="50px" height="50px"></td>
                            <td style="border-bottom-color: black"><br><br><br><br><span style="font-size: 11"><strong>' . $this->headerContent['header_title'] . '</strong></span></td>
                            <td style="border-bottom-color: black"><br><h2 style="color: orange">' . Yii::$app->params['default_site_settings']['site_name'] . '</h2></td>
                        </tr>
                    </table>';
        $this->writeHTMLCell(0, 0, '', '', $header, 0, 1, 0, true, '', true);
    }

    public function Footer() {
        $footer = '<table style="width: 100%; padding-top: 23mm; padding-bottom: 5mm; padding-left: 12mm; padding-right: 7mm; text-align: center">
                    <tr>
                        <td><span style="color: gray">' . Yii::$app->params['default_site_settings']['support_email'] . '</span></td>';
        $footer .= '<td><span >' . $this->getAliasNumPage() . ' / ' . $this->getAliasNbPages() . '</span></td>';
        $footer .= '<td><span style="color: gray">' . Yii::$app->formatter->asDate(date('Y-m-d'), 'full') . '</span></td>
            </tr>
        </table>';
        $this->SetY(263);       // Position from top
        $this->SetFont('helvetica', 'I', 8);        // Font
        $this->writeHTMLCell(0, 0, '', '', $footer, 0, 1, 0, true, '', true);
    }

}