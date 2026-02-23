<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>

<h2>Login Page</h2>

@if ($errors->any())
    <div style="color:red;">
        {{ $errors->first() }}
    </div>
@endif

<form method="POST" action="/login">
  @csrf

  <div>
      <label>No IC:</label>
      <input type="text" name="ic_no" required>
  </div>

  <br>

  <div>
      <label>Password:</label>
      <input type="password" name="password" required>
  </div>

  <br>

  <button type="submit">Login</button>
</form>

</body>
</html>