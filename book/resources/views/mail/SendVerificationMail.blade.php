@extends('mail.layout')

@section('content')
<tr>
  <td>
    <p>Halo {{ $user->first_name . ' ' . $user->last_name }},</p>
    <p>Selamat anda telah terdaftar di ethis.co.id, di mohon klik link dibawah ini untuk melakukan registrasi:</p>
    <table role="presentation" border="0" cellpadding="0" cellspacing="0" class="btn btn-primary">
      <tbody>
        <tr>
          <td align="left">
            <table role="presentation" border="0" cellpadding="0" cellspacing="0">
              <tbody>
                <tr>
                  <td> <a href="{{ env('FE_HOST') . $reference->token }}" target="_blank">Verifikasi e-mail.</a> </td>
                </tr>
              </tbody>
            </table>
          </td>
        </tr>
      </tbody>
    </table>
    <p>jika link berikut tidak berkerja dengan baik, di mohon untuk klik link dibawah ini:</p>
    <a href="{{ env('FE_HOST') . $reference->token }}"> Klik link berikut.</a>
  </td>
</tr>
@endsection