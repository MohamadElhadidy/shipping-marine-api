<!DOCTYPE html>
<html>

<head>
    <title>إضافة الكميات طبقا للموازين</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.js"></script>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.2/css/bootstrap-select.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
    <link href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css" rel="stylesheet">

    <link href="../../css/datatable.css" rel="stylesheet">

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

    .bootstrap-select.btn-group .btn .filter-option,
    a {
        text-align: center !important;
        font-size: 1.2rem !important;
    }

    #element {
        display: none;
    }

    .form-group {
        margin-top: -5px;
    }

    #headers {
        font-size: .6rem;
        text-align: center !important;
        align-items: center !important;
        justify-content: center !important;
    }

    #headers table {
        width: 100%;
        margin-bottom: 5px;
    }

    #headers table td {
        padding: 3px;

    }

    .bootstrap-select.btn-group .dropdown-menu li {
        padding: 10px !important;
        border: 1px solid #000;
    }
    </style>
</head>

<body>
    <div class="container" id="container">
        <div class="panel panel-default">
            <div class="panel-heading">إضافة الكميات طبقا للموازين</div>
            <div class="panel-body text-center justify-content-center">
                <div class="form-group">
                    <label>اختر الباخرة</label>
                    <select name="vessels" id="vessels" class="form-control input-lg" data-live-search="true"
                        title="اختر الباخرة"> </select>
                </div>
            </div>
        </div>
    </div>
    </div>

    <div id="element">
        <div id="headers"></div>
        <table id="table">
            <thead>
                <tr>
                    <th>كارت باركود</th>
                    <th>تعديل</th>
                    <th>رقم السيارة</th>
                    <th>الكمية</th>
                    <th>وقت التحميل</th>
                    <th>جامبو</th>
                    <th>اسم الصنف </th>
                    <th>رقم المخزن </th>
                    <th>اسم الموظف</th>
                    <th>ملاحظات</th>
                </tr>
            </thead>
        </table>
    </div>

</body>

</html>

<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/3.3.7/js/dataTables.bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.9/js/responsive.bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.2/js/bootstrap-select.min.js"></script>

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
                $('#vessels').html(html);
                $('#vessels').selectpicker('refresh');

            }
        })
    }

    function load_headers(vessel_id) {
        $.ajax({
            url: "../controllers/load_header.php",
            method: "POST",
            data: {
                vessel_id: vessel_id
            },
            dataType: "json",
            success: function(data) {
                var html = '';
                console.log(data.vessel);
                html += '<table><tr><td>  اسم الباخرة : ' + data.vessel.name +
                    '</td><td> رقم الرصيف :  ' + data.vessel.quay + '</td><td> نوع الصنف :  ' + data
                    .vessel.type + '</td></tr></table>'

                html += '<table><tr><td>  سيارة توكتوك :  ' + data.toktok_cars +
                    '</td><td> سيارة قلاب  :  ' + data.qlab_cars + '</td><td> سيارة شركة  :  ' +
                    data.company_cars + '</td><td> سيارة جرار :  ' + data.grar_cars +
                    '</td></tr></table>'
                html += '<table><tr><td>  الكمية   : ' + data.qnt +
                    '  طن </td><td> نقلات وصلت  :  ' + data.moves +
                    '  </td><td> عدد السيارات المفعلة  :  ' + data.active_cars +
                    '</td></tr></table>'
                $('#headers').html(html);

            }
        })
    }




    $(document).on('change', '#vessels', function() {
        var vessel_id = $('#vessels').val();
        $('#element').show();
        $('#container').hide();
        load_headers(vessel_id);
        $('#table').DataTable({
            'dom': 'lBfrtip',
            'processing': true,
            'serverSide': true,
            'responsive': true,
            "order": [
                [1, "asc"]
            ],
            'fixedHeader': {
                header: true,
                footer: true
            },
            "lengthMenu": [
                [25, 50, 75, -1],
                [25, 50, 75, "الكل"]
            ],
            'language': {
                "searchPlaceholder": "ابحث",
                "sSearch": "",
                "sProcessing": "جاري التحميل...",
                "sLengthMenu": "أظهر مُدخلات _MENU_",
                "sZeroRecords": "لم يُعثر على أية سجلات",
                "sInfo": "إظهار _START_ إلى _END_ من أصل _TOTAL_ مُدخل",
                "sInfoEmpty": "يعرض 0 إلى 0 من أصل 0 سجلّ",
                "sInfoFiltered": "(منتقاة من مجموع _MAX_ مُدخل)",
                "sInfoPostFix": "",
                "sUrl": "",
                "oPaginate": {
                    "sFirst": "الأول",
                    "sPrevious": "السابق",
                    "sNext": "التالي",
                    "sLast": "الأخير"
                }
            },
            'serverMethod': 'post',
            'ajax': {
                'url': '../controllers/load_quantity_edit.php',
                'data': {
                    "vessel_id": vessel_id
                },
            },

            'columns': [{
                    data: 'sn'
                },
                {
                    data: 'edit'
                },
                {
                    data: 'car_no'
                },
                {
                    data: 'qnt'
                },
                {
                    data: 'date'
                },
                {
                    data: 'jumbo'
                },
                {
                    data: 'type'
                },
                {
                    data: 'store_no'
                },
                {
                    data: 'ename'
                },
                {
                    data: 'notes'
                },
            ]
        });

    });

});
</script>