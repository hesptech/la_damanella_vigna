<?php 
	if($_POST) {

		$to = "postmaster@ladamanellavigna-monteriggioni.it"; // Your email here
		$subject = 'Message from my website'; // Subject message here

	}

	//Send mail function
	function send_mail($to,$subject,$message,$headers){
		if(@mail($to,$subject,$message,$headers)){
			echo json_encode(array('info' => 'success', 'msg' => "Il vostro messaggio è stato inviato. Grazie!"));
		} else {
			echo json_encode(array('info' => 'error', 'msg' => "Errore, il tuo messaggio non è stato inviato"));
		}
	}

	//Check if $_POST vars are set
	if(!isset($_POST['name']) || !isset($_POST['mail']) || !isset($_POST['comment'])){
		echo json_encode(array('info' => 'error', 'msg' => 'Si prega di compilare tutti i campi'));
	}

	//Sanitize input data, remove all illegal characters	
	$name    = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
	$mail    = filter_var($_POST['mail'], FILTER_SANITIZE_EMAIL);
	$subject = filter_var($_POST['subject'], FILTER_SANITIZE_STRING);
	$comment = filter_var($_POST['comment'], FILTER_SANITIZE_STRING);

	//Validation
	if($name == '') {
		echo json_encode(array('info' => 'error', 'msg' => "Per favore inserisci il tuo nome."));
		exit();
	}
	if(!filter_var($mail, FILTER_VALIDATE_EMAIL)){
		echo json_encode(array('info' => 'error', 'msg' => "Per favore inserisci un'email valida."));
		exit();
	}
	if($comment == ''){
		echo json_encode(array('info' => 'error', 'msg' => "Inserisci il tuo messaggio."));
		exit();
	}

	//Send Mail
	$headers = 'From: ' . $mail .''. "\r\n".
	'Reply-To: '.$mail.'' . "\r\n" .
	'X-Mailer: PHP/' . phpversion();

	send_mail($to, $subject, $comment . "\r\n\n"  .'Name: '.$name. "\r\n" .'Email: '.$mail, $headers);
?>