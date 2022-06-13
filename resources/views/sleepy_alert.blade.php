<h3>Alert!! Your Driver is Sleepy </h3>

<div class="text-center">
    <br />
     Driver ID: {{$ID}} <br />
     Driver Name: {{$Name}} <br />
    <br />
    Vehicle No. - {{$Vehicle_No}}
    <br />

    <h3><a href="http://localhost:3000/admin/dashboard">Open Dashboard For Details</a></h3>
</div>

Thanks,<br>
{{ env('MAIL_FROM_NAME') }} 

<br/>
N.B. - This is system generated mail, Please do not reply. @noreply