<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>New Town Cabinetry - Dashboard</title>
	<link href="{{ URL::asset('css/bootstrap.min.css') }}" rel="stylesheet">
	<link href="{{ URL::asset('css/datepicker3.css') }}" rel="stylesheet">
	<link href="{{ URL::asset('css/styles.css') }}" rel="stylesheet">

	<!--Icons-->
	<script src="js/lumino.glyphs.js"></script>

	<!--[if lt IE 9]>
	<script src="js/html5shiv.js"></script>
	<script src="js/respond.min.js"></script>
	<![endif]-->

</head>

<body>

<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#sidebar-collapse">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="#"><span>New Town</span> Cabinetry</a>
				<ul class="user-menu">
					<li class="dropdown pull-right">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown"><svg class="glyph stroked male-user"><use xlink:href="#stroked-male-user"></use></svg> User <span class="caret"></span></a>
						<ul class="dropdown-menu" role="menu">
							<li><a href="#"><svg class="glyph stroked male-user"><use xlink:href="#stroked-male-user"></use></svg> Profile</a></li>
							<li><a href="#"><svg class="glyph stroked gear"><use xlink:href="#stroked-gear"></use></svg> Settings</a></li>
							<li><a href="#"><svg class="glyph stroked cancel"><use xlink:href="#stroked-cancel"></use></svg> Logout</a></li>
						</ul>
					</li>
				</ul>
			</div>

		</div><!-- /.container-fluid -->
	</nav>

	<div id="sidebar-collapse" class="col-sm-3 col-lg-2 sidebar">
		<form role="search">
			<div class="form-group">
				<input type="text" class="form-control" placeholder="Search">
			</div>
		</form>
		<ul class="nav menu">
			<li><a href="index"><svg class="glyph stroked home"><use xlink:href="#stroked-home"/></svg> Home</a></li>
			<li class="active"><a href="add_product"><svg class="glyph stroked dashboard-dial"><use xlink:href="#stroked-dashboard-dial"></use></svg> Suppliers &amp; Products</a></li>
			<li><a href="widgets.html"><svg class="glyph stroked calendar"><use xlink:href="#stroked-calendar"></use></svg> Purchase Order</a></li>
			<li><a href="tables.html"><svg class="glyph stroked table"><use xlink:href="#stroked-table"></use></svg> Invoice</a></li>
			<li><a href="charts.html"><svg class="glyph stroked line-graph"><use xlink:href="#stroked-line-graph"></use></svg> Report</a></li>

			<li role="presentation" class="divider"></li>
			<li><a href="login.html"><svg class="glyph stroked male-user"><use xlink:href="#stroked-male-user"></use></svg> Contact</a></li>
			<li><a href="forms.html"><svg class="glyph stroked pencil"><use xlink:href="#stroked-pencil"></use></svg> About</a></li>
			<li><a href="icons.html"><svg class="glyph stroked star"><use xlink:href="#stroked-star"></use></svg> Help</a></li>
		</ul>

	</div><!--/.sidebar-->
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
<div class="row">
			<ol class="breadcrumb">
				<li><a href="#"><svg class="glyph stroked dashboard-dial"><use xlink:href="#stroked-dashboard-dial"></use></svg></a></li>
				<li class="active">Icons</li>
			</ol>
		</div><!--/.row-->

		<div class="row">
			<div class="col-lg-12">
				<h1 class="page-header">Products</h1>
			</div>
		</div><!--/.row-->
