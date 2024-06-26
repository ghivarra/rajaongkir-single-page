const cekResiForm = document.getElementById('pills-lacak-paket');
const originSelect = document.getElementById('co-origin');
const destinationSelect = document.getElementById('co-destination');

cekResiForm.addEventListener('submit', function(e) {
	e.preventDefault();

	document.getElementById('cr-result').classList.add('d-none');

	Swal.fire({
		text: 'Memproses Permohonan',
		showConfirmButton: false,
		showCloseButton: false,
		allowOutsideClick: false,
		didOpen: function() {
			Swal.showLoading();
		}
	});

	// ajax post
	xhrPOST({
		link: url('lacak-paket'),
		data: new FormData(cekResiForm),
		catch: function() {
			Swal.hideLoading();
			Swal.update({
				title: 'Permohonan Gagal Diproses',
				text: 'Server sedang mengalami gangguan, silahkan coba lagi dalam beberapa menit',
				icon: 'warning',
				allowOutsideClick: true,
				showConfirmButton: true,
			});
		},
		error: function() {
			Swal.hideLoading();
			Swal.update({
				title: 'Permohonan Gagal Diproses',
				text: 'Gagal menghubungi server, periksa koneksi internet anda',
				icon: 'warning',
				allowOutsideClick: true,
				showConfirmButton: true,
			});
		},
		success: function(res) {
			res = JSON.parse(res);

			if (res.code !== 200) {
				Swal.hideLoading();
				Swal.update({
					title: 'Permohonan Gagal Diproses',
					text: res.description,
					icon: 'error',
					allowOutsideClick: true,
					showConfirmButton: true,
				});

				return;
			}

			// mutasi data
			let courier = res.courier;
			let result  = res.result;
			let summary = result.summary;

			// set data kurir
			let crKurirLogo = document.getElementById('cr-kurir-logo');
			crKurirLogo.setAttribute('src', url('assets/images/kurir/' + courier.logo));
			crKurirLogo.setAttribute('alt', summary.courier_name);

			// set warna title
			document.getElementById('cr-title-1').style.color = courier.warna;
			document.getElementById('cr-title-2').style.color = courier.warna;
			document.getElementById('cr-title-3').style.color = courier.warna;

			// set status pengiriman
			let crStatus = document.getElementById('cr-status');
			let statusPengiriman = (result.delivered === true) ? 'TERKIRIM' : 'DIKIRIM';
			let statusColor = (result.delivered === true) ? 'text-success' : 'text-warning';

			crStatus.innerText = statusPengiriman;
			crStatus.classList.remove('text-success', 'text-warning');
			crStatus.classList.add(statusColor);

			// set detail pengiriman
			document.getElementById('cr-detail-resi').innerText = result.details.waybill_number;
			document.getElementById('cr-detail-datetime').innerText = result.details.datetime;
			document.getElementById('cr-detail-shipper').innerText = summary.shipper_name;
			document.getElementById('cr-detail-shipper-city').innerText = result.details.origin;
			document.getElementById('cr-detail-receiver').innerText = summary.receiver_name;
			document.getElementById('cr-detail-receiver-city').innerText = result.details.destination;

			// set histori pengiriman
			let crHistoryTimeline = document.getElementById('cr-history-timeline');
			crHistoryTimeline.innerHTML = '';

			Array.prototype.forEach.call(result.history, function (item, i) {
				let section = document.createElement('section');
				let dateDiv = document.createElement('div');
				let innerDateDiv = document.createElement('div');
				let dateText = document.createElement('p');
				let dateDayText = document.createElement('p');

				// set date & time text
				dateDayText.innerText = item.day;
				dateDayText.classList.add('mb-0');

				dateText.innerText = item.date;
				dateText.classList.add('mb-0');

				innerDateDiv.appendChild(dateDayText);
				innerDateDiv.appendChild(dateText);
				innerDateDiv.classList.add('bg-dark', 'text-white', 'py-2', 'px-3', 'rounded');

				dateDiv.appendChild(innerDateDiv);
				dateDiv.classList.add('border-start', 'border-2', 'border-secondary', 'd-flex', 'px-4', 'pb-4', 'd-md-none');

				// set history left & right
				let outerDiv = document.createElement('div');
				let historyRight = document.createElement('div');
				let historyLeft = document.createElement('div');
				let hlDate = document.createElement('p');
				let hlDay = document.createElement('p');

				hlDay.innerText = item.day;
				hlDay.classList.add('mb-1', 'fw-bold');

				hlDate.innerText = item.date;
				hlDate.classList.add('mb-0');

				historyLeft.appendChild(hlDay);
				historyLeft.appendChild(hlDate);
				historyLeft.classList.add('cr-history-left', 'd-none', 'd-md-block', 'pe-4');

				historyRight.classList.add('cr-history-right');

				outerDiv.appendChild(historyLeft);
				outerDiv.appendChild(historyRight);
				outerDiv.classList.add('d-flex');

				section.appendChild(dateDiv);
				section.appendChild(outerDiv);
				section.classList.add('cr-history-date', 'cr-history-' + i);

				// foreach manifests
				Array.prototype.forEach.call(item.manifests, function (manifest, n) {
					let manifestDiv = document.createElement('div');
					let manifestCircle = document.createElement('div');
					let manifestInner = document.createElement('div');
					let manifestInnerDesc = document.createElement('p');
					let manifestInnerTime = document.createElement('p');

					manifestInnerTime.innerText = manifest.time;
					manifestInnerTime.classList.add('mb-0', 'fw-bold');

					manifestInnerDesc.innerText = manifest.desc;
					manifestInnerDesc.classList.add('mb-1');

					manifestInner.appendChild(manifestInnerTime);
					manifestInner.appendChild(manifestInnerDesc);
					manifestInner.classList.add('cr-manifest-details');

					manifestCircle.classList.add('cr-history-right-circle', 'rounded-circle');
					manifestCircle.style.backgroundColor = courier.warna;

					manifestDiv.appendChild(manifestCircle);
					manifestDiv.appendChild(manifestInner);
					manifestDiv.classList.add('position-relative', 'px-4', 'pb-5', 'border-start', 'border-2', 'border-secondary');

					historyRight.appendChild(manifestDiv);
				});

				crHistoryTimeline.appendChild(section);
			});

			// display none
			document.getElementById('cr-result').classList.remove('d-none');

			Swal.close();

			setTimeout(function() {
				let pos = document.getElementById('cr-result').getBoundingClientRect();
				window.scrollTo({
					top: pos.top,
					left: pos.left,
					behavior: 'smooth'
				});
			}, 400);
		}
	});
});

