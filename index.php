<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge,chrome=1">
    <title>test</title>
</head>

<body>
    <form action="index.php" method="post" enctype="multipart/form-data">
        <label for="file">Filename:</label>
        <input type="file" name="file" id="file" />
        <label for="text">text:</label>
        <input type="text" name="text" id="text" />
        <input type="submit" name="submit" value="Submit" />
    </form>
</body>

</html>

<?php
	require('./src/md5.php');
	
	echo '<br>';

	if($_FILES['file']['name']){
		if ($_FILES['file']['error']) {
			echo 'Error Code: ' . $_FILES['file']['error'] . '<br />';
		} else {
			foreach ($_FILES['file'] as $key => $value) {
				echo $key . ':' . $_FILES['file'][$key] . '<br>';
			}
			if (file_exists('tmp/' . $_FILES['file']['name'])) {
				echo 'Error Code: -1';
			}
			else {
				move_uploaded_file($_FILES['file']['tmp_name'], 'tmp/' . $_FILES['file']['name']);
				echo 'Stored in: ' . 'tmp/' . $_FILES['file']['name'];
			}
		}
		echo '<br>';
		$md5encrypt = new Md5Encrypt();
		$md5encrypt->savetemps($_FILES['file']['name']);
		echo $_FILES['file']['name'];
		$md5encrypt->AddPaddingBits();
		$md5encrypt->AddLength();
		$md5encrypt->Merge();
		$md5encrypt->Calc();
		echo md5_file('tmp/' . $_FILES['file']['name']) . '<br>';
		unset($md5encrypt);
	} else if($_POST){
		echo $_POST['text'];
		$txt = $_POST['text'];
		$file = fopen('tmp/temp.txt', 'w');
		fwrite($file, $txt);
		fclose($file);
		echo '<br>';
		$md5encrypt = new Md5Encrypt();
		$md5encrypt->savetemps('temp.txt');
		$md5encrypt->AddPaddingBits();
		$md5encrypt->AddLength();
		$md5encrypt->Merge();
		$md5encrypt->Calc();
		echo md5_file('tmp/temp.txt') . '<br>';
		unset($md5encrypt);
	} else {
		echo 'Error Code: 4';
	}

?>