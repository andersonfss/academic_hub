<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Curso;

class CursosController extends Controller
{
    /**
     * Ex.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {
        //  o método validate do objeto request é chamado para garantir que os dados enviados atenda aos criterios
        $request->validate([
            'nome' => 'required|unique:cursos', // O campo 'nome' e obrigatório e deve ser único na tabela 'cursos'.
            'coordenador_id' => ['required', 'exists:professores,id'], // O campo 'coordenador_id' é obrigatório e deve existir como 'id' na tabela 'professores'.
            'carga_horaria' => 'required',
            'sigla' => 'required'
        ]);

        // se a validação passar, um novo registro curso é criado no banco de dados usando os dados da solicitação.
        $curso = Curso::create([
            'nome' => $request->nome,
            'coordenador_id' => $request->coordenador_id,
            'carga_horaria' => $request->carga_horaria,
            'sigla' => $request->sigla,
        ]);

        // uma resposta json é retornada e o código de status 201 é retornado para indicar que um novo curso foi criado
        return response()->json(['message' => 'Curso criado com sucesso', 'curso' => $curso], 201);
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Curso $curso)
    {
        // Para assegurar que as informações estejam nos conformes:
        $request->validate([
            // Nome é um atributo não facultativo;
            // Abaixo, também são verificados todos os nomes de curso existentes, 
            // à exceção do nome do curso antes da atualização.
            
            'nome' => ['required', "unique:cursos, nome, $curso->nome"],
            'coordenador_id' => ['required', 'exists:professores,id'],
            'carga_horaria' => 'required',
            'sigla' => 'required'
        ]);

        // Em seguida, certificando-se de que o ID existe. Se não existir, este método encerrará prontamente
        // e vai retornar erro 404. Senão, o fluxo de execução continuará.

        if (!$curso) {
            return response()->json(['message' => 'A operação falhou por ID inexistente.'], 404);
        }

        // (A SER APRECIADO PELO PROFESSOR) $curso->update($request->validated());

        $curso->nome = $request->nome;
        $curso->coordenador_id = $request->coordenador_id;
        $curso->carga_horaria = $request->carga_horaria;
        $curso->sigla = $request->sigla;
        $curso->save();

        return response()->json(['message' => 'Alteração de curso bem-sucedida.'], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
