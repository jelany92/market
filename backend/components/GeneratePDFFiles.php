<?php

namespace backend\components;


use backend\models\PdfDownloadSelectedAdditionalContent;
use common\models\BaseData;
use kartik\mpdf\Pdf;
use Yii;

class GeneratePDFFiles
{
    private static $partials = [
        '_css'            => ['doNewPage' =>false, 'alwaysDisplay' => true],
        '_cover_page'     => ['doNewPage' =>true, 'alwaysDisplay' => false],
        '_base_data'      => ['doNewPage' =>true, 'alwaysDisplay' => false],
        '_preface'        => ['doNewPage' =>true, 'alwaysDisplay' => false],
        '_provider_data'  => ['doNewPage' =>true, 'alwaysDisplay' => false],
        '_functions'      => ['doNewPage' =>true, 'alwaysDisplay' => false],
        '_final_page'     => ['doNewPage' =>true, 'alwaysDisplay' => false],
        '_functions_text' => ['doNewPage' =>true, 'alwaysDisplay' => false],
    ];

    /**
     * helper function to reduce code size
     *
     * @param       $partialName
     * @param array $params
     *
     * @return string
     */
    private static function renderPartial($partialName, $params = [])
    {
        return Yii::$app->controller->renderPartial('@backend/components/views/generate-pdf-files/_partial/' . $partialName, $params);
    }

    /**
     * renders PDF
     *
     * @param BaseData $model
     *
     * @return mixed
     * @throws \Mpdf\MpdfException
     * @throws \yii\base\InvalidConfigException
     */
    public static function pdf(BaseData $model)
    {
        $pdf = new Pdf([
            'mode'     => Pdf::MODE_CORE,
            'filename' => GeneratePDFFiles::generatePdfFilename($model),
            // leaner size using standard fonts
            'options'  => [
                'title'   => 'Privacy Policy',
                'subject' => 'Generating PDF files via yii2-mpdf extension has never been easy',
            ],
        ]);
        /* @var $mpdf \Mpdf\Mpdf */
        $mpdf                    = $pdf->api; // fetches mpdf api
        $mpdf->useActiveForms    = true;
        $mpdf->defaultheaderline = false;
        $mpdf->defaultfooterline = false;
        $mpdf->SetTitle(date('d.m.Y') . ' Leistungskatalog ' . $model->company_name);
        $mpdf->SetAuthor($model->first_name . ' ' . $model->last_name);

        //Header und Footer setzen
        $mpdf->DefHTMLHeaderByName('document_header', self::renderPartial('_header', ['model' => $model]));
        $mpdf->DefHTMLFooterByName('document_footer', self::renderPartial('_footer', ['model' => $model]));

        $partialsToDisplay = $model->pdfDownload->getPdfDownloadContents()->indexBy('content')->all();
        $partialsAsHtml    = [];
        foreach (self::$partials as $partial => $arrConfig)
        {
            if (array_key_exists($partial, $partialsToDisplay) || $arrConfig['alwaysDisplay'])
            {
                $partialsAsHtml[] = [
                    'doNewPage' => $arrConfig['doNewPage'],
                    'html'      => self::renderPartial($partial, ['model' => $model]),
                ];
            }
        }

        $hadContent = false;
        foreach ($partialsAsHtml as $key => $arrData)
        {
            if ($hadContent)
            {
                $mpdf->AddPage();
            }
            $mpdf->WriteHTML($arrData['html']);
            if (0 < strlen(trim($arrData['html'])) && $arrData['doNewPage'])
            {
                $hadContent = true;
            }
            else
            {
                $hadContent = false;
            }
        }

        return $pdf->render();
    }

    /**
     * generatePdfFilename
     *
     * @param BaseData $model
     *
     * @return string
     */
    public static function generatePdfFilename(BaseData $model)
    {
        $model->company_name = preg_replace("/[^a-zA-Z0-9 ]/", "", $model->company_name);
        $model->company_name = str_replace(" ", "_", $model->company_name);
        return date('Y_m_d') . '_Leistungskatalog_' . $model->company_name . '.pdf';
    }

    /**
     * returns saved color for additional content type
     *
     * @param $baseData
     * @param $type
     *
     * @return array|false
     * @throws \yii\db\Exception
     */
    public static function getAdditionalContentColorByType(BaseData $baseData, $type)
    {
        if ($type == PdfDownloadSelectedAdditionalContent::TYPE_EXPLAIN)
        {
            $command = Yii::$app->getDb()->createCommand("
            SELECT DISTINCT pdacc.color, pdacc.back_color
            FROM pdf_download_additional_content_color AS pdacc 
            INNER JOIN pdf_download AS pd ON pd.id = pdacc.pdf_download_id
            INNER JOIN category_function_answer AS cfa ON cfa.base_data_id = pd.base_data_id
            INNER JOIN pdf_download_selected_additional_content AS pdsac ON pdsac.pdf_download_id = pd.id AND pdsac.type = pdacc.type
            WHERE cfa.`explain` = 1 AND pd.base_data_id = :base_data_id AND pdacc.type = :searchedType
            ", [
                'base_data_id' => $baseData->id,
                'searchedType' => $type,
            ]);
        }
        else
        {
            $command = Yii::$app->getDb()->createCommand("
            SELECT DISTINCT pdacc.color, pdacc.back_color
            FROM pdf_download_additional_content_color as pdacc 
            INNER JOIN pdf_download AS pd ON pd.id = pdacc.pdf_download_id
            INNER JOIN category_function_answer AS cfa ON cfa.base_data_id = pd.base_data_id
            INNER JOIN pdf_download_selected_additional_content AS pdsac ON pdsac.pdf_download_id = pd.id AND pdsac.type = pdacc.type
            WHERE cfa.test_criteria = 1 AND pd.base_data_id = :base_data_id AND pdacc.type = :searchedType
            ", [
                'base_data_id' => $baseData->id,
                'searchedType' => $type,
            ]);
        }
        return $command->queryOne();
    }

    /**
     * returns array of saved colors of the given answer Id
     *
     * @param BaseData $baseData
     * @param          $answerId
     *
     * @return array|false
     * @throws \yii\db\Exception
     */
    public static function getAnswerColorByAnswerId(BaseData $baseData, $answerId)
    {
        $command = Yii::$app->getDb()->createCommand("
        SELECT DISTINCT a.name, pdac.color, pdac.back_color 
        FROM pdf_download_answer_color AS pdac 
        INNER JOIN pdf_download AS pd ON pd.id = pdac.pdf_download_id
        INNER JOIN pdf_download_selected_answer AS pdsa ON pdsa.pdf_download_id = pd.id AND pdsa.answer_id = pdac.answer_id
        INNER JOIN answer AS a ON a.id = pdac.answer_id
        WHERE pdac.answer_id = :answerId AND pd.base_data_id = :baseData
        ", [
            'answerId' => $answerId,
            'baseData' => $baseData->id,
        ]);
        return $command->queryOne();
    }
}