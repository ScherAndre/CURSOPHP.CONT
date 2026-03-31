<?php

$notas = [100, 50, 10, 5];
$resultado = [];
$valor = null;
$erro = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $valor = intval($_POST['valor'] ?? 0);

    if ($valor <= 0) {
        $erro = "Por favor, informe um valor válido maior que zero.";
    } elseif ($valor % 5 !== 0) {
        $erro = "O valor deve ser múltiplo de R$5 (notas disponíveis: R$100, R$50, R$10 e R$5).";
    } else {
        $restante = $valor;
        foreach ($notas as $nota) {
            $quantidade = intdiv($restante, $nota);
            $resultado[$nota] = $quantidade;
            $restante -= $quantidade * $nota;
        }

        if ($restante !== 0) {
            $erro = "Não foi possível realizar o saque com as notas disponíveis.";
            $resultado = [];
        }
    }
}

$coresNotas = [
    100 => ['cor' => '#4a90d9', 'label' => '100'],
    50  => ['cor' => '#e8a020', 'label' => '50'],
    10  => ['cor' => '#c0392b', 'label' => '10'],
    5   => ['cor' => '#8e44ad', 'label' => '5'],
];


?>
</xai:function_call >

<xai:function_call name="edit_file">
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Caixa Eletrônico</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .nota-visual {
            width: 90px;
            height: 45px;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 1rem;
            color: #fff;
            text-shadow: 0 1px 2px rgba(0,0,0,0.4);
            box-shadow: 0 2px 8px rgba(0,0,0,0.2);
            flex-shrink: 0;
        }
    </style>
</head>

<body>
    <div class="card">
        <h1>Caixa Eletrônico</h1>

        <form method="POST" action="">
            <label for="valor">Qual valor você deseja sacar? (R$) <sup>*</sup></label>
            <input
                type="number"
                id="valor"
                name="valor"
                min="5"
                step="5"
                value="<?= htmlspecialchars($_POST['valor'] ?? '') ?>"
                required
            >
            <p class="notas-info">*Notas disponíveis: R$100, R$50, R$10 e R$5</p>

            <?php if ($erro): ?>
                <p style="color:red; margin-bottom:12px; font-size:0.9rem;"><?= htmlspecialchars($erro) ?></p>
            <?php endif; ?>

            <button type="submit" class="btn-sacar">Sacar</button>
        </form>
    </div>
    <?php if (!empty($resultado) && $valor > 0 && !$erro): ?>
    <div class="resultado">
        <h2>Saque de R$<?= number_format($valor, 2, ',', '.') ?> realizado</h2>
        <p>O caixa eletrônico vai te entregar as seguintes notas:</p>
        <ul>
            <?php foreach ($notas as $nota):
                $qtd = $resultado[$nota];
            ?>
            <li>
                <div class="nota-visual" style="background-color: <?= $coresNotas[$nota]['cor'] ?>;">
                    R$ <?= $nota ?>
                </div>
                <span class="qtd">x<?= $qtd ?></span>
            </li>

            <?php endforeach; ?>
        </ul>
    </div>
    <?php endif; ?>

</body>
</html>