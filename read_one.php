<!DOCTYPE HTML>
<html>
<head>
    <title>Buku Tamu - Melihat Data Tamu</title>
 
    <!-- Latest compiled and minified Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
 
</head>
<body>
 
    <!-- container -->
    <div class="container">
 
        <div class="page-header">
            <h1>Melihat Data Tamu</h1>
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
 
        <!--we have our html table here where the record will be displayed-->
        <table class='table table-hover table-responsive table-bordered'>
            <tr>
                <td>Nama</td>
                <td><?php echo htmlspecialchars($nama, ENT_QUOTES);  ?></td>
            </tr>
            <tr>
                <td>Email</td>
                <td><?php echo htmlspecialchars($email, ENT_QUOTES);  ?></td>
            </tr>
            <tr>
                <td>Waktu</td>
                <td><?php echo htmlspecialchars($waktu, ENT_QUOTES);  ?></td>
            </tr>
            <tr>
            <tr>
                <td>Komentar</td>
                <td><?php echo htmlspecialchars($komentar, ENT_QUOTES);  ?></td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <a href='index.php' class='btn btn-primary'>Kembali ke lihat data tamu</a>
                </td>
            </tr>
        </table>
 
    </div> <!-- end .container -->
 
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
 
<!-- Latest compiled and minified Bootstrap JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
 
</body>
</html>