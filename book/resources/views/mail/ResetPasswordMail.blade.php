@extends('mail.layout')

@section('content')
<tr>
  <td>
    <p>Hi {{ $user->first_name . ' ' . $user->last_name }},</p>
    <p>Kami menerima permintaan anda untuk mengatur ulang sandi, mohon klik link berikut untuk mengatur ulang sandi anda:</p>
    <table role="presentation" border="0" cellpadding="0" cellspacing="0" class="btn btn-primary">
      <tbody>
        <tr>
          <td align="left">
            <table role="presentation" border="0" cellpadding="0" cellspacing="0">
              <tbody>
                <tr>
                  <td> <a href="{{ env('FE_HOST_FORGOT_PASSWORD') . $reference->token }}" target="_blank">Atur sandi</a> </td>
                </tr>
              </tbody>
            </table>
          </td>
        </tr>
      </tbody>
    </table>
    <p>jika link berikut tidak berkerja dengan baik, di mohon untuk klik link dibawah ini:</p>
    <a href="{{ env('FE_HOST_FORGOT_PASSWORD') . $reference->token }}"> Klik link berikut.</a>
  </td>
</tr>
@endsection