<?php
// database connection
require "../../config.php";

$id =$_GET['id'];
$result = mysqli_query($con,"SELECT *  FROM cars   where  id =  $id ");
$row = mysqli_fetch_assoc($result);
$vessel_id=$row['vessel_id'];

$result = mysqli_query($con,"SELECT *  FROM vessels_log   where  vessel_id = '$vessel_id'");
$row2 = mysqli_fetch_assoc($result);

$types = mysqli_query($con,"SELECT *  FROM cars_types ");
?>
<!DOCTYPE html>
<html>
<html>

<head>
    <title> تعديل بيانات سيارة</title>
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
        font-size: 1.1rem;
        direction: rtl;
        overflow: visible;
        text-align: center !important;
        align-items: center !important;
        justify-content: center !important;
    }

    input[type="text"] {
        margin-bottom: 5px;
        text-align: center;
    }

    .disabled {
        width: 40vw;
        margin-bottom: 5px;
        text-align: center;
    }

    p {
        font-size: .8rem;
        width: 30vw !important;
        display: inline-block;
    }

    .text {
        width: 50vw !important;
        margin-bottom: 10px;
        text-align: center;
    }

    select {
        width: 50vw !important;
        text-align: center !important;
        margin-bottom: 5px;
    }

    .width {
        width: 80vw !important;
    }

    #element {
        display: none;
    }

    .error_input {
        border: red solid 2px !important;
    }
    </style>
</head>

<body>
    <div class="container">
        <div class="panel panel-default">
            <div class="panel-heading"> تعديل بيانات سيارة</div>
            <div class="panel-body text-center justify-content-center">
                <form id="myform">
                    <input type="hidden" value="<?php echo $id ;?>" id="id" name="id">

                    <input type="text" class="disabled" disabled value="<?php echo $row2['name'];?>">
                    <input type="text" class="disabled" disabled value="<?php echo $row2['type'];?>">

                    <input type="text" class="disabled" disabled value="<?php echo$row['sn'];?>">
                    <input type="text" class="disabled" disabled value="<?php echo $row['car_no'];?>">
                    <p>أرقام السيارة الجديدة</p>
                    <input type="number" id="carn" name="carn" pattern="[0-9]{1,4}" class="text"
                        placeholder="أرقام السيارة الجديدة">
                    <p>حروف السيارة الجديدة</p>
                    <input type="text" id="carl" pattern="[أ-ي _]+" name="carl" class="text"
                        placeholder="حروف السيارة الجديدة">
                    <p>نوع السيارة</p>
                    <select id="car_type" name="car_type">
                        <option value="<?php echo $row['car_type'] ;?>"><?php echo $row['car_type'] ;?></option>
                        <?php   while ($type = mysqli_fetch_assoc($types)) {
                                    if($type["name"] !=  $row['car_type']) echo '<option value="'.$type["name"].'">'.$type["name"].'</option>';
                        }
                        ?>
                    </select>
                    <p>المقاول / الشركة</p>
                    <input type="text" id="car_owner" name="car_owner" class="text"
                        value="<?php echo $row['car_owner'];?>">
                    <p> وزن المحاور</p>
                    <input type="text" class="text" pattern="[0-9]+(\.[0-9]{1,2})?%?" id="mehwer" name="mehwer"
                        value="<?php echo $row['mehwer'];?>">
                    <p>وزن الفارغ</p>
                    <input type="text" class="text" pattern="[0-9]+(\.[0-9]{1,2})?%?"
                        value="<?php echo $row['vacant'];?>" id="vacant" name="vacant">

                    <button class="btn btn-primary  btn-lg" id='btn-save'>حفظ البيانات</button>
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
<script src="https://cdn.jsdelivr.net/gh/mgalante/jquery.redirect@master/jquery.redirect.js"></script>
<script>
$(document).on('change', '#car_type', function() {
    var type = $('#car_type').val();
    if (type == 'سيارة الشركة') $("#car_owner").val(type);
});


$("#btn-save").click(function(e) {
    $("#myform").validate({
        rules: {
            id: {
                required: true
            },
            carl: {
                required: true
            },
            carn: {
                required: true
            },
            car_type: {
                required: true
            },
            car_owner: {
                required: true
            },
            mehwer: {
                required: true
            },
            vacant: {
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
                id: $("#id").val(),
                carl: $("#carl").val(),
                carn: $("#carn").val(),
                car_type: $("#car_type").val(),
                car_owner: $("#car_owner").val(),
                mehwer: $("#mehwer").val(),
                vacant: $("#vacant").val()
            };

            $.ajax({
                type: "POST",
                url: '../controllers/car_update.php',
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
                        title: 'تم التعديل بنجاح  ',
                        icon: 'fa fa-thumbs-up',
                        content: ' ارجع للخلف',
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
                                    $.redirect("edit.php", "",
                                        "GET", "");
                                }
                            },
                        }
                    })
                }
            })
        }
    })
});
</script>