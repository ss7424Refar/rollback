<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>hello world</title>
    <!--  IE10 viewport hack for Surface/desktop Windows 8 bug
    <link href="http://v3.bootcss.com/assets/css/ie10-viewport-bug-workaround.css" rel="stylesheet">

     HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries
    [if lt IE 9]>
    <script src="https://cdn.bootcss.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <link href="third_party/bootstrap-3.3.7-dist/css/bootstrap.css" rel="stylesheet">
    <!-- Required Javascript -->
    <script src="third_party/bootstrap-3.3.7-dist/js/jquery-3.1.1.js"></script>
    <script src="third_party/bootstrap-3.3.7-dist/js/bootstrap.js"></script>
<!--    <script src="https://cdn.bootcss.com/jquery.bootstrapvalidator/0.5.3/js/bootstrapValidator.js"></script>-->
    <script src="third_party/bootstrapvalidator/dist/js/bootstrapValidator.js"></script>
    <script type="text/javascript">
        $(function () {

            getPackageInfo();

            selectAll();

            // checkbox
            function selectAll() {
                $('#selectAll').prop("checked", false);
                $('#selectAll').click(function () {
                    if (this.checked) {
                        $('input[name=chk]').prop("checked", true);
                    } else {
                        $('input[name=chk]').prop("checked", false);
                    }
                });
            };

            function getPackageInfo() {
                $.ajax({
                    type: "get",
                    url: "function/readPackageDataFromFile.php",
                    success: function (result) {
                        var pars_result = JSON.parse(result);
                        console.log(pars_result);
                        var lastTr;
                        if ("ng" !== pars_result) {
                            for (var i = 0; i < pars_result.length; i++) {
                                $('#smTable').append("<tr></tr>");
                                lastTr = $('#smTable tr:last');
                                lastTr.append("<td><input type='checkbox' name='chk' value='" + i + "'></td>");
                                for (var j = 0; j < pars_result[i].length; j++) {
                                    lastTr.append("<td>" + pars_result[i][j] + "</td>");
                                }

                            }

                        } else {
                            $('#myTable').append("<p class='btn btn-primary col-md-12'>No Data</p>");
                        }
                    },
                    error: function () {
                        $('#myTable').append("<p class='btn btn-danger col-md-12'>No Data</p>");
                    }


                });

            };

            $('#addForm').bootstrapValidator({
                message: '输入值不合法',
                feedbackIcons: {
                    valid: 'glyphicon glyphicon-ok',
                    invalid: 'glyphicon glyphicon-remove',
                    validating: 'glyphicon glyphicon-refresh'
                },
                fields: {
                    foldername: {
                        message: 'foldername不合法',
                        validators: {
                            notEmpty: {
                                message: 'foldername不能为空'
                            },
                            stringLength: {
                                min: 3,
                                max: 10,
                                message: '请输入3到10个字符'
                            },
                            regexp: {
                                regexp: /^[a-zA-Z0-9_\. \u4e00-\u9fa5 ]+$/,
                                message: 'foldername只能由字母、数字、点、下划线和汉字组成 '
                            },
                            callback: {
                                message: '文件已经存在',
                                callback: function (value, validator, $field) {
                                    $.ajax({
                                            type: "get",
                                            url: "function/fileController.php?action=checkFile&filename=" + $('#FolderName').val(),
                                            success: function (result) {
                                                return result;
                                            },
                                            error: function () {
                                                return false;
                                            }
                                        }
                                    );
                                }

                            }
                        }
                    }
                    , desc: {
                        validators: {
                            notEmpty: {
                                message: 'desc不能为空'
                            },
                            stringLength: {
                                min: 3,
                                max: 20,
                                message: '请输入3到20个字符'
                            }
                        }
                    }
                }

            });


            $('#addCheck').click(function () {
                var checkArray = [];
                var saveArray = "";
                $('input[name=chk]:checked').each(function (i) {
                    checkArray[i] = $(this).val();
                })
                if (checkArray.length == 0) {
                    $('.alert').remove();
                    $('h2').after('<div class="alert alert-warning"><a href="#" class="close" data-dismiss="alert">&times;</a><strong>警告！</strong>请选择至少一项</div>');
                    $('.alert').hide();
                    $('.alert').show(300);
                    return false;
                } else {
                    for (var i = 0; i < checkArray.length; i++) {
                        saveArray = saveArray + checkArray[i] + ",";
                    }
                    saveArray = saveArray.substr(0, saveArray.length - 1);
                    console.log(saveArray);
                    $('input[name=saveArray]').val(saveArray);

                }

            });

            $('#add').click(function () {
                // 编辑的时候，防止验证状态一直存在
                $("#addForm").bootstrapValidator('destroy');
                //进行表单验证
                var bv = $('#addForm').data('bootstrapValidator');
                bv.validate();
                if (bv.isValid()) {
                    //发送ajax请求
                    $.ajax({
                        url: 'function/addPackage.php',
                        type: 'GET',//PUT DELETE POST
                        data: $('#addForm').serialize(),
                        complete: function (msg) {
                            console.log('完成了');
                        },
                        success: function (result) {
                            console.log(result);
                            if (result) {

                            } else {
                                $("#returnMessage").html('<label class="label label-danger">修改失败!</label>').show(300);
                            }
                        }, error: function () {
                            $("#returnMessage").html('<label class="label label-danger">修改失败!</label>').show(300);
                        }
                    })
                }
            });


        });

    </script>
</head>
<body>
<div class="container">
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="#"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></a></li>
        </ol>
    </div>
    <div class="col-md-12" id="myTable">
        <h2></h2>
        <table id='smTable' class="table table-striped">
            <tr>
                <th class="col-md-1"><input type='checkbox' id='selectAll'>全选</th>
                <th class="col-md-1">File Name</th>
                <th class="col-md-3">Download Path</th>
                <th class="col-md-5">GABAI Args</th>
                <th class="col-md-2">Packed Name</th>
            </tr>

        </table>
    </div>
    <div class="col-md-11">
    </div>
    <div class="col-md-1">
        <button class="btn btn-primary" data-toggle="modal" data-target="#myModal" id="addCheck">Add</button>
        <!-- 模态框（Modal） -->
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
             aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            &times;
                        </button>
                        <h4 class="modal-title" id="myModalLabel">
                            Add Folder
                        </h4>
                    </div>
                    <div class="modal-body">
                        <form id="addForm">
<!--                            <form id="addForm" action="" method="get">-->
                            <div class="form-group">
                                <label for="FolderName" class="control-label">FolderName: </label>
                                <input type="text" class="form-control" id="FolderName" name="foldername"
                                       placeholder="请输入名称">
                            </div>
                            <div class="form-group">
                                <label class="control-label">Desc : </label>
                                <input type="text" class="form-control" name="desc" placeholder="请输入desc">
                                <input type="hidden" name="saveArray">
                            </div>
                            <div class="modal-footer">
                                <span id="returnMessage" class="glyphicon"> </span>
                                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                                <button type="submit" class="btn btn-primary" id="add">提交</button>
                            </div>
                        </form>
                    </div>

                </div><!-- /.modal-content -->
            </div><!-- /.modal -->
        </div>
    </div>
</div>
</div>

</body>


</html>