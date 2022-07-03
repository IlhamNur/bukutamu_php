<?php
// include database connection
include 'database.php';
 
try {
 
    // get record nomor
    // isset() is a PHP function used to verify if a value is there or not
    $nomor=isset($_GET['nomor']) ? $_GET['nomor'] : die('ERROR: Data tamu tidak ditemukan.');
 
    // delete query
    $query = "DELETE FROM bukutamu WHERE nomor = ?";
    $stmt = $con->prepare($query);
    $stmt->bindParam(1, $nomor);

    if($stmt->execute()){
        // redirect to read records page and
        // tell the user record was deleted
        header('Location: index.php?action=deleted');
    }else{
        die('Tidak dapat menghapus data tamu.');
    }
}
 
// show error
catch(PDOException $exception){
    die('ERROR: ' . $exception->getMessage());
}
?>