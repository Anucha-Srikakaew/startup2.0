const queryStringmain = window.location.search;
const urlParamsmain = new URLSearchParams(queryStringmain);
const COUNTRYmain = urlParamsmain.get('COUNTRY')
const FACTORYmain = urlParamsmain.get('FACTORY')
const BIZmain = urlParamsmain.get('BIZ')
const PERIODmain = urlParamsmain.get('PERIOD')

var STARTUP_EMP_BIZ
    , STARTUP_EMP_COUNTRY
    , STARTUP_EMP_DEPARTMENT
    , STARTUP_EMP_FACTORY
    , STARTUP_EMP_ID
    , STARTUP_EMP_IMG
    , STARTUP_EMP_NAME
    , STARTUP_EMP_TYPE

// ✅ Or create a reusable function
function padTo2Digits(num) {
    return num.toString().padStart(2, '0');
}

function formatDate(date = new Date()) {
    return [
        date.getFullYear(),
        padTo2Digits(date.getMonth() + 1),
        padTo2Digits(date.getDate()),
    ].join('-');
}

// 👇️ 20220119 (get today's date) (yyyymmdd)
// console.log(formatDate());

// //  👇️️ 20250509 (yyyymmdd)
// console.log(formatDate(new Date("2025.05.09")));

checkLogin()

function checkLogin() {
    console.log('checkLogin')
    $.ajax({
        url: "php/ajax_checklogin.php",
        dataType: "json",
        success: function (result) {
            // console.log(result)
            var obj = '', cardObj = '', btn = ''
            $("#ShowLogin").empty()

            if (result.STARTUP_EMP_ID == '') {
                obj = '<div class="btn-group">' +
                    '<a href="login.html?COUNTRY=' + COUNTRYmain + '&FACTORY=' + FACTORYmain + '&BIZ=' + BIZmain + '&PERIOD=' + PERIODmain + '"' +
                    'type="button"' +
                    'class="btn btn-dark btn-sm">' +
                    'SIGN IN &nbsp; &nbsp;' +
                    '<img src="http://43.72.228.147/smart/pages/assets/media/internal/internal3.png"' +
                    'alt=""' +
                    'width="110"' +
                    'height="25">' +
                    '</a>' +
                    '</div>'
            } else {
                STARTUP_EMP_BIZ = result.STARTUP_EMP_BIZ
                STARTUP_EMP_COUNTRY = result.STARTUP_EMP_COUNTRY
                STARTUP_EMP_DEPARTMENT = result.STARTUP_EMP_DEPARTMENT
                STARTUP_EMP_FACTORY = result.STARTUP_EMP_FACTORY
                STARTUP_EMP_ID = result.STARTUP_EMP_ID
                STARTUP_EMP_IMG = result.STARTUP_EMP_IMG
                STARTUP_EMP_NAME = result.STARTUP_EMP_NAME
                STARTUP_EMP_TYPE = result.STARTUP_EMP_TYPE

                var btnStartup = '<a href="startup_c.html?COUNTRY=' + STARTUP_EMP_COUNTRY + '&FACTORY=' + STARTUP_EMP_FACTORY + '&BIZ=' + STARTUP_EMP_BIZ + '&PERIOD=' + PERIODmain + '" type="button" class="btn btn-dark form-control">STARTUP</a><br><br>'
                var btnItem = '<a href="#" type="button" class="btn btn-dark form-control">ITEM</a><br><br>'
                var btnMember = '<a href="#" type="button" class="btn btn-dark form-control">MEMBER</a><br><br>'
                var btnTime = '<a href="#" type="button" class="btn btn-dark form-control">TIME</a><br><br>'

                if (result.STARTUP_EMP_TYPE == 'TECH') {
                    btn = btnStartup
                } else if (result.STARTUP_EMP_TYPE == 'PIC') {
                    btn = btnStartup + btnItem + btnMember + btnTime
                } else {
                    btn = '<b>CONFIRM</b>'
                }

                obj = '<div class="btn-group">' +
                    '<button type="button"' +
                    'class="btn btn-dark btn-sm dropdown-toggle"' +
                    'data-bs-toggle="dropdown"' +
                    'data-bs-auto-close="outside"' +
                    'aria-expanded="false">' +
                    'Mr. Anucha Srilakaew &nbsp; &nbsp;' +
                    '<img src="http://43.72.228.147/smart/pages/assets/media/internal/internal3.png"' +
                    'alt=""' +
                    'width="110"' +
                    'height="25" >' +
                    '</button>' +
                    '<div class="dropdown-menu w-100 border-light shadow">' +
                    '<div class="container-fluid">' +
                    '<div class="text-center">' +
                    '' +
                    '<div class="row">' +
                    '<div class="col">' +
                    '<img src="' + result.STARTUP_EMP_IMG + '"' +
                    'alt=""' +
                    'class="rounded-circle"' +
                    'width="30%">' +
                    '<br>' +
                    '<h6>' + result.STARTUP_EMP_NAME + '</h6>' +
                    '<p>' + result.STARTUP_EMP_TYPE + '</p>' +
                    '<b>' + result.STARTUP_EMP_FACTORY + '</b>' +
                    '<p>' + result.STARTUP_EMP_DEPARTMENT + '</p>' +
                    '</div>' +
                    '</div>' +
                    '<div class="row">' +
                    '<div class="col">' +
                    '<div class="card">' +
                    '<div class="card-body">' +
                    btn +
                    '</div>' +
                    '</div>' +
                    '</div>' +
                    '</div>' +
                    '<br>' +
                    '<div class="row">' +
                    '<div class="col">' +
                    '<a href="#"' +
                    'class="btn btn-danger btn-sm form-control" onclick="logout()">SIGN OUT</a>' +
                    '</div>' +
                    '</div>' +
                    '</div>' +
                    '</div>' +
                    '</div>' +
                    '</div>'
            }

            $("#ShowLogin").append(obj)

            $(".se-pre-con").fadeOut()
        },
        async: false
    })
}

function logout() {
    $.ajax({
        url: "php/ajax_logout.php",
        dataType: "json",
        success: function (result) {
            window.location.href = 'login.html?COUNTRY=' + COUNTRYmain + '&FACTORY=' + FACTORYmain + '&BIZ=' + BIZmain + '&PERIOD=' + PERIODmain + ''
        }
    })
}