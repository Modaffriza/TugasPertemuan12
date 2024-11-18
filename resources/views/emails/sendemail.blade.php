<!DOCTYPE html>
<html>
<head>
    <title>Pendaftaran Berhasil</title>
</head>
<body>
    <h1>Halo {{ $data['name'] }}!</h1>
    <p>Selamat, akun Anda berhasil didaftarkan di aplikasi kami.</p>
    <p><strong>Email:</strong> {{ $data['email'] }}</p>
    <p><strong>Tanggal Pendaftaran:</strong> {{ $data['date'] }}</p>
    <p>Terima kasih telah bergabung dengan kami!</p>
</body>
</html>
