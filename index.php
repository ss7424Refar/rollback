<!DOCTYPE html>
<html>
    <head>
        <link href="bootstrap-3.3.7-dist/css/bootstrap.css" rel="stylesheet">
        <!-- Required Javascript -->
        <script src="bootstrap-3.3.7-dist/js/jquery-3.1.1.js"></script>
        <script src="bootstrap-treeview-1.2.0/public/js/bootstrap-treeview.js"></script>
        <script src="bootstrap-3.3.7-dist/js/bootstrap.js"></script>
        <script type="text/javascript">
            window.name="win_test"

            $(function () {
                function getTree() {
                    var tree = [
                        {
                            text: "Parent 1",
                            nodes: [
                                {
                                    text: "Child 1",
                                    nodes: [
                                        {
                                            text: "Grandchild 1"
                                        },
                                        {
                                            text: "Grandchild 2"
                                        }
                                    ]
                                },
                                {
                                    text: "Child 2"
                                }
                            ]
                        },
                        {
                            text: "Parent 2"
                        },
                        {
                            text: "Parent 3"
                        },
                        {
                            text: "Parent 4"
                        },
                        {
                            text: "Parent 5"
                        }
                    ];
                    return tree;
                }

                $('#tree').treeview({data: getTree(), levels: 3 ,
                    collapseIcon:" glyphicon glyphicon-folder-open",  //收缩节点的图标
                    expandIcon:"glyphicon glyphicon-folder-close",    //展开节点的图标
                    showIcon: false,//是否显示图标
                    showCheckbox:true//是否显示多选框
                    });

                $('#collapseAll').click(function () {

                    $('#tree').treeview('collapseAll', { silent: true });
                    return false;

                });
                $('#expandAll').click(function () {

                    $('#tree').treeview('expandAll', { silent: true });
                    return false;

                });

            });

        </script>

    </head>

    <body>
        <div class="container">
           <div class="row">
               <ol class="breadcrumb">
                   <li><a href="#"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></a></li>
<!--                   <li><a href="#">Library</a></li>-->
<!--                   <li class="active">Data</li>-->
               </ol>
           </div>
            <div class="row">
                <form class="navbar-form navbar-left">
                    <div class="form-group">
                        <button type="submit" class="btn btn-danger" id="collapseAll">collapseAll</button>
                        <button type="submit" class="btn btn-primary" id="expandAll">expandAll</button>
                    </div>
                </form>
            </div>
            <div class="row"><div id="tree"></div></div>
            <div class="col-md-10">
            </div>
            <div class="col-md-2">
                <button class="btn btn-primary" data-toggle="modal" data-target="#myModal">Add</button>
                <button type="submit" class="btn btn-primary" id="delete">Delete</button>
                <!-- 模态框（Modal） -->
                <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
                                <form id="addForm" class="form-horizontal" action="showPackage.php">
                                    <div class="form-group">
                                        <label for="FolderName" class="col-sm-3 control-label">FolderName : </label>
                                        <div class="col-sm-5">
                                            <input type="text" class="form-control" id="FolderName" name="foldername" placeholder="请输入名称">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Desc : </label>
                                        <div class="col-sm-5">
                                            <input type="text"  class="form-control" name="desc" placeholder="请输入desc">
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                                        <button type="submit" class="btn btn-primary" id="add">提交更改 </button>
                                    </div>
                                </form>
                            </div>

                        </div><!-- /.modal-content -->
                    </div><!-- /.modal -->
                </div></div>
        </div>

    </body>


</html>