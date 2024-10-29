<?php
session_start();
require 'db.php';
if(isset($_SESSION['Email']))
{
    header('location: admin.php');
    exit();
}
if($_SERVER['REQUEST_METHOD']==='POST')
{
    $username=trim($_POST['email']);
    $password=trim($_POST['pswd']);
    $stmt=$conn->prepare('SELECT*FROM accounts WHERE Email=:email');
        $stmt->bindValue(':email',$username);
        $stmt->execute();
        $kq=$stmt->fetch();
setcookie('email',$username,time()+(86400*7));
setcookie('pswd',$password,time()+(86400*7));
if($kq && $password == $kq['Password'])
{
    $_SESSION['Email']=$username;
    header('location: admin.php');
   
    exit();
} else {
   
   echo" <script>alert('Tên đăng nhập hoặc mật khẩu không đúng, vui lòng nhập lại')</script>";
}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <style>
        .login-container {
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .card {
            width: 400px;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="card">
            <div class="card-body">
                <h1 class="text-center mb-4">Login Admin</h1>
                <form action="login.php" method="post">
                    <div class="form-group">
                        <label for="txtEmail">Email:</label>
                        <input type="email" class="form-control" id="txtEmail" placeholder="Enter your email" name="email" value="<?php echo htmlspecialchars($_COOKIE['email'] ?? ''); ?>">
                    </div>
                    <div class="form-group">
                        <label for="txtMK">Password:</label>
                        <input type="password" class="form-control" id="txtMK" placeholder="Enter your password" name="pswd">
                    </div>
                    <div class="form-group form-check">
                        <input class="form-check-input" type="checkbox" id="chkRemember" name="remember" <?php if (isset($_COOKIE['email'])) echo 'checked'; ?>>
                        <label class="form-check-label" for="chkRemember"> Remember me</label>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Login</button>
                    <?php if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['pswd']) && !isset($_SESSION['Email'])): ?>
                        <div class="alert alert-danger mt-3" role="alert">
                            Tên đăng nhập hoặc mật khẩu không đúng, vui lòng nhập lại.
                        </div>
                    <?php endif; ?>
                </form>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>
