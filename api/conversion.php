<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Currency</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <main>
        <h1>Currency Converter</h1>
        <?php
        //Exchange rate from the Central Bank API
        $beginning = date("m-d-Y", strtotime("-7 days"));
        $end = date("m-d-Y");
        $url = 'https://olinda.bcb.gov.br/olinda/servico/PTAX/versao/v1/odata/CotacaoDolarPeriodo(dataInicial=@dataInicial,dataFinalCotacao=@dataFinalCotacao)?@dataInicial=\'' . $beginning . '\'&@dataFinalCotacao=\'' . $end . '\'&$top=1&$orderby=dataHoraCotacao%20desc&$format=json&$select=cotacaoCompra,dataHoraCotacao';

        $data = json_decode((file_get_contents($url)), true);

        $quotation = $data["value"][0]["cotacaoCompra"];

        //Howmuch do you have?"
        $real = $_REQUEST["din"] ?? 0;

        //Equivalence in dollars
        $dolar = $real / $quotation;

        $pattern = numfmt_create("pt_BR", NumberFormatter::CURRENCY);

        //NumberFormat
        echo " <p>Your " . numfmt_format_currency($pattern, $real, "BRL") . " are equivalent to " . numfmt_format_currency($pattern, $dolar, "USD") . "</p>";
        ?>
        <button onclick="javascript:history.go(-1)">back</button>
    </main>
</body>

</html>