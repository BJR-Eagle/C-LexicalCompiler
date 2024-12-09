<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function index(){
        return view("lexar");
    }

    public function compileLexarForC(Request $request)
    {
        try {
            // Validação do arquivo
            $request->validate([
                'code' => 'required|file|mimes:txt,c,h|max:2048',
            ]);
            //Leitura e tratamento do arquivo
            $file = $request->file('code');
            $code = file_get_contents($file->getRealPath());

            // Definindo tokens e palavras chaves
            $tokens = [];
            $simbols = [];

            $keywords =
                [
                    'int','float','char','double','void','return',
                    'if','else','while','for','do','break',
                    'continue','switch','case', 'default',
                    'struct','',
                ];
            $operators =
                [
                    '+','-','*','/','%','=','==','!=','<','>',
                    '<=','>=','&&','||','!','++','--','+=','-=',
                    '&','|','^','<<','>>','~','&=','|=','->','?',':'
                ];
            $delimiters =['(',')','{','}','[',']',';',',','.',':'];

            // Remoção de comentarios
            $code = preg_replace(['!/\*.*?\*/!s', '!//.*!'], '', $code);

            // Tokenização
            $pattern = '/([a-zA-Z_]\w*)|([0-9]*\.?[0-9]+)|(".*?")|(\'.\')|(==|!=|<=|>=|\|\||&&|[+\-*\/%=<>!&|^])|([,;(){}[\]])|\s+/';

            //Procurar por palavras chaves, numeros, strings, char, operadores, delimitadores e espaços
            preg_match_all($pattern, $code, $matches);

            //Identificador de tokens
            foreach ($matches[0] as $token) {
                //Remoção de espaços presentes nos tokens
                $token = trim($token);

                if (empty($token)) continue;

                //Palavra chave
                if (in_array($token, $keywords)) {
                    $tokens[] = ['type' => 'Palavra Chave', 'value' => $token];
                    //Identifcador de numeros
                } elseif (preg_match('/^[0-9]*\.?[0-9]+$/', $token)) {
                    $tokens[] = ['type' => 'Numero', 'value' => $token];
                    //Identificador de strings
                } elseif (preg_match('/^".*"$/', $token)) {
                    $tokens[] = ['type' => 'string', 'value' => $token];
                    //Identificador de char
                } elseif (preg_match('/^\'.*\'$/', $token)) {
                    $tokens[] = ['type' => 'char', 'value' => $token];
                    //Identificador de operadores
                } elseif (in_array($token, $operators)) {
                    $tokens[] = ['type' => 'Operador', 'value' => $token];
                    //Identificador de delimitadores
                } elseif (in_array($token, $delimiters)) {
                    $tokens[] = ['type' => 'Delitimator', 'value' => $token];
                    //Identificador de identificadores
                } elseif (preg_match('/^[a-zA-Z_][a-zA-Z0-9_]*$/', $token)) {
                    if (!array_key_exists($token, $simbols)) {
                        $simbols[$token] = count($simbols) + 1;
                    }
                    $tokens[] = ['type' => 'Identificador', 'value' => $token, 'ID' => $simbols[$token]];
                }
                
            }
            return redirect()->route('lexar')->with(key: ['tokens' => $tokens]);
        } catch (\Exception $e) {
            return redirect()->route('lexar')->with('error', $e->getMessage());
        }
    }

}
