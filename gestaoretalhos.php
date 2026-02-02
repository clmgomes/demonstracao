<?php
/**
 * SISTEMA DE RETALHOS - VERSÃO DEMONSTRAÇÃO (ESTÁTICA)
 * Esta versão utiliza dados em memória para exibição em portfólio.
 */

// --- MOCK DE DADOS (Simulando o que viria do Banco de Dados) ---
$dados_estaticos = [
    ['id' => 1, 'referencia' => 'B BOX 00842', 'item_codigo' => '10255', 'descricao_material' => 'ACRILICO CRISTAL 4MM', 'largura' => 500, 'comprimento' => 300, 'valor_estimado' => 45.50, 'status' => 'disponivel'],
    ['id' => 2, 'referencia' => 'B BOX 00843', 'item_codigo' => '10255', 'descricao_material' => 'ACRILICO CRISTAL 4MM', 'largura' => 250, 'comprimento' => 250, 'valor_estimado' => 18.90, 'status' => 'disponivel'],
    ['id' => 3, 'referencia' => 'PALLET 992', 'item_codigo' => '20400', 'descricao_material' => 'ACM BRANCO BRILHO 3MM', 'largura' => 1200, 'comprimento' => 400, 'valor_estimado' => 112.00, 'status' => 'disponivel'],
    ['id' => 4, 'referencia' => 'REF 771', 'item_codigo' => '30500', 'descricao_material' => 'POLICARBONATO ALVEOLAR 6MM', 'largura' => 800, 'comprimento' => 600, 'valor_estimado' => 89.30, 'status' => 'disponivel'],
    ['id' => 5, 'referencia' => 'SOBRA 001', 'item_codigo' => '10255', 'descricao_material' => 'ACRILICO CRISTAL 4MM', 'largura' => 100, 'comprimento' => 100, 'valor_estimado' => 5.00, 'status' => 'disponivel'],
];

// Cálculo de Totais para os Cards
$total_itens = count($dados_estaticos);
$valor_total_estoque = array_sum(array_column($dados_estaticos, 'valor_estimado'));

