<?php
// insert into notes ('sno','title','description','tstamp') values (NULL,'But Books','Please buy books from store',current_timestamp()); 
//connect to the database
$insert= false;
$update = false;
$delete = false;
$servername="localhost";
$username ="root";
$password ="";
$database = "notes";

//create a connection
$con = mysqli_connect($servername,$username,$password,$database);

// Die if connection was not successsful
if(!$con){
  die("Sorry we failed to connect:".mysqli_connect_error());
}
// else{
//   echo"connection was successful!<br>";
// }
// echo $_SERVER['REQUEST_METHOD'];
if(isset($_GET['delete'])){
  $sno = $_GET['delete'];
  // echo $sno;
  $delete=true;
  $sql ="Delete from notes where sno='$sno'";
  $result=mysqli_query($con,$sql);
}
if($_SERVER['REQUEST_METHOD']=='POST'){
  if(isset($_POST['snoEdit'])){
    // update the record
    $SNo =$_POST['snoEdit'];
    $title= $_POST['titleEdit'];
    $description =$_POST['descriptionEdit'];

    $sql ="update notes set title='$title',description='$description'where notes.sno='$SNo'";
    $result = mysqli_query($con, $sql);
    if($result){
      $update=true;
    }else{
      echo"We could not update the record successfully!";
    }

    
  }else{
    $title= $_POST['title'];
    $description =$_POST['description'];

    $sql ="insert into  notes (title,description) values ('$title','$description') ";
    $result = mysqli_query($con, $sql);

    if($result){
      // echo"The record has been inserted successfully!";
      $insert= true;
    }else{
      echo"The record was not  inserted successfully! because of error--->".mysqli_error($con);
    }
  }
}
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>iNotes - Notes taking made easy</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="//cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.7.0.js" integrity="sha256-JlqSTELeR4TLqP0OG9dxM7yDPqX1ox/HfgiSLBj8+kM=" crossorigin="anonymous"></script>
    <script>
      $(document).ready(function(){
      $('#mytable').DataTable();
    });
    </script>
  </head>
  <body>
    <!-- Edit modal -->
<!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editmodal">
  Edit Modal
</button> -->

<!-- Edit Modal -->
<div class="modal fade" id="editmodal" tabindex="-1" aria-labelledby="editmodalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="editmodalLabel">Edit This Note</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="/crud/index.php" method="post">
      <div class="modal-body">
      
        <input type="hidden"name="snoEdit" id="snoEdit">
  <div class="mb-3">
    <label for="title" class="form-label">Note Title</label>
    <input type="text" class="form-control" id="titleEdit"name="titleEdit" aria-describedby="emailHelp">
    
  </div>
 <div class="form-group">
    <label for ="desc">Note Description</label>
    <textarea class="form-control"id="descriptionEdit"name="descriptionEdit"rows="3"cols="5"></textarea>
 </div>
  
  <!-- <button type="submit" class="btn btn-primary mt-2">Update Note</button> -->

      </div>
      <div class="modal-footer d-block mr-auto">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
      </div>
      </form> 
    </div>
  </div>
</div>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="#"><img src="logo.png" height="28px"alt=""></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="#">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">About</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Contact Us</a>
        </li>
      </ul>
      <form class="form-inline my-2 my-lg-0 d-flex align-items-center">
        <input class="form-control me-4" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success" type="submit">Search</button>
      </form>
    </div>
  </div>
</nav>
<?php 
if($insert){
  echo " <div class='alert alert-success alert-dismissible fade show' role='alert'>
  <strong>Success</strong> Your notes has been inserted successfully!.
  <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
</div>";
}

?>
<?php 
if($update){
  echo " <div class='alert alert-success alert-dismissible fade show' role='alert'>
  <strong>Success</strong> Your notes has been updated successfully!.
  <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
</div>";
}

?>
<?php 
if($delete){
  echo " <div class='alert alert-success alert-dismissible fade show' role='alert'>
  <strong>Success</strong> Your notes has been deleted successfully!.
  <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
</div>";
}

?>
<div class="container my-4">
    <h2>Add a Note </h2>
    <form action="/crud/index.php" method="post">
  <div class="mb-3">
    <label for="title" class="form-label">Note Title</label>
    <input type="text" class="form-control" id="title"name="title" aria-describedby="emailHelp">
    
  </div>
 <div class="form-group">
    <label for ="desc">Note Description</label>
    <textarea class="form-control"id="description"name="description"rows="3"cols="5"></textarea>
 </div>
  
  <button type="submit" class="btn btn-primary mt-2">Add Note</button>
</form>
</div>
<div class="container my-4">
    <!-- <?php 
    $sql ="SELECT * FROM notes ";
    $res =mysqli_query($con,$sql);
    while($row = mysqli_fetch_assoc($res)){
      //echo var_dump($row);
      echo $row['sno']."Title" .$row['title'] . "Desc is" . $row['Description'];
      echo"<br>";
    }
    
    
    
    ?> -->
    <table class="table" id="mytable">
  <thead>
    <tr>
      <th scope="col">S. No</th>
      <th scope="col">Title</th>
      <th scope="col">Description</th>
      <th scope="col">Actions</th>
    </tr>
  </thead>
 
  <tbody>
  <?php 
    $sql ="SELECT * FROM notes ";
    $res =mysqli_query($con,$sql);
    $sno=0;
    while($row = mysqli_fetch_assoc($res)){
      //echo var_dump($row);
      $sno=$sno +1;
      echo "<tr>
      <th scope='row'>".$sno."</th>
      <td>".$row['title']."</td>
      <td>".$row['description']."</td>
      <td><button class='edit btn btn-sm btn-primary'id=".$row['sno'].">Edit</button> <button class='delete btn btn-sm btn-primary'id=d".$row['sno'].">Delete</button></td>
    </tr>";
    
        }
        
        
    
    
    
    ?>    
    </tbody> 
</table>
</div>
<hr>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <script src="//cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script>

      edits=document.getElementsByClassName('edit');
      Array.from(edits).forEach((element)=>{
        element.addEventListener("click",(e)=>{
          console.log("edit",);
          tr=e.target.parentNode.parentNode;
          title =tr.getElementsByTagName("td")[0].innerText;
          description =tr.getElementsByTagName("td")[1].innerText;
          console.log(title,description);
          titleEdit.value=title;
          descriptionEdit.value=description;
          snoEdit.value=e.target.id;
          console.log(e.target.id);
          $('#editmodal').modal('toggle');

        })
      })

      deletes=document.getElementsByClassName('delete');
      Array.from(deletes).forEach((element)=>{
        element.addEventListener("click",(e)=>{
          console.log("edit",);
          sno= e.target.id.substr(1,);
         
          if(confirm("Are You sure you want to delete this note!")){
            console.log("Yes");
            window.location = '/crud/index.php?delete=<?php echo $sno ?>;';
            // Create a from and use Post request to submit a form
          }else{
            console.log("No");
          }

        })
      })
    </script>
  </body>
</html>