/**
 *
 * You can write your JS code here, DO NOT touch the default style file
 * because it will make it harder for you to update.
 * 
 */

"use strict";
$(document).ready(function () {


	const flashData = $('#text-flash').data('flashdata');
	const tipe = $('#tipe-flash').data('tipe');
	const status = $('#status-flash').data('status');

	if (flashData) {
		Swal.fire({
			title: status,
			text: flashData,
			type: tipe
		});
	}

	$('.hapus-alert').on('click', function (e) {

		e.preventDefault();
		const href = $(this).attr('href');
		Swal.fire({
			title: 'Hapus Data',
			text: "Data yang telah dihapus tidak dapat dikembalikan",
			type: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Hapus'
		}).then((result) => {
			if (result.value) {
				document.location.href = href;
			}
		})

	});

	$('.btn-logout').on('click', function (e) {

		e.preventDefault();
		const href = $(this).attr('href');
		Swal.fire({
			title: 'Keluar',
			text: "Apakah anda yakin ingin keluar",
			type: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Keluar'
		}).then((result) => {
			if (result.value) {
				document.location.href = href;
			}
		})

	});

	$('.custom-hapus-alert').on('click', function (e) {
		e.preventDefault();
		let text = $(this).data('ctexta');
		const href = $(this).attr('href');
		Swal.fire({
			title: 'Hapus Data',
			text: text,
			type: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Hapus'
		}).then((result) => {
			if (result.value) {
				document.location.href = href;
			}
		})

	});

	$('.ask-alert').on('click', function (e) {
		e.preventDefault();
		let text = $(this).data('asktext');
		let btn = $(this).data('askbtn');
		let title = $(this).data('asktitle');
		const href = $(this).attr('href');
		Swal.fire({
			title: title,
			text: text,
			type: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: btn
		}).then((result) => {
			if (result.value) {
				document.location.href = href;
			}
		})

	});


	$('.uang-saya').on('keyup', function () {
		let uang = $('.uang-saya').val();
		let hargaTotal = $('.harga-total-saya').val();
		let i = uang - hargaTotal;
		$('.kembalian-saya').val(i);
	})

	function get_harga_jual() {

		var harga_beli = $('#harga_beli').val();
		var harga_jual = $('#harga_jual').val();
		var profit = harga_jual - harga_beli;
		$('#profit').val(profit);
	}

	$('.count_hr').keyup(function () {
		get_harga_jual();
	})

	function enableDisableButton(row) {

		let is_check = $('.check-produk').is(':checked');
		if (is_check) {
			$('#j_' + row).removeAttr('disabled');
		} else {
			$('#j_' + row).attr("disabled", true);
		}
	}

	$('.check-produk').on('change', function () {
		var row = $(this).data('id');
		let asd = "#" + row;
		enableDisableButton(row);
	});


	$('[data-toggle="datepicker"]').datepicker({
		format: 'dd-mm-yyyy'
	});

	$('#btnBarcode').on('click', function () {
		var codeNegara = 899;
		var kodePerusahaan = 5296;
		var kodeProduk = Math.random() * 99999;
		var bkp = Math.floor(kodeProduk);
		var barcodenya = "" + codeNegara + "" + "" + kodePerusahaan + "" + "" + bkp + "";
		var asw = "" + barcodenya + "";
		var ak = asw.length;
		if (ak == 11) {
			var codeNegara = 899;
			var kodePerusahaan = 5296;
			var kodeProduk = Math.random() * 99999;
			var bkp = Math.floor(kodeProduk);
			var barcodenya = "" + codeNegara + "" + "" + kodePerusahaan + "" + "" + bkp + "";
			$('#barcodeInp').val(barcodenya);
		} else {
			$('#barcodeInp').val(barcodenya);
		}

	})
	$('.uang-rp').number(true);


});