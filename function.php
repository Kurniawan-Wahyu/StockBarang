<<?php  


// membuat koneksi ke datatbase
$conn = mysqli_connect("localhost","root","","stockbarang");

// menambah barang baru
if (isset($_POST['addnewbarang'])) {
	$namabarang = $_POST['namabarang'];
	$deskripsi = $_POST['deskripsi'];
	$stock = $_POST['stock'];

	$addtotable = mysqli_query($conn,"insert into stock (namabarang, deskripsi, stock) values('$namabarang','$deskripsi','$stock')");
	if ($addtotable) {
		header('location:index.php');
	} else {
		echo 'Gagal';
		header('location:index.php');
	}
};



// menambah barang masuk
if (isset($_POST['barangmasuk'])) {
	$barangnya = $_POST['barangnya'];
	$penerima = $_POST['penerima'];
	$qty = $_POST['qty'];

	$cekstocksekarang = mysqli_query($conn,"SELECT * FROM stock where idbarang = '$barangnya'");
	$ambildatanya = mysqli_fetch_array($cekstocksekarang);

	$stocksekarang = $ambildatanya['stock'];
	$tambahkanstocksekarangdenganquantity = $stocksekarang+$qty;

	$addtomasuk = mysqli_query($conn,"insert into masuk (idbarang,keterangan,qty) values('$barangnya','$penerima','$qty')");
	$updatestockmasuk = mysqli_query($conn, "update stock set stock='$tambahkanstocksekarangdenganquantity' where idbarang='$barangnya'");
	if ($addtomasuk&&$updatestockmasuk) {
		    header('location:masuk.php');
		} else {
			echo'Gagal';
			header('location:masuk.php');
		}
}


// menambah barang keluar
if (isset($_POST['addbarangkeluar'])) {
	$barangnya = $_POST['barangnya'];
	$penerima = $_POST['penerima'];
	$qty = $_POST['qty'];

	$cekstocksekarang = mysqli_query($conn,"SELECT * FROM stock where idbarang = '$barangnya'");
	$ambildatanya = mysqli_fetch_array($cekstocksekarang);

	$stocksekarang = $ambildatanya['stock'];
	$tambahkanstocksekarangdenganquantity = $stocksekarang-$qty;

	$addtokeluar = mysqli_query($conn,"insert into keluar (idbarang,penerima,qty) values('$barangnya','$penerima','$qty')");
	$updatestockmasuk = mysqli_query($conn, "update stock set stock='$tambahkanstocksekarangdenganquantity' where idbarang='$barangnya'");
	if ($addtokeluar&&$updatestockmauk) {
		header('location:keluar.php');
		} else {
			echo'Gagal';
			header('location:keluar.php');
		}
}


// update info barang
if (isset($_POST['updatebaranf'])) {
	$idb = $_POST['idb'];
	$namabarang = $_POST['namabarang'];
	$deskripsi = $_POST['deskripsi'];

	$update = mysqli_query($conn,"update stock set namabarang='$namabarang', deskripsi = '$deskripsi' where idbarang ='$idb'");
	if ($updata) {
		header('location:index.php');
	} else {
		echo 'gagal';
		header ('location:index.php');
	}
}


// menghapus barang dari stock
if (isset($_POST['hapusbarang'])) {
	$idb = $_POST['idb'];

	$hapus = mysqli_query($conn, "delete from stock where idbarang='$idb'");
	if ($hapus) {
		header('location:index.php');
	} else {
		echo 'gagal';
		header('location:index.php');
	}
	
};


// mengubah data barang masuk
if (isset($_POST['updatebarangmasuk'])) {
	$idb = $_POST['idb'];
	$idm = $_POST['idm'];
	$deskripsi = $_POST['keterangan'];
	$qty = $_POST['qty'];

	$lihatstock = mysqli_query($conn,"SELECT * FROM stock where idbarang='$idb' ");
	$stocknya = mysqli_fetch_array($lihatstock);
	$stockskrng = $stocknya ['stock'];

	$qtyskrng = mysqli_query($conn,"SELECT * FROM stock where idmasuk='$idm' ");
	$qtynya = mysqli_fetch_array($qtyskrng);
	$qtyskrng = $qtynya ['qty'];

	if ($qty>$qtyskrng) {
		$selisih = $qty-$qtyskrng;
		$kurangin = $stockskrng + $selisih;
		$kurangistocknya = mysqli_query($conn,"update stock set stock='$kurangin' where idbarang='$idb'");
		$updatenya = mysqli_query($conn, "update masuk set qty='$qty', keterangan='$deskripsi' where idmasuk='$idm'");
		if ($kurangistocknya&&$updatenya) {
			header('location:masuk.php');
		} else {
			echo 'Gagal';
			header('location:masuk.php');
		}
	} else {
		$selisih = $qtyskrng-$qty;
		$kurangin = $stockskrng - $selisih;
		$kurangistocknya = mysqli_query($conn,"update stock set stock='$kurangin' where idbarang='$idb'");
		$updatenya = mysqli_query($conn, "update masuk set qty='$qty', keterangan='$deskripsi' where idmasuk='$idm'");
		if ($kurangistocknya&&$updatenya) {
			header('location:masuk.php');
		} else {
			echo 'Gagal';
			header('location:masuk.php');
		}
	}	
}


