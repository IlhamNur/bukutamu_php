<!DOCTYPE HTML>
<html>
<head>
    <title>Buku Tamu - Data Tamu</title>
 
    <!-- Latest compiled and minified Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
 
    <!-- custom css -->
    <style>
    .m-r-1em{ margin-right:1em; }
    .m-b-1em{ margin-bottom:1em; }
    .m-l-1em{ margin-left:1em; }
    .mt0{ margin-top:0; }
    </style>
 
</head>
<body>
 
    <!-- container -->
    <div class="container">
 
        <div class="page-header">
            <h1>Buku Data Tamu</h1>
        </div>
 
        <?php
        // include database connection
        include 'database.php';
        // PAGINATION VARIABLES
        // page is the current page, if there's nothing set, default is page 1
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        
        // set records or rows of data per page
        $records_per_page = 5;
        
        // calculate for the query LIMIT clause
        $from_record_num = ($records_per_page * $page) - $records_per_page;
        
        $action = isset($_GET['action']) ? $_GET['action'] : "";
 
        // if it was redirected from delete.php
        if($action=='deleted'){
            echo "<div class='alert alert-success'>Data tamu telah dihapus.</div>";
        }
        
        // select data for current page
        $query = "SELECT nomor, nama, email, waktu, komentar FROM bukutamu ORDER BY nomor
            LIMIT :from_record_num, :records_per_page";
        
        $stmt = $con->prepare($query);
        $stmt->bindParam(":from_record_num", $from_record_num, PDO::PARAM_INT);
        $stmt->bindParam(":records_per_page", $records_per_page, PDO::PARAM_INT);
        $stmt->execute();
        
        // this is how to get number of rows returned
        $num = $stmt->rowCount();
        
        // link to create record form
        echo "<a href='create.php' class='btn btn-warning m-b-1em'>Masukkan Data Tamu Baru</a>";
        
        //check if more than 0 record found
        if($num>0){
        
            //start table
            echo "<table class='table table-hover table-responsive table-bordered'>";
            
            //creating our table heading
            echo "<tr>
                <th>Nomor</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Waktu</th>
                <th>Komentar</th>
            </tr>";

            // retrieve our table contents
            // fetch() is faster than fetchAll()
            // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop

            $no = 1;

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                // extract row
                // this will make $row['firstname'] to
                // just $firstname only
                extract($row);

                $query2 = "ALTER TABLE bukutamu AUTO_INCREMENT = 1";
                $stmt2 = $con->prepare($query2);
                $stmt2->execute();
                
                $query3 = "UPDATE bukutamu SET nomor = $no WHERE nomor = $nomor";
                $stmt3 = $con->prepare($query3);
                $stmt3->execute();

                $no++;
            
                // creating new table row per record
                echo "<tr>
                    <td>{$nomor}</td>
                    <td>{$nama}</td>
                    <td>{$email}</td>
                    <td>{$waktu}</td>
                    <td>{$komentar}</td>
                    <td>";
                        // read one record
                        echo "<a href='read_one.php?nomor={$nomor}' class='btn btn-info m-r-1em'>Lihat</a>";
            
                        // we will use this links on next part of this post
                        echo "<a href='update.php?nomor={$nomor}' class='btn btn-warning m-r-1em'>Ubah</a>";
            
                        // we will use this links on next part of this post
                        echo "<a href='#' onclick='delete_user({$nomor});'  class='btn btn-danger'>Hapus</a>";
                    echo "</td>";
                echo "</tr>";
            }

            // end table
            echo "</table>";

            // PAGINATION
            // count total number of rows
            $query = "SELECT COUNT(*) as total_rows FROM bukutamu";
            $stmt = $con->prepare($query);
            
            // execute query
            $stmt->execute();
            
            // get total rows
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $total_rows = $row['total_rows'];

            // paginate records
            $page_url="index.php?";
            include_once "paging.php";
        
        }
        
        // if no records found
        else{
            echo "<div class='alert alert-danger'>Data tamu tidak ditemukan</div>";
        }
        ?>
 
    </div> <!-- end .container -->
 
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
 
<!-- Latest compiled and minified Bootstrap JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
 
<script type='text/javascript'>
// confirm record deletion
function delete_user( nomor ){
 
    var answer = confirm('Apakah kamu yakin?');
    if (answer){
        // if user clicked ok,
        // pass the id to delete.php and execute the delete query
        window.location = 'delete.php?nomor=' + nomor;
    }
}
</script>
 
</body>
</html>