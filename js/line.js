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

        var selectType = '<select name="selectEdit" id="' + data.ID + '" class="form-select">'
        selectType += '<option value="" selected>TYPE</option>'
        selectType += '<option value="CENTER">CENTER</option>'
        selectType += '<option value="PRODUCTION">PRODUCTION</option>'
        selectType += '</select>'

        $('td:eq(3)', row).empty()
        $('td:eq(3)', row).append(selectType)

        var btn = '<button class="btn btn-danger" onclick="DelData(this.name)" name="' + data.ID + '"><i class="fas fa-trash"></i></button>'
        $('td:eq(4)', row).empty()
        $('td:eq(4)', row).append(btn)

        if (data.TYPE == 'CENTER') {
            var linkModel = '<a href="model.html?CENTER=' + data.LINE + '" class="text-primary"><u>' + data.LINE + '</u></a>'
            $('td:eq(2)', row).empty()
            $('td:eq(2)', row).append(linkModel)
        }
    }
});

$('select').change(function () {
    if (this.name == 'selectEdit') {
        UpdateType(this.value, this.id)
    } else {
        if (this.id == 'FACTORY') {
            STARTUP_EMP_FACTORY = this.value
        }

        if (this.id == 'BIZ') {
            STARTUP_EMP_BIZ = this.value
        }
        LoadData()
    }
})

function saveLine() {
    var data = {}
    $.each($('input'), function (key, value) {
        data[value.name] = value.value
    })

    console.log(data)

    $.ajax({
        url: "php/ajax_query_line_insert.php",
        type: "POST",
        dataType: "json",
        data: data,
        success: function (json) {
            if (json.response == true) {
                Swal.fire(
                    'Save!',
                    'Your file has been Save.',
                    'success'
                ).then(function () {
                    window.location.reload()
                })
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: json.message,
                }).then(function () {
                    window.location.reload()
                })
            }
        }
    })
}

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
            table.clear().draw()
            table.rows.add(json).draw().nodes().to$().addClass("text-center")
            $.each(json, function (key, value) {
                if ($('#' + value.ID).length > 0) {
                    $('#' + value.ID).val(value.TYPE)
                }
            })
        }
    })
}

function UpdateType(val, id) {
    $.ajax({
        url: "php/ajax_query_line_update.php",
        type: "POST",
        dataType: "json",
        data: {
            id: id,
            val: val,
        },
        success: function (json) {
            if (json.response == true) {
                console.log(json)
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: json.message,
                }).then(function () {
                    window.location.reload()
                })
            }
        }
    })
}

function DelData(id) {
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
            $.ajax({
                url: "php/ajax_query_line_delete.php",
                type: "POST",
                dataType: "json",
                data: { id: id },
                success: function (json) {
                    if (json.response == true) {
                        Swal.fire(
                            'Deleted!',
                            'Your file has been deleted.',
                            'success'
                        ).then(function () {
                            $("#closeModal").click()
                            LoadData()
                        })
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: json.message,
                        }).then(function () {
                            window.location.reload()
                        })
                    }
                }
            })
        } else {
        }
    })
}