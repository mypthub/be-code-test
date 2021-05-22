<html>
<body>
	<p>
		Hello {{ $name?? "" }},<br><br>
			The organisation <b>{{ $organization_name?? "" }}</b> is successfully registered. <br>

			Trial Ends on : {{ $trial_end?? "" }} <br><br>

			Thanks and Regards,<br>
			Clubwise.

	</p>
</body>

</html>