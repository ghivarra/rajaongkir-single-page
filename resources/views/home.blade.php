@include('header')

<main class="main text-dark d-flex align-items-center justify-content-center py-5">

	<div class="w-100">
	
		<section class="main-section bg-white rounded shadow-sm px-4 py-3 mx-auto">
			
			<div class="mb-4">
				<h5 class="fw-bold mb-3">Pilih Layanan</h5>
				<ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
				  	<li class="nav-item" role="presentation">
				    	<button class="nav-link rounded-0 rounded-start active border border-secondary border-2" id="pills-cek-ongkir-tab" data-bs-toggle="pill" data-bs-target="#pills-cek-ongkir" type="button" role="tab" aria-controls="pills-cek-ongkir" aria-selected="true">
				    		Cek Ongkir
				    	</button>
				  	</li>
				  	<li class="nav-item" role="presentation">
				    	<button class="nav-link rounded-0 rounded-end border border-secondary border-2" id="pills-lacak-paket-tab" data-bs-toggle="pill" data-bs-target="#pills-lacak-paket" type="button" role="tab" aria-controls="pills-lacak-paket" aria-selected="false">
				    		Lacak Paket
				    	</button>
				  	</li>
				</ul>
			</div>

			<div class="tab-content">

				<section class="tab-pane fade show active" id="pills-cek-ongkir" role="tabpanel" aria-labelledby="pills-cek-ongkir-tab" tabindex="0">

					<div class="form-group mb-4">
	  					<h6 class="fw-bold mb-2">Jenis Pengiriman</h6>
	  					<div class="d-flex">
		  					<div class="form-check me-3">
	  							<input class="form-check-input" type="radio" name="co-jenis" id="co-jenis-lokal" value="lokal" checked>
	  							<label class="form-check-label" for="co-jenis-lokal">
	    							Lokal
	  							</label>
							</div>
							<div class="form-check">
	  							<input class="form-check-input" type="radio" name="co-jenis" value="internasional" id="co-jenis-internasional">
	  							<label class="form-check-label" for="co-jenis-internasional">
	    							Internasional
	  							</label>
							</div>
						</div>
	  				</div>

		  			<form id="co-form">
		  				
		  				@csrf

		  				<div class="form-group mb-4">
		  					<label for="co-kurir" class="form-label mb-2 fw-bold">Jasa Ekspedisi/Kurir</label>
		  					<select id="co-kurir" name="courier" class="form-select" required>
		  						<option value="">Pilih Kurir</option>

		  						@foreach ($lokalKurir as $kurir)
		  							<option value="{{ $kurir['id'] }}">{{ $kurir['nama_pendek'] }} - {{ $kurir['nama'] }}</option>
		  						@endforeach

		  					</select>
		  				</div>

		  				<div class="form-group mb-4">
		  					<label for="co-origin" class="form-label mb-2 fw-bold">Asal</label>
		  					<select id="co-origin" name="origin" class="form-select" required>
		  						<option value="">Tulis Kecamatan/Kota Asal</option>
		  					</select>
		  				</div>

		  				<div class="form-group mb-4">
		  					<label for="co-destination" class="form-label mb-2 fw-bold">Tujuan</label>
		  					<select id="co-destination" name="destination" class="form-select" required>
		  						<option value="">Tulis Kecamatan/Kota Tujuan</option>
		  					</select>
		  				</div>

		  				<div class="form-group mb-4">
		  					<label for="co-weight" class="form-label mb-2 fw-bold">Berat Paket <span class="fw-normal">(dalam kg)</span></label>
		  					<input id="co-weight" type="text" name="weight" class="form-control" placeholder="contoh: 3.000 kg ditulis 3000 tanpa titik" required>
		  				</div>

		  				<div class="form-group mb-5">
		  					<label class="form-label mb-2 fw-bold">Dimensi Paket <span class="fw-normal">(opsional)</span></label>
		  					<div class="co-form-dimensi row row-cols-1 row-cols-sm-2 g-3">
		  						<div class="col">
		  							<div class="input-group">
		  								<label for="co-length" class="input-group-text ">Panjang</label>
		  								<input id="co-length" type="number" name="length" class="form-control" placeholder="dalam cm">
		  							</div>
		  						</div>
		  						<div class="col">
		  							<div class="input-group">
		  								<label for="co-width" class="input-group-text ">Lebar</label>
		  								<input id="co-width" type="number" name="width" class="form-control" placeholder="dalam cm">
		  							</div>
		  						</div>
		  						<div class="col">
		  							<div class="input-group">
		  								<label for="co-height" class="input-group-text ">Tinggi</label>
		  								<input id="co-height" type="number" name="height" class="form-control" placeholder="dalam cm">
		  							</div>
		  						</div>
		  						<div class="col">
		  							<div class="input-group">
		  								<label for="co-diameter" class="input-group-text ">Diameter</label>
		  								<input id="co-diameter" type="number" name="diameter" class="form-control" placeholder="dalam cm">
		  							</div>
		  						</div>
		  					</div>
		  				</div>

		  				<div class="form-action">
		  					<button type="submit" class="btn btn-primary text-light me-2">Cek Tarif</button>
		  					<button type="reset" class="btn btn-outline-primary">Kosongkan</button>
		  				</div>

		  			</form>
					
				</section>


	  			<form method="POST" class="tab-pane fade" id="pills-lacak-paket" role="tabpanel" aria-labelledby="pills-lacak-paket-tab" tabindex="0">

	  				@csrf

	  				<div class="alert alert-warning mb-3" role="alert">
	  					API Rajaongkir belum menyediakan fitur pengecekan resi/pelacakan paket untuk jasa ekspedisi 

	  					@foreach ($cekResiKurirNotAvailable as $n => $item)

	  						@if (isset($cekResiKurirNotAvailable[($n + 1)]))
	  							<b>{{ $item['nama_pendek'] }}</b>,
	  						@else
	  							dan <b>{{ $item['nama_pendek'] }}</b>
	  						@endif

	  					@endforeach

	  				</div>

	  				<div class="form-group mb-3">
	  					<label for="cr-kurir" class="form-label mb-2 fw-bold">Jasa Ekspedisi/Kurir</label>
	  					<select id="cr-kurir" class="form-select" name="courier" required>
	  						<option value="">Pilih Jasa Ekspedisi</option>

	  						@foreach ($cekResiKurir as $item)

	  							<option value="{{ $item['id'] }}">{{ $item['nama_pendek'] }} - {{ $item['nama'] }}</option>

	  						@endforeach

	  					</select>
	  				</div>

	  				<div class="form-group mb-4">
	  					<label for="cr-resi" class="form-label mb-2 fw-bold">Nomor Resi</label>
	  					<input id="cr-resi" type="text" class="form-control" name="waybill" placeholder="Input resi pengiriman anda..." required>
	  				</div>
	  				<div class="form-action">
	  					<button type="submit" class="btn btn-primary text-light me-2">Lacak</button>
	  					<button type="reset" class="btn btn-outline-primary">Kosongkan</button>
	  				</div>
	  			</form>
			</div>

		</section>

		<section id="cr-result" class="mt-5 d-none bg-white p-4 mx-auto">

			<div class="mb-5">
				<figure class="m-0">
					<img id="cr-kurir-logo">
				</figure>
			</div>

			
			
			<div class="d-block d-lg-flex mb-5">
				
				<div class="mb-5 me-4">

					<div class="mb-5">
						<h5 id="cr-title-1" class="fw-bold mb-4">Status Pengiriman</h5>
						<p id="cr-status" class="fw-bold fs-5"></p>
					</div>

					<div class="mb-4">
						<h5 id="cr-title-2" class="fw-bold mb-4">Detail Pengiriman</h5>
						<div class="row mb-4 mb-lg-0 row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
							<div class="col">
								<h6 class="fw-bold">No. Resi</h6>
								<p id="cr-detail-resi"></p>
							</div>
							<div class="col">
								<h6 class="fw-bold">Waktu Pengiriman</h6>
								<p id="cr-detail-datetime"></p>
							</div>
							<div class="col">
								<h6 class="fw-bold">Kota/Kode Pos Asal</h6>
								<p id="cr-detail-shipper-city"></p>
							</div>
							<div class="col">
								<h6 class="fw-bold">Kota/Kode Pos Tujuan</h6>
								<p id="cr-detail-receiver-city"></p>
							</div>	
							<div class="col">
								<h6 class="fw-bold">Pengirim</h6>
								<p id="cr-detail-shipper"></p>
							</div>
							<div class="col">
								<h6 class="fw-bold">Penerima</h6>
								<p id="cr-detail-receiver"></p>
							</div>			
						</div>
					</div>
				</div>

				<div>
					<h5 id="cr-title-3" class="fw-bold mb-4">Histori Pengiriman</h5>
					<div id="cr-history-timeline"></div>
				</div>

			</div>

		</section>

	</div>

</main>

@include('modal')
@include('footer')