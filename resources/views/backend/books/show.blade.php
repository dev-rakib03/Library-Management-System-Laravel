<!DOCTYPE html>
<html>
<head>
    <title>{{$book->title}}</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.js"></script>

<link rel="stylesheet" type="text/css" href="{{asset('/')}}pdfreader/css/flipbook.style.css">
<link rel="stylesheet" type="text/css" href="{{asset('/')}}pdfreader/css/font-awesome.css">

<script src="{{asset('/')}}pdfreader/js/flipbook.min.js"></script>

<script type="text/javascript">

    $(document).ready(function () {
        $("#container").flipBook({
            pdfUrl:"{{asset('/').$book->file_path}}",
            viewMode:"2d",
			singlePageMode:true
        });
    })
</script>

</head>
	<body>
		<div id="container"/>
	</body>
</html>

