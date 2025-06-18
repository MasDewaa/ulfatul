<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-image: linear-gradient(to bottom, #4CAF50, #2E8B57); 
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            align-items: center;
            min-height: 100vh;
        }
        main {
            background-color: rgba(255, 255, 255, 0.9);
            padding: 50px;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            flex-grow: 1;
            margin-bottom: 20px; 
        }
        h1 {
            color: #333;
            font-size: 36px;
            margin-bottom: 20px;
        }
        p {
            color: #555;
            font-size: 18px;
            line-height: 1.6;
            margin-bottom: 30px;
        }
        footer {
            background-color: rgba(255, 255, 255, 0.9);
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 100%;
            margin-top: auto; 
            border-top: 2px solid #ccc; 
        }
        footer p {
            margin: 0;
        }
        
        .center-column {
            text-align: center;
        }
       
        a {
            font-weight: bold;
            color: #333; 
            text-decoration: none; 
            transition: color 0.3s; 
        }
        a:hover {
            color: #2E8B57; 
        }
    </style>
</head>
<body>
    <header>
        <h1>Monitoring JPL Website</h1>
    </header>
    
    <main>
        <div class="center-column">
            <img src="/DeteksiPerlintasan/img/ppi.png" alt="PPI Logo" class="img-fluid" style="width: 150px; height: auto;"/>
            <img src="/DeteksiPerlintasan/img/KAI.png" alt="KAI Logo" class="img-fluid"style="width: 150px; height: auto;"/> 
            <h1>Selamat Datang!</h1>
            <p>Halo,Ini merupakan halaman index website monitoring JPL</p>
            <p>
                <a href="index.php">Home</a> |
                <a href="register.php">Register</a> |
                <a href="login.php">Login</a>
            </p>
        </div>
    </main>

    <footer>
    <hr />
        &copy;<i>dibuat oleh @Ulfatul_Rahmad</i>
    </footer>
</body>
</html>
