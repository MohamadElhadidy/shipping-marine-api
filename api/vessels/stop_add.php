<!DOCTYPE html>
<html>

<head>
    <title>إضافة خصم</title>
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
        font-family: "Changa", sans-serif !important;
        font-size: 1.2rem;
        direction: rtl;
        overflow: visible;
        text-align: center !important;
        align-items: center !important;
        justify-content: center !important;
    }

    input[type="number"] {
        width: 40vw;
        margin-bottom: 10px;
        text-align: center;
    }

    input[type="text"] {
        width: 85vw;
        margin-bottom: 10px;
        text-align: center;
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
        margin-top: -10px;
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
            <div class="panel-heading">إضافة توقف للباخرة </div>
            <div class="panel-body text-center justify-content-center">
                <form id="myform">
                    <div class="form-group">
                        <label>اختر الباخرة</label>
                        <select name="vessels" id="vessels" class="form-control input-lg" data-live-search="true"
                            title="اختر الباخرة">

                        </select>
                    </div>
                    <div id="element">
                        <input type="number" id='hours' placeholder="ساعة" name="hours">
                        <input type="number" id='minutes' placeholder="دقيقة" name="minutes">

                        <input type="text" id="cause" placeholder="سبب التوقف" name="cause">

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
    load_data('vessels');

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
                    html += '<option value="' + data[count].id + '">' + data[count].name +
                        ' - ' +
                        data[count].type +
                        '</option>';
                }
                if (type == 'vessels') {
                    $('#vessels').html(html);
                    $('#vessels').selectpicker('refresh');
                } else {
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
            hours: {
                required: true
            },
            minutes: {
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
                hours: $("#hours").val(),
                minutes: $("#minutes").val(),
                cause: $("#cause").val(),
                employee: $("#employee").val()
            };

            $.ajax({
                type: "POST",
                url: '../controllers/stop_add.php',
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
                    $.confirm({
                        title: 'تم إضافة توقف ',
                        icon: 'fa fa-thumbs-up',
                        content: ' للباخرة ' + data.name,
                        type: 'green',
                        rtl: true,
                        closeIcon: false,
                        draggable: true,
                        dragWindowGap: 0,
                        typeAnimated: true,
                        theme: 'supervan',
                        autoClose: 'okAction|600000000',
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
            })
        }
    });
});
</script>