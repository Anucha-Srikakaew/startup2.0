var table = $('#example').DataTable({
    paging: false,
    searching: false,
    createdRow: function (row, data, dataIndex) {
        // console.log(row)

        // $('td:eq(1)', row).css('font-weight', 'bold');
        // $('td:eq(2)', row).css('font-weight', 'bold');
        // $('td:eq(5)', row).css('font-weight', 'bold');
        // $('td:eq(6)', row).css('font-weight', 'bold');

        // if ((typeof data[6]) == 'string') {
        //     $('td:eq(6)', row).attr('colspan', 2);
        //     $('td:eq(5)', row).css('display', 'none');
        // }

        // if ((typeof data[2]) == 'string') {
        //     $('td:eq(2)', row).attr('colspan', 2);
        //     $('td:eq(1)', row).css('display', 'none');
        // }
    }
});

const queryString = window.location.search;
const urlParams = new URLSearchParams(queryString);
var COUNTRY = urlParams.get('COUNTRY')
var FACTORY = urlParams.get('FACTORY')
var BIZ = urlParams.get('BIZ')
var CENTER = urlParams.get('CENTER')
var LINE = urlParams.get('LINE')
var START_DATE = urlParams.get('START_DATE')
var END_DATE = urlParams.get('END_DATE')
var SHIFT = urlParams.get('SHIFT')
var PERIOD = urlParams.get('PERIOD')

var dataSearch = {
    COUNTRY: COUNTRY,
    FACTORY: FACTORY,
    BIZ: BIZ,
    CENTER: CENTER,
    LINE: LINE,
    START_DATE: START_DATE,
    END_DATE: END_DATE,
    SHIFT: SHIFT,
    PERIOD: PERIOD
}
{/* <p class="lead" id="txtMain"><b>COUNTRY : TH / FACTORY : STTC / BIZ : IM</b></p>
<p class="lead" id="txtSub"><b>LINE : HEA / MODEL : CX622XX_TI,CX622XX_TI,CX622XX_TI,CX622XX_TI</b></p> */}
console.log(dataSearch)

$('#txtMain').text('COUNTRY : ' + COUNTRY + ' / FACTORY : ' + FACTORY + ' / BIZ : ' + BIZ + '')

$.ajax({
    url: "php/ajax_query_visual_line_sub_obj.php",
    type: "POST",
    dataType: "json",
    data: dataSearch,
    success: function (result) {
        
    }
})