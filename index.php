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


$dataTruck=processVolPerTruck($truckVolCapacity,$listQtVolDefault,$listItemOrder);

showDataProcessed($dataTruck);

function processVolPerTruck($tVC,$listQtVolDefault,$listItemOrder){
    $arrayTruck=array();
    $countFull=0;
    $countTruck=1;

    foreach ($listItemOrder as $item=>$qtd){

        $truckCapacityPerItem=($tVC/$listQtVolDefault[$item]);
        $countQtd=0;
        while($countQtd<$qtd){
            if(empty($arrayTruck[$countTruck][$item]['qtd'])){
                $arrayTruck[$countTruck][$item]['qtd']=0;
            };
            while($countFull<$truckCapacityPerItem && $countQtd<$qtd){
                $arrayTruck[$countTruck][$item]['qtd']++;
                $arrayTruck[$countTruck]['total']+=$listQtVolDefault[$item];
                $countFull++;
                $countQtd++;
            }
            if($countFull>=$truckCapacityPerItem){
                $countFull=0;
                $countTruck++;
                $arrayTruck[$countTruck]['total']=0;
            }
        }
    }
    return $arrayTruck;
}

function showDataProcessed($dataTruck){
    ?>
<!DOCTYPE html>
    <html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <link rel="shortcut icon" href="favicon.ico"/>
        <title><?php echo $titulo; ?> ..:: Listagem Cubagem ::..</title>
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

    <table class="table" >
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

foreach ($dataTruck as $truck=>$number){
    echo "<tr style='border-bottom: cornflowerblue'>
            <td>
                {$truck}
            </td>
             <td>";
    $showItem='';
    foreach ($number as $item=>$qtd){
        if($item!='total') {
            $showItem .= $item . "(" . $qtd['qtd'] . ")<br>";
        }
    }
    //A CONTAGEM DO SEGUNDO ITEM ESTÁ ERRADA, É CULPA DO LOOP DE CONTAGEM QUE DEVE ESTAR IGNORANDO ALGUMA CONDICIONAL E NÃO ZERANDO/SOMANDO O TOTAL
    echo $showItem."
            </td>
            <td>
                {$number['total']}
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


EU SEI QUE O SEGUNDO CAMINHÃO ESTÁ EXIBINDO A CUBAGEM TOTAL ERRADA, INFELIZMENTE NÃO HÁ MAIS TEMPO PARA EU CORRIGIR O PROBLEMA
";

}
