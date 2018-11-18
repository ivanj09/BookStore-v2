# Tugas 2 IF3110 Pengembangan Aplikasi Berbasis Web
#### Dibuat oleh IF3110-2018-K02-Isyana

## Deskripsi Singkat

Pada tugas 2, Developer diminta untuk mengembangkan aplikasi toko buku online sederhana yang sudah dibuat pada tugas 1. Arsitektur aplikasi diubah agar memanfaatkan 2 buah webservice, yaitu webservice bank dan webservice buku. Baik aplikasi maupun kedua webservice, masing-masing memiliki database sendiri.

## Pengembang

- **[13516038 - Mochamad Alghifari](http://gitlab.informatika.org/mo.alghifari)**
- **[13516056 - M Rafli Al Khadafi](http://gitlab.informatika.org/raflyalk)**
- **[13516059 - Ivan Jonathan](http://gitlab.informatika.org/ivanj09)**

## Buat nyoba WebService buku (trial and error dulu)
- Buat nyalain webservice buku bisa gunain Eclipse buat running WebService buku.
- Kalo udah buka Eclipse dan Projectnya.
- Cari Main.java dan klik kanan pada Main.java di Project Explorer.
- Terus pilih Run > Run as Java Application.
- Buat ngetest bisa atau gak WebServicenya ke link berikut: http://localhost:4789/services/order?wsdl
- Bisa langsung ke http://localhost:port/index.php/testservice (ini localhost dan port buat pro book) buat nyoba servicenya di pro-book.
- Prosedur connect dari php ke Service bisa dilihat di controllers/SoapServiceController.php
