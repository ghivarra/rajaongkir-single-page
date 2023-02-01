const cekResiForm = document.getElementById('pills-lacak-paket');

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
const cekOngkirForm = document.getElementById('co-form');
const kurirSelect = document.getElementById('co-kurir');

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
});