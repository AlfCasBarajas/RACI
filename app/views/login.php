<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login RACI</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        body {
            min-height: 100vh;
            background: linear-gradient(120deg, #3949ab 60%, #1976d2 100%);
            font-family: 'Inter', sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-container {
            max-width: 400px;
            width: 100%;
            padding: 32px 28px;
            background: rgba(255,255,255,0.85);
            border-radius: 18px;
            box-shadow: 0 8px 32px #3949ab44;
            backdrop-filter: blur(6px);
        }
        .login-title {
            font-weight: 700;
            color: #3949ab;
            letter-spacing: 1px;
        }
        .login-icon {
            font-size: 2.5rem;
            color: #1976d2;
            margin-bottom: 8px;
        }
        .btn-login {
            background: linear-gradient(90deg,#3949ab 60%,#1976d2 100%);
            color: #fff;
            font-weight: 600;
            border-radius: 2rem;
            box-shadow: 0 2px 8px #3949ab55;
            transition: box-shadow 0.2s, background 0.2s;
        }
        .btn-login:hover {
            background: linear-gradient(90deg,#1976d2 60%,#3949ab 100%);
            box-shadow: 0 4px 16px #3949ab88;
            color: #fff;
        }
        .form-label {
            font-weight: 600;
            color: #3949ab;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="text-center">
            <i class="bi bi-shield-lock login-icon"></i>
            <h2 class="login-title mb-3">Iniciar Sesión</h2>
        </div>
        <?php if(isset($error)) { echo '<div class="alert alert-danger mb-3">'.$error.'</div>'; } ?>
        <form method="POST" action="?url=LoginController/login">
            <div class="mb-3">
                <label for="username" class="form-label">Usuario</label>
                <input type="text" class="form-control" id="username" name="username" required autofocus>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Contraseña</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-login w-100 py-2 mt-2">Ingresar</button>
        </form>
    </div>
</body>
</html>
