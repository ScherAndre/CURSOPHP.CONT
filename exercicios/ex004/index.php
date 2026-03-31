<?php
$salario_minimo = 1650.00;
$resultado = null;
$salario = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['salario'])) {
    $salario = floatval($_POST['salario']);
    
    if ($salario > 0) {
        $qtd_salarios = floor($salario / $salario_minimo);
        $resto = $salario - ($qtd_salarios * $salario_minimo);
        $resultado = [
            'salario'       => $salario,
            'qtd'           => $qtd_salarios,
            'resto'         => $resto,
        ];
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informe seu salário</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background-color: #3b1f6b;
            font-family: Arial, sans-serif;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .card {
            background-color: #ffffff;
            border-radius: 12px;
            padding: 40px 30px;
            width: 100%;
            max-width: 480px;
            margin-bottom: 20px;
        }

        .card h1 {
            font-size: 2rem;
            font-weight: bold;
            color: #1a1a1a;
            margin-bottom: 24px;
            text-align: center;
        }

        .input-group {
            background-color: #eeeaf6;
            border-radius: 8px;
            padding: 16px;
            margin-bottom: 16px;
        }

        .input-group label {
            display: block;
            background-color: #d6cff0;
            color: #444;
            font-size: 0.85rem;
            font-weight: 600;
            padding: 4px 10px;
            border-radius: 20px;
            display: inline-block;
            margin-bottom: 10px;
        }

        .input-group input[type="number"] {
            width: 100%;
            border: 1px solid #ccc;
            border-radius: 6px;
            padding: 10px 14px;
            font-size: 1rem;
            color: #333;
            outline: none;
            transition: border-color 0.2s;
        }

        .input-group input[type="number"]:focus {
            border-color: #7c4dff;
        }

        .salario-minimo-info {
            font-size: 0.9rem;
            color: #555;
            margin-bottom: 20px;
        }

        .salario-minimo-info strong {
            color: #1a1a1a;
        }

        .btn-calcular {
            width: 100%;
            background-color: #4caf50;
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 14px;
            font-size: 1.1rem;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        .btn-calcular:hover {
            background-color: #43a047;
        }

        .resultado-card {
            background-color: #ffffff;
            border-radius: 12px;
            padding: 30px;
            width: 100%;
            max-width: 480px;
        }

        .resultado-card h2 {
            font-size: 1.5rem;
            font-weight: bold;
            color: #7c4dff;
            margin-bottom: 16px;
        }

        .resultado-card p {
            font-size: 1rem;
            color: #333;
            line-height: 1.6;
        }

        .resultado-card p strong {
            font-weight: bold;
        }
    </style>
</head>
<body>

    <div class="card">
        <h1>Informe seu salário</h1>

        <form method="POST" action="">
            <div class="input-group">
                <label for="salario">Salário (R$)</label>
                <input
                    type="number"
                    id="salario"
                    name="salario"
                    step="0.01"
                    min="0"
                    value="<?= htmlspecialchars($salario ?? '') ?>"
                    placeholder="Ex: 5000"
                >
            </div>

            <p class="salario-minimo-info">
                Considerando o salário mínimo de <strong>R$<?= number_format($salario_minimo, 2, ',', '.') ?></strong>
            </p>

            <button type="submit" class="btn-calcular">Calcular</button>
        </form>
    </div>

    <?php if ($resultado !== null): ?>
    <div class="resultado-card">
        <h2>Resultado Final</h2>
        <p>
            Quem recebe um salário de R$<?= number_format($resultado['salario'], 2, ',', '.') ?>
            ganha <strong><?= $resultado['qtd'] ?> salário<?= $resultado['qtd'] !== 1 ? 's' : '' ?> mínimo<?= $resultado['qtd'] !== 1 ? 's' : '' ?></strong>
            <?php if ($resultado['resto'] > 0): ?>
                + R$ <?= number_format($resultado['resto'], 2, ',', '.') ?>
            <?php endif; ?>
            .
        </p>
    </div>
    <?php endif; ?>

</body>
</html>