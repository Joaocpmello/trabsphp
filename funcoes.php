<?php
function limitarTexto($texto, $limite) {
    if (strlen($texto) <= $limite) {
        return $texto;
    }
    
    return substr($texto, 0, $limite) . '...';
}

function filtrarJogosPorCategoria($jogos, $categoria) {
    if (empty($categoria)) {
        return $jogos;
    }
    
    return array_filter($jogos, function($jogo) use ($categoria) {
        return in_array($categoria, $jogo['categorias']);
    });
}

function filtrarJogosPorDesenvolvedora($jogos, $desenvolvedora) {
    if (empty($desenvolvedora)) {
        return $jogos;
    }
    
    return array_filter($jogos, function($jogo) use ($desenvolvedora) {
        return $jogo['desenvolvedora'] == $desenvolvedora;
    });
}

function filtrarJogosPorAno($jogos, $ano) {
    if (empty($ano)) {
        return $jogos;
    }
    
    return array_filter($jogos, function($jogo) use ($ano) {
        return $jogo['ano'] == $ano;
    });
}

function pesquisarJogos($jogos, $termo) {
    if (empty($termo)) {
        return $jogos;
    }
    
    $termo = strtolower($termo);
    
    return array_filter($jogos, function($jogo) use ($termo) {
        if (stripos(strtolower($jogo['titulo']), $termo) !== false) {
            return true;
        }
        
        if (stripos((string)$jogo['ano'], $termo) !== false) {
            return true;
        }
        
        if (stripos(strtolower($jogo['desenvolvedora']), $termo) !== false) {
            return true;
        }
        
        foreach ($jogo['categorias'] as $categoria) {
            if (stripos(strtolower($categoria), $termo) !== false) {
                return true;
            }
        }
        
        return false;
    });
}

function obterCategorias($jogos) {
    $categorias = [];
    
    foreach ($jogos as $jogo) {
        foreach ($jogo['categorias'] as $categoria) {
            if (!in_array($categoria, $categorias)) {
                $categorias[] = $categoria;
            }
        }
    }
    
    sort($categorias);
    return $categorias;
}

function obterDesenvolvedoras($jogos) {
    $desenvolvedoras = [];
    
    foreach ($jogos as $jogo) {
        if (!in_array($jogo['desenvolvedora'], $desenvolvedoras)) {
            $desenvolvedoras[] = $jogo['desenvolvedora'];
        }
    }
    
    sort($desenvolvedoras);
    return $desenvolvedoras;
}

function obterAnos($jogos) {
    $anos = [];
    
    foreach ($jogos as $jogo) {
        if (!in_array($jogo['ano'], $anos)) {
            $anos[] = $jogo['ano'];
        }
    }
    
    sort($anos);
    return $anos;
}

function buscarJogoPorId($jogos, $id) {
    foreach ($jogos as $jogo) {
        if ($jogo['id'] == $id) {
            return $jogo;
        }
    }
    
    return null;
}
?>