// Simulação de ações (Apenas para não dar erro 404 ao clicar)
if ($_SERVER['REQUEST_METHOD'] == 'POST' || isset($_GET['sucesso'])) {
    $msg_demo = "Nota: Esta é uma versão de demonstração. As alterações não são salvas no banco de dados.";
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Retalhos - Demonstração Online</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        :root { --bg-page: #f0f2f5; --primary-teal: #00a9b5; --primary-green: #007d84; --primary-orange: #f39c12; --text-dark: #2c3e50; }
        body { background-color: var(--bg-page); color: var(--text-dark); font-family: 'Segoe UI', sans-serif; }
        .card-stat { border: none; border-radius: 4px; color: white; padding: 15px; margin-bottom: 20px; box-shadow: 0 2px 4px rgba(0,0,0,0.05); }
        .card-main { background: white; border: none; border-radius: 4px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); }
        .table thead th { background-color: var(--primary-green); color: white; font-size: 0.75rem; text-transform: uppercase; border: none; }
        .table tbody td { border-bottom: 1px solid #f0f0f0; vertical-align: middle; font-size: 0.85rem; }
        .medida-valor { color: var(--primary-teal); font-weight: 700; font-size: 1rem; }
        .area-tag { background: #e8f6f7; color: var(--primary-green); padding: 2px 8px; border-radius: 10px; font-size: 0.75rem; font-weight: bold; }
        .valor-tag { background: #fff3e0; color: #e67e22; padding: 2px 8px; border-radius: 10px; font-size: 0.75rem; font-weight: bold; }
        .select2-container--default .select2-selection--single { border: 1px solid #ced4da !important; height: 40px !important; padding-top: 5px; }
        .subtotal-area { font-size: 0.8rem; opacity: 0.9; border-top: 1px solid rgba(255,255,255,0.2); margin-top: 5px; padding-top: 5px; }
        .demo-badge { background: #e74c3c; color: white; padding: 2px 10px; border-radius: 20px; font-size: 0.6rem; vertical-align: middle; margin-left: 10px; }
    </style>
</head>
<body class="p-4">

<div class="container-fluid">
    <div class="alert alert-info alert-dismissible fade show" role="alert">
        🚀 <b>Modo de Demonstração:</b> Este site é um modelo estático. Funcionalidades de gravação estão desabilitadas.
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>

    <div class="row">
        <div class="col-md-3">
            <div class="card-stat" style="background-color: var(--primary-green);">
                <small>Itens em Estoque</small>
                <h3><?= $total_itens ?></h3>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card-stat" style="background-color: var(--primary-teal);">
                <small>Valor Total em Estoque</small>
                <h3 id="valorTotalGeral">R$ <?= number_format($valor_total_estoque, 2, ',', '.') ?></h3>
                <div class="subtotal-area" id="areaSubtotal" style="display:none;">
                    Subtotal Filtrado: <b id="valorSubtotal">R$ 0,00</b>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card card-stat" style="background-color: #fff; color: #333; border: 1px solid #ddd;">
                <form onsubmit="alert('Simulação de importação concluída!'); return false;">
                    <small class="text-muted fw-bold">IMPORTAÇÃO EM MASSA</small>
                    <button type="submit" class="btn btn-sm btn-outline-dark w-100 mt-2 fw-bold">IMPORTAR SHELISTA.CSV</button>
                </form>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card-stat" style="background-color: #2c3e50;">
                <small>Referência Sistema</small>
                <h3>DEMO 2.2 <span class="demo-badge">G-PAGES</span></h3>
            </div>
        </div>
    </div>

    <div class="row mt-2">
        <div class="col-md-4">
            <div class="card card-main">
                <div class="card-body p-4">
                    <h6 class="mb-4 fw-bold text-muted text-uppercase">Cadastro Manual</h6>
                    <form onsubmit="alert('Item simulado com sucesso!'); return false;">
                        <div class="mb-3">
                            <label class="small fw-bold">Referência</label>
                            <input type="text" name="referencia" class="form-control" placeholder="Ex: B BOX 00842" required>
                        </div>
                        <div class="mb-3">
                            <label class="small fw-bold">Material (ERP)</label>
                            <select id="busca_erp_demo" class="form-control" required></select>
                        </div>
                        <div class="row g-2 mb-3">
                            <div class="col-6">
                                <label class="small fw-bold">Largura (mm)</label>
                                <input type="number" step="0.01" class="form-control" required>
                            </div>
                            <div class="col-6">
                                <label class="small fw-bold">Comprimento (mm)</label>
                                <input type="number" step="0.01" class="form-control" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="small fw-bold text-danger">Quantidade</label>
                            <input type="number" class="form-control" value="1" min="1" max="10">
                        </div>
                        <button type="submit" class="btn w-100 mt-2 py-2 text-white fw-bold" style="background: var(--primary-teal); border:none;">SALVAR NO ESTOQUE</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card card-main">
                <div class="card-body">
                    <div class="row g-2 mb-3 align-items-center">
                        <div class="col-md-3">
                            <span class="fw-bold text-muted">INVENTÁRIO ATIVO</span>
                        </div>
                        <div class="col-md-5">
                            <input type="text" id="filtroTexto" class="form-control form-control-sm shadow-sm" placeholder="Ex: ACRILICO 4MM (vários termos)">
                        </div>
                        <div class="col-md-4">
                            <input type="text" id="filtroMedida" class="form-control form-control-sm shadow-sm" placeholder="Filtrar por Medida (ex: 500)...">
                        </div>
                    </div>
                    
                    <div class="table-responsive" style="max-height: 65vh;">
                        <table class="table table-hover" id="tabelaRetalhos">
                            <thead>
                                <tr>
                                    <th>Referência</th>
                                    <th>Material / ERP</th>
                                    <th class="text-center">Dimensões</th>
                                    <th class="text-center">Valor Estimado</th>
                                    <th class="text-center">Ação</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($dados_estaticos as $r): 
                                    $area = ($r['largura'] * $r['comprimento']) / 1000000;
                                ?>
                                    <tr class="linha-retalho">
                                        <td class='fw-bold td-ref' style='color: var(--primary-green)'><?=$r['referencia']?></td>
                                        <td class="td-material">
                                            <small class='text-muted'><?=$r['item_codigo']?></small><br>
                                            <span class='fw-semibold'><?=$r['descricao_material']?></span>
                                        </td>
                                        <td class='text-center' data-dimensao="<?= (int)$r['largura'] . " " . (int)$r['comprimento'] ?>">
                                            <span class='medida-valor'><?=(int)$r['largura']?> x <?=(int)$r['comprimento']?></span><br>
                                            <span class='area-tag'><?=number_format($area, 3, ',', '.')?> m²</span>
                                        </td>
                                        <td class='text-center'>
                                            <span class='valor-tag td-valor' data-valor-num="<?=$r['valor_estimado']?>">
                                                R$ <?=number_format($r['valor_estimado'], 2, ',', '.')?>
                                            </span>
                                        </td>
                                        <td class='text-center'>
                                            <button onclick="confirm('Dar baixa?') ? alert('Baixa realizada!') : null" class='btn btn-light btn-sm border text-danger fw-bold'>BAIXA</button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
$(document).ready(function() {
    // Dados para simular o Select2 do ERP
    const materiaisDemo = [
        { id: '10255', text: '10255 # ACRILICO CRISTAL 4MM', preco: 150.00 },
        { id: '20400', text: '20400 # ACM BRANCO BRILHO 3MM', preco: 85.00 },
        { id: '30500', text: '30500 # POLICARBONATO ALVEOLAR 6MM', preco: 110.00 }
    ];

    $('#busca_erp_demo').select2({
        data: materiaisDemo,
        placeholder: 'Pesquisar material (Ex: Acrilico)...'
    });

    // FUNÇÃO DE FILTRO INTELIGENTE (Mantida conforme original)
    function recalcularSubtotal() {
        var inputTxt = $("#filtroTexto").val().toLowerCase().trim();
        var termosBusca = inputTxt === "" ? [] : inputTxt.split(/\s+/);
        var med = $("#filtroMedida").val().toLowerCase().trim();
        var soma = 0;

        $(".linha-retalho").each(function() {
            var rowText = $(this).text().toLowerCase();
            var rowMedida = $(this).find('td[data-dimensao]').attr('data-dimensao');
            var valorItem = parseFloat($(this).find('.td-valor').attr('data-valor-num')) || 0;
            
            var matchTexto = true;
            for (var i = 0; i < termosBusca.length; i++) {
                if (rowText.indexOf(termosBusca[i]) === -1) {
                    matchTexto = false;
                    break;
                }
            }

            var matchMedida = med === "" || rowMedida.indexOf(med) > -1;

            if (matchTexto && matchMedida) {
                $(this).show();
                soma += valorItem;
            } else {
                $(this).hide();
            }
        });

        if (inputTxt !== "" || med !== "") {
            $("#areaSubtotal").fadeIn();
            $("#valorSubtotal").text("R$ " + soma.toLocaleString('pt-BR', {minimumFractionDigits: 2, maximumFractionDigits: 2}));
        } else {
            $("#areaSubtotal").fadeOut();
        }
    }

    $("#filtroTexto, #filtroMedida").on("keyup", function() {
        recalcularSubtotal();
    });
});
</script>
</body>
</html>