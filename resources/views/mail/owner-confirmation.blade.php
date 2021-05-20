<html>
<head>
    <meta charset="utf-8"> 
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
</head>

<body style="background:#fff; font-family:Arial, Helvetica, sans-serif; font-size:14px; line-height:25px;">
	<table border="0" cellspacing="0" cellpadding="0"
	style="background:#eaeaea; max-width:760px; width:100%; padding:0px 15px;" align="center">
		<tr>
			<td>
				<table border="0" cellspacing="0" cellpadding="0" align="center"
				style="margin:30px auto; max-width:700px; width:95%">
					<tr>
						<td>
						<table width="100%" border="0" cellspacing="0" cellpadding="0"
						style="padding: 20px 0px 20px; background: #eef7ff;">
							<tr>
								<td style="text-align: center;">
									<strong>Club Wise</strong>
								</td>
							</tr>
						</table>
						</td>
					</tr>
					<tr>
						<td style="background:#fff;">
							<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
							<td style="text-align: justify; padding: 5%">
								<table width="100%" border="0" cellspacing="0" cellpadding="0">
									<table width="100%" border="0" cellspacing="0" cellpadding="0">
							          <tr> Dear {{ $name?? "" }}, <br><br> 
							            <td colspan="2">The organization {{ $organization_name?? "" }} has beed registered successfully.<br/><br/></td>
							          </tr>
								       <tr>
								       	<td colspan="2"><h2>Below are the details</h2></td>
								       </tr>
								       	<tr>
								       		<td width="25%">Organization Name:</td>
								       		<td>{{ $organization_name?? "" }}</td>
								       	</tr>
								       <tr>
								       		<td>Trial End Date:</td>
								       		<td>{{ $trial_end_date?? "" }}</td>
								       	</tr>								       	
							          	<tr><td colspan="2"><br>Regards,<br>
							      			Club Wise Team</td>
							      		</tr>
							      		</table>
								</table>
							</td>
							</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td>
						<table width="100%" border="0" cellspacing="0" cellpadding="0"
						style="padding: 20px 0px 20px; background: #286484;">
							<tr>
								<td colspan="2" style="text-align: center;">
									<p style="font-family:Nimbus Sans L; font-size:14px; color:#ffffff; font-weight:400;text-align: center;">Copyright © {{ now()->year }}. All Rights Reserved.</p>
								</td>
							</tr>
						</table>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
</body>
</html>