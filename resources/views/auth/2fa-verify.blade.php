<form method="POST" action="{{ route('2fa.verify') }}">
    @csrf
    <input type="text" name="code" placeholder="Enter 2FA Code" required>
    <button type="submit">Verify</button>
</form>
