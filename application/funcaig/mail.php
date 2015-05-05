<?php

function envoieMail($societe, $nomprenom, $fonction, $nous, $mailclient, $objet, $precontent, $content, $postcontent)
	{
		// en local
		ini_set("SMTP","10.25.103.8");
		//
		
		ini_set('sendmail_from', "$mailclient");
		
		$headers  = "From: ".$societe." - ".$nomprenom." <".$mailclient.">\n";
		$headers .= "MIME-version: 1.0 \r\n";
		$headers .= "Importance: Normal \r\n";
		$headers .= "X-Priority: 2 \r\n";
		$headers .= "Content-type: text/html; charset= iso-8859-1\n";

		$message = "
		<html>
		<head>
			<title></title>
		</head>
			<body>
			<style>
				font-family: Arial, Helvetica, sans-serif;
				font-size: 10px;
			</style>
			<table width='100%' bgcolor='F6F6F6' cellspacing='0' cellpadding='0'>
				<tr>
					<td valign='top' align='center' style='padding:20px 0 20px 0'>
						<table align='center' width='60%' cellspacing='0' cellpadding='10' border='0' bgcolor='FFFFFF' style='border:1px solid #e0e0e0'>
							<tr>
								<td valign='top' align='left' style='padding-bot: 10px'>
									<strong><font color='#5e5e5e' size='4'>$objet</font></strong>
								</td> 
							</tr>
							<tr>
								<td valign='top' align='left'>
									$precontent
								</td>
							</tr>
							<tr>
								<td valign='top' align='left' style='padding: 20px;'>
									<table width='100%' bgcolor='F6F6F6' style='border:1px solid #e0e0e0'>
										<tr>
											<td valign='top' align='left' >
												$content
											</td>
										</tr>
									</table> 
								</td>
							</tr>
							<tr>
								<td valign='top' align='left'>
									$postcontent
								</td>
							</tr>
							<tr>
								<td valign='top' align='left' bgcolor='EAEAEA'>
									<b>Espace client AIG</b> 
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td>
						<center><i>Ce mail est généré automatiquement. Aucune réponse n'est attendue à cette adresse.</i></center>
					</td>
				</tr>
				<tr>
					<td>
						&nbsp;
					</td>
				</tr>
			</table>
			</body>
		</html>
		";
		
		mail($nous, utf8_decode("AIG.fr : ".$objet), utf8_decode($message), utf8_decode($headers));
	}
?>