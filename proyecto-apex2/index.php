<?php
// Capturamos el estado de autenticación enviado por capturador.php
$status = $_GET['status'] ?? '';
$isAuthenticated = ($status === 'success_authenticated');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>APEX ENERGY - Terminal de Control SCADA</title>
    <style>
        :root {
            --bg-main: #0b0f17;
            --bg-card: #111622;
            --bg-input: #171e2e;
            --accent-green: #00ffaa;
            --accent-red: #ff5e7e;
            --text-primary: #ffffff;
            --text-secondary: #7e8b9b;
            --border-color: #1e2638;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: var(--bg-main);
            color: var(--text-primary);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Barra de Navegación Superior Solicitada */
        header {
            background-color: var(--bg-card);
            border-bottom: 2px solid var(--border-color);
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        header h1 {
            font-size: 1.2rem;
            letter-spacing: 2px;
            font-weight: 800;
        }

        header h1 span {
            color: var(--accent-green);
        }

        .header-tag {
            color: var(--text-secondary);
            font-size: 0.85rem;
            font-weight: 600;
            letter-spacing: 1px;
        }

        /* Contenedor Principal en formato Grid */
        main {
            flex: 1;
            display: grid;
            grid-template-columns: 1.3fr 1fr;
            gap: 25px;
            padding: 30px;
            max-width: 1400px;
            margin: 0 auto;
            width: 100%;
        }

        @media (max-width: 900px) {
            main {
                grid-template-columns: 1fr;
            }
        }

        /* Paneles del Contenedor */
        .panel-card {
            background-color: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 6px;
            padding: 25px;
            display: flex;
            flex-direction: column;
        }

        .panel-card h2 {
            font-size: 1.3rem;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .panel-card p {
            color: var(--text-secondary);
            font-size: 0.85rem;
            margin-bottom: 20px;
        }

        /* Bloques de Consola / Terminal */
        .log-section {
            margin-bottom: 15px;
        }

        .log-section label {
            display: block;
            color: var(--text-secondary);
            font-size: 0.8rem;
            font-weight: 600;
            margin-bottom: 6px;
            text-transform: uppercase;
        }

        .terminal {
            background-color: #05070b;
            border: 1px solid var(--border-color);
            border-radius: 4px;
            padding: 12px;
            font-family: 'Courier New', Courier, monospace;
            font-size: 0.85rem;
            color: #00ff66;
            line-height: 1.5;
            height: 110px;
            overflow-y: auto;
        }

        .sockets-box {
            background-color: rgba(0, 0, 0, 0.2);
            border: 1px solid var(--border-color);
            border-radius: 4px;
            padding: 15px;
            margin-top: auto;
        }

        .sockets-box h3 {
            font-size: 0.8rem;
            color: var(--text-secondary);
            margin-bottom: 8px;
            text-transform: uppercase;
        }

        .sockets-box .terminal-netstat {
            font-family: 'Courier New', Courier, monospace;
            color: var(--accent-red);
            font-size: 0.85rem;
            white-space: pre-wrap;
        }

        /* --- INTERFAZ DERECHA: FORMULARIO DE ACCESO --- */
        .auth-panel {
            justify-content: center;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            color: var(--text-secondary);
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
            margin-bottom: 8px;
        }

        .form-group input {
            width: 100%;
            background-color: var(--bg-input);
            border: 1px solid var(--border-color);
            border-radius: 4px;
            padding: 12px 15px;
            color: var(--text-primary);
            font-size: 0.95rem;
            outline: none;
            transition: border-color 0.2s;
        }

        .form-group input:focus {
            border-color: var(--accent-green);
        }

        .btn-submit {
            width: 100%;
            background-color: var(--bg-input);
            border: 1px solid var(--border-color);
            color: var(--text-primary);
            padding: 14px;
            font-size: 0.95rem;
            font-weight: 600;
            border-radius: 4px;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-submit:hover {
            border-color: var(--accent-green);
            color: var(--accent-green);
            background-color: rgba(0, 255, 170, 0.05);
        }

        .alert-error {
            background-color: rgba(255, 94, 126, 0.1);
            border: 1px solid var(--accent-red);
            color: var(--accent-red);
            padding: 12px;
            border-radius: 4px;
            font-size: 0.85rem;
            margin-bottom: 20px;
            text-align: center;
            font-weight: 600;
        }

        /* --- INTERFAZ DERECHA: ESTADO COMPROMETIDO --- */
        .compromised-panel {
            border: 2px dashed var(--accent-green);
            background-color: rgba(0, 255, 170, 0.02);
            border-radius: 6px;
            padding: 30px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
        }

        .status-badge {
            font-size: 1.4rem;
            color: var(--accent-green);
            font-weight: 700;
            letter-spacing: 1px;
            margin-bottom: 8px;
        }

        .status-sub {
            font-family: 'Courier New', Courier, monospace;
            color: var(--accent-green);
            font-size: 0.8rem;
            font-weight: bold;
            letter-spacing: 1px;
            margin-bottom: 20px;
        }

        .compromised-panel p {
            color: var(--text-secondary);
            font-size: 0.9rem;
            line-height: 1.5;
            margin-bottom: 30px;
            max-width: 320px;
        }

        .btn-danger {
            width: 100%;
            background-color: var(--accent-red);
            border: none;
            color: #000000;
            padding: 15px;
            font-size: 0.9rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.2s;
            margin-bottom: 20px;
        }

        .btn-danger:hover {
            background-color: #ff3b60;
        }

        .btn-logout {
            color: var(--accent-red);
            text-decoration: none;
            font-size: 0.85rem;
            font-family: monospace;
            transition: opacity 0.2s;
        }

        .btn-logout:hover {
            opacity: 0.8;
        }
    </style>
</head>
<body>

    <header>
        <h1>APEX<span>ENERGY</span></h1>
        <div class="header-tag">TRANSFORMADOR PRINCIPAL // NODO DE ALTA TENSIÓN</div>
    </header>

    <main>
        <div class="panel-card">
            <h2>Trazas de Auditoría Perimetral</h2>
            <p>Consumo en tiempo real de registros e inteligencia perimetral del sistema.</p>
            
            <div class="log-section">
                <label>Huella Sherlock (Admin):</label>
                <div class="terminal">
                    <?= file_exists('resultado_sherlock.txt') ? nl2br(htmlspecialchars(file_get_contents('resultado_sherlock.txt'))) : "Esperando ejecución de Sherlock..." ?>
                </div>
            </div>
            
            <div class="log-section">
                <label>Huella Holehe (Operador):</label>
                <div class="terminal">
                    <?= file_exists('resultado_holehe.txt') ? nl2br(htmlspecialchars(file_get_contents('resultado_holehe.txt'))) : "Esperando ejecución de Holehe..." ?>
                </div>
            </div>
            
            <div class="sockets-box">
                <h3>Netstat SCADA (Sockets Activos):</h3>
                <div class="terminal-netstat"><?= file_exists('resultado_netstat.txt') ? nl2br(htmlspecialchars(file_get_contents('resultado_netstat.txt'))) : "Esperando ejecución de Netstat..." ?></div>
            </div>
        </div>

        <?php if (!$isAuthenticated): ?>
            <div class="panel-card auth-panel">
                <h2 style="margin-bottom: 5px;">Autenticación de Operadores SCADA</h2>
                <p style="margin-bottom: 25px;">Ingrese los vectores perimetrales para sincronizar el nodo.</p>

                <?php if ($status === 'error_credentials'): ?>
                    <div class="alert-error">
                        ❌ ACCESO DENEGADO.
                    </div>
                <?php endif; ?>

                <form action="capturador.php" method="POST">
                    <div class="form-group">
                        <label>ID de Operador (Email)</label>
                        <input type="text" name="usuario_apex" placeholder="operador@apexenergy.com" required autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label>Código de Acceso SCADA</label>
                        <input type="password" name="password_apex" placeholder="••••••••" required>
                    </div>
                    <button type="submit" class="btn-submit">Autenticar Nodo Eléctrico</button>
                </form>
            </div>

        <?php else: ?>
            <div class="compromised-panel">
                <div class="status-badge">🔓 NODO COMPROMETIDO</div>
                <div class="status-sub">[BYPASS LÓGICO MEDIANTE SQL INJECTION]</div>
                <p>Acceso concedido al panel del Transformador Principal de Alta Tensión sin credenciales legítimas.</p>
                
                <button class="btn-danger" onclick="alert('Simulación: Forzando parada de emergencia...')">
                    FORZAR PARADA DE EMERGENCIA
                </button>
                
                <a href="index.php" class="btn-logout">
                    [ 🔏 Cerrar Sesión Segura ]
                </a>
            </div>
        <?php endif; ?>
    </main>

</body>
</html>
