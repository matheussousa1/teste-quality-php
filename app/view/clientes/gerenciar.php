<style type="text/css">
  #new-search-area {
    width: 100%;
    clear: both;
    padding-top: 20px;
    padding-bottom: 20px;
  }
  #new-search-area input {
      width: 600px;
      font-size: 20px;
      padding: 5px;
  }
</style>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-maskmoney/3.0.2/jquery.maskMoney.min.js"></script>
<script type="text/javascript">
$(document).ready( function () {

  var options = {
      onKeyPress: function (cpf, ev, el, op) {
          var masks = ['000.000.000-000', '00.000.000/0000-00'];
          $('.cpfOuCnpj').mask((cpf.length > 14) ? masks[1] : masks[0], op);
      }
  }

  var maskContato = function (val) {
      return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
  },
  optionsContato = { onKeyPress: function(val, e, field, optionsContato) {
          field.mask(maskContato.apply({}, arguments), optionsContato);
      }
  };

  $('.cpfOuCnpj').length > 11 ? $('.cpfOuCnpj').mask('00.000.000/0000-00', options) : $('.cpfOuCnpj').mask('000.000.000-00#', options);
  $('.contato').mask(maskContato, optionsContato);
  $('.valor').maskMoney({allowZero: true, thousands:'', decimal:'.'});

  // ativar o tooltip
  $('body').tooltip({selector: '[data-toggle="tooltip"]'});

  $('#tabela').DataTable({
    "paging": true,
    "lengthChange": true,
    "searching": true,
    "ordering": true,
    "info": true,
    "responsive": true,
    "autoWidth": false,
    "pageLength": 10,
    dom: 'Bfrtip',
    buttons: [
      'excel', 'print'
    ],
    "ajax": {
      "url": "<?php echo API; ?>clientes.php?acao=buscar",
      "type": "GET"
    },
    "language": {
      "url": "https://cdn.datatables.net/plug-ins/1.10.22/i18n/Portuguese-Brasil.json",
      buttons: {
        print: 'Imprimir'
      }
    },
    initComplete : function() {
      $("#tabela_filter").detach().appendTo('#new-search-area');
    },    
    "columns": [
      { "data": "Codigo" },
      { "data": "Nome" },
      { "data": "CPF_CNPJ" },
      { "data": "endereco" },
      { "data": "Fone" },
      { "data": "LimiteCredito" },
      { "data": "Validade" },
      { "data": "dataCadastro" },
      { "data": "button" }
    ]
  });

  // adicionar unser
  $(document).on("click","#btnadd",function(){
    $("#modal_add").modal("show");
    $("#nome").focus();
  });


  $('#formCadastrar').validate({
    rules: {
      nome : { required: true},
      cpf : { required: true},
    },
    messages: {
      nome : { required: 'Preencha este campo' },
      cpf : { required: 'Preencha este campo'},
    },
    submitHandler: function( form ){
      var dados = $('#formCadastrar').serialize();
      $.ajax({
        type: "GET",
        url: "<?php echo API; ?>clientes.php?acao=cadastrar",
        data: dados,
        dataType: 'json',
        success: function(res) {
          if(res.status == 200){
            swal({   
              title: "Cadastrado com Sucesso",  
              type: "success",   
              showConfirmButton: false,
            });
            window.setTimeout(function(){
              $('#formCadastrar input').val(""); 
              swal.close();
              var table = $('#tabela').DataTable(); 
              table.ajax.reload( null, false );
              $("#modal_add").modal("hide");
            } ,2500);
          }else{
            swal({   
              title: "Error",  
              type: "error",   
              showConfirmButton: false,
            });
            window.setTimeout(function(){
              swal.close();
            } ,2500);
          }
        }
      });
      return false;
    }
  });
     //abrir modal pra edi????o
    $(document).on("click",".btnedit",function(){
      var id_user = $(this).attr("id_user");
      var value = {
        id: id_user
      };
      $.ajax({
        url : "<?php echo API; ?>clientes.php?acao=buscarDados",
        type: "GET",
        data : value,
        success: function(data, textStatus, jqXHR){
          var data = jQuery.parseJSON(data);
          $("#codigoEdit").val(data.Codigo);
          $("#nomeEdit").val(data.Nome);
          $("#cpfEdit").val(data.CPF_CNPJ);
          $("#cepEdit").val(data.CEP);
          $("#logradouroEdit").val(data.Logradouro);
          $("#numeroEdit").val(data.Numero);
          $("#bairroEdit").val(data.Bairro);
          $("#cidadeEdit").val(data.Cidade);
          $("#estadoEdit").val(data.UF);
          $("#complementoEdit").val(data.Complemento);
          $("#contatoEdit").val(data.Fone);
          $("#limiteCreditoEdit").val(data.LimiteCredito);
          $("#validadeEdit").val(data.Validade);
          $("#idObj").val(data.idUsuario);
          $("#moda_edit").modal('show');
        },
        error: function(jqXHR, textStatus, errorThrown){
          swal("Error!", textStatus, "error");
        }
      });
    });

    $('#formCadastrarEdit').validate({
      rules: {
        nome : { required: true},
        cpf : { required: true},
      },
      messages: {
        nome : { required: 'Preencha este campo' },
        cpf : { required: 'Preencha este campo'},
      },
      submitHandler: function( form ){
        var dados = $('#formCadastrarEdit').serialize();
        $.ajax({
          type: "GET",
          url: "<?php echo API; ?>clientes.php?acao=editar",
          data: dados,
          dataType: 'json',
          crossDomain: false,
          success: function(res) {
            if(res.status == 200){
              swal({   
                title: "Alterado com Sucesso",  
                type: "success",   
                showConfirmButton: false,
              });
              window.setTimeout(function(){
                $('#formCadastrarEdit input').val(""); 
                swal.close();
                  var table = $('#tabela').DataTable(); 
                  table.ajax.reload( null, false );
                  $("#moda_edit").modal("hide");
              } ,2500);
            }else{
              swal({   
                title: "Error",  
                type: "error",   
                showConfirmButton: false,
              });
              window.setTimeout(function(){
                swal.close();
              } ,2500);
            }
          }
        });
        return false;
      }
    });

    // inativar usuarios
     $(document).on( "click",".btndel", function() {
      var id_user = $(this).attr("id_user");
      var name = $(this).attr("nome_user");
      swal({   
        title: "Inativar",   
        text: "Inativar: "+name+" ?",   
        type: "warning",   
        showCancelButton: true,   
        confirmButtonColor: "#DD6B55",   
        confirmButtonText: "Inativar",   
        closeOnConfirm: true}).then(function(){   
          $.ajax({
          type: "GET",
          url: "<?php echo API; ?>clientes.php",
          data: {'acao':'deletar', 'id': id_user},
          dataType: 'json',
          success: function(res) {
            if(res.status == 200){
              swal({   
                title: "Alterado com Sucesso",  
                type: "success",   
                showConfirmButton: false,
              });
              window.setTimeout(function(){ 
                swal.close();
                var table = $('#tabela').DataTable(); 
                table.ajax.reload( null, false );
              } ,2500);
            }else{
              swal({   
                title: "Error",  
                type: "error",   
                showConfirmButton: false,
              });
              window.setTimeout(function(){
                swal.close();
              } ,2500);
            }
          }
        });
        return false;
      });
    });
     // ativar usuarios
     $(document).on( "click",".btnativar", function() {
      var id_user = $(this).attr("id_user");
      var name = $(this).attr("nome_user");
      swal({   
        title: "Ativar",   
        text: "Ativar: "+name+" ?",   
        type: "warning",   
        showCancelButton: true,   
        confirmButtonColor: "#DD6B55",   
        confirmButtonText: "Ativar",   
        closeOnConfirm: true}).then(function(){   
          $.ajax({
          type: "GET",
          url: "<?php echo API; ?>clientes.php",
          data: {'acao':'ativar', 'id': id_user},
          dataType: 'json',
          success: function(res) {
            if(res.status == 200){
              swal({   
                title: "Alterado com Sucesso",  
                type: "success",   
                showConfirmButton: false,
              });
              window.setTimeout(function(){ 
                swal.close();
                var table = $('#tabela').DataTable(); 
                table.ajax.reload( null, false );
              } ,2500);
            }else{
              swal({   
                title: "Error",  
                type: "error",   
                showConfirmButton: false,
              });
              window.setTimeout(function(){
                swal.close();
              } ,2500);
            }
          }
        });
        return false;
      });
    });

    //verificar cep
    $('#cep').blur(function(event) {
        var cep = $('#cep').val().replace(/[^\d]+/g,'');
        if(cep.length == 8){
            $.ajax({
                type: "GET",
                url: 'https://viacep.com.br/ws/'+cep+'/json/',
                dataType: 'json',
                success: function(dados) {
                  if(dados.erro == true){
                      swal({   
                          title: "CEP n??o encontrado",  
                          type: "error",   
                          showConfirmButton: true,
                      });
                      $('#cep').val('');
                  }else{
                      $('#logradouro').val(dados.logradouro);
                      $('#bairro').val(dados.bairro);
                      $("#cidade" ).val(dados.localidade);
                      $("#estado" ).val(dados.uf);
                  }
                }
            }); 
        }else{
            swal({   
                title: "CEP Incompleto",  
                type: "error",   
                showConfirmButton: true,
            });
            $('#cep').val('');
        }
    });

    //verificar cep
    $('#cepEdit').blur(function(event) {
        var cep = $('#cepEdit').val().replace(/[^\d]+/g,'');
        if(cep.length == 8){
            $.ajax({
                type: "GET",
                url: 'https://viacep.com.br/ws/'+cep+'/json/',
                dataType: 'json',
                success: function(dados) {
                  if(dados.erro == true){
                      swal({   
                          title: "CEP n??o encontrado",  
                          type: "error",   
                          showConfirmButton: true,
                      });
                      $('#cepEdit').val('');
                  }else{
                      $('#logradouroEdit').val(dados.logradouro);
                      $('#bairroEdit').val(dados.bairro);
                      $("#cidadeEdit" ).val(dados.localidade);
                      $("#estadoEdit" ).val(dados.uf);
                  }
                }
            }); 
        }else{
            swal({   
                title: "CEP Incompleto",  
                type: "error",   
                showConfirmButton: true,
            });
            $('#cepEdit').val('');
        }
    });

 });  
