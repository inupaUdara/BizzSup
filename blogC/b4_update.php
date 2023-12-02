<?php
//connect blog4_panel
include 'blog4_panel.php';
?>


<?php
//database connection
include_once('inc/conn.php');



$id = $_GET['edit'];

if(isset($_POST['update_blog'])) {
    //collect new data
    $blog_id = $_POST['blog_id'];
    $blog_title = $_POST['blog_title'];
    $blog_content = $_POST['blog_content'];
    $blog_date = $_POST['blog_date'];
    $blog_image = $_FILES['blog_image']['name'];
    $blog_image_tmp_name = $_FILES['blog_image']['tmp_name'];
    $blog_image_folder = 'uploaded_image/'.$blog_image;

    //update data
    if(empty($blog_id) || empty($blog_title) || empty($blog_content) || empty($blog_date) || empty($blog_image) ){
        $message[] = 'please fill out all';
    }else{
        $update_data = "UPDATE blog4 SET bid ='$blog_id', btitle ='$blog_title', bcontent ='$blog_content', bdate ='$blog_date', bimage ='$blog_image' WHERE id ='$id'";
        $upload = mysqli_query($conn, $update_data);
        
        if($upload){
            move_uploaded_file($blog_image_tmp_name, $blog_image_folder);
            header('location:blog4_panel.php');            
        }else{
            $message[] = 'please fill out all';

        }
    }


};

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>blog update</title>

    <link rel ="stylesheet" href="bstyle.css" type="text/css">
</head>
<body>

<?php
//display error message
if(isset($message)){
    foreach($message as $message){
        echo '<span class="message">'.$message.'</span>';
    }
}



?>

<div class ="container">

<div class="blog-contents centered">


<?php 
$select = mysqli_query($conn,"SELECT * FROM blog4 WHERE id = '$id' ");
while($row = mysqli_fetch_assoc($select)){


?>      
        <!-- display update panel for enter date -->
        <form action ="" method ="post" enctype ="multipart/form-data">
        <h3> Update the Blog 02 </h3>
        <input type="text"  class ="box" name ="blog_id" value="<?php echo $row['bid'];?>" placeholder ="Enter blog ID like (E_)">
        <input type="text" class ="box" name ="blog_title" value="<?php echo $row['btitle'];?>"  placeholder ="Enter blog title">
        <input type="text" class ="box" name ="blog_content" value="<?php echo $row['bcontent'];?>"  placeholder ="Enter blog content" >
        <input type="text"  class ="box" name ="blog_date" value="<?php echo $row['bdate'];?>"  placeholder ="Enter blog date">
        <input type="file" accept="image/png, image/jpeg, image/jpg" name ="blog_image" class ="box">
        <input type ="submit" class = "btn" name ="update_blog" value = "update Blog" >
        <a href="blog2_panel.php" class="btn" >go back </a>
</form>

<?php }; ?>
</div>
</div>
    
</body>
</html>