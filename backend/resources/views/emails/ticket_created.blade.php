<!DOCTYPE html>
<html>
<body style="margin:0; background:#f3f4f6; font-family:Arial;">

<table width="100%" style="padding:40px 0;">
<tr>
<td align="center">

<table width="600" style="background:white; border-radius:10px; overflow:hidden;">

<!-- HEADER -->
<tr>
<td style="background:#10b981; padding:20px; text-align:center;">
<h1 style="color:white; margin:0;"> Ticket Created</h1>
</td>
</tr>

<!-- BODY -->
<tr>
<td style="padding:30px; color:#374151;">

<h2>Hello {{ $ticket->user->name }} </h2>

<p>Your ticket has been successfully created.</p>

<!-- TICKET BOX -->
<div style="background:#f9fafb; padding:15px; border-radius:6px; margin:20px 0;">

<p><strong>#{{ $ticket->ticket_number }}</strong></p>

<p><strong>Title:</strong> {{ $ticket->title }}</p>

<p><strong>Status:</strong> {{ $ticket->status }}</p>

</div>

<!-- CTA -->
<div style="text-align:center; margin:25px 0;">
<a href="http://localhost:5173/app/tickets/{{ $ticket->id }}"
style="background:#10b981;color:white;padding:12px 20px;border-radius:6px;text-decoration:none;">
View Ticket
</a>
</div>

<p style="font-size:13px; color:#6b7280;">
Our team will get back to you as soon as possible.
</p>

</td>
</tr>

<!-- FOOTER -->
<tr>
<td style="background:#f9fafb; padding:15px; text-align:center; font-size:12px; color:#9ca3af;">
Ticket System © {{ date('Y') }}
</td>
</tr>

</table>

</td>
</tr>
</table>

</body>
</html>