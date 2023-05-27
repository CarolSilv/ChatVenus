<?php

namespace App\DAO;

class UsuarioDAO extends Conexao
{
    public function insertUsuario($chaveSecreta, $nomeFantasia, $idade, $email,$numero)
    {
        $query = $this->pdo->prepare(
            "INSERT INTO api.tb_user(
            ID_USER, 
            NOME_FANTASIA,
            IDADE, 
            E_MAIL, 
            NUMERO)
            VALUES(:ID_USER, 
            :NOME_FANTASIA, 
            :IDADE, 
            :E_MAIL, 
            :NUMERO)"
        );
        $query->execute([
            'ID_USER' => $chaveSecreta,
            'NOME_FANTASIA' => $nomeFantasia,
            'IDADE' => $idade,
            'E_MAIL' => $email,
            'NUMERO' => $numero
        ]);
    }

    public function insertContato($chave, $numeroRelacionado, $nomeContato, $mensagem)
    {
        $query = $this->pdo->prepare(
            "INSERT INTO api.tb_contatos(
            id_user,
            numero, 
            nome_contato, 
            Mensagem
            )
            VALUES(:id_user,
            :numero, 
            :nome_contato, 
            :Mensagem)"
        );
        $query->execute([
            'id_user' => $chave,
            'numero' => $numeroRelacionado,
            'nome_contato' => $nomeContato,
            'Mensagem' => $mensagem
        ]);
    }

    public function getContatos($chave)
    {
        $query = $this->pdo->prepare(
            "SELECT numero, nome_contato
            FROM api.tb_contatos WHERE id_user = :id_user;"
        );
        $query->execute([
            'id_user' => $chave
        ]);
        return $query->fetchAll(\PDO::FETCH_ASSOC) ?? [];
    }
    
    public function deleteContato($chave, $numeroRelacionado)
    {
        $query = $this->pdo->prepare(
            "DELETE FROM api.tb_contatos 
            WHERE id_user = :id_user
            AND numero = :numero
            LIMIT 1;"
        );
        $query->execute([
            'id_user' => $chave,
            'numero'=> $numeroRelacionado
        ]);
    }

    public function getUser($usuario, $senha)
    {
        $query = $this->pdo->prepare(
            "SELECT *
            FROM api.tb_user
            WHERE ID_USER = :ID_USER
            AND SENHA = :SENHA;"
        );
        $query->execute([
            'ID_USER' => $usuario,
            'SENHA'=> $senha
        ]);

        return $query->fetchAll(\PDO::FETCH_ASSOC)[0] ?? [];
    }

    public function editContato($chave, $numeroRelacionado, $nomeContato)
    {
        $query = $this->pdo->prepare(
            "UPDATE api.tb_contatos 
            SET numero = :numero,
            nome_contato = :nome_contato
            WHERE id_user = :id_user
            LIMIT 1;"
        );
        $query->execute([
            'numero'=> $numeroRelacionado,
            'nome_contato'=> $nomeContato,
            'id_user' => $chave
        ]);
    }
}