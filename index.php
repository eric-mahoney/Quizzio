<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
	<head>
		<title>Online Quiz</title>
		<link rel="stylesheet" href="style.css">
	</head>
	<body>
		<h1>Online Quiz</h1>
		<?php

			// reading the questions from the questions.txt file
			$q_file = 'questions.txt';
			$questions = fopen($q_file,'r'); //opens the file
			$number_arr = array(); //stores the number of the question in an array
			$questions_arr = array(); //stores the questions in an array
			$chapter_arr = array(); //stores the chapter the question comes from in an array
			flock($questions, LOCK_EX); //locks the file using an exclusive lock

			// opens the files to obtain the answers and defines arrays for answers and correct answers
			$a_file = 'answers.txt';
			$answers = fopen($a_file, 'r');
			$answer_arr = array();
			$correct_arr = array();
			flock($answers, LOCK_EX); //locks the file using an exclusive lock

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
			<!-- echos out questions and answers from the arrays defined above -->
		<p><?php echo $number_arr[$i] . " " . $questions_arr[$i] . " " . $chapter_arr[$i]; ?></p>
		<form method="post" action="submitted.php">
			<input type="radio" value="<?php echo $answer1_arr[$i]; ?>" name="<?php echo $i; ?>"><?php echo $answer1_arr[$i]; ?>
			<input type="radio" value="<?php echo $answer2_arr[$i];  ?>" name="<?php echo $i; ?>"><?php echo $answer2_arr[$i]; ?>
		<?php 
			}
			// unlocks and closes the questions file
			flock($questions, LOCK_UN);
			fclose($questions);
		?>
		<input type="submit">
		</form>
		<p>Last Modified: <?php 
			// adds the filename as an easy to read variable.
			$filename = 'index.php';
			
			// echos back the date of when the file was last modified.
			echo date ("F d Y H:i:s.", filemtime($filename)); ?>
		</p>

	</body>
</html>