@extends('emails.layout.layout')
@section('content')

<tr>
	<td style="padding: 20px 30px 30px; font-family: 'Open Sans','Lucida Grande','Segoe UI',Arial,Verdana,'Lucida Sans Unicode',Tahoma,'Sans Serif'; font-size: 11pt; line-height: 27px; color: #444; text-align: left;">
            <p style="margin: 0;">Hello {{$name}},</p>
	</td>
</tr>
<tr>
	<td style="padding: 0 30px 30px; font-family: 'Open Sans','Lucida Grande','Segoe UI',Arial,Verdana,'Lucida Sans Unicode',Tahoma,'Sans Serif'; font-size: 11pt; line-height: 27px; color: #444; text-align: left;">
		<p style="margin: 0;">We have received a request of forgot password. Please find below security code to Reset your password</p>
	</td>
</tr>
<tr>
	<td style="padding: 0 30px 30px; font-family: 'Open Sans','Lucida Grande','Segoe UI',Arial,Verdana,'Lucida Sans Unicode',Tahoma,'Sans Serif'; font-size: 11pt; line-height: 27px; color: #444;">
		<table role="presentation" cellspacing="0" cellpadding="0" border="0" align="center" style="margin: auto;">
			<tr>
				<td style="border-radius: 5px; background: #7367f0; text-align: center; padding: 10px 20px;" class="button-td">					
                    <span style="color:white;" class="button-link">{{ $security_code }}</span>					
				</td>
			</tr>
		</table>
	</td>
</tr>
<tr>
	<td style="padding: 0 30px 30px; font-family: 'Open Sans','Lucida Grande','Segoe UI',Arial,Verdana,'Lucida Sans Unicode',Tahoma,'Sans Serif'; font-size: 11pt; line-height: 27px; color: #444; text-align: left;">
		<p style="margin: 0;">If you believe that this is a mistake and you do not intend to change your password, you can simply ignore this message and nothing else will happen.</p>
	</td>
</tr>
@endsection