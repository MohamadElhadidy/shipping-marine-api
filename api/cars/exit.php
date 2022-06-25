<!DOCTYPE html>
<html>

<head>
    <title>خروج سيارة من المنظومة</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.2/css/bootstrap-select.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.2/js/bootstrap-select.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">

    <style>
    @import url("https://fonts.googleapis.com/css2?family=Changa:wght@600&display=swap");

    html,
    body {
        margin: 0;
        top: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: "Changa", sans-serif;
        font-size: 1.1rem;
        direction: rtl;
        overflow: visible;
        text-align: center !important;
        align-items: center !important;
        justify-content: center;
    }

    input[type="date"],
    input[type="time"] {
        width: 40vw;
        margin-bottom: 10px;
        text-align: center;
        font-family: Impact, Charcoal, sans-serif !important;
    }

    .datetime input[type="text"] {
        width: 40vw;
        margin-bottom: 10px;
        text-align: center;
    }

    #date__lable {
        width: 90vw !important;
    }

    input[type="text"] {
        width: 85vw;
        margin-bottom: 10px;
        text-align: center !important;
    }


    .bootstrap-select.btn-group .btn .filter-option,
    a {
        text-align: center !important;
        font-size: 1.2rem !important;
    }

    #element {
        display: none;
    }

    .form-group {
        margin-top: -15px !important;

    }

    .error_input {
        border: red solid 2px !important;
    }

    .bootstrap-select.btn-group .dropdown-menu li {
        padding: 10px !important;
        border: 1px solid #000;
    }
    </style>
</head>

<body>
    <div class="container">
        <div class="panel panel-default">
            <div class="panel-heading">خروج سيارة من المنظومة</div>
            <div class="panel-body text-center justify-content-center">
                <form id="myform">
                    <div class="form-group">
                        <label>اختر الباخرة</label>
                        <select name="vessels" id="vessels" class="form-control input-lg" data-live-search="true"
                            title="اختر الباخرة">

                        </select>
                    </div>
                    <div id="element">
                        <div class="form-group">
                            <label>اختر سيارة النقل</label>
                            <select name="car" id="cars" class="form-control input-lg" data-live-search="true"
                                title="اختر سيارة النقل">

                            </select>
                        </div>
                        <div class="datetime">
                            <label id="date__lable">اختر التاريخ و الوقت</label>
                            <input type="date" id="date" max='2000-13-13' placeholder="التاريخ" name="date">
                            <input type="time" id="time" placeholder="الوقت" name="time">
                        </div>
                        <input type="text" id="cause" placeholder="سبب الخروج" name="cause">

                        <input type="text" id="employee" placeholder="اسم الموظف" name="employee">
                        <button class="btn btn-primary  btn-lg" id='btn-save'>حفظ البيانات</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
<script src="https://kit.fontawesome.com/715e93c83e.js" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"
    integrity="sha512-37T7leoNS06R80c8Ulq7cdCDU5MNQBwlYoy1TX/WUsLFC2eYNqtKlV0QjH7r8JpG/S0GUMZwebnVFLPd6SU5yg=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/localization/messages_ar.min.js"
    integrity="sha512-bGOftAqe7xfGxaWMsVQR187i+R9E0tXZIUL0idz1NKBBZIW78hoDtFY9gGLEGJFwHPjQSmPiHdm+80QParVi1A=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/additional-methods.min.js"
    integrity="sha512-XZEy8UQ9rngkxQVugAdOuBRDmJ5N4vCuNXCh8KlniZgDKTvf7zl75QBtaVG1lEhMFe2a2DuA22nZYY+qsI2/xA=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/additional-methods.min.js"
    integrity="sha512-XZEy8UQ9rngkxQVugAdOuBRDmJ5N4vCuNXCh8KlniZgDKTvf7zl75QBtaVG1lEhMFe2a2DuA22nZYY+qsI2/xA=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
$(document).ready(function() {

    $('#vessels').selectpicker();
    $('#cars').selectpicker();
    load_data('vessels');

    var today = new Date();
    var dd = today.getDate();
    var mm = today.getMonth() + 1; //January is 0!
    var yyyy = today.getFullYear();

    if (dd < 10) {
        dd = '0' + dd;
    }

    if (mm < 10) {
        mm = '0' + mm;
    }

    today = yyyy + '-' + mm + '-' + dd;
    document.getElementById("date").setAttribute("max", today);

    function load_data(type, vessel_id = '') {
        $.ajax({
            url: "../controllers/load_cars.php",
            method: "POST",
            data: {
                type: type,
                vessel_id: vessel_id
            },
            dataType: "json",
            success: function(data) {
                var html = '';
                for (var count = 0; count < data.length; count++) {
                    if (type == 'cars') {
                        html += '<option value="' + data[count].id + '">' + data[count].name +
                            '</option>';
                    } else {
                        html += '<option value="' + data[count].id + '">' + data[count].name +
                            ' - ' +
                            data[count].type +
                            '</option>';
                    }
                }
                if (type == 'vessels') {
                    $('#vessels').html(html);
                    $('#vessels').selectpicker('refresh');
                } else {
                    $('#cars').html(html);
                    $('#cars').selectpicker('refresh');
                    $('#element').show();
                }
            }
        })
    }

    $(document).on('change', '#vessels', function() {
        var vessel_id = $('#vessels').val();
        load_data('cars', vessel_id);
    });

});

$("#btn-save").click(function(e) {

    $("#myform").validate({
        rules: {
            car: {
                required: true
            },
            date: {
                required: true
            },
            time: {
                required: true
            },
            cause: {
                required: true
            },
            employee: {
                required: true
            }
        },
        highlight: function(input) {
            $(input).addClass('error_input');
            $('.bootstrap-select button').css('border', 'red solid 2px');
        },
        unhighlight: function(input) {
            $(input).removeClass('error_input');
            $('.bootstrap-select button').css('border', 'black solid 1px');
        },
        errorPlacement: function(error, element) {
            $(element).append(error);
        },
        submitHandler: function() {

            e.preventDefault();
            var formData = {
                vessel_id: $("#vessels").val(),
                sn: $("#cars").val(),
                date: $("#date").val(),
                time: $("#time").val(),
                cause: $("#cause").val(),
                employee: $("#employee").val()
            };

            $.ajax({
                type: "POST",
                url: '../controllers/car_exit.php',
                data: formData,
                dataType: "json",
                encode: true,
                error: function(xhr, status, error) {
                    msg = 'اعد المحاولة مرة أخرى';
                    $.alert({
                        title: '',
                        type: 'red',
                        content: msg,
                        icon: 'fa fa-warning'
                    })
                },
                success: function(data) {
                    if(data.car_no == false ){
                        $.alert({
                        title: '',
                        type: 'red',
                        content: 'لم يتم إثبات تعتيق أخر نقلة للسيارة ',
                        icon: 'fa fa-warning'
                        })
                    }else{
                        $.confirm({
                        title: 'تم  خروج ',
                        icon: 'fa fa-thumbs-up',
                        content: ' سيارة رقم ' + data.car_no + '  بنجاح ',
                        type: 'green',
                        rtl: true,
                        closeIcon: false,
                        draggable: true,
                        dragWindowGap: 0,
                        typeAnimated: true,
                        theme: 'supervan',
                        autoClose: 'okAction|3000',
                        buttons: {
                            okAction: {
                                text: 'ارجع للخلف',
                                action: function() {
                                    $('#element').hide();
                                    $("#vessels").val('').selectpicker(
                                        'refresh');
                                }
                            },
                        }
                    })
                    }
                    
                }
            })
        }
    });
});
</script>