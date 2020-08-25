<?php

namespace backend\components;

use yii\bootstrap4\Html;

class ComponentsPDF extends \kartik\mpdf\Pdf
{
    /**
     * @var string the company name that is shown in the footer
     */
    public $companyName = '';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->setFooter();
    }

    /**
     * generates the default footer
     */
    private function setFooter(): void
    {
        $footer = '<div class="container">
            <div style="float: left; width: 45%">' . Html::encode($this->companyName) . '</div>
            <div style="float: left; width: 40%">' . date('d.m.Y') . '</div>
            <div style="float: left;">Seite {PAGENO} von {nbpg}</div>
            <br style="clear: left;"/>
        </div>';
        $this->api->DefHTMLFooterByName('document_footer', $footer);
    }

}