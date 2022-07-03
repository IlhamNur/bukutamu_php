<!DOCTYPE HTML>
<html>
<head>
    <title>Buku Tamu - Ubah Data Tamu</title>
 
    <!-- Latest compiled and minified Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
 
</head>
<body>
 
    <!-- container -->
    <div class="container">
 
        <div class="page-header">
            <h1>Ubah Data Tamu</h1>
        </div>
 
        <?php
        // get passed parameter value, in this case, the record nomor
        // isset() is a PHP function used to verify if a value is there or not
        $nomor=isset($_GET['nomor']) ? $_GET['nomor'] : die('ERROR: Data tamu tidak ditemukan.');
        
        //include database connection
        include 'database.php';
        
        // read current record's data
        try {
            // prepare select query
            $query = "SELECT nomor, nama, email, waktu, komentar FROM bukutamu WHERE nomor = ? LIMIT 0,1";
            $stmt = $con->prepare( $query );
        
            // this is the first question mark
            $stmt->bindParam(1, $nomor);
        
            // execute our query
            $stmt->execute();
        
            // store retrieved row to a variable
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
            // values to fill up our form
            $nama = $row['nama'];
            $email = $row['email'];
            $waktu = $row['waktu'];
            $komentar = $row['komentar'];
        }
        
        // show error
        catch(PDOException $exception){
            die('ERROR: ' . $exception->getMessage());
        }
        ?>
 
        <?php
        
        // check if form was submitted
        if($_POST){
        
            try{
        
                // write update query
                // in this case, it seemed like we have so many fields to pass and
                // it is better to label them and not use question marks
                $query = "UPDATE bukutamu
                            SET nama=:nama, email=:email, komentar=:komentar
                            WHERE nomor =:nomor";
        
                // prepare query for excecution
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
                $stmt->bindParam(':nomor', $nomor);
        
                // Execute the query
                if($stmt->execute()){
                    echo "<div class='alert alert-success'>Data tamu telah diubah.</div>";
                }else{
                    echo "<div class='alert alert-danger'>Tidak dapat mengubah data tamu. Tolong coba lagi.</div>";
                }
        
            }
        
            // show errors
            catch(PDOException $exception){
                die('ERROR: ' . $exception->getMessage());
            }
        }
        ?>
 
        <!--we have our html form here where new record information can be updated-->
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?nomor={$nomor}");?>" method="post">
            <table class='table table-hover table-responsive table-bordered'>
                <tr>
                    <td>Nama</td>
                    <td><input type='text' name='nama' value="<?php echo htmlspecialchars($nama, ENT_QUOTES); ?>" class='form-control' /></td>
                </tr>
                <tr>
                    <td>Email</td>
                    <td><input type='email' name='email' value="<?php echo htmlspecialchars($email, ENT_QUOTES); ?>" class='form-control'></input></td>
                </tr>
                <!-- <tr>
                    <td>Waktu</td>
                    <td><input type='time' name='waktu' value="echo htmlspecialchars($waktu, ENT_QUOTES);" class='form-control' /></td>
                </tr> -->
                <tr>
                    <td>Komentar</td>
                    <td><textarea name='komentar' class='form-control'><?php echo htmlspecialchars($komentar, ENT_QUOTES); ?></textarea></td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <input type='submit' value='Simpan Perubahan' class='btn btn-warning' />
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