</script>


<div class="pcoded-main-container">
    <div class="pcoded-content">
        <!-- [ breadcrumb ] start -->
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h5 class="m-b-10">Clientes</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- [ breadcrumb ] end -->
        <!-- [ Main Content ] start -->
        <div class="row">
            <!-- [ sample-page ] start -->
            <div class="col-sm-12">
                <div class="card">

                    <div class="card-header">
                        <h5>Gerenciar Clientes</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb20 col-sm-12 text-center">
                          <button type="submit" class="btn btn-raised  btn-success" id="btnadd" name="btnadd"><i class="fa fa-plus"></i> Adicionar Cliente</button>
                        </div>
                        <div class="col-md-6">
                            <div id="new-search-area"></div>
                          </div>
                        <table id="tabela" class="table table-striped table-bordered table-hover">
                          <thead>
                            <tr class="tableheader">
                              <th>C??digo</th>
                              <th>Nome</th>
                              <th>CPF/CNPJ</th>
                              <th>Endere??o</th>
                              <th>Contato</th>
                              <th>Limite de Cr??dito</th>
                              <th>Validade</th>
                              <th>Data Cadastro</th>
                              <th width="17%">A????es</th>
                            </tr>
                          </thead>
                          <tbody>
                            <!-- resultado -->
                          </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- [ sample-page ] end -->
        </div>
        <!-- [ Main Content ] end -->
    </div>
