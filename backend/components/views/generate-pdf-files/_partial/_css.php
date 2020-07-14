<?php
 //CSS für alle anderen Partials
?>

<style>
    /*Page format*/
    @page  {
        margin-left: 25mm;
        margin-right: 20mm;
        margin-top: 20mm;
        margin-bottom: 20mm;
        header: document_header;
        footer: document_footer;
    }
    /* _base_data begin */
    .base_data_table, .base_data_table th, .base_data_table td {
        padding: 2px;
        text-align: left;
    }

    .base_data_table th {
        width: 300px;
    }

    .base-data-view h3 {
        margin-bottom: 2px;
    }

    /* _base_data end */

    /* _functions begin */
    .functions_table {
        font-size: 11pt;
    }
    .functions_table th, .functions_table td {
        text-align: left;
        vertical-align: top;
    }

    .functions_table td {
        padding-bottom: 10px;
        padding-top: 10px;
    }
    /* _functions end */

    /* _functions_text begin */
    .function-text p {
        margin-top: 2px;
    }
    .function-text h3 {
        margin-bottom: 0;
    }

    .function-category-number {
        font-weight: normal;
    }
    /* _functions_text end */

    /* _header and _footer */
    .header-footer
    {
        font-size: 9pt;
        font-style: italic;
        font-weight: bold;
    }
    /* _header and _footer end */
</style>