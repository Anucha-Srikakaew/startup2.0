
$("#login").click(function () {
    username = $("#username").val()
    password = $("#password").val()

    if (username != '') {
        if (password != '') {
            $(".se-pre-con").fadeIn()
            $.ajax({
                url: "php/ajax_checklogin.php",
                type: "POST",
                dataType: "json",
                data: {
                    'username': username,
                    'password': password,
                },
                success: function (result) {
                    console.log(result)
                    $(".se-pre-con").fadeOut()

                    if (result.STARTUP_EMP_ID == '') {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Please check your member.',
                        })
                    } else {
                        if (result.STARTUP_EMP_TYPE == 'TECH') {
                            window.location.href = 'startup_c.html?COUNTRY=' + COUNTRYmain + '&FACTORY=' + FACTORYmain + '&BIZ=' + BIZmain + '&PERIOD=' + PERIODmain + ''
                        } else if (result.STARTUP_EMP_TYPE == 'PIC') {
                            window.location.href = 'visual.html'
                        } else {
                            window.location.href = 'visual.html'
                        }
                    }
                }
            })
        } else {
            Swal.fire({
                icon: 'info',
                title: 'Oops...',
                text: 'Please input user password',
            }).then(function () {
                $("#password").focus()
            })
        }
    } else {
        Swal.fire({
            icon: 'info',
            title: 'Oops...',
            text: 'Please input user id',
        }).then(function () {
            $("#username").focus()
        })
    }
})
