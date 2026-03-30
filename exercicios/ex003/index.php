<?php
// ─── LÓGICA DE PROCESSAMENTO ───────────────────────────────────────────────
$dividendo = '';
$divisor   = '';
$quociente = 0;
$resto     = 0;
$analisou  = false;
$erro      = '';

// Inicialização das variáveis — antes de qualquer coisa, criamos todas as variáveis com valores "vazios/padrão". Isso evita erros caso a página seja aberta pela primeira vez sem nenhum dado enviado.

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //$_SERVER['REQUEST_METHOD'] é uma variável global do PHP que informa como a página foi acessada.Então essa linha diz: "só execute o bloco abaixo SE o usuário enviou o formulário".

    $dividendo = trim($_POST['dividendo'] ?? '');
    $divisor   = trim($_POST['divisor']   ?? '');
    //$_POST['dividendo'] → pega o valor digitado no campo com name="dividendo"
    //?? → operador "null coalescing": se $_POST['dividendo'] não existir, usa '' (string vazia) no lugar
    //trim() → remove espaços em branco do início e fim (ex: " 25 " vira "25")

    if (!is_numeric($dividendo) || !is_numeric($divisor)) {
        $erro = 'Por favor, insira apenas números inteiros.';
    //is_numeric() → verifica se o valor é um número
    //! → negação (NOT): "se NÃO for numérico"
    //|| → operador OU: se qualquer um dos dois não for número, entra no erro

    } elseif ((int)$divisor === 0) {
        $erro = 'O divisor não pode ser zero!';
    //Divisão por zero é matematicamente impossível, então verificamos isso separadamente. (int)$divisor converte para inteiro antes de comparar.

    } else {
        $dividendo = (int) $dividendo;
        $divisor   = (int) $divisor;
        $quociente = intdiv($dividendo, $divisor); // parte inteira
        $resto     = $dividendo % $divisor;        // resto
        $analisou  = true;
    }
}


?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Anatomia de uma Divisão</title>
  <style>
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    body {
      min-height: 100vh;
      background-color: #4b3a7c;
      display: flex;
      flex-direction: column;
      align-items: center;
      padding: 40px 16px 60px;
      font-family: Arial, sans-serif;
    }

    /* ── TÍTULO ── */
    h1 {
      font-size: 2rem;
      font-weight: bold;
      color: #1a1a2e;
      text-align: center;
      margin-bottom: 24px;
    }

    /* ── CARD FORMULÁRIO ── */
    .card-form {
      background: #ffffff;
      border-radius: 12px;
      padding: 28px 24px;
      width: 100%;
      max-width: 460px;
      margin-bottom: 24px;
    }

    /* Campo com label estilo "badge" */
    .campo {
      background: #e8e4f0;
      border-radius: 8px;
      padding: 12px 14px;
      margin-bottom: 16px;
    }

    .campo label {
      display: inline-block;
      background: #ffffff;
      border: 1px solid #ccc;
      border-radius: 4px;
      padding: 2px 10px;
      font-size: 0.82rem;
      color: #333;
      margin-bottom: 8px;
    }

    .campo input[type="number"] {
      display: block;
      width: 100%;
      background: #ffffff;
      border: 1px solid #d0cce0;
      border-radius: 6px;
      padding: 12px 14px;
      font-size: 1rem;
      color: #222;
      outline: none;
      -moz-appearance: textfield;
    }
    .campo input[type="number"]::-webkit-inner-spin-button { display: none; }
    .campo input[type="number"] {
      appearance: textfield;
      -moz-appearance: textfield;
    }
    .campo input[type="number"]:focus {
      border-color: #7c5cbf;
    }

    /* ── ERRO ── */
    .erro {
      background: #fde8e8;
      border: 1px solid #f5a0a0;
      border-radius: 6px;
      padding: 10px 14px;
      color: #c0392b;
      font-size: 0.85rem;
      margin-bottom: 14px;
    }

    /* ── BOTÃO ANALISAR ── */
    button[type="submit"] {
      display: block;
      width: 100%;
      padding: 14px;
      background: #4caf50;
      color: #ffffff;
      border: none;
      border-radius: 6px;
      font-size: 1rem;
      font-weight: bold;
      cursor: pointer;
      letter-spacing: 0.03em;
      transition: background 0.2s;
    }
    button[type="submit"]:hover  { background: #43a047; }
    button[type="submit"]:active { background: #388e3c; }

    /* ── CARD RESULTADO ── */
    .card-resultado {
      background: #ffffff;
      border-radius: 12px;
      padding: 28px 24px;
      width: 100%;
      max-width: 460px;
    }

    .card-resultado h2 {
      font-size: 1.3rem;
      font-weight: bold;
      color: #5b3fa0;
      margin-bottom: 28px;
    }

    /* ── GRADE DA DIVISÃO ── */
    .grade-wrapper {
      display: flex;
      justify-content: center;
    }

    .grade {
      display: grid;
      grid-template-columns: 1fr 1fr;
      grid-template-rows: auto auto;
      width: 260px;
    }

    .celula {
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 28px 20px;
      font-size: 2.6rem;
      color: #1a1a2e;
    }

    /* Linha vertical entre as duas colunas */
    .celula.divisor,
    .celula.quociente {
      border-left: 2px solid #555;
    }

    /* Linha horizontal só no lado direito (abaixo do divisor) */
    .celula.quociente {
      border-top: 2px solid #555;
    }

    /* Resto com underline igual à imagem */
    .celula.resto {
      text-decoration: underline;
      text-underline-offset: 6px;
    }
  </style>
</head>
<body>

  <!-- TÍTULO -->
  <h1>Anatomia de uma Divisão</h1>

  <!-- FORMULÁRIO -->
  <div class="card-form">
    <form method="POST" action="">

      <?php if ($erro): ?>
        <div class="erro"><?= htmlspecialchars($erro) ?></div>
      <?php endif; ?>

      <div class="campo">
        <label for="dividendo">Dividendo</label>
        <input
          type="number"
          id="dividendo"
          name="dividendo"
          placeholder="Ex: 25"
          value="<?= htmlspecialchars((string)$dividendo) ?>"
          required
        >
      </div>

      <div class="campo">
        <label for="divisor">Divisor</label>
        <input
          type="number"
          id="divisor"
          name="divisor"
          placeholder="Ex: 4"
          value="<?= htmlspecialchars((string)$divisor) ?>"
          required
        >
      </div>

      <button type="submit">Analisar</button>
    </form>
  </div>

  <!-- RESULTADO -->
  <?php if ($analisou): ?>
    <div class="card-resultado">
      <h2>Estrutura da Divisão</h2>

      <div class="grade-wrapper">
        <div class="grade">

          <!-- Topo-esquerda: Dividendo -->
          <div class="celula dividendo">
            <?= $dividendo ?>
          </div>

          <!-- Topo-direita: Divisor -->
          <div class="celula divisor">
            <?= $divisor ?>
          </div>

          <!-- Baixo-esquerda: Resto (com underline) -->
          <div class="celula resto">
            <?= $resto ?>
          </div>

          <!-- Baixo-direita: Quociente -->
          <div class="celula quociente">
            <?= $quociente ?>
          </div>

        </div>
      </div>
    </div>
  <?php endif; ?>

</body>
</html>