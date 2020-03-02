<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Config</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="/../../plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="/../../dist/css/adminlte.min.css">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">
    <!-- Navbar -->
   @include("partials.header")
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    @include("partials.menu")

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Configuration</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Configuration</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
            <section class="content">
            <div class="row">
                <div class="col-md-6">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Result Page</h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                    <i class="fas fa-minus"></i></button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="inputName">Store Name</label>
                                <input type="text" id="inputName" class="form-control" value="{{$store["name"]}}" readonly>
                            </div>
                            <div class="form-group">
                                <label for="inputStatus">Results per page (Choose 1)</label>
                                <select class="form-control custom-select" value="{{$resultsPerPage}}" id="selResults" onchange="onSelChange()">
                                    <option selected disabled>Select one</option>
                                    <option value="1">1</option>
                                    <option value="3">3</option>
                                    <option value="5">5</option>
                                    <option value="6">6</option>
                                    <option value="10">10</option>
                                    <option value="12">12</option>
                                    <option value="0">Others</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="inputDescription">Results per page</label>
                                <input type="number" id="txtResults" class="form-control" rows="4" disabled="true" value="{{$resultsPerPage}}"/>
                            </div>
                            <div class="form-group">
                                <a href="/" class="btn btn-secondary">Cancel</a>
                                <input type="submit" value="Save" class="btn btn-success float-right" onclick="updateConfig()">
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                    </div>
                <div class="col-md-6">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Config Products</h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                    <i class="fas fa-minus"></i></button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="inputStatus">Product</label>
                                <select class="form-control custom-select" id="productId">
                                    <option selected disabled>Select one</option>
                                    @foreach($products as $product)
                                        <option value="{{$product->id}}">{{$product->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="inputDescription">Tags</label>
                                <input type="text"  class="form-control" rows="4" id="productTag"/>
                            </div>
                            <div class="form-group">
                                <a href="/" class="btn btn-secondary">Cancel</a>
                                <input type="submit" value="Add Tag" class="btn btn-success float-right" onclick="addProductTag()">
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
            </div>
            </section>
            <section class="content">
            <div class="row">
                <div class="col-md-6">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Config Category</h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                    <i class="fas fa-minus"></i></button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="inputStatus">Category</label>
                                <select class="form-control custom-select" id="categoryId">
                                    <option selected disabled>Select one</option>
                                    @foreach($categories as $category)
                                        <option value="{{$category->id}}">{{$category->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="inputDescription">Tag</label>
                                <input type="text" class="form-control" rows="4" id="categoryTag"/>
                            </div>
                            <div class="form-group">
                                <a href="/" class="btn btn-secondary">Cancel</a>
                                <input type="submit" value="Add Tag" class="btn btn-success float-right" onclick="addCategoryTag()">
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                    </div>
                <div class="col-md-6">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Config Blogs</h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                    <i class="fas fa-minus"></i></button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="inputStatus">Blog</label>
                                <select class="form-control custom-select" id="blogId">
                                    <option selected disabled >Select one</option>
                                    @foreach($blogs as $blog)
                                        <option value="{{$blog->id}}">{{$blog->title}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="inputDescription">Tags</label>
                                <input type="text" class="form-control" rows="4" id="blogTag"/>
                            </div>
                            <div class="form-group">
                                <a href="/" class="btn btn-secondary">Cancel</a>
                                <input type="submit" value="addTag" class="btn btn-success float-right" onclick="addBlogTag()">
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
            </div>
            </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <footer class="main-footer">
        <div class="float-right d-none d-sm-block">
            <b>Version</b> 3.0.2
        </div>
        <strong>Copyright &copy; 2014-2019 <a href="http://adminlte.io">AdminLTE.io</a>.</strong> All rights
        reserved.
    </footer>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="/../../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="/../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="/../../dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="/../../dist/js/demo.js"></script>
<script src="/../../plugins/toastr/toastr.min.js"></script>
<script src="../../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- SweetAlert2 -->
<script src="../../plugins/sweetalert2/sweetalert2.min.js"></script>
<!-- Toastr -->
<script src="../../plugins/toastr/toastr.min.js"></script>
<!-- AdminLTE App -->
<script src="../../dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../../dist/js/demo.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>
    $(function() {
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
        });
    });
    function onSelChange() {
        var results = document.getElementById("selResults").value;
        document.getElementById("txtResults").value = results;
        if(results == 0) {
            document.getElementById("txtResults").disabled = false;
        }else{
            document.getElementById("txtResults").disabled = true;
        }
    }
    function updateConfig() {
        $.ajax({
            url: "/api/updateConfig",
            method: "post",
            data:{
                resultsPerPage: $("#txtResults").val(),
                context: "{{$param['context']}}",
            },
            success: function (result) {
                console.log(result);
                swal("Good job!", "Your config is saved", "success");
            },
            error: function (result) {
                var jsonResult = (result.responseText);
                var message = (JSON.parse(jsonResult).message);
                swal("Error!", message, "error");
            }
        })
    }
    function addTag(type, tag, foreignId) {
        $.ajax({
            url: "/api/addTag",
            method: "post",
            data: {
                type: type,
                tag: tag,
                context: "{{$param["context"]}}",
                foreignId: foreignId
            },
            success: function(result){
                console.log(result);
                swal("Good job!", "Your tag is added", "success");
            },
            error: function (result) {
                console.log(result);
                swal("Error", "Error occur when add the tag", "error");
            }
        })
    }
    function addProductTag() {
        var productId = document.getElementById("productId").value;
        var productTag = document.getElementById("productTag").value;
        addTag("product", productTag, productId );
    }
    function addBlogTag() {
        var blogId = document.getElementById("blogId").value;
        var blogTag = document.getElementById("blogTag").value;
        addTag("blog", blogTag, blogId );
    }
    function addCategoryTag() {
        var categoryId = document.getElementById("categoryId").value;
        var categoryTag = document.getElementById("categoryTag").value;
        addTag("category", categoryTag, categoryId );
    }
</script>
</body>
</html>