// cek ongkir
var postUrl = url('cek-ongkir/lokal');
const timeout = 300;
const cekOngkirForm = document.getElementById('co-form');
const kurirSelect = document.getElementById('co-kurir');

var throttleOriginSearch = false;
var throttleOriginSearchTimeout;

var throttleDestinationSearch = false;
var throttleDestinationSearchTimeout;

function getOrigin(query = '', originSelectChoice) {
	if (throttleOriginSearchTimeout) {
		clearTimeout(throttleOriginSearchTimeout);
	}

	throttleOriginSearchTimeout = setTimeout(function() {

		// cek lokal/internasional
		let type = document.querySelector('input[name="co-jenis"]:checked').value;
		let lokasi = (type == 'lokal') ? 'Kecamatan/Kota' : 'Kota';

		xhrGET({
			link: url('get/lokasi/asal') + '?type=' + encodeURI(type) + '&query=' + encodeURI(query),
			catch: function() {
				Swal.fire({
					title: 'Gagal Mengambil Data '+ lokasi +' Asal',
					text: 'Server sedang mengalami gangguan, silahkan coba lagi dalam beberapa menit',
					icon: 'warning',
					allowOutsideClick: true,
					showConfirmButton: true,
				});
			},
			error: function() {
				Swal.fire({
					title: 'Gagal Mengambil Data Kurir',
					text: 'Gagal menghubungi server, periksa koneksi internet anda',
					icon: 'error',
					allowOutsideClick: true,
					showConfirmButton: true,
				});
			},
			success: function(res) {
				res = JSON.parse(res);
				originSelectChoice.clearChoices();
				setTimeout(function() {
					originSelectChoice.setChoices(res.result);
				}, 200);
			}
		});

		clearTimeout(throttleOriginSearchTimeout);

	}, timeout);
}

