ready(function() {

});

const cekResiForm = document.getElementById('pills-lacak-paket');

cekResiForm.addEventListener('submit', function(e) {
	e.preventDefault();

	// ajax post
	xhrPOST({
		link: url('lacak-paket'),
		data: new FormData(cekResiForm),
		catch: function() {
			Swal.fire('Permohonan Gagal Diproses', 'Server sedang mengalami gangguan, silahkan coba dalam beberapa menit', 'warning');
		},
		error: function() {
			Swal.fire('Permohonan Gagal Diproses', 'Gagal menghubungi server, periksa koneksi internet anda', 'error');
		},
		success: function(res) {
			console.log(res);
		}
	});
});