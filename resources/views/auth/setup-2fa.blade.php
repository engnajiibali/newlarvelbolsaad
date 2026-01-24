<h3>Scan this QR code in Google Authenticator</h3>
<div>{!! $QR !!}</div>
<p>Secret: <strong>{{ $secret }}</strong></p>
<form method="POST" action="{{ url('/setup-2fa') }}">
    @csrf
    <input type="hidden" name="secret" value="{{ $secret }}">
    <button type="submit">Enable 2FA</button>
</form>
