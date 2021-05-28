<?php

	include('config/db_connect.php');

	$email = $title = $timeframe = '';
	$errors = array('email' => '', 'title' => '', 'timeframe' => '');

	if(isset($_POST['submit'])){
		
		// check email
		if(empty($_POST['email'])){
			$errors['email'] = 'An email is required';
		} else{
			$email = $_POST['email'];
			if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
				$errors['email'] = 'Email must be a valid email address';
			}
		}

		// check title
		if(empty($_POST['title'])){
			$errors['title'] = 'A title is required';
		} else{
			$title = $_POST['title'];
			if(!preg_match('/^[a-zA-Z\s]+$/', $title)){
				$errors['title'] = 'Title must be letters and spaces only';
			}
		}

		// check timeframe
		if(empty($_POST['timeframe'])){
		$errors['timeframe'] = 'At least one timeframe is required';
		} else{
			$timeframe = $_POST['timeframe'];
			if(!preg_match('/^[0-9]+(\\.[0-9]+)?$/', $timeframe)){
				$errors['timeframe'] = 'timeframe must be a comma separated list';
			}
		}

		if(array_filter($errors)){
			//echo 'errors in form';
		} else {
			// escape sql chars
			$email = mysqli_real_escape_string($conn, $_POST['email']);
			$title = mysqli_real_escape_string($conn, $_POST['title']);
			$timeframe = mysqli_real_escape_string($conn, $_POST['timeframe']);

			// create sql
			$sql = "INSERT INTO details(title,email,timeframe) VALUES('$title','$email','$timeframe')";

			// save to db and check
			if(mysqli_query($conn, $sql)){
				// success
				header('Location: user.php');
			} else {
				echo 'query error: '. mysqli_error($conn);
			}
			
		}

	} // end POST check

?>

<!DOCTYPE html>
<html>
	
	<?php include('templates/header.php'); ?>

	<section class="container grey-text">
		<h4 class="center">Enter details</h4>
		<form class="white" action="add.php" method="POST">
			<label>Your Email</label>
			<input type="text" name="email" value="<?php echo htmlspecialchars($email) ?>">
			<div class="red-text"><?php echo $errors['email']; ?></div>
			<label>Purpose</label>
			<input type="text" name="title" value="<?php echo htmlspecialchars($title) ?>">
			<div class="red-text"><?php echo $errors['title']; ?></div>
			<label> Travel time</label>
			<input type="text" name="timeframe" value="<?php echo htmlspecialchars($timeframe) ?>">
			<div class="red-text"><?php echo $errors['timeframe']; ?></div>
			<div class="center">
				<input type="submit" name="submit" value="Submit" class="btn brand z-depth-0">
			</div>
		</form>
	</section>

	<?php include('templates/footer.php'); ?>

</html>