<?php 
$insert = false;
$update =false;
$delete = false;
$localhost = "localhost";
$username = "root";
$password = "";
$database = "notes";

$conn = mysqli_connect($localhost, $username, $password, $database);
if(!$conn){
    die("Connection failed: ".mysqli_connect_error());
}
if(isset($_GET['delete'])){
  $srno=$_GET['delete'];
  $delete=true;
  $sql = "DELETE FROM `notes` WHERE `srno` = $srno";
  $result=mysqli_query($conn,$sql);
 
}
if($_SERVER['REQUEST_METHOD'] == 'POST'){
  if(isset($_POST['snoEdit'])){
    $srno = $_POST['snoEdit'];
    $title=$_POST["TitleEdit"];
    $discription =$_POST["discriptionEdit"];
    $sql = "UPDATE `notes` SET `title` = '$title', `discription` = '$discription' WHERE `notes`.`srno` = $srno";

    $result = mysqli_query($conn, $sql);
    if($result){
      echo"updated successfully";
    }else{
      echo "not updated successfully";
    }

  }else{
  $title=$_POST["Title"];
  $discription =$_POST["discription"];
  $sql = "INSERT INTO `notes` (`title`, `discription`) VALUES ('$title', '$discription')";
  $result =mysqli_query($conn, $sql);
  if($result){
    $insert = true;
  }else{
    echo "The data is not inserted successfully because of the error --->".mysqli_error($conn);
  }
}
}

?>

<!doctype html>
<html lang="en">
  <head>
    <title>Title</title>
    
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="//cdn.datatables.net/2.1.8/css/dataTables.dataTables.min.css">
    
    
    
  
  
  </head>
  <body>

  <div class="modal" id="editModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit Modal</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">X</button>
      </div>
      <div class="modal-body">
      <form Action="index.php" method='POST'>
        <input type="hidden" name="snoEdit" id="snoEdit">
        <div class="mb-3 row">
            <label for="Title" class="col-sm-2 col-form-label">Edit note</label>
            <div class="col-sm-10">
              <input type="text" name="TitleEdit" class="form-control" id="TitleEdit">
            </div>
          </div>
          <div class="mb-3">
            <label for="discription" class="form-label">Note discription</label>
            <textarea class="form-control" name="discriptionEdit" id="discriptionEdit" rows="3"></textarea>
          </div>
            <button type="submit" class="btn btn-primary ">Update note</button>
          </div>
          </form>
      </div>
      <!-- <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div> -->
    </div>
  </div>
</div>


    <nav class="navbar navbar-expand-lg bg-dark navbar-dark">
        <div class="container-fluid">
          <a class="navbar-brand" href="#">Keep notes</a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
              <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="#">Home</a>
              </li>
              <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="#">About</a>
              </li>
              <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="#">Contact us</a>
              </li>
            
            </ul>
            <form class="d-flex" role="search">
              <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
              <button class="btn btn-outline-success" type="submit">Search</button>
            </form>
          </div>
        </div>
      </nav>
      <?php 
      if($insert == true){
        echo "
        <div class='alert alert-success alert-dismissible fade show' role='alert'>
        <strong>success</strong> Your record has been inserted sucessfully.
        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
        &times;
        </button>
      </div>";
      }
?>
      <div class="container my-5">
        <h2>ADD A NOTE</h2>
        <form Action="index.php" method='POST'>
        <div class="mb-3 row">
            <label for="Title" class="col-sm-2 col-form-label">Note title</label>
            <div class="col-sm-10">
              <input type="text" name="Title" class="form-control" id="Title">
            </div>
          </div>
          <div class="mb-3">
            <label for="discription" class="form-label">Note discription</label>
            <textarea class="form-control" name="discription" id="discription" rows="3"></textarea>
          </div>
            <button type="submit" class="btn btn-primary ">Add note</button>
          </div>
          </form>

      </div>
      <div class="container">
       
         <table class="table" id="myTable">
  <thead>
    <tr>
      <th scope="col">srno</th>
      <th scope="col">Title</th>
      <th scope="col">discription</th>
      <th scope="col">Actions</th>
    </tr>
  </thead>
  <tbody>
  <?php
$sql = "SELECT * FROM `notes`";
$result = mysqli_query($conn, $sql);
$srno = 0;
while ($row = mysqli_fetch_assoc($result)) {
    $srno = $srno + 1;
    echo " <tr>
        <th scope='row'>" . $srno . "</th>
        <td>" . $row['title'] . "</td>
        <td>" . $row['discription'] . "</td>
        <td> <button class='edit btn btn-primary btn-sm' id=" . $row['srno'] . ">EDIT</button>  <button class='delete btn btn-primary btn-sm' id=d" . $row['srno'] . ">DELETE</button></td>
    </tr>";
}
?>
    
  </tbody>
</table>
      </div>
      <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>


    <script src="//cdn.datatables.net/2.1.8/js/dataTables.min.js"></script>
  

<script> $(document).ready( function () {
$('#myTable').DataTable();
} );
</script>

  <script>    
edits = document.getElementsByClassName('edit');
Array.from(edits).forEach((element)=>{
  element.addEventListener("click",(e)=>{
    console.log("edit", e);
    tr = e.target.parentNode.parentNode;
    title = tr.getElementsByTagName("td")[0].innerText;
    discription = tr.getElementsByTagName("td")[1].innerText;
    console.log(title, discription);
    TitleEdit.value = title;
    discriptionEdit.value = discription;
    snoEdit.value = e.target.id;
    console.log(e.target.id);
    const modal = new bootstrap.Modal(document.getElementById('editModal'));
    modal.toggle();
  })
})

deletes = document.getElementsByClassName('delete');
Array.from(deletes).forEach((element)=>{
  element.addEventListener("click",(e)=>{
    console.log("edits", e);
    srno = e.target.id.substr(1);
    if (confirm("press ok button to delete")){
        window.location = `index.php?delete=${srno}`;
    }
    else{
console.log("no")
    }
    

   
  })
})
   </script>

  </body>
</html>
<!-- note the delete issue -->