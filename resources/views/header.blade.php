<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>{{ env('APP_NAME') . ' - ' . env('APP_OWNER') }}</title>
	<link rel="shortcut icon" href="{{ url('favicon.ico') }}">

	<!-- FONTS -->
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

	<!-- CSS -->
	<link async href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
	<link async rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap-custom.min.css') }}">
	<link async rel="stylesheet" type="text/css" href="{{ asset('css/styles.css?v='.time()) }}">

</head>
<body class="bg-secondary">

	<header class="bg-white py-3 px-5 header">

		<section class="d-flex align-items-center justify-content-between">
			
			<div>
				<a href="{{ url('') }}" class="fs-3 text-primary text-decoration-none">Cek<b>Ongkir</b></a>
			</div>

			<figure class="m-0 p-0">
				<a href="{{ env('APP_OWNER_URL') }}">
					<img class="header-logo" src="{{ asset('images/website/logo.png') }}" alt="Ghivarra Senandika Rushdie">
				</a>
			</figure>

		</section>

	</header>