function getDestination(query = '', destinationSelectChoice) {
	if (throttleDestinationSearchTimeout) {
		clearTimeout(throttleDestinationSearchTimeout);
	}

	throttleDestinationSearchTimeout = setTimeout(function() {

		// cek lokal/internasional
		let type = document.querySelector('input[name="co-jenis"]:checked').value;
		let lokasi = (type == 'lokal') ? 'Kecamatan/Kota' : 'Negara';

		xhrGET({
			link: url('get/lokasi/tujuan') + '?type=' + encodeURI(type) + '&query=' + encodeURI(query),
			catch: function() {
				Swal.fire({
					title: 'Gagal Mengambil Data '+ lokasi +' Tujuan',
					text: 'Server sedang mengalami gangguan, silahkan coba lagi dalam beberapa menit',
					icon: 'warning',
					allowOutsideClick: true,
					showConfirmButton: true,
				});
			},
			error: function() {
				Swal.fire({
					title: 'Gagal Mengambil Data Kurir',
					text: 'Gagal menghubungi server, periksa koneksi internet anda',
					icon: 'error',
					allowOutsideClick: true,
					showConfirmButton: true,
				});
			},
			success: function(res) {
				res = JSON.parse(res);
				destinationSelectChoice.clearChoices();
				setTimeout(function() {
					destinationSelectChoice.setChoices(res.result);
				}, 200);
			}
		});

		clearTimeout(throttleDestinationSearchTimeout);

	}, timeout);
}

ready(function() {

	const originSelectChoice = new Choices(originSelect, {
		allowHTML: false,
		itemSelectText: '',
		searchResultLimit: 50,
	});

	const destinationSelectChoice = new Choices(destinationSelect, {
		allowHTML: false,
		itemSelectText: '',
		searchResultLimit: 50,
	});

	document.getElementById('co-jenis-lokal').addEventListener('change', function(e) {
		if (!this.checked) {
			return;
		}

		postUrl = url('cek-ongkir/lokal');
		cekOngkirForm.reset();

		xhrGET({
			link: url('get/kurir/lokal'),
			catch: function() {
				Swal.fire({
					title: 'Gagal Mengambil Data Kurir',
					text: 'Server sedang mengalami gangguan, silahkan coba lagi dalam beberapa menit',
					icon: 'warning',
					allowOutsideClick: true,
					showConfirmButton: true,
				});
			},
			error: function() {
				Swal.fire({
					title: 'Gagal Mengambil Data Kurir',
					text: 'Gagal menghubungi server, periksa koneksi internet anda',
					icon: 'error',
					allowOutsideClick: true,
					showConfirmButton: true,
				});
			},
			success: function(res) {
				kurirSelect.innerHTML = '';

				let defaultOption = document.createElement('option');
				defaultOption.setAttribute('value', '');
				defaultOption.innerText = 'Pilih Kurir';
				kurirSelect.appendChild(defaultOption);

				res = JSON.parse(res);

				if (res.result.length > 0) {
					Array.prototype.forEach.call(res.result, function(item, i) {
						let option = document.createElement('option');
						option.setAttribute('value', item.id);
						option.innerText = item.nama_pendek + ' - ' + item.nama;
						kurirSelect.appendChild(option);
					});
				}
			}
		});

		// modify asal dan tujuan
		originSelectChoice.setChoices([
			{ value: '', label: 'Ketik Kecamatan/Kota Asal', selected: true }
		]);

		destinationSelectChoice.setChoices([
			{ value: '', label: 'Ketik Kecamatan/Kota Tujuan', selected: true }
		]);
	});

	document.getElementById('co-jenis-internasional').addEventListener('change', function(e) {
		if (!this.checked) {
			return;
		}

		postUrl = url('cek-ongkir/internasional');
		cekOngkirForm.reset();

		xhrGET({
			link: url('get/kurir/internasional'),
			catch: function() {
				Swal.fire({
					title: 'Gagal Mengambil Data Kurir',
					text: 'Server sedang mengalami gangguan, silahkan coba lagi dalam beberapa menit',
					icon: 'warning',
					allowOutsideClick: true,
					showConfirmButton: true,
				});
			},
			error: function() {
				Swal.fire({
					title: 'Gagal Mengambil Data Kurir',
					text: 'Gagal menghubungi server, periksa koneksi internet anda',
					icon: 'error',
					allowOutsideClick: true,
					showConfirmButton: true,
				});
			},
			success: function(res) {
				kurirSelect.innerHTML = '';

				let defaultOption = document.createElement('option');
				defaultOption.setAttribute('value', '');
				defaultOption.innerText = 'Pilih Kurir';
				kurirSelect.appendChild(defaultOption);

				res = JSON.parse(res);

				if (res.result.length > 0) {
					Array.prototype.forEach.call(res.result, function(item, i) {
						let option = document.createElement('option');
						option.setAttribute('value', item.id);
						option.innerText = item.nama_pendek + ' - ' + item.nama;
						kurirSelect.appendChild(option);
					});
				}
			}
		});

		// modify asal dan tujuan
		originSelectChoice.setChoices([
			{ value: '', label: 'Ketik Kota Asal', selected: true }
		]);

		destinationSelectChoice.setChoices([
			{ value: '', label: 'Ketik Negara Tujuan', selected: true }
		]);
	});

	originSelect.addEventListener('search', function(item) {
		let query = item.detail.value;
		getOrigin(query, originSelectChoice);
	});

	destinationSelect.addEventListener('search', function(item) {
		let query = item.detail.value;
		getDestination(query, destinationSelectChoice);
	});
});

