<?php

class MailerController extends AbstractController{
    public function get($request){
        // the get is going to actually send an email so that we can redirect afterwards
        $sGuid = "";
        if(count($request->url_elements) > 1){
			$sGuid = $request->url_elements[1];
		}
        $sth = Database::open()->prepare("SELECT * FROM accounts WHERE guid = ?");
		$sth->execute(array($sGuid));
		$oUser = $sth->fetch(PDO::FETCH_OBJ);
        // then we actually need to send the email

        // Identify the sender, recipient, mail subject, and body
        $oCreds = json_decode(file_get_contents('../creds/sendgrid.json'));
        $sender    = $oCreds->from;
        $recipient = $oUser->recipient;
        $subject   = $request->parameters["subject"];
        $sReplyTo = $request->parameters["email"];
        $sBody      = "Message from " . $sReplyTo . "\n" . $request->parameters["message"];

        // Identify the mail server, username, password, and port
        $url   = "https://api.sendgrid.com/api/mail.send.json";
        $username = $oCreds->api_user;
        $password = $oCreds->api_key;

        // Set up the mail headers
        $fields = array(
                "from"    => $sender,
                "to"      => $recipient,
                "subject" => $subject,
                "text" => $sBody,
                "replyto" => $sReplyTo,
                "api_user" => $username,
                "api_key" => $password
        );

        //open connection
        $ch = curl_init();

        //set the url, number of POST vars, POST data
        curl_setopt($ch,CURLOPT_URL, $url);
        curl_setopt($ch,CURLOPT_POST, count($fields));
        curl_setopt($ch,CURLOPT_POST, count($fields));
        curl_setopt($ch,CURLOPT_POSTFIELDS, http_build_query($fields));
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        //execute post
        $oResult = json_decode(curl_exec($ch));

        //close connection
        curl_close($ch);


        if ($oResult->message != "success") {
            $sResults = $oResult->message;
            if($oUser->failure != ''){
                $sReferer = dirname($_SERVER['HTTP_REFERER']);
                header("Location: " . $sReferer . '/' . $oUser->failure);
            }

        }
        else {
            $sResults = "thank-you for your inquiry";
            if($oUser->success != ''){
                $sReferer = dirname($_SERVER['HTTP_REFERER']);
                header("Location: " . $sReferer . '/' . $oUser->success);
            }
        }
        $rc = new stdClass();
        $rc->result = $sResults;
        return($rc);
    }
}
