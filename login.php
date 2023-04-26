<!DOCTYPE html>
<html>

<head>
    <title>Iniciar Sesión</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
        body {
            background-color: #5086c1;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 400px;
            margin: 100px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0px 0px 10px 0px #cfcfcf;
        }

        h2 {
            margin-top: 0;
            text-align: center;
            color: #333;
        }

        input[type=text],
        input[type=password] {
            width: 100%;
            padding: 12px 20px;
            margin: 8px 0;
            display: inline-block;
            border: 1px solid #ccc;
            font-size: 15px;
            border-radius: 4px;
            box-sizing: border-box;
            margin-bottom: 20px;
        }

        button {
            background-color: #42ab49;
            color: white; 
            font-size: 15px;
            padding: 14px 20px;
            margin: 8px 0;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
        }

        button:hover {
            background-color: #45a049;
        }

        .cancelbtn {
            width: auto;
            padding: 10px 18px;
            background-color: #f44336;
        }

        .imgcontainer {
            text-align: center;
            margin: 24px 0 12px 0;
            position: relative;
        }

        img.avatar {
            width: 100px;
            border-radius: 50%;
        }

        .container form {
            border: none;
        }

        .container label {
            color: black;
            font-size: 17px;
            margin-bottom: 10px;
            display: block;
        }

        .container span.psw {
            float: right;
            padding-top: 16px;
        }

        /* Change styles for span and cancel button on extra small screens */
        @media screen and (max-width: 300px) {
            span.psw {
                display: block;
                float: none;
            }

            .cancelbtn {
                width: 100%;
            }
        }
    </style>
</head>

<body>

    <div class="container">
        <h2>Iniciar Sesión</h2>
        <form method="post" action="/dwp_2023_pf_bmanuel/auth/Auth.php"> 
            <div class="imgcontainer">
                <img src="./frontend/images//login.png" alt="Avatar" class="avatar">
            </div>
            <label for="uname"><i class='bx bxs-user' ></i> <b>Usuario</b></label>
            <input type="text" placeholder="Ingrese Nombre de Usuario" name="user" required >

            <label for="psw"><i class='bx bxs-key' ></i> <b>Contraseña</b></label>
            <input type="password" placeholder="Ingrese Contraseña" name="password" required>
            <button type="submit">Iniciar Sesión</button>
        </form>

</body>

</html>