cekOngkirForm.addEventListener('submit', function(e) {
	e.preventDefault();

	Swal.fire({
		text: 'Memproses Permohonan',
		showConfirmButton: false,
		showCloseButton: false,
		allowOutsideClick: false,
		didOpen: function() {
			Swal.showLoading();
		}
	});

	xhrPOST({
		link: postUrl,
		data: new FormData(cekOngkirForm),
		catch: function() {
			Swal.hideLoading();
			Swal.update({
				title: 'Gagal Mengecek Tarif Pengiriman',
				text: 'Server sedang mengalami gangguan, silahkan coba lagi dalam beberapa menit',
				icon: 'warning',
				allowOutsideClick: true,
				showConfirmButton: true,
			});
		},
		error: function() {
			Swal.hideLoading();
			Swal.update({
				title: 'Gagal Mengecek Tarif Pengiriman',
				text: 'Gagal menghubungi server, periksa koneksi internet anda',
				icon: 'error',
				allowOutsideClick: true,
				showConfirmButton: true,
			});
		},
		success: function(res) {
			res = JSON.parse(res);

			if (res.code !== 200) {
				Swal.hideLoading();
				Swal.update({
					title: 'Gagal Mengecek Tarif Pengiriman',
					text: res.desc,
					icon: 'error',
					allowOutsideClick: true,
					showConfirmButton: true,
				});
				return;
			}

			Swal.close();

			let cekOngkirModalBody = document.getElementById('coModalBody');
			let cekOngkirModalButton = document.getElementById('coModalButton');
			let cekOngkirModalClose = document.getElementById('coModalClose');

			// set meta data
			document.getElementById('coModalLabel').innerText = res.courier.nama_pendek;
			document.getElementById('coModalLogo').setAttribute('src', url('assets/images/kurir/' + res.courier.logo));
			document.getElementById('coModalLogo').setAttribute('alt', res.courier.nama);

			// set origin & destination
			let type = document.querySelector('input[name="co-jenis"]:checked').value;
			let originText;
			let destinationText;

			if (type == 'lokal') {

				originText = (res.info.originType == 'subdistrict') ? res.origin.subdistrict_name + ' - ' + res.origin.city + ', ' + res.origin.province : res.origin.city_name + ', ' + res.origin.province;
				destinationText = (res.info.destinationType == 'subdistrict') ? res.destination.subdistrict_name + ' - ' + res.destination.city + ', ' + res.destination.province : res.destination.city_name + ', ' + res.destination.province;

			} else {

				originText = res.origin.city_name + ', ' + res.origin.province;
				destinationText = res.destination.nama_trans;
			}

			document.getElementById('coModalAsal').innerText = originText;
			document.getElementById('coModalTujuan').innerText = destinationText;

			// set berat dan dimensi
			let formData = new FormData(cekOngkirForm);
			let dimensiHTML = (formData.get('length').length < 1) ? '<p>-</p>' : '<p><b>Panjang: </b>'+ formData.get('length') +' cm, <b>Lebar: </b>'+ formData.get('width') +' cm, <b>Tinggi: </b>'+ formData.get('height') +' cm, <b>Diameter: </b>'+ formData.get('diameter') +' cm</p>';
			let weightText = res.info.weight / 1000;

			document.getElementById('coModalBerat').innerText = weightText + ' kg';
			document.getElementById('coModalDimensi').innerHTML = dimensiHTML;

			// create element tarif
			let elementTarifWrapper = document.getElementById('coModalTarifWrapper');
			elementTarifWrapper.innerHTML = '';

			if (res.result.length < 1) {
				elementTarifWrapper.innerHTML = '<div class="alert alert-warning" role="alert">Jasa Ekspedisi '+ res.courier.nama_pendek +' belum menyediakan pelayanan pengantaran dari '+ originText +' menuju '+ destinationText +'</div>';
			} else {

				let tarifCards = [];
				Array.prototype.forEach.call(res.result, function(item, n) {

					if (type == 'lokal') {
						let durasi = (item.cost[0].etd.length < 1) ? '-' : item.cost[0].etd.replace(/hari/ig, '') + ' Hari';
						let tarif = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(item.cost[0].value);
						tarif = tarif.replace(',00', '');

						elementTarifWrapper.innerHTML += '<div class="co-modal-tarif mb-4 card"><button class="rounded-0 btn btn-dark text-start form-select" type="button" data-bs-toggle="collapse" data-bs-target="#coModalTarif'+ n +'" aria-expanded="true" aria-controls="coModalTarif'+ n +'">'+ item.service +' - '+ item.description +'</button><div id="coModalTarif'+ n +'" class="collapse show card-body"><div class="row row-cols-2 g-3"><div class="col"><h6 class="fw-bold" style="color: '+ res.courier.warna +';">Durasi</h6><p class="m-0">'+ durasi +'</p></div><div class="col"><h6 class="fw-bold" style="color: '+ res.courier.warna +';">Tarif</h6><p class="m-0">'+ tarif +'</p></div></div></div></div>';

					} else {

						let durasi = (item.etd.length < 1) ? '-' : item.etd.replace(/hari/ig, '') + ' Hari';
						let tarif = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(item.cost);
						tarif = tarif.replace(',00', '');

						elementTarifWrapper.innerHTML += '<div class="co-modal-tarif mb-4 card"><button class="rounded-0 btn btn-dark text-start form-select" type="button" data-bs-toggle="collapse" data-bs-target="#coModalTarif'+ n +'" aria-expanded="true" aria-controls="coModalTarif'+ n +'">'+ item.service +'</button><div id="coModalTarif'+ n +'" class="collapse show card-body"><div class="row row-cols-2 g-3"><div class="col"><h6 class="fw-bold" style="color: '+ res.courier.warna +';">Durasi</h6><p class="m-0">'+ durasi +'</p></div><div class="col"><h6 class="fw-bold" style="color: '+ res.courier.warna +';">Tarif</h6><p class="m-0">'+ tarif +'</p></div></div></div></div>';
					}
				});
			}

			// up modal
			document.getElementById('coModalButton').click();
		}
	});
});