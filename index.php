<?php
require './vendor/autoload.php';
/**
 * Configurações da importação
 */
$nomeArquivo = 'import';
$camposHeader = ['<b>NOME</b>', '<b>SOBRENOME</b>', '<b>criado em</b>'];
$fontSize = 8;

/**
 * Config of DB
 */
$host = 'localhost';
$dbname = 'mysql_xlsx';
$user = 'root';
$pass = '123456';
$tabela = 'clientes';
$camposQuery = ['nome', 'sobrenome', 'created_at'];
$sortBy = 'nome';
$orderBy = 'desc';
/**
 * Adicione atributos extras na sua query, exemplo LIMIT 10, WHERE E AFINS
 */
$extraQuery = 'LIMIT 10';

/**
 * Valida se a quantidade de campos da busca é a mesma que a do header;
 */
$countTotalCampos = count($camposQuery);
if ($countTotalCampos != count($camposHeader)) {
	echo 'A quantidade de campos precisa ser a mesma que a do header';
	return;
}
/**
 * Cria a queryString
 */
$selectString = '';
foreach ($camposQuery as $key => $value) {
	if ($countTotalCampos != $key + 1) {

		$selectString = $selectString . $value . ', ';
	} else {
		$selectString = $selectString . $value . ' ';
	}
}
$queryString = 'SELECT ' . $selectString . ' FROM ' . $tabela . ' ORDER BY ' . $sortBy . ' ' . $orderBy . ' ' . $extraQuery;

/**
 * Faz a conexão e trás os dados
 */
$pdo = new PDO('mysql:host=' . $host . ';dbname=' . $dbname, $user, $pass);
$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
$stmt = $pdo->prepare($queryString);
$stmt->execute();
$rows = $stmt->fetchAll();
$pdo = null;

/**
 * Cria o array que gera o Excell
 */
$table = [$camposHeader];
foreach ($rows as $key => $value) {

	array_push($table, $value);
};
/**
 * Gera o arquivo e libera o download
 */
$xlsx = Shuchkin\SimpleXLSXGen::fromArray($table)
	->setDefaultFont('Courier New')
	->setDefaultFontSize($fontSize)
	->setColWidth(1, 50);
try {
	$xlsx->downloadAs($nomeArquivo . '.xlsx');
	echo "<pre>";
	echo '<bold>xlsx gerado e salvo faça o downloas</bold>';
} catch (Error $error) {
	echo "<pre>";
	echo '<bold>Não foi possível gerar o Excel</bold>/n';
	echo '----------------------------------------/n';
	echo $error->getMessage();
}
