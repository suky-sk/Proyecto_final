<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error 404 - ¡Cuidado con el borde!</title>
    <link href="https://fonts.googleapis.com/css2?family=Permanent+Marker&family=Fira+Mono:wght@500&display=swap" rel="stylesheet">
    <style>
        body {
            margin: 0; padding: 0; height: 100vh; background: #111;
            display: flex; flex-direction: column; justify-content: center; align-items: center;
            color: #eee; font-family: 'Fira Mono', monospace; overflow: hidden;
        }

        .stage {
            position: relative; width: 100%; max-width: 900px; height: 400px;
        }

        .ground {
            position: absolute; bottom: 100px; left: 0; width: 60%; height: 4px; background: #333;
        }

        .ground::after {
            content: ''; position: absolute; right: -2px; top: 0;
            width: 4px; height: 20px; background: #333;
        }

        .car-container {
            position: absolute;
            bottom: 100px;
            left: -350px;
            width: 320px;
            z-index: 10;
            animation: drive-and-fall 3s cubic-bezier(0.45, 0.05, 0.55, 0.95) forwards;
        }

        @keyframes drive-and-fall {
            0% { left: -350px; transform: rotate(0deg); }
            40% { left: 50%; transform: rotate(0deg); bottom: 100px; }
            45% { left: 55%; transform: rotate(10deg); bottom: 95px; }
            100% {
                left: 80%;
                bottom: -500px;
                transform: rotate(120deg);
            }
        }

        .smoke {
            position: absolute; left: 50%; bottom: 100px; width: 40px; height: 40px;
            background: rgba(255, 255, 255, 0.2); border-radius: 50%;
            filter: blur(10px); opacity: 0;
            animation: smoke-puff 0.5s forwards 1.2s;
        }

        @keyframes smoke-puff {
            0% { opacity: 0; transform: scale(1); }
            50% { opacity: 0.5; }
            100% { opacity: 0; transform: scale(3) translateY(-20px); }
        }

        .text {
            text-align: center;
            margin-top: 20px;
            opacity: 0;
            animation: fadeIn 0.8s forwards 2.5s;
        }

        @keyframes fadeIn { to { opacity: 1; } }

        h1 { font-family: 'Permanent Marker', cursive; font-size: 3.5rem; color: #ff4444; margin: 0; }
        p { font-size: 1.2rem; }
        a {
            display: inline-block; margin-top: 20px; padding: 10px 25px;
            color: #ff4444; border: 2px solid #ff4444; text-decoration: none;
            border-radius: 5px; transition: 0.3s;
        }
        a:hover { background: #ff4444; color: white; }
    </style>
</head>
<body>

    <div class="stage">
        <div class="ground"></div>
        <div class="smoke"></div>

        <div class="car-container">
            <svg viewBox="0 0 350 120" xmlns="http://www.w3.org/2000/svg">
                <ellipse cx="175" cy="110" rx="150" ry="10" fill="rgba(0,0,0,0.3)"/>

                <path d="M15 85 L15 102 Q15 108 22 108 L328 108 Q335 108 335 102 L335 75 L310 45 C290 15, 240 10, 180 10 L70 15 C40 15, 20 45, 15 85" fill="#e74c3c" stroke="#000" stroke-width="2"/>

                <path d="M75 22 L180 22 L180 58 L55 58 Q65 35, 75 22" fill="#d1eaf7" stroke="#000"/>
                <path d="M190 22 L260 22 L295 58 L190 58 Z" fill="#d1eaf7" stroke="#000"/>

                <line x1="185" y1="22" x2="185" y2="108" stroke="#000" stroke-width="2"/>
                <rect x="315" y="78" width="18" height="10" rx="2" fill="#f1c40f" stroke="#000"/>

                <g>
                    <circle cx="70" cy="105" r="22" fill="#111" stroke="#444" stroke-width="3"/>
                    <circle cx="70" cy="105" r="10" fill="#bdc3c7"/>
                    <circle cx="265" cy="105" r="22" fill="#111" stroke="#444" stroke-width="3"/>
                    <circle cx="265" cy="105" r="10" fill="#bdc3c7"/>
                </g>
            </svg>
        </div>
    </div>

    <div class="text">
        <h1>error 404</h1>
        <p>Esta carretera no existe</p>
        <a href="/">Vuelve al inicio</a>
    </div>

</body>
</html>
