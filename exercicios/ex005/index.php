<?php
$v1 = $p1 = $v2 = $p2 = null;
$media_simples = $media_ponderada = null;
$calculou = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $v1 = isset($_POST['v1']) ? (float) $_POST['v1'] : 0;
    $p1 = isset($_POST['p1']) ? (float) $_POST['p1'] : 1;
    $v2 = isset($_POST['v2']) ? (float) $_POST['v2'] : 0;
    $p2 = isset($_POST['p2']) ? (float) $_POST['p2'] : 1;

    $media_simples = ($v1 + $v2) / 2;

    $soma_pesos = $p1 + $p2;
    $media_ponderada = ($soma_pesos != 0) ? ($v1 * $p1 + $v2 * $p2) / $soma_pesos : 0;

    $calculou = true;
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Médias Aritméticas</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <div class="card-form">
        <h1>Médias Aritméticas</h1>

        <form method="POST" action="">

            <div class="form-group">
                <label for="v1">1º Valor</label>
                <input type="number" id="v1" name="v1" step="any"
                    value="<?= htmlspecialchars($v1 ?? '') ?>">
            </div>

            <div class="form-group">
                <label for="p1">1º Peso</label>
                <input type="number" id="p1" name="p1" step="any" min="0"
                    value="<?= htmlspecialchars($p1 ?? '') ?>">
            </div>

            <div class="form-group">
                <label for="v2">2º Valor</label>
                <input type="number" id="v2" name="v2" step="any"
                    value="<?= htmlspecialchars($v2 ?? '') ?>">
            </div>

            <div class="form-group">
                <label for="p2">2º Peso</label>
                <input type="number" id="p2" name="p2" step="any" min="0"
                    value="<?= htmlspecialchars($p2 ?? '') ?>">
            </div>

            <button type="submit" class="btn-calcular">Calcular Médias</button>

        </form>
    </div>

    <?php if ($calculou): ?>
    <div class="card-resultado">
        <h2>Cálculo das Médias</h2>
        <p>Analisando os valores <?= $v1 ?> e <?= $v2 ?>:</p>
        <ul>
            <li>A <strong>Média Aritmética Simples</strong> entre os valores é igual a <?= number_format($media_simples, 2, ',', '.') ?>.</li>
            <li>A <strong>Média Aritmética Ponderada</strong> com pesos <?= $p1 ?> e <?= $p2 ?> é igual a
                <?= number_format($media_ponderada, 2, ',', '.') ?>.</li>
        </ul>
    </div>
    <?php endif; ?>

</body>
</html>