# Quizzer.io

Creator: Eric Mahoney

Date: October 2018

About: Uses PHP to parse text files and display questions and answers. Calculates and returns percentage based on performance.

## Built With: **PHP**

## About:


**index.php**: Generates the questions and answers from the two text files, answers.txt and questions.txt, in an HTML form. Sends the answers to submitted.php to be graded and displayed.

**submitted.php**: Compares the two text files to determine how many questions the user answered correctly. Generates a percentage and displays a color-coordinated footer.

**questions.txt**: Questions csv text file.

- Format: (question),(chapter_number),(correct_answer).

**answers.txt**: Answers csv text file. 

- Format: (question_number),(answer_choice_one),(answer_choice_two).
