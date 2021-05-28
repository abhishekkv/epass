<?php 

	include('config/db_connect.php');

	if(isset($_POST['delete'])){

		$id_to_delete = mysqli_real_escape_string($conn, $_POST['id_to_delete']);

		$sql = "DELETE FROM details WHERE id = $id_to_delete";
		// echo $id_to_delete;
		if(mysqli_query($conn, $sql)){
			header('Location: pol.php');
		} else {
			echo 'query error: '. mysqli_error($conn);
		}

	}








	if(isset($_POST['approve'])){

		$id_to_approve = mysqli_real_escape_string($conn, $_POST['id_to_approve']);

		$sql = "UPDATE details  SET stat = 'Approved'  WHERE id = $id_to_approve";
		 
		if(mysqli_query($conn, $sql)){
			header('Location: pol.php');
		} else {
			echo 'query error: '. mysqli_error($conn);
		}

	}




	if(isset($_POST['reject'])){

		$id_to_approve = mysqli_real_escape_string($conn, $_POST['id_to_reject']);

		$sql = "UPDATE details  SET stat = 'Rejected'  WHERE id = $id_to_approve";
		 
		if(mysqli_query($conn, $sql)){
			header('Location: pol.php');
		} else {
			echo 'query error: '. mysqli_error($conn);
		}

	}
	





	// check GET request id param
	if(isset($_GET['id'])){
		
		// escape sql chars
		$id = mysqli_real_escape_string($conn, $_GET['id']);

		// make sql
		$sql = "SELECT * FROM details WHERE id = $id";

		// get the query result
		$result = mysqli_query($conn, $sql);

		// fetch result in array format
		$temp = mysqli_fetch_assoc($result);

		mysqli_free_result($result);
		mysqli_close($conn);

	}





?>

<!DOCTYPE html>
<html>

	<?php include('templates/header.php'); ?>

	<div class="container center grey-text">
		<?php if($temp): ?>
			<h4><?php echo $temp['title']; ?></h4>
			<p>Requested by  <?php echo $temp['email']; ?></p>
			<p><?php echo date($temp['created_at']); ?></p>
			<p>Time slot:</p>
			<p><?php echo $temp['timeframe']; ?></p>

			<!-- DELETE /Appprove FORM -->
			<form action="poldet.php" method="POST">
				<input type="hidden" name="id_to_delete" value="<?php echo $temp['id']; ?>">
				<input type="submit" name="delete" value="Delete" class="btn brand z-depth-0">


				<input type="hidden" name="id_to_approve" value="<?php echo $temp['id']; ?>">
				<input type="submit" name="approve" value="Approve" class="btn brand z-depth-0">

             

				<input type="hidden" name="id_to_reject" value="<?php echo $temp['id']; ?>">
				<input type="submit" name="reject" value="Reject" class="btn brand z-depth-0">
				


			</form>

		<?php else: ?>
			<h5>Pass is Approved .</h5>
			exit;
		<?php endif ?>
	</div>

	<?php include('templates/footer.php'); ?>

</html>