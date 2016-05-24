<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Added</title>
    <style>
        body {
			width: 800px;
			margin: 20px auto;
		}
    </style>
</head>

<body>
<h1>Added Successfully</h1>
Supplier Id is: {{$product->supplierId}}<br>
Category Id is: {{$product->categoryId}}<br>
Product Name is: {{$product->name}}<br>
Product ID is: {{$product->supplierProductId}}<br>
Cost is: {{$product->unitPrice}}<br>
Quantity is:  {{$product->quantity}}<br>
Color is: {{$product->color}}<br>
Description is: {{$product->details}}<br>

</body>
</html>