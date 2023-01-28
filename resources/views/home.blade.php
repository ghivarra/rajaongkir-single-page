@include('header')

<main class="main text-dark d-flex align-items-center justify-content-center py-5">
	
	<section class="main-section bg-white rounded shadow-sm px-4 py-3">
		
		<div class="mb-4">
			<h5 class="fw-bold mb-3">Pilih Layanan</h5>
			<ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
			  	<li class="nav-item border border-secondary border-2" role="presentation">
			    	<button class="nav-link rounded-0 active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">
			    		Cek Ongkir
			    	</button>
			  	</li>
			  	<li class="nav-item border border-secondary border-2" role="presentation">
			    	<button class="nav-link rounded-0" id="pills-lacak-paket-tab" data-bs-toggle="pill" data-bs-target="#pills-lacak-paket" type="button" role="tab" aria-controls="pills-lacak-paket" aria-selected="false">
			    		Lacak Paket
			    	</button>
			  	</li>
			</ul>
		</div>

		<div class="tab-content">
  			<div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab" tabindex="0">...</div>
  			<form action="{{ url('lacak-paket') }}" method="POST" class="tab-pane fade" id="pills-lacak-paket" role="tabpanel" aria-labelledby="pills-lacak-paket-tab" tabindex="0">

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

</main>

@include('footer')