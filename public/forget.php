<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
    <link rel="stylesheet" href="css/forget.css">
    <link rel="icon" href="img/iconn.png">
    <!-- font awesome icons -->
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
      integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    />
    <title>Lupa Password</title>
</head>
<body>
    <div class="container">
        <div class="signin-signup">
        <form action="../controller/reset/forget.php" class="sign-in-form" method="post">
            <h2 class="title">Lupa Password</h2>
            <div class="input-field">
                <i class="fa-regular fa-envelope"></i>
                <input type="text" placeholder="Masukan Alamat Email" name="email" autofocus required>
            </div>
            <div style="width: 100%; justify-content: space-around; display: flex; align-items: center;">
                <a href="../index.php" style="width: 150px; height: 50px; display: flex; align-items: center; justify-content: center; font-size: 13px; border-radius: 50px; background-color: #dcdcdc; color: #000;">BATAL</a>
                <input type="submit" value="cari" class="btn" name="next">
            </div>
        </form>
        </div>   
    </div>
</body>
</html>