<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">Add Product</div>
				<div class="panel-body">
					<div class="col-md-9">


 {{Form::open(array('url' => 'view_product_details', 'class' => 'form-horizontal', 'id' => 'add_product_form'))}}

 	<div class="form-group"><!--Category name field-->
 		{{ Form::label('category', "Category", array('class' => 'col-xs-3 control-label')) }}
 		@if ($errors->has('categories_id'))
        	<div class="col-xs-4 has-error">
        @else
        	<div class="col-xs-4">
        @endif
        {{ Form::select('categories_id', ['' => 'Choose Category'] + $categories, array('class' => 'form-control')) }}
        	</div>
        <div class="col-xs-5 messageContainer">
        	<font color="red">{{ $errors->first('categories_id') }} </font>
        </div>
 	</div><!-- Category nam end-->

 	<div class="form-group row"><!-- Supplier name field start-->
 		{{ Form::label('supplier', 'Supplier', array('class' => 'col-xs-3 control-label')) }}
 		@if ($errors->has('suppliers_id'))
        	<div class="col-xs-4 has-error">
        @else
        	<div class="col-xs-4">
        @endif
        {{ Form::select('suppliers_id', ['' => 'Choose Supplier'] + $suppliers, array('class' => 'form-control')) }}
        	</div>
        <div class="col-xs-5 messageContainer">
        	<font color="red">{{ $errors->first('suppliers_id') }} </font>
        </div>
 	</div><!-- Supplier name field end -->

  	<div class="form-group"><!-- Supplier Product Id field start-->
        {{ Form::label('supplierProductId', 'Product Id', array('class' => 'col-xs-3 control-label')) }}
        @if ($errors->has('supplierProductId'))
        	<div class="col-xs-4 has-error">
        @else
        	<div class="col-xs-4">
        @endif
            {{ Form::text('supplierProductId', '', array('class' => 'form-control')) }}
        	</div>
        <div class="col-xs-5 messageContainer">
        	<font color="red">{{ $errors->first('supplierProductId') }} </font>
        </div>
    </div><!-- Supplier Product Id end-->

    <div class="form-group"><!-- Product Name field start-->
    	{{ Form::label('name', 'Name', array('class' => 'col-xs-3 control-label')) }}
    	@if ($errors->has('name'))
			<div class="col-xs-4 has-error">
		@else
			<div class="col-xs-4">
		@endif
			{{ Form::text('name', '', array('class' => 'form-control')) }}
			</div>
		<div class="col-xs-5 messageContainer">
			<font color="red">{{ $errors->first('name') }} </font>
		</div>
    </div><!-- Product Name end-->

    <div class="form-group"><!-- Cost field start-->
        {{ Form::label('unitPrice', 'Cost', array('class' => 'col-xs-3 control-label')) }}
        @if ($errors->has('unitPrice'))
			<div class="col-xs-4 has-error">
		@else
        	<div class="col-xs-4">
        @endif
            {{ Form::input('decimal', 'unitPrice', '', array('class' => 'form-control')) }}
        	</div>
        <div class="col-xs-5 messageContainer">
        	<font color="red">{{ $errors->first('unitPrice') }} </font>
        </div>
    </div><!-- Cost end-->

    <div class="form-group"><!-- Quantity field start -->
    	{{ Form::label('quantity', 'Quantity', array('class' => 'col-xs-3 control-label')) }}
    	@if ($errors->has('quantity'))
			<div class="col-xs-4 has-error">
		@else
			<div class="col-xs-4">
		@endif
			{{ Form::number('quantity', '', array('class' => 'form-control')) }}
			</div>
		<div class="col-xs-5 messageContainer">
			<font color="red">{{ $errors->first('quantity') }} </font>
		</div>
    </div><!-- Quantity field end -->

    <div class="form-group"><!-- Color field start -->
    	{{ Form::label('color', 'Color', array('class' => 'col-xs-3 control-label')) }}
    	@if ($errors->has('color'))
			<div class="col-xs-4 has-error">
		@else
			<div class="col-xs-4">
		@endif
		{{ Form::text('color', '', array('class' => 'form-control'))}}
			</div>
		<div class="col-xs-5 messageContainer">
			<font color="red">{{ $errors->first('color') }} </font>
		</div>
    </div><!-- Color field end -->

    <div class="form-group"><!-- Description field start -->
    	{{ Form::label('description', 'Details', array('class' => 'col-xs-3 control-label')) }}
    	@if ($errors->has('description'))
			<div class="col-xs-4 has-error">
		@else
			<div class="col-xs-4">
		@endif
		{{ Form::textarea('description', '', array('class' => 'form-control')) }}
			</div>
		<div class="col-xs-5 messageContainer">
			<font color="red">{{ $errors->first('description') }} </font>
		</div>
    </div><!-- Description field end -->

    <div class="form-group"><!-- Buttons start -->
    	<div class="col-xs-9 col-xs-offset-3">
			{{ Form::submit('Add', array('class' => 'btn btn-primary', 'onsubmit' => 'return ConfirmDelete')) }}
			{{ Form::reset('Reset Form', array('class' => 'btn btn-default'))}}
		</div>
	</div><!-- Buttons end -->
{{ Form::close() }}
</div>
									</div>
				</div>
		</div>
	</div>



	<script src="js/jquery-1.11.1.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/chart.min.js"></script>
	<script src="js/chart-data.js"></script>
	<script src="js/easypiechart.js"></script>
	<script src="js/easypiechart-data.js"></script>
	<script src="js/bootstrap-datepicker.js"></script>
	<script>
		<script>

  			!function ConfirmDelete()
  			{
  				var x = confirm("Are you sure you want to add?");
  				if (x)
   			 	return true;
  				else
    			return false;
  			}

		!function clearForm(){
			alert('Hi');
			document.getElementById("add_product_form").reset();
		}
		!function ($) {
			$(document).on("click","ul.nav li.parent > a > span.icon", function(){
				$(this).find('em:first').toggleClass("glyphicon-minus");
			});
			$(".sidebar span.icon").find('em:first').addClass("glyphicon-plus");
		}(window.jQuery);

		$(window).on('resize', function () {
		  if ($(window).width() > 768) $('#sidebar-collapse').collapse('show')
		})
		$(window).on('resize', function () {
		  if ($(window).width() <= 767) $('#sidebar-collapse').collapse('hide')
		})
	</script>
</body>
</html>