<h3>Welcome {{ $name }},</h3> 

<div>

    set your password mail.
    <br/>
    <a href="{{ env('FRONTEND_URL') }}/Create_password/{{ $token }}">Create Password</a>
</div>

Thanks,<br>
{{ env('MAIL_FROM_NAME') }}