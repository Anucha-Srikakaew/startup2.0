const queryString = window.location.search;
const urlParams = new URLSearchParams(queryString);
var CENTER = urlParams.get('CENTER')

$("#FACTORY").val(STARTUP_EMP_FACTORY)
$("#BIZ").val(STARTUP_EMP_BIZ)
$("#txtCenter").text(CENTER)
$('input[name=LINE]').val(CENTER)
$('input[name=FACTORY]').val(STARTUP_EMP_FACTORY)

var dataShow = [], dataInsert = {}
var table = $('#example').DataTable({
    paging: false,
    searching: false,
    columns: [
        { data: 'FACTORY' },
        { data: 'BIZ' },
        { data: 'MODEL' },
        { data: 'ID' },
    ],
    createdRow: function (row, data, dataIndex) {

        dataShow[data.ID] = data

        var btn = '<button class="btn btn-danger" onclick="DelData(this.name)" name="' + data.ID + '"><i class="fas fa-trash"></i></button>'
        $('td:eq(3)', row).empty()
        $('td:eq(3)', row).append(btn)
    }
});

function saveModel() {
    var data = {}
    $.each($('input'), function (key, value) {
        data[value.name] = value.value
    })

    $.ajax({
        url: "php/ajax_query_model_insert.php",
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
        url: "php/ajax_query_model.php",
        type: "POST",
        dataType: "json",
        data: {
            BIZ: STARTUP_EMP_BIZ,
            COUNTRY: STARTUP_EMP_COUNTRY,
            FACTORY: STARTUP_EMP_FACTORY,
            CENTER: CENTER,
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
                url: "php/ajax_query_model_delete.php",
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