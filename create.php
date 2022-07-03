<!DOCTYPE HTML>
<html>
<head>
    <title>Buku Tamu - Create</title>
 
    <!-- Latest compiled and minified Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
 
</head>
<body>
 
    <!-- container -->
    <div class="container">
 
        <div class="page-header">
            <h1>Masukkan Data Tamu</h1>
        </div>
 
        <?php
        if($_POST){
        
            // include database connection
            include 'database.php';
        
            try{
        
                // insert query
                $query = "INSERT INTO bukutamu SET nama=:nama, email=:email, waktu=:waktu, komentar=:komentar";
        
                // prepare query for execution
                $stmt = $con->prepare($query);
        
                // posted values
                $nama=htmlspecialchars(strip_tags($_POST['nama']));
                $email=htmlspecialchars(strip_tags($_POST['email']));
                // $waktu=htmlspecialchars(strip_tags($_POST['waktu']));
                $komentar=htmlspecialchars(strip_tags($_POST['komentar']));
        
                // bind the parameters
                $stmt->bindParam(':nama', $nama);
                $stmt->bindParam(':email', $email);
                // $stmt->bindParam(':waktu', $waktu);
                $stmt->bindParam(':komentar', $komentar);

                // specify when this record was inserted to the database
                date_default_timezone_set("Asia/Jakarta");
                $waktu=date('Y-m-d H:i:s');
                $stmt->bindParam(':waktu', $waktu);

                $no = 1;
                $query2 = "ALTER TABLE bukutamu AUTO_INCREMENT = $no";
                $stmt2 = $con->prepare($query2);
                $stmt2->execute();
        
                // Execute the query
                if($stmt->execute()){
                    echo "<div class='alert alert-success'>Data tamu telah tersimpan.</div>";
                }else{
                    echo "<div class='alert alert-danger'>Tidak dapat menyimpan data tamu.</div>";
                }
        
            }
        
            // show error
            catch(PDOException $exception){
                die('ERROR: ' . $exception->getMessage());
            }
        }
        ?>
 
    <!-- html form here where the tamu information will be entered -->
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
        <table class='table table-hover table-responsive table-bordered'>
            <tr>
                <td>Nama</td>
                <td><input type='text' name='nama' class='form-control' /></td>
            </tr>
            <tr>
                <td>Email</td>
                <td><input type='email' name='email' class='form-control'></input></td>
            </tr>
            <!-- <tr>
                <td>Waktu</td>
                <td><input type='time' name='waktu' class='form-control' /></td>
            </tr> -->
            <tr>
                <td>Komentar</td>
                <td><textarea name='komentar' class='form-control'></textarea></td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <input type='submit' value='Simpan' class='btn btn-warning' />
                    <a href='index.php' class='btn btn-primary'>Kembali ke Buku Tamu</a>
                </td>
            </tr>
        </table>
    </form>
 
    </div> <!-- end .container -->
 
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
 
<!-- Latest compiled and minified Bootstrap JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
 
</body>
</html>