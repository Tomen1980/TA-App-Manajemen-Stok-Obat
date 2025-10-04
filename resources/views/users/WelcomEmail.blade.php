<!DOCTYPE html>
<html>
<head>
    <title>Welcome</title>
</head>
<body>
    <h1>Welcome, {{ $user->name }}!</h1>
    <p>Your account has been created. Please log in and set your password if needed.</p>
    <p>Email: {{ $user->email }}</p>
    <p>Password: {{ $password }}</p>
</body>
</html>