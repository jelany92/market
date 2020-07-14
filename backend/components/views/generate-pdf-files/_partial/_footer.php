<table width="100%" class="header-footer">
    <tr>
        <td width="33%">
            {DATE d.m.Y}
        </td>
        <td width="33%" align="center">
            Seite {PAGENO} von {nbpg}
        </td>
        <td width="33%" style="text-align: right;">
            <?= $model->pdfDownload->getPdfDownloadString()->footer()->one()->content ?>
        </td>
    </tr>
</table>