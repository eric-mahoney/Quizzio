<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
	<head>
		<title>Submitted Quiz</title>
		<link rel="stylesheet" href="style.css">
	</head>
	<body>
		<h1>Online Quiz</h1>
		<?php

			// opens and locks the questions text file
			$q_file = 'questions.txt';
			$questions = fopen($q_file,'r');
			$number_arr = array();
			$questions_arr = array();
			$chapter_arr = array();
			flock($questions, LOCK_EX);

			// answers
			$a_file = 'answers.txt';
			$answers = fopen($a_file, 'r');
			$answer_arr = array();
			$correct_arr = array();
			flock($questions, LOCK_EX);

			// while loop that executes until we've reached the end of the $questions file
			while(!feof($questions)){

				// opens the questions file and reads the current line from the file pointer and stores the different comma separated values into arrays
				$q_line = fgetcsv($questions);
				$number_arr[] = $q_line[0];
				$questions_arr[] = $q_line[1];
				$chapter_arr[] = $q_line[2];
				$correct_arr[] = $q_line[3];

				// opens the answers file and reads the current line from the file pointer and stores the different comma separated values into arrays
				$a_line = fgetcsv($answers);
				$answer1_arr[] = $a_line[1];
				$answer2_arr[] = $a_line[2];
			}
		?>

		<?php 
			// opens a new PHP block to advanced escape a block of HTML code
			for($i = 0; $i < count($number_arr); $i++){
		?>

		<p><?php echo $number_arr[$i] . " " . $questions_arr[$i] . " " . $chapter_arr[$i]; ?></p>
		<form method="post" action="submitted.php" name="answers">
			<input type="radio"><?php echo $answer1_arr[$i]; ?>
			<input type="radio"><?php echo $answer2_arr[$i]; ?>
		<?php 
			}
			// unlocks and closes the questions file
			flock($questions, LOCK_UN);
			fclose($questions);

			// unlocks and closes the answers file
			flock($answers, LOCK_UN);
			fclose($answers);
		?>
		<input type="submit">
		</form>

		<?php 
			$question1 = $_POST['0'];
			$question2 = $_POST['1'];
			$question3 = $_POST['2'];
			$user_answers = array($question1,$question2,$question3);

			// function that calculates the users grade / percentage based on how many answers they got correct
			function getGrade($user_answers,$correct_answers){
				$correct = 0;
				$total = 0;
				for($i = 0; $i < count($correct_answers); $i++){
					if($correct_answers[$i] == $user_answers[$i]){
						$correct = $correct + 1;
						$total = $total + 1;
					}else{
						$total = $total + 1;
					}
				}
			
			$final_total = (($correct / $total) * 100);
			
			return $final_total;
			
			}
			
			$final_total = getGrade($user_answers,$correct_arr);
			
			// creates a function that generates the different colors for the user's grade.
			// n > 80 = green
			// 60 < n < 80 = yellow
			// 50 < n < 60 = red
			// n < 50 = black
			function generateColors($final_total){
				if($final_total > 50){
					if($final_total > 80){
						echo "<h1 class='score great'>Final Total: " . $final_total . "</h1:>";
					}else if($final_total > 60){
						echo "<h1 class='score good'>Final Total: " . $final_total . "</h1:>";
					}else{
						echo "<h1 class='score okay'>Final Total: " . $final_total . "</h1:>";
					}
				}else{
					echo "<h1 class='score bad'>Final Total: " . $final_total . "</h1:>";
				}
			}
		?>

		<p><a href="index.php">Return to previous page</a></p>
		<p>Last Modified: 
		<?php 
			// adds the filename as an easy to read variable.
			$filename = 'index.php';
			
			// echos back the date of when the file was last modified.
			echo date ("F d Y H:i:s.", filemtime($filename)); 
		?>
		</p>
		<?php
			// calls the generateColors function to determine which color the footer should be
			generateColors($final_total);
		?>
	</body>
</html>