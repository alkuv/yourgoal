<?php

/**
 * User defined functions
 */
class MailHelpers
{
	function createGoalMailtoadmin($name,$email,$username)
	{
		$subject = 'Some one Subscription';
		//$body = 'invitation mail from '.CHtml::encode(Yii::app()->name).' <br>You Can Login With <br>website :: '.Yii::app()->params['website'].' <br>username ::'.$email.' <br> Password :: '.$pass.' ';
		$body = 'Hello '.$name.',<br/>
				<br/>
				'.$username.' has been Subcribed your goal<br/>						
				Regards,<br/>
				Yourgoals<br/>
				';
		
		$eol = PHP_EOL;
		$separator = md5(time());
		///////////HEADERS INFORMATION////////////
		// main header (multipart mandatory) message
		$headers = "From: ".CHtml::encode("Yourgoals")." <" . Yii::app()->params['adminEmail'] . ">" . $eol;
		//$headers .= "Bcc: email@domain.com".$eol;
		$headers .= "MIME-Version: 1.0" . $eol;
		$headers .= "Content-Type: multipart/mixed; boundary=\"" . $separator . "\"" . $eol . $eol;
		$headers .= "Content-Transfer-Encoding: 7bit" . $eol;
		$headers .= "This is a MIME encoded message." . $eol . $eol;
		
		// message
		$headers .= "--" . $separator . $eol;
		$headers .= "Content-Type: text/html; charset=\"UTF-8\"" . $eol;
		$headers .= "Content-Transfer-Encoding: 8bit" . $eol . $eol;
		$headers .= $eol . $eol;		
		mail($email,$subject,$body,$headers);
	}
        function createGoalMailtouser($name,$email)
	{
		$subject = 'Successfully Subcribed';
		//$body = 'invitation mail from '.CHtml::encode(Yii::app()->name).' <br>You Can Login With <br>website :: '.Yii::app()->params['website'].' <br>username ::'.$email.' <br> Password :: '.$pass.' ';
		$body = 'Hello '.$name.',<br/>
				<br/>
				Thanks  for  Subcribed the goal<br/>						
				Regards,<br/>
				Yourgoals<br/>
				';
		
		$eol = PHP_EOL;
		$separator = md5(time());
		///////////HEADERS INFORMATION////////////
		// main header (multipart mandatory) message
		$headers = "From: ".CHtml::encode("Yourgoals")." <" . Yii::app()->params['adminEmail'] . ">" . $eol;
		//$headers .= "Bcc: email@domain.com".$eol;
		$headers .= "MIME-Version: 1.0" . $eol;
		$headers .= "Content-Type: multipart/mixed; boundary=\"" . $separator . "\"" . $eol . $eol;
		$headers .= "Content-Transfer-Encoding: 7bit" . $eol;
		$headers .= "This is a MIME encoded message." . $eol . $eol;
		
		// message
		$headers .= "--" . $separator . $eol;
		$headers .= "Content-Type: text/html; charset=\"UTF-8\"" . $eol;
		$headers .= "Content-Transfer-Encoding: 8bit" . $eol . $eol;
		$headers .= $eol . $eol;		
		mail($email,$subject,$body,$headers);
	}
        
