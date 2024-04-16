<?php

namespace App\Controllers;

use App\DAO\UsuarioDAO;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

final class UsuarioController
{
    public function apiRun(Request $request, Response $response)
    {
        echo 'Run!';
        die();
    }


    public function cadastrarUsuario(Request $request, Response $response)
    {
        $dados = $request->getParsedBody();
        $chaveSecreta = $dados['CHAVE_SECRETA'];
        $nomeFantasia = $dados['NOME_FANTASIA'];
        $idade = $dados['IDADE'];
        $email = $dados['E_MAIL'];
        $senha = $dados['SENHA'];
        $numero = $dados['NUMERO'];
        $usuarioDAO = new UsuarioDAO();
        $usuarioDAO->insertUsuario(
            $chaveSecreta,
            $nomeFantasia,
            $idade,
            $email,
            $numero,
            $senha
        );
        if (!$response) {
            return $response->withJson("Erro ao realizar cadastro.");
        }
        return $response->withJson("Usuario inserido com sucesso.");
    }

    public function cadastrarContatos(Request $request, Response $response, $args)
    {
        $dadosContatos = $request->getParsedBody();
        $chave = $args['CHAVE_SECRETA'];
        $numeroRelacionado = $dadosContatos['numero'];
        $nomeContato = $dadosContatos['nome_contato'];
        $mensagem = $dadosContatos['Mensagem'];
        $usuarioDAO = new UsuarioDAO();
        $usuarioDAO->insertContato($chave, $numeroRelacionado, $nomeContato, $mensagem);
        if (!$response) {
            return $response->withJson("Erro ao inserir contato.");
        }
        return $response->withJson("Contato inserido com sucesso.");
    }

    public function buscarContatos(Request $request, Response $response, $args)
    {
        $chave = $args['CHAVE_SECRETA'];
        $usuarioDAO = new UsuarioDAO();
        $contatos = $usuarioDAO->getContatos($chave);
        if (!$response) {
            return $response->withJson("Erro ao buscar contatos.");
        }
        $response = $response->withJson($contatos);
        return $response;
    }

    public function excluirContato(Request $request, Response $response, $args)
    {
        $chave = $args['CHAVE_SECRETA'];
        $numeroRelacionado = $request->getParsedBody()['numero'];
        $usuarioDAO = new UsuarioDAO();
        $usuarioDAO->deleteContato($chave, $numeroRelacionado);
        if (!$response) {
            return $response->withJson("Erro ao excluir contato.");
        }
        return $response->withJson("Contato excluido com sucesso.");
    }

    public function autenticarUsuario(Request $request, Response $response, $args)
    {
        $data = $request->getParsedBody();
        $usuario = $data['ID_USUARIO'];
        $senha = $data['SENHA'];
        $usuarioSDAO = new UsuarioDAO();
        $user = $usuarioSDAO->getUser($usuario, $senha);
        if (count($user) != 0) {

            return $response->withJson(array(
                "message" => "success",
                "dados"=>$user
            ));
        }
        return $response->withStatus(401);
    }

    public function editarContato(Request $request, Response $response, $args)
    {
        $chave = $args['CHAVE_SECRETA'];
        $numeroRelacionado = $request->getParsedBody()['numero'];
        $nomeContato = $request->getParsedBody()['nome_contato'];
        $usuarioDAO = new UsuarioDAO();
        $usuarioDAO->editContato($chave, $numeroRelacionado, $nomeContato);
        if (!$response) {
            return $response->withJson("Erro ao atualizar contato.");
        }
        return $response->withJson("Contato atualizado   com sucesso.");

    }
}
