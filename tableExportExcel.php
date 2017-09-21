<?php ?>


<div>
    <table id="test_table">

    </table>
    <button >EXPORT TO EXCEL</button></div>
</div>

<script>
    jQuery(document).ready(function () {

        //Export to Excel---------------------------------------------------------
        var btn_export = jQuery(".btn_export");

        btn_export.click(function () {
            var table = jQuery("#test_table");
            //console.log(table);
            fnExcelReport(table);
        });

        function fnExcelReport(filename, table)
        {
            var tab_text = "<table border='2px'>";
            var j = 0;
            jQuery.each(table.find("tr"), function (i, row) {
                tab_text += "<tr>";
                jQuery.each(jQuery(row).find("td"), function (i, col) {

                    //skip delete and email etp operation
                    if (i !== 1 && i !== 6) {
                        tab_text += "<td>";
                        var dom_col = jQuery(col);
                        var innerText = dom_col.html();
                        //input               
                        if (innerText.indexOf("<input") > -1) {
                            tab_text += dom_col.find("input").val();
                        }
                        //textarea                    
                        else if (innerText.indexOf("<textarea") > -1) {
                            tab_text += dom_col.find("textarea").html();
                        }
                        //normal column text
                        else {
                            tab_text += innerText;
                        }

                        tab_text += "</td>";
                    }
                });
                tab_text += "</tr>";
            });

            tab_text += "</table>";
            //tab_text = tab_text.replace(/<a[^>]*>|<\/a>/g, ""); //remove if u want links in your table
            tab_text = tab_text.replace(/<span[^>]*>|<\/span>/gi, ""); // reomves input params
            tab_text = tab_text.replace(/&nbsp;/gi, ""); // reomves input params

            tab_text = tableToExcel(tab_text);
            tab_text = encodeURIComponent(tab_text);

            var a = document.createElement('a');
            var uri = 'data:application/vnd.ms-excel,';
            var href = uri + tab_text;
            a.href = href;
            a.download = filename + '.xls';
            a.click();

            return;

        }

        function tableToExcel(table_text) {
            var excelFile = "<html xmlns:o='urn:schemas-microsoft-com:office:office' xmlns:x='urn:schemas-microsoft-com:office:excel' xmlns='http://www.w3.org/TR/REC-html40'>";
            excelFile += "<head>";
            excelFile += "<!--[if gte mso 9]>";
            excelFile += "<xml>";
            excelFile += "<x:ExcelWorkbook>";
            excelFile += "<x:ExcelWorksheets>";
            excelFile += "<x:ExcelWorksheet>";
            excelFile += "<x:Name>";
            excelFile += "{worksheet}";
            excelFile += "</x:Name>";
            excelFile += "<x:WorksheetOptions>";
            excelFile += "<x:DisplayGridlines/>";
            excelFile += "</x:WorksheetOptions>";
            excelFile += "</x:ExcelWorksheet>";
            excelFile += "</x:ExcelWorksheets>";
            excelFile += "</x:ExcelWorkbook>";
            excelFile += "</xml>";
            excelFile += "<![endif]-->";
            excelFile += "</head>";
            excelFile += "<body>";
            excelFile += table_text;
            excelFile += "</body>";
            excelFile += "</html>";
            return excelFile;
        }

        //Export to Excel---------------------------------------------------------

    });
</script>
