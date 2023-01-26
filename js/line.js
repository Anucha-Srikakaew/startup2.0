$(".se-pre-con").fadeOut()
console.log(STARTUP_EMP_BIZ)
console.log(STARTUP_EMP_COUNTRY)
console.log(STARTUP_EMP_FACTORY)

$("#FACTORY").val(STARTUP_EMP_FACTORY)
$("#BIZ").val(STARTUP_EMP_BIZ)

var dataShow = [], dataEdit = {
}, idUpdate

var table = $('#example').DataTable({
    paging: false,
    searching: false,
    columns: [
        { data: 'FACTORY' },
        { data: 'BIZ' },
        { data: 'LINE' },
        { data: 'TYPE' },
        { data: 'ID' },
    ],
    createdRow: function (row, data, dataIndex) {
        dataShow[data.ID] = data

        var selectType = '<select name="selectEdit" id="selectEdit' + data.ID + '" class="form-select">'
        // selectType += '<option value="' + data.TYPE + '">' + data.TYPE + '</option>'
        selectType += '<option value="CENTER">CENTER</option>'
        selectType += '<option value="PRODUCTION">PRODUCTION</option>'
        selectType += '</select>'

        $('td:eq(3)', row).empty()
        $('td:eq(3)', row).append(selectType)

        // var startup_day = data.START_TIME_SHIFT_DAY + ' - ' + data.TARGET_TIME_SHIFT_DAY
        // $('td:eq(2)', row).empty()
        // $('td:eq(2)', row).append(startup_day)


        // var startup_night = data.START_TIME_SHIFT_NIGHT + ' - ' + data.TARGET_TIME_SHIFT_NIGHT
        // $('td:eq(3)', row).empty()
        // $('td:eq(3)', row).append(startup_night)

        // $('td:eq(4)', row).empty()
        // $('td:eq(4)', row).append(data.SHIFT_DATE)

        var btn = '<button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#exampleModal" onclick="DelData(this.name)" name="' + data.ID + '"><i class="fas fa-trash"></i></button>'
        $('td:eq(4)', row).empty()
        $('td:eq(4)', row).append(btn)
    }
});
LoadData()
function LoadData() {
    $.ajax({
        url: "php/ajax_query_line.php",
        type: "POST",
        dataType: "json",
        data: {
            BIZ: STARTUP_EMP_BIZ,
            COUNTRY: STARTUP_EMP_COUNTRY,
            FACTORY: STARTUP_EMP_FACTORY,
        },
        async: false,
        success: function (json) {
            console.log(json)
            table.clear().draw()
            table.rows.add(json).draw().nodes().to$().addClass("text-center")
            $.each(json, function (key, value) {
                if($('#selectEdit' + key).length > 0){
                    $('#selectEdit' + key).val(value.TYPE)
                }
            })
        }
    })
}

function valSelect() {
    $.each(dataShow, function (key, value) {
        if($('#selectEdit' + key).length > 0){
            $('#selectEdit' + key).val(value.TYPE)
        }
    })
}

function DelData() {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            // $.ajax({
            //     url: "php/ajax_query_line_update.php",
            //     type: "POST",
            //     dataType: "json",
            //     data: dataEdit,
            //     success: function (json) {
            //         if (json.response == true) {
            //             Swal.fire(
            //                 'Deleted!',
            //                 'Your file has been deleted.',
            //                 'success'
            //             ).then(function () {
            //                 $("#closeModal").click()
            //                 LoadData()
            //             })
            //         } else {
            //             Swal.fire({
            //                 icon: 'error',
            //                 title: 'Oops...',
            //                 text: json.message,
            //             }).then(function () {
            //                 window.location.reload()
            //             })
            //         }
            //     }
            // })
        } else {
        }
    })
}