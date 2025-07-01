<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar JPL</title>
</head>
<body style="font-family: Arial, sans-serif; display: flex; justify-content: center; align-items: center; min-height: 100vh; background-color: #f0f2f5; margin: 0;">
    <div style="background-color: #ffffff; padding: 30px; border-radius: 10px; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1); text-align: center; max-width: 500px; width: 90%;">
        <h1 style="color: #333; margin-bottom: 20px;">Daftar JPL</h1>
        <div id="toggle-items" style="background-color: #007bff; color: white; padding: 10px 20px; border-radius: 5px; cursor: pointer; margin-bottom: 10px; font-size: 1.1em; display: inline-block;">Tampilkan Pilihan &#9660;</div> <ul id="item-list" style="list-style: none; padding: 0; margin: 0; margin-top: 15px; display: none;">
            <li style="margin-bottom: 10px;"><a href="jpl01/monitor.php" style="display: block; padding: 12px 20px; background-color: #e9ecef; color: #333; text-decoration: none; border-radius: 5px;">JPL 01 PD-PLA</a></li>
            <li style="margin-bottom: 10px;"><a href="monitor_jaringan.html" style="display: block; padding: 12px 20px; background-color: #e9ecef; color: #333; text-decoration: none; border-radius: 5px;">JPL 02 PD-PLA</a></li>
            <li style="margin-bottom: 10px;"><a href="monitor_aplikasi.html" style="display: block; padding: 12px 20px; background-color: #e9ecef; color: #333; text-decoration: none; border-radius: 5px;">JPL 03 PD-PLA</a></li>
            <li style="margin-bottom: 10px;"><a href="monitor_database.html" style="display: block; padding: 12px 20px; background-color: #e9ecef; color: #333; text-decoration: none; border-radius: 5px;">JPL 04 PD-PLA</a></li>
        </ul>
    </div>

    <script>
        const toggleButton = document.getElementById('toggle-items');
        const itemList = document.getElementById('item-list');
        let isVisible = false; // Status awal: item tersembunyi

        toggleButton.addEventListener('click', () => {
            if (isVisible) {
                // Jika sedang terlihat, sembunyikan
                itemList.style.display = 'none';
                toggleButton.textContent = 'Tampilkan Pilihan \u25BC'; // Ganti panah ke bawah
                isVisible = false;
            } else {
                // Jika sedang tersembunyi, tampilkan
                itemList.style.display = 'block';
                toggleButton.textContent = 'Sembunyikan Pilihan \u25B2'; // Ganti panah ke atas
                isVisible = true;
            }
        });
    </script>
</body>
</html>