         function createGoalcommenttoadmin($name,$email,$addedby,$goalname)
	{
		$subject = 'New Comment added';
		//$body = 'invitation mail from '.CHtml::encode(Yii::app()->name).' <br>You Can Login With <br>website :: '.Yii::app()->params['website'].' <br>username ::'.$email.' <br> Password :: '.$pass.' ';
		$body = 'Hello '.$name.',<br/>
				<br/>
				New Comment added by '.$addedby.' on goal name '.$goalname.'<br/>						
				Regards,<br/>
				Yourgoals<br/>
				';
		
		$eol = PHP_EOL;
		$separator = md5(time());
		///////////HEADERS INFORMATION////////////
		// main header (multipart mandatory) message
		$headers = "From: ".CHtml::encode("Yourgoals")." <" . Yii::app()->params['adminEmail'] . ">" . $eol;
		//$headers .= "Bcc: email@domain.com".$eol;
		$headers .= "MIME-Version: 1.0" . $eol;
		$headers .= "Content-Type: multipart/mixed; boundary=\"" . $separator . "\"" . $eol . $eol;
		$headers .= "Content-Transfer-Encoding: 7bit" . $eol;
		$headers .= "This is a MIME encoded message." . $eol . $eol;
		
		// message
		$headers .= "--" . $separator . $eol;
		$headers .= "Content-Type: text/html; charset=\"UTF-8\"" . $eol;
		$headers .= "Content-Transfer-Encoding: 8bit" . $eol . $eol;
		$headers .= $eol . $eol;		
		mail($email,$subject,$body,$headers);
	}
        
        
        function createGoalcommenttoall($goalname,$email,$addedby,$mainname)
	{
		$subject = 'New Comment added';
		//$body = 'invitation mail from '.CHtml::encode(Yii::app()->name).' <br>You Can Login With <br>website :: '.Yii::app()->params['website'].' <br>username ::'.$email.' <br> Password :: '.$pass.' ';
		$body = 'Hello '.$mainname.',<br/>
				<br/>
				'.$addedby.' make a comment on goal name{ '.$goalname.'}<br/>						
				Regards,<br/>
				Yourgoals<br/>
				';
		
		$eol = PHP_EOL;
		$separator = md5(time());
		///////////HEADERS INFORMATION////////////
		// main header (multipart mandatory) message
		$headers = "From: ".CHtml::encode("Yourgoals")." <" . Yii::app()->params['adminEmail'] . ">" . $eol;
		//$headers .= "Bcc: email@domain.com".$eol;
		$headers .= "MIME-Version: 1.0" . $eol;
		$headers .= "Content-Type: multipart/mixed; boundary=\"" . $separator . "\"" . $eol . $eol;
		$headers .= "Content-Transfer-Encoding: 7bit" . $eol;
		$headers .= "This is a MIME encoded message." . $eol . $eol;
		
		// message
		$headers .= "--" . $separator . $eol;
		$headers .= "Content-Type: text/html; charset=\"UTF-8\"" . $eol;
		$headers .= "Content-Transfer-Encoding: 8bit" . $eol . $eol;
		$headers .= $eol . $eol;		
		mail($email,$subject,$body,$headers);
	}
        function createGoalupdatetoall($goalname,$email,$mainname)
	{
		$subject = 'Goal updated';
		//$body = 'invitation mail from '.CHtml::encode(Yii::app()->name).' <br>You Can Login With <br>website :: '.Yii::app()->params['website'].' <br>username ::'.$email.' <br> Password :: '.$pass.' ';
		$body = 'Hello '.$mainname.',<br/>
				<br/>
				 Goal name {'.$goalname.'} is updated. Please review once<br/>						
				Regards,<br/>
				Yourgoals<br/>
				';
		
		$eol = PHP_EOL;
		$separator = md5(time());
		///////////HEADERS INFORMATION////////////
		// main header (multipart mandatory) message
		$headers = "From: ".CHtml::encode("Yourgoals")." <" . Yii::app()->params['adminEmail'] . ">" . $eol;
		//$headers .= "Bcc: email@domain.com".$eol;
		$headers .= "MIME-Version: 1.0" . $eol;
		$headers .= "Content-Type: multipart/mixed; boundary=\"" . $separator . "\"" . $eol . $eol;
		$headers .= "Content-Transfer-Encoding: 7bit" . $eol;
		$headers .= "This is a MIME encoded message." . $eol . $eol;
		
		// message
		$headers .= "--" . $separator . $eol;
		$headers .= "Content-Type: text/html; charset=\"UTF-8\"" . $eol;
		$headers .= "Content-Transfer-Encoding: 8bit" . $eol . $eol;
		$headers .= $eol . $eol;		
		mail($email,$subject,$body,$headers);
	}
	
}