<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error 403 - Acceso Restringido</title>
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
            position: absolute; bottom: 100px; left: 0; width: 100%; height: 4px; background: #333;
        }

        /* Barrera de seguridad */
        .barrier {
            position: absolute;
            bottom: 100px;
            right: 20%;
            width: 15px;
            height: 120px;
            background: repeating-linear-gradient(45deg, #f1c40f, #f1c40f 10px, #111 10px, #111 20px);
            border: 2px solid #333;
            z-index: 15;
            animation: shake 0.2s 1.2s ease-in-out;
        }

        .car-container {
            position: absolute;
            bottom: 100px;
            left: -400px;
            width: 320px;
            z-index: 10;
            /* Animación: llega rápido y frena en seco */
            animation: drive-and-stop 1.5s cubic-bezier(0.25, 0.46, 0.45, 0.94) forwards;
        }

        @keyframes drive-and-stop {
            0% { left: -400px; }
            80% { left: 45%; transform: translateX(0) scaleX(1); }
            90% { left: 48%; transform: translateX(0) scaleX(0.98); } /* Efecto de compresión por frenazo */
            100% { left: 47%; transform: translateX(0); }
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(5px); }
            75% { transform: translateX(-5px); }
        }

        .smoke {
            position: absolute;
            left: 48%;
            bottom: 105px;
            width: 60px; height: 20px;
            background: rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            filter: blur(15px);
            opacity: 0;
            animation: tire-smoke 1s forwards 1s;
        }

        @keyframes tire-smoke {
            0% { opacity: 0; transform: scale(0.5); }
            30% { opacity: 0.6; }
            100% { opacity: 0; transform: scale(2) translateY(-10px); }
        }

        .text {
            text-align: center;
            margin-top: 20px;
            opacity: 0;
            animation: fadeIn 0.8s forwards 1.5s;
        }

        @keyframes fadeIn { to { opacity: 1; } }

        h1 { font-family: 'Permanent Marker', cursive; font-size: 3.5rem; color: #f1c40f; margin: 0; }
        p { font-size: 1.2rem; }
        .warning { color: #f1c40f; font-weight: bold; }

        a {
            display: inline-block; margin-top: 20px; padding: 10px 25px;
            color: #f1c40f; border: 2px solid #f1c40f; text-decoration: none;
            border-radius: 5px; transition: 0.3s;
        }
        a:hover { background: #f1c40f; color: #111; }
    </style>
</head>
<body>

    <div class="stage">
        <div class="ground"></div>
        <div class="barrier"></div>
        <div class="smoke"></div>

        <div class="car-container">
            <svg viewBox="0 0 350 120" xmlns="http://www.w3.org/2000/svg">
                <ellipse cx="175" cy="110" rx="150" ry="10" fill="rgba(0,0,0,0.3)"/>

                <path d="M15 85 L15 102 Q15 108 22 108 L328 108 Q335 108 335 102 L335 75 L310 45 C290 15, 240 10, 180 10 L70 15 C40 15, 20 45, 15 85" fill="#f39c12" stroke="#000" stroke-width="2"/>

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
        <h1>error 403</h1>
        <p>¡ALTO! <span class="warning">Zona restringida.</span></p>
        <p>No tienes los permisos para pasar por aquí</p>
        <a href="/">Dar la vuelta</a>
    </div>

</body>
</html>