</div>

  <!-- /.content-wrapper -->
<div id="modal_add" class="modal fade">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Adicionar</h4>
          <button type="button" class="close" data-dismiss="modal">??</button>
        </div>
        <!--modal header-->
        <div class="modal-body">
          <form role="form" id="formCadastrar" autocomplete="off">
            <div class="form-group">
              <label>Codigo</label>
              <input type="text" class="form-control" name="codigo" id="codigo">
            </div>
            <div class="form-group">
              <label>Nome</label>
              <input type="text" class="form-control" name="nome" id="nome">
            </div>
            <div class="form-group">
              <label>CPF/CNPJ</label>
              <input type="text" class="form-control cpfOuCnpj" name="cpf" id="cpf">
            </div>
            <div class="form-group">
              <label>CEP</label>
              <input type="text" class="form-control cep" name="cep" id="cep">
            </div>
            <div class="form-group">
              <label>Logradouro</label>
              <input type="text" class="form-control" name="logradouro" id="logradouro">
            </div>
            <div class="form-group">
              <label>Numero</label>
              <input type="text" class="form-control" name="numero" id="numero">
            </div>
            <div class="form-group">
              <label>Bairro</label>
              <input type="text" class="form-control" name="bairro" id="bairro">
            </div>
            <div class="form-group">
              <label>Cidade</label>
              <input type="text" class="form-control" name="cidade" id="cidade">
            </div>
            <div class="form-group">
              <label>Estado</label>
              <input type="text" class="form-control" name="estado" id="estado">
            </div>
            <div class="form-group">
              <label>Complemento</label>
              <input type="text" class="form-control" name="complemento" id="complemento">
            </div>
            <div class="form-group">
              <label>Contato</label>
              <input type="text" class="form-control contato" name="contato" id="contato">
            </div>
            <div class="form-group">
              <label>Limite de Cr??dito</label>
              <input type="text" class="form-control valor" name="limiteCredito" id="limiteCredito">
            </div>
            <div class="form-group">
              <label>Validade</label>
              <input type="date" class="form-control" name="validade" id="validade">
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
              <button type="submit" class="btn btn-primary float-left">Cadastrar</button>
            </div>
           </form>
        </div>
          <!--modal footer-->
        </div>
        <!--modal-content-->
      </div>
      <!--modal-dialog modal-lg-->
    </div>


  <div id="moda_edit" class="modal fade">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Editar</h4>
          <button type="button" class="close" data-dismiss="modal">??</button>
        </div>
        <!--modal header-->
          <form role="form" id="formCadastrarEdit" autocomplete="off">
        <div class="modal-body">
            <div class="form-group">
              <label>Codigo</label>
              <input type="text" class="form-control" name="codigo" id="codigoEdit">
            </div>
            <div class="form-group">
              <label>Nome</label>
              <input type="text" class="form-control" name="nome" id="nomeEdit">
            </div>
            <div class="form-group">
              <label>CPF/CNPJ</label>
              <input type="text" class="form-control cpfOuCnpj" name="cpf" id="cpfEdit">
            </div>
            <div class="form-group">
              <label>CEP</label>
              <input type="text" class="form-control cep" name="cep" id="cepEdit">
            </div>
            <div class="form-group">
              <label>Logradouro</label>
              <input type="text" class="form-control" name="logradouro" id="logradouroEdit">
            </div>
            <div class="form-group">
              <label>Numero</label>
              <input type="text" class="form-control" name="numero" id="numeroEdit">
            </div>
            <div class="form-group">
              <label>Bairro</label>
              <input type="text" class="form-control" name="bairro" id="bairroEdit">
            </div>
            <div class="form-group">
              <label>Cidade</label>
              <input type="text" class="form-control" name="cidade" id="cidadeEdit">
            </div>
            <div class="form-group">
              <label>Estado</label>
              <input type="text" class="form-control" name="estado" id="estadoEdit">
            </div>
            <div class="form-group">
              <label>Complemento</label>
              <input type="text" class="form-control" name="complemento" id="complementoEdit">
            </div>
            <div class="form-group">
              <label>Contato</label>
              <input type="text" class="form-control contato" name="contato" id="contatoEdit">
            </div>
            <div class="form-group">
              <label>Limite de Cr??dito</label>
              <input type="text" class="form-control valor" name="limiteCredito" id="limiteCreditoEdit">
            </div>
            <div class="form-group">
              <label>Validade</label>
              <input type="date" class="form-control" name="validade" id="validadeEdit">
            </div> 
          <input type="hidden" name="idObj" id="idObj" value="">
        <div class="modal-footer">
          <button type="button" class="btn btn-raised btn-default" data-dismiss="modal">Fechar</button>
          <button type="submit" class="btn btn-raised btn-primary">Alterar</button>
        </div>
      </form>
          </div>
          <!--modal footer-->
        </div>
        <!--modal-content-->
      </div>
      <!--modal-dialog modal-lg-->
    </div>
    <!--form-kantor-modal-->