// menghapus barang masuk
if (isset($_POST['hapusbarangmasuk'])) {
	$idb = $_POST['idb'];
	$idm = $_POST['idm'];
	$qty = $_POST['kty'];

	$getdatastock = mysqli_query($conn,"SELECT * FROM stock where idbarang='$idb' ");
	$data = mysqli_fetch_array($getdatastock);
	$stok = $data ['stok'];

	$selisih = $stok-$qty;

	$update = mysqli_query($conn,"update stock set stock='$selisih' where idbarang='$idb' ");
	$hapusdata = mysqli_query($conn,"delete FROM stock where idmasuk='$idm' ");
	
	if ($update&&$hapusdata) {
		    header('location:masuk.php');
		} else {
			header('location:masuk.php');
		}
	}



// mengubah data barang keluar
if (isset($_POST['updatebarangkeluar'])) {
	$idb = $_POST['idb'];
	$idk = $_POST['idk'];
	$penerima = $_POST['penerima'];
	$qty = $_POST['qty']; // Qty baru inputan user

// mengambil stock barang saat ini
	$lihatstock = mysqli_query($conn,"SELECT * FROM stock where idbarang='$idb' ");
	$stocknya = mysqli_fetch_array($lihatstock);
	$stockskrng = $stocknya ['stock'];

// qty barang keluar saat ini
	$qtyskrng = mysqli_query($conn,"SELECT * FROM stock where idkeluar='$idk' ");
	$qtynya = mysqli_fetch_array($qtyskrng);
	$qtyskrng = $qtynya ['qty'];

	if ($qty>$qtyskrng) {
		$selisih = $qty-$qtyskrng;
		$kurangin = $stockskrng - $selisih;

		if ($selisih <= $stockskrng) {
			$kurangistocknya = mysqli_query($conn,"update stock set stock='$kurangin' where idbarang='$idb'");
		    $updatenya = mysqli_query($conn, "update masuk set qty='$qty', keterangan='$deskripsi' where idkeluar='$idk'");
		    if ($kurangistocknya&&$updatenya) {
			    header('location:keluar.php');
		    } else {
			    echo 'Gagal';
			    header('location:keluar.php');
		    }
			
		} else {
			echo '
			<script>alert("Stock tidak mencukupi");
			window.location.href="keluar.php";
			</script>
			';
		}
		
	} else {
		$selisih = $qtyskrng-$qty;
		$kurangin = $stockskrng + $selisih;
		$kurangistocknya = mysqli_query($conn,"update stock set stock='$kurangin' where idbarang='$idb'");
		$updatenya = mysqli_query($conn, "update masuk set qty='$qty', keterangan='$deskripsi' where idkeluar='$idk'");
		if ($kurangistocknya&&$updatenya) {
			header('location:keluar.php');
		} else {
			echo 'Gagal';
			header('location:keluar.php');
		}
	}	
}



// menghapus barang keluar
if (isset($_POST['hapusbarangkeluar'])) {
	$idb = $_POST['idb'];
	$idk = $_POST['idk'];
	$qty = $_POST['kty'];

	$getdatastock = mysqli_query($conn,"SELECT * FROM stock where idbarang='$idb' ");
	$data = mysqli_fetch_array($getdatastock);
	$stok = $data ['stok'];

	$selisih = $stok+$qty;

	$update = mysqli_query($conn,"update stock set stock='$selisih' where idbarang='$idb' ");
	$hapusdata = mysqli_query($conn,"delete FROM stock where idkeluar='$idk' ");
	
	if ($update&&$hapusdata) {
		    header('location:keluar.php');
		} else {
			header('location:keluar.php');
		}
	}


	
?>