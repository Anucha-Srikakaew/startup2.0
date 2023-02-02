var table = $('#example').DataTable({
    paging: false,
    searching: false,
    columns: [
        { data: 'MEMBER_ID' },
        { data: 'MEMBER_ID' },
        { data: 'NAME' },
        { data: 'TYPE' },
        { data: 'ID' }
    ],
    createdRow: function (row, data, dataIndex) {
        if (data.FACTORY == 'STTC') {
            url = 'http://43.72.52.159/ATTENd/IMG_opt/' + data.MEMBER_ID + '.jpg'
        } else {
            url = 'http://43.72.228.147/attend/img_opt/' + data.MEMBER_ID + '.jpg'
        }
        var img2 = '<img src="' + url + '" alt="" width="70%">'
        $('td:eq(0)', row).empty()
        $('td:eq(0)', row).append(img2)

        var button = '<button class="btn btn-sm btn-danger" onclick="del(this.name)" name="' + data.ID + '">DELETE</button>'
        $('td:eq(4)', row).empty()
        $('td:eq(4)', row).append(button)
    }
})

var dataSearch = {
    FACTORY: '',
    TYPE: '',
}
search(dataSearch)
function search(dataSearch) {
    $.ajax({
        url: "php/ajax_query_member.php",
        type: "POST",
        dataType: "json",
        data: dataSearch,
        async: false,
        success: function (json) {
            table.clear().draw()
            table.rows.add(json).draw().nodes().to$().addClass("text-center")
        }
    })
}

$('select').change(function () {
    dataSearch[this.id] = this.value
    search(dataSearch)
})

function del(id) {
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
                url: "php/ajax_delete_member.php",
                type: "POST",
                dataType: 'json',
                data: {
                    'ID': id
                },
                success: function (json) {
                    if (json.response == true) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Complete.',
                            text: json.message,
                        }).then(function () {
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
            });
        }
    })
}
var memberidAdd = '', nameAdd = '', typeAdd = ''

var myModalEl = document.getElementById('exampleModal')
myModalEl.addEventListener('shown.bs.modal', function (event) {
    // do something...
    memberidAdd = ''
    nameAdd = ''
    typeAdd = ''
    // $("#FACTORYAdd").val()
    // $("#TYPEAdd").val()
    $("#member_id").val('')
    $("#imgMemberAdd").attr('src', '')
})

$("#member_id").on('keyup keypress blur change', function () {
    var fac = $("#FACTORYAdd").val()
    var memberID = this.value

    $.ajax({
        url: "php/ajax_member_add.php",
        type: "POST",
        dataType: 'json',
        data: {
            'memberID': memberID,
            'fac': fac,
            'typeQuery': 'select'
        },
        success: function (json) {
            console.log(json)
            if (json.data != null) {
                memberidAdd = json.data.ENID
                nameAdd = json.data.EMP_NAME_EN
                typeAdd = $("#TYPEAdd").val()
                $("#imgMemberAdd").attr('src', 'http://43.72.52.159/ATTENd/IMG_opt/' + json.data.ENID + '.jpg')
            }
        }
    });
})

function save() {
    $.ajax({
        url: "php/ajax_member_add.php",
        type: "POST",
        dataType: 'json',
        data: {
            'typeQuery': 'insert',
            'FACTORY': $("#FACTORYAdd").val(),
            'MEMBER_ID': memberidAdd,
            'NAME': nameAdd,
            'TYPE': $("#TYPEAdd").val(),
        },
        success: function (json) {
            if (json.response == true) {
                Swal.fire({
                    icon: 'success',
                    title: 'Complete.',
                    text: json.message,
                }).then(function () {
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
    });
}