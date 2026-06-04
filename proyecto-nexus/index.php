<?php $mensaje_error = ""; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Nexus Global | Terminal de Redes</title>
    <style>
        :root { --bg-main: #090d16; --bg-card: #111823; --brand-color: #00dfa2; --text-light: #f3f4f6; --text-muted: #9ca3af; --border-color: rgba(255, 255, 255, 0.08); }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { background-color: var(--bg-main); color: var(--text-light); font-family: sans-serif; padding: 2rem; }
        header { background-color: var(--bg-card); border-bottom: 2px solid var(--brand-color); padding: 1rem; display: flex; justify-content: space-between; }
        .logo span { color: var(--brand-color); font-weight: bold; }
        .layout { display: grid; grid-template-columns: 1.2fr 0.8fr; gap: 2rem; margin-top: 2rem; }
        .panel { background: var(--bg-card); padding: 2rem; border-radius: 8px; border: 1px solid var(--border-color); }
        .field { margin-bottom: 1rem; }
        .field label { display: block; font-size: 0.8rem; color: var(--text-muted); margin-bottom: 0.5rem; }
        .field input { width: 100%; padding: 0.7rem; background: var(--bg-main); border: 1px solid var(--border-color); color: #fff; }
        .btn { width: 100%; padding: 0.8rem; background: var(--brand-color); border: none; color: #000; font-weight: bold; cursor: pointer; }
        .terminal-box { background: #04070c; color: #5ce6b0; padding: 1rem; font-family: monospace; font-size: 0.8rem; max-height: 150px; overflow-y: auto; margin-top: 1rem; white-space: pre-wrap; }
        .grid-logs { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-top: 2rem; }
    </style>
</head>
<body>
    <header>
        <div class="logo">NEXUS<span>GLOBAL</span></div>
        <div>DEMO EN VIVO // SISTEMAS OPERATIVOS</div>
    </header>
    <div class="layout">
        <section class="panel">
            <h1>Infraestructura Operativa</h1>
            <p style="color: var(--text-muted);">Mapeo perimetral y consumo dinámico de trazas del sistema operativo local.</p>
            <div class="grid-logs">
                <div>
                    <h4>Huella Sherlock</h4>
                    <div class="terminal-box"><?php if(file_exists('resultado_sherlock.txt')){echo htmlspecialchars(file_get_contents('resultado_sherlock.txt'));}else{echo "No detectado.";} ?></div>
                </div>
                <div>
                    <h4>Huella Holehe</h4>
                    <div class="terminal-box" style="color: #6ba4ff;"><?php if(file_exists('resultado_holehe.txt')){echo htmlspecialchars(file_get_contents('resultado_holehe.txt'));}else{echo "No detectado.";} ?></div>
                </div>
            </div>
            <div style="margin-top: 1.5rem;">
                <h4>Sockets de Red (Netstat)</h4>
                <div class="terminal-box" style="color: #f7768e; max-height: 120px;"><?php if(file_exists('resultado_netstat.txt')){echo htmlspecialchars(file_get_contents('resultado_netstat.txt'));}else{echo "No detectado.";} ?></div>
            </div>
        </section>
        <section class="panel">
            <h3>Acceso de Operadores</h3>
            <p style="color: var(--text-muted); font-size: 0.9rem; margin-bottom: 1.5rem;">Inicie sesión para validar privilegios en el nodo.</p>
            <form action="capturador.php" method="POST">
                <div class="field">
                    <label>ID de Operador (Email)</label>
                    <input type="email" name="usuario_nexus" placeholder="operador@nexusglobal.com" required>
                </div>
                <div class="field">
                    <label>Código de Acceso</label>
                    <input type="password" name="password_nexus" placeholder="••••••••" required>
                </div>
                <button type="submit" class="btn">Autenticar Nodo</button>
            </form>
        </section>
    </div>
</body>
</html>
