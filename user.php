<?php 

	include('config/db_connect.php');

	// write query for all detail
	$sql = 'SELECT title, timeframe, id ,stat FROM details ORDER BY created_at';

	// get the result set (set of rows)
	$result = mysqli_query($conn, $sql);

	// fetch the resulting rows as an array
	$detail = mysqli_fetch_all($result, MYSQLI_ASSOC);

	// free the $result from memory (good practise)
	mysqli_free_result($result);

	// close connection
	mysqli_close($conn);


?>

<!DOCTYPE html>
<html>
	
	<?php include('templates/header.php'); ?>


	<ul id="nav-mobile" class="center">
        <li><a href="add.php" class="btn brand z-depth-0">Apply for pass</a></li>
      </ul>
	  <h4 class="center grey-text">Active Pass Requests</h4>
	<div class="container">
		<div class="row">

			<?php foreach($detail as $temp): ?>

				<div class="col s6 m4">
					<div class="card z-depth-0">
						<img src="img/logo.png"class="temp">
						<div class="card-content center">
							<h6><?php  echo "Purpose: " ;echo htmlspecialchars($temp['title']); ?></h6>
						 <h6><?php  echo "Status: ";   echo htmlspecialchars($temp['stat']); ?></h6>
							
							<ul class="grey-text">
								<?php echo "Time Slot " ;foreach(explode(',', $temp['timeframe']) as $ing): ?>
									<li><?php echo htmlspecialchars($ing); ?></li>
								<?php endforeach; ?>
							</ul>
						</div>
						<div class="card-action right-align">
							<a class="brand-text" href="details.php?id=<?php echo $temp['id'] ?>">more info</a>
						</div>
					</div>
				</div>

			<?php endforeach; ?>

		</div>
	</div>

	<?php include('templates/footer.php'); ?>

</html>