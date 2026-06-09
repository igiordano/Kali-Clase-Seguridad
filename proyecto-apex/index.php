<?php 
$status = isset($_GET['status']) ? $_GET['status'] : '';
$msg = ($status === 'error_credentials') ? "❌ ACCESO DENEGADO." : "";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Apex Energy | SCADA</title>
    <style>
        :root { --bg: #090d16; --brand: #00dfa2; --text: #f3f4f6; }
        body { background: var(--bg); color: var(--text); font-family: monospace; padding: 2rem; }
        .grid { display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; }
        .panel { background: #111823; padding: 1.5rem; border: 1px solid #333; }
        .terminal { background: #000; color: #00dfa2; padding: 1rem; height: 100px; overflow-y: auto; margin-top: 0.5rem; }
        input { width: 100%; padding: 0.5rem; margin: 0.5rem 0; background: #000; color: #fff; }
        .btn { width: 100%; padding: 0.8rem; background: var(--brand); border: none; cursor: pointer; }
    </style>
</head>
<body>
   <section class="panel">
    <h3>Trazas de Auditoría Perimetral</h3>
    <p>Huella Sherlock (Admin):</p>
    <div class="terminal">
        <?= file_exists('resultado_sherlock.txt') ? nl2br(htmlspecialchars(file_get_contents('resultado_sherlock.txt'))) : "Esperando ejecución de Sherlock..." ?>
    </div>
    
    <p>Huella Holehe (Operador):</p>
    <div class="terminal">
        <?= file_exists('resultado_holehe.txt') ? nl2br(htmlspecialchars(file_get_contents('resultado_holehe.txt'))) : "Esperando ejecución de Holehe..." ?>
    </div>
    
    <p>Netstat SCADA (Sockets):</p>
    <div class="terminal">
        <?= file_exists('resultado_netstat.txt') ? nl2br(htmlspecialchars(file_get_contents('resultado_netstat.txt'))) : "Esperando ejecución de Netstat..." ?>
    </div>
</section>
        
    <section class="panel">
    <?php 
    // Capturamos el estado que viene desde capturador.php
    $status = isset($_GET['status']) ? $_GET['status'] : '';
    ?>

    <?php if ($status === 'success_authenticated'): ?>
        <div style="border: 2px dashed #00dfa2; background: rgba(0, 223, 162, 0.03); padding: 1.5rem; text-align: center; border-radius: 8px;">
            <h2 style="color: #00dfa2; font-size: 1.4rem; margin-bottom: 1rem;">🔓 NODO COMPROMETIDO</h2>
            <p style="font-family: monospace; color: #00dfa2; font-weight: bold; margin-bottom: 1rem;">[BYPASS LÓGICO MEDIANTE SQL INJECTION]</p>
            <p style="font-size: 0.9rem; margin-bottom: 1.5rem;">Acceso concedido al panel del Transformador Principal de Alta Tensión sin credenciales legítimas.</p>
            
            <button style="background: #f7768e; color: #000; width: 100%; padding: 0.8rem; border: none; font-weight: bold; cursor: pointer; text-transform: uppercase; margin-bottom: 1rem;" 
                    onclick="alert('Simulación: Forzando parada de emergencia...')">
                FORZAR PARADA DE EMERGENCIA
            </button>
            
            <a href="index.php" style="color: #f7768e; text-decoration: none; font-size: 0.85rem; font-family: monospace; display: block; margin-top: 1rem;">
                [ 🔏 Cerrar Sesión Segura ]
            </a>
        </div>
    <?php else: ?>
        <h3>Autenticación de Operadores SCADA</h3>
        <form action="capturador.php" method="POST">
            <div class="field">
                <input type="text" name="usuario_apex" placeholder="operador@apexenergy.com" required>
            </div>
            <div class="field">
                <input type="password" name="password_apex" placeholder="••••••••" required>
            </div>
            <button type="submit" class="btn">Autenticar Nodo Eléctrico</button>
        </form>
    <?php endif; ?>
</section>
    </div>
</body>
</html>
