$(".se-pre-con").fadeOut()
console.log(STARTUP_EMP_BIZ)
console.log(STARTUP_EMP_COUNTRY)
console.log(STARTUP_EMP_FACTORY)

var dataShow = [], dataEdit = {
    // TARGET1: '',
    // TARGET2: '',
    // TARGET3: '',
    // START_TIME_SHIFT_DAY: '',
    // TARGET_TIME_SHIFT_DAY: '',
    // START_TIME_SHIFT_NIGHT: '',
    // TARGET_TIME_SHIFT_NIGHT: '',
    // SHIFT_DATE: '',
}, idUpdate

var table = $('#example').DataTable({
    paging: false,
    searching: false,
    columns: [
        { data: 'LINE' },
        { data: 'COUNTRY' },
        { data: 'FACTORY' },
        { data: 'BIZ' },
        { data: 'SHIFT_DATE' },
        { data: 'ID' },
    ],
    createdRow: function (row, data, dataIndex) {
        dataShow[data.ID] = data
        var target = 'TARGET1 : ' + data.TARGET1 + ' MIN.<br>'
        target += 'TARGET2 : ' + data.TARGET2 + ' MIN.<br>'
        target += 'TARGET3 : ' + data.TARGET3 + ' MIN.'
        $('td:eq(1)', row).empty()
        $('td:eq(1)', row).append(target)

        var startup_day = data.START_TIME_SHIFT_DAY + ' - ' + data.TARGET_TIME_SHIFT_DAY
        $('td:eq(2)', row).empty()
        $('td:eq(2)', row).append(startup_day)


        var startup_night = data.START_TIME_SHIFT_NIGHT + ' - ' + data.TARGET_TIME_SHIFT_NIGHT
        $('td:eq(3)', row).empty()
        $('td:eq(3)', row).append(startup_night)

        $('td:eq(4)', row).empty()
        $('td:eq(4)', row).append(data.SHIFT_DATE)

        var btn = '<button disabled class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#exampleModal" onclick="Edit(this.name)" name="' + data.ID + '"><i class="fas fa-edit"></i></button>'
        $('td:eq(5)', row).empty()
        $('td:eq(5)', row).append(btn)
    }
});
LoadData()
function LoadData() {
    $.ajax({
        url: "php/ajax_query_startup_time.php",
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
        }
    })
}

$('input').on('keyup keypress blur change', function (e) {
    dataEdit[this.id] = this.value
});

function Edit(id) {
    console.log(id)
    idUpdate = id
    dataEdit['ID'] = id
    $("#LINENAME").text(dataShow[id].LINE)
    $.each(dataShow[id], function (key, value) {
        $("#" + key).val(value)
    })
}

function SaveData() {
    if (Object.keys(dataEdit).length > 1) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Edit it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "php/ajax_query_startup_time_update.php",
                    type: "POST",
                    dataType: "json",
                    data: dataEdit,
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
    } else {
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Please fill data',
        })
    }
}