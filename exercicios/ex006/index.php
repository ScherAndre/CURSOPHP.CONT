<?php
$preco = isset($_POST['preco']) ? floatval($_POST['preco']) : 0;
$percentual = isset($_POST['percentual']) ? intval($_POST['percentual']) : 0;
$novo_preco = 0;
$mostrar_resultado = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $preco > 0) {
    $novo_preco = $preco + ($preco * $percentual / 100);
    $mostrar_resultado = true;
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reajustador de Preços</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">

    <!-- Card do Formulário -->
    <div class="card-form">
        <h1>Reajustador de Preços</h1>

        <form method="POST" action="">

            <div class="form-group">
                <label for="preco">Preço do Produto (R$)</label>
                <input
                    type="number"
                    id="preco"
                    name="preco"
                    min="0"
                    step="0.01"
                    value="<?= $preco > 0 ? htmlspecialchars($preco) : '' ?>"
                    placeholder="0"
                >
            </div>

            <div class="form-group">
                <span class="slider-label">
                    Qual será o percentual de reajuste? (<strong id="valor-percentual"><?= $percentual ?>%</strong>)
                </span>
                <input
                    type="range"
                    id="percentual"
                    name="percentual"
                    min="0"
                    max="100"
                    value="<?= $percentual ?>"
                    oninput="document.getElementById('valor-percentual').textContent = this.value + '%'"
                >
            </div>

            <button type="submit" class="btn-reajustar">Reajustar</button>

        </form>
    </div>

    <!-- Card do Resultado -->
    <?php if ($mostrar_resultado): ?>
    <div class="card-result">
        <h2>Resultado do Reajuste</h2>
        <p>
            O produto que custava
            R$<?= number_format($preco, 2, ',', '.') ?>,
            com <strong><?= $percentual ?>% de aumento</strong>
            vai passar a custar
            <strong>R$<?= number_format($novo_preco, 2, ',', '.') ?></strong>
            a partir de agora.
        </p>
    </div>
    <?php endif; ?>

</div>

</body>
</html>