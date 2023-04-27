<?php

//EDSON DA SILVA RICOBOM 26/04/2023

error_reporting(0);
//variáveis bem descritas para facilitar leitura
$truckVolCapacity = 50;

$listQtVolDefault = array();//tabela da database ou informação prévia de conhecimento da empresa
$listQtVolDefault['PAPEL HIG'] = 0.1;
$listQtVolDefault['DETERGENTE'] = 0.025;
$listQtVolDefault['LUVA'] = 0.0125;


$listItemOrder = array();//lista recebida de pedidos
$listItemOrder['PAPEL HIG'] = 741;
$listItemOrder['DETERGENTE'] = 890;
$listItemOrder['LUVA'] = 6000;


$dataTruck = processVolPerTruck($truckVolCapacity, $listQtVolDefault, $listItemOrder);

showDataProcessed($dataTruck);

function processVolPerTruck($tVC, $listQtVolDefault, $listItemOrder)
{
    $arrayTruck = array();
    $countFull = 0;
    $countTruck = 1;
    $nextTruck = 0;
    $total = 0;
    $arrayTruck[$countTruck]['empty'] = $tVC;

    foreach ($listItemOrder as $item => $qtd) {
        $countQtd = 0;
        while ($countQtd < $qtd) {
            if (!isset($arrayTruck[$countTruck][$item]['qtd'])) {
                $arrayTruck[$countTruck][$item]['qtd'] = 0;
                $arrayTruck[$countTruck][$item]['total'] = 0;
            };
            if ($total >= $tVC || ($total + $listQtVolDefault[$item]) > $tVC) {
                $nextTruck = 1;
            } else {
                $arrayTruck[$countTruck][$item]['qtd']++;
                $arrayTruck[$countTruck][$item]['total'] += $listQtVolDefault[$item];
                $arrayTruck[$countTruck]['empty'] -=$listQtVolDefault[$item];
                $total += $listQtVolDefault[$item];
                $countFull++;
                $countQtd++;
            }
            if ($nextTruck) {
                $nextTruck = 0;
                $countFull = 0;
                $countTruck++;
                $total = 0;
                $arrayTruck[$countTruck]['empty'] = $tVC;
            } else if ($countQtd == $qtd) {
                break;
            }
        }
    }

    return $arrayTruck;
}

function showDataProcessed($dataTruck)
{
    global $truckVolCapacity;
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
        <link rel="shortcut icon" href="favicon.ico"/>
        <title> ..:: Listagem Cubagem ::..</title>
    <body>
    <p>
        Cenário
        Cliente entrou em contato e solicitou uma melhoria, existe uma tela que faz a listagem de
        pedidos de venda, ele precisa que seja adicionado um botão para realizar o cálculo
        automático da cubagem de um pedido de venda, esse pedido será transportado em vários
        caminhões, para isso ele vai informar a cubagem necessária (os caminhões possuem o
        mesmo tamanho, 50 m3), o sistema precisa realizar esse cálculo.
    </p>

    <table class="table">
        <thead>
        <tr>
            <td>
                ITEM
            </td>
            <td>
                Total de Caixas
            </td>
            <td>
                Cubagem por Caixa (m3)
            </td>
        </tr>
        </thead>
        <tr>
            <td>
                PAPEL HIGIÊNICO
            </td>
            <td>
                741
            </td>
            <td>
                0,1
            </td>
        </tr>
        <tr>
            <td>
                DETERGENTE
            </td>
            <td>
                890
            </td>
            <td>
                0,025
            </td>
        </tr>
        <tr>
            <td>
                LUVA
            </td>
            <td>
                6000
            </td>
            <td>
                0,0125
            </td>
        </tr>
    </table>
    <br>

    <table class="table">
        <caption>RESULTADO DO PROCESSAMENTO</caption>
        <thead>
        <tr>
            <td>
                N° Caminhão
            </td>
            <td>
                Itens (QUANTIDADE DE CAIXAS)
            </td>
            <td>
                Cubagem Total
            </td>
        </tr>
        </thead>

    <?php

    foreach ($dataTruck as $truck => $number) {
        $total=$truckVolCapacity-$number['empty'];

        echo "<tr style='border-bottom: cornflowerblue'>
            <td>
                {$truck}
            </td>
             <td>";
        $showItem = '';
        foreach ($number as $item => $qtd) {
            if ($item != 'empty') {
                $showItem .= $item . "(" . $qtd['qtd'] . ")<br>";
            }
        }
        echo $showItem . "
            </td>
            <td>
                {$total} m³
            </td>
            </tr>
            <tr></tr>
            <tr></tr>
            <tr></tr>
            <tr></tr>
            <tr></tr>
            
    ";
    }
    echo "
    </table>
</body>
";

}

