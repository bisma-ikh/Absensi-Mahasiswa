function confirmLogout() {
    var confirmLogout = confirm("Apakah Anda yakin ingin logout?");
    if (confirmLogout) {
        window.location.href = "../../../controller/app/logout.php"; // Redirect ke halaman logout jika "OK" ditekan
    } else {
        // Tindakan jika "Cancel" ditekan (opsional)
        // Misalnya: tidak melakukan apa-apa atau menutup dialog
    }
}