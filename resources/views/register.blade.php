<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
    <h2>Register</h2>
    <form method="POST" action="/signup">
    @csrf
        <div class="mb-3">
            <label>Full Name:</label>
            <input type="text" name="fullName" required class="form-control">
        </div>
        <div class="mb-3">
            <label>Phone No.:</label>
            <input type="text" name="phone" required class="form-control">
        </div>
        <div class="mb-3">
            <label>Username:</label>
            <input type="text" name="username" required class="form-control">
        </div>
        <div class="mb-3">
            <label>Password:</label>
            <input type="password" name="password" required class="form-control">
        </div>
         <button type="submit" class="btn btn-primary">Register</button>
        <a href="/login" class="btn btn-link">Login</a>
    </form>
</body>
</html>
