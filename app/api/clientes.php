<?php 
session_start();
include_once('../model/clientes.php');
include_once('../model/funcoes/firewall.php');
$con = condb();

//for handle post action and perform operations 
if(isset($_GET['acao']) && $_GET['acao'] != ''){
    switch ($_GET['acao']) {
        case 'cadastrar'://for like any post
            cadastrar($con, $_GET);
        break;
        case 'buscar':
        	buscar($con, $_GET);
        break;
        case 'buscarDados':
        	buscarDados($con, $_GET);
        break;
        case 'editar':
        	editar($con, $_GET);
        break;
        case 'deletar':
        	deletar($con, $_GET);
        break;
    }
}

function cadastrar($con, $dados){

	$model = new ClientesModel;

	$Firewall = new Firewall(); 
    $Firewall->SecureUris();

	$nome = $Firewall->getClean($dados['nome']);
	$cpf = $Firewall->getClean($dados['cpf']);
	$cep = $Firewall->getClean($dados['cep']);
	$logradouro = $Firewall->getClean($dados['logradouro']);
	$numero = $Firewall->getClean($dados['numero']);
	$bairro = $Firewall->getClean($dados['bairro']);
	$cidade = $Firewall->getClean($dados['cidade']);
	$estado = $Firewall->getClean($dados['estado']);
	$codigo = $Firewall->getClean($dados['codigo']);
	$complemento = $Firewall->getClean($dados['complemento']);
	$contato = $Firewall->getClean($dados['contato']);
	$limiteCredito = $Firewall->getClean($dados['limiteCredito']);
	$validade = $Firewall->getClean($dados['validade']);

	$model->cadastrar($nome, $cpf, $cep, $logradouro, $numero, $bairro, $cidade, $estado, $codigo, $complemento, $contato, $limiteCredito, $validade);

	$res = array();
	if($model->retorno){
        $res['status'] = 200;
    }else{
        $res['status'] = 511;
    }

    echo json_encode($res);
}



function buscar($con){

	$model = new ClientesModel;

	$model->buscar();

	$data = array();
	while($res = mysqli_fetch_object($model->retorno)) {

		$status = '<button type="button" id_user="'.$res->idUsuario.'" nome_user="'.$res->Nome.'" class="btn  btn-danger btndel " data-toggle="tooltip" data-placement="top" title="Inativar"><i class="fas fa-trash-alt"></i></button>';
		$button = '<button type="button" id_user="'.$res->idUsuario.'" class="btn  btn-info btnedit mr-2" data-toggle="tooltip" data-placement="top" title="Alterar Dados"><i class="fas fa-edit"></i></button>';

		$button .= $status;

		$data['data'][] = array(
			'id' => $res->idUsuario,
			'Nome' => $res->Nome,
			'Codigo' => $res->Codigo,
			'CPF_CNPJ' => $res->CPF_CNPJ,
			'endereco' => $res->Logradouro.', '.$res->Numero.', '.$res->Bairro.', '.$res->Cidade.', '.$res->UF.', '.$res->CEP,
			'dataCadastro' => date("d/m/Y H:i:s", strtotime($res->DataHoraCadastro)),
			'Fone' => $res->Fone,
			'LimiteCredito' => 'R$ '.number_format(($res->LimiteCredito), 2, ',', '.'),
			'Validade' => date("d/m/Y", strtotime($res->Validade)),
			'button' => $button,
		);
	}
	echo json_encode($data);
}

function buscarDados($con, $dados){

	$Firewall = new Firewall(); 
    $Firewall->SecureUris();

	$id = $Firewall->getClean($dados['id']);

	$model = new ClientesModel;

	$model->buscarDados($id);

	$array = array();
	while($res = mysqli_fetch_object($model->retorno)){
		$array['idUsuario'] = $res->idUsuario;
		$array['Codigo'] = $res->Codigo;
		$array['Nome'] = $res->Nome;
		$array['CPF_CNPJ'] = $res->CPF_CNPJ;
		$array['CEP'] = $res->CEP;
		$array['Logradouro'] = $res->Logradouro;
		$array['Numero'] = $res->Numero;
		$array['Bairro'] = $res->Bairro;
		$array['Cidade'] = $res->Cidade;
		$array['UF'] = $res->UF;
		$array['Complemento'] = $res->Complemento;
		$array['Fone'] = $res->Fone;
		$array['LimiteCredito'] = $res->LimiteCredito;
		$array['Validade'] = $res->Validade;
	}
	echo json_encode($array);
}

function editar($con, $dados){

	$model = new ClientesModel;

	$Firewall = new Firewall(); 
    $Firewall->SecureUris();

    $id = $Firewall->getClean($dados['idObj']);
	$nome = $Firewall->getClean($dados['nome']);
	$cpf = $Firewall->getClean($dados['cpf']);
	$cep = $Firewall->getClean($dados['cep']);
	$logradouro = $Firewall->getClean($dados['logradouro']);
	$numero = $Firewall->getClean($dados['numero']);
	$bairro = $Firewall->getClean($dados['bairro']);
	$cidade = $Firewall->getClean($dados['cidade']);
	$estado = $Firewall->getClean($dados['estado']);
	$codigo = $Firewall->getClean($dados['codigo']);
	$complemento = $Firewall->getClean($dados['complemento']);
	$contato = $Firewall->getClean($dados['contato']);
	$limiteCredito = $Firewall->getClean($dados['limiteCredito']);
	$validade = $Firewall->getClean($dados['validade']);

	$model->editar($id, $nome, $cpf, $cep, $logradouro, $numero, $bairro, $cidade, $estado, $codigo, $complemento, $contato, $limiteCredito, $validade);

	$res = array();
	if($model->retorno){
		$res['status'] = 200;
    }else{
        $res['status'] = 511;
    }

    echo json_encode($res);
}

function deletar($con, $dados){

	$Firewall = new Firewall(); 
    $Firewall->SecureUris();

	$model = new ClientesModel;

	$id = $Firewall->getClean($dados['id']);

	$model->deletar($id);

	$res = array();
	if($model->retorno){
		$res['status'] = 200;
    }else{
        $res['status'] = 511;
    }

    echo json_encode($res);
}



?>