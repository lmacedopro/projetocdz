<?php

/* Verifica o tipo de efeito baseado no codigo do mesmo
 * @status - codigo do efeito ativado
 */
function checkEfeito($status){
	
	$desc = "";
	switch($status){
		
		case 1: 
			$desc = "CURA";
			break;
		case 2: 
			$desc = "ENVENENAMENTO";
			break;
		case 3: 
			$desc = "SANGRAMENTO";
			break;
		case 4: 
			$desc = "QUEIMADURA";
			break;
		case 5: 
			$desc = "CONGELAMENTO";
			break;
		case 6: 
			$desc = "PARALISIA";
			break;
		case 7: 
			$desc = "BLOQUEIO";
			break;
		case 8: 
			$desc = "MORTE";
			break;
		default: 
			$desc = "";
	}
	
	return $desc;
}

/*
 * Calcula o dano normal de ataque de um cavaleiro ao oponente
 */
function DanoNormal($level,$patk,$tecforca,$pdef_op){
	
	$dano = round((($level * 2 / 5 + 2) * $patk * $tecforca / $pdef_op) / 50 + 2);
	
	return $dano;
}

/*
 * Calcula o dano especial sem vantagem de tipo de um cavaleiro ao oponente
 */
function DanoEspecial($level,$spatk,$tecforca,$spdef_op){
	
	$dano = round(((($level * 2 / 5 + 2) * $spatk * $tecforca / $spdef_op) / 50 + 2) * 1.5);
	
	return $dano;
}

/*
 * Calcula o dano especial de mesmo tipo de ataque de um cavaleiro ao oponente
 */
function DanoEspMesmoTipo($level,$patk,$tecforca,$pdef_op){
	
	$dano = round((($level * 2 / 5 + 2) * $patk * $tecforca / $pdef_op) / 50 + 2);
	
	return $dano;
}

/*
 * Calcula o dano especial com vantagem de tipo de ataque de um cavaleiro ao oponente
 */
function DanoEspVantagemTipo($level,$patk,$tecforca,$pdef_op){
	
	$dano = round(((($level * 2 / 5 + 2) * $spatk * $tecforca / $spdef_op) / 50 + 2) * 1.5);
	
	return $dano;
}

/*
 * Sorteia tecnicas aleatorias para cada oponente em batalha. As tecnicas são sorteadas
 * com base no vetor de tecnicas filtradas por level e id de cavaleiro, alem das tecnicas basicas.
 * @tec - Vetor de tecnicas de um cavaleiro
 */
function sortTecnicas($tec){
    
    //Conta a qt de tecnicas no vetor
    $tot = count($tec);
    
    $ntec = 0; #por padrão se o cavaleiro nao tiver tecnicas a mais sorteará apenas a primeira
    if($tot <= 3){
        $ntec = 1; # uma tecnica a ser sorteada
    }elseif(($tot > 3) & ($tot <= 6)){
        $ntec = 2;
    }elseif(($tot > 6) & ($tot <= 9)){
        $ntec = 3;
    }elseif($tot > 9){
        $ntec = 4;
    }
    
    for($i=0;$i<$ntec;$i++){
        $ind = array_rand($tec);
        $arraytec[$i] = $tec[$ind];
        unset($tec[$ind]); #Remove o item ja selecionado 
    }
    
    return $arraytec;
}

function porcentagem($valor,$total){
	
	return ( $valor/$total) * 100;
}

/*Gera um array de porcentagens baseado no rank, level e HP do oponente para definir
 * a probilidade de recrutamento
 * @tbrec - Tabela auxiliar de recrutamento
 * @level - level do oponente
 * @hp - porcentsgem de hp do oponente
 * retorna true ou false para recrutamento
 */
function geraTabRecrutRank($tbrec, $level, $hp){
	
	foreach($tbrec as $tr){
		
		if($level <= 30){
		
			if($hp <= 10){ //hp até 10%
				
				$prob = array("TRUE"=>$tr->rct_p1h10,"FALSE"=>100 - $tr->rct_p1h10);
				
				//echo "HP abaixo de 10%";
				//print_r($prob);
			}elseif($hp > 10 & $hp <= 33){ //hp entre 11 e 33%
			
				$prob = array("TRUE"=>$tr->rct_p1h33,"FALSE"=>100 - $tr->rct_p1h33);
				
				//echo "HP entre 11 e 33%";
				//print_r($prob);
			}elseif($hp > 33 & $hp <= 66){ //hp entre 34 e 66%
				
				$prob = array("TRUE"=>$tr->rct_p1h66,"FALSE"=>100 - $tr->rct_p1h66);
				
				//echo "HP entre 34 e 66%";
				//print_r($prob);
			}else{ //hp acima de 66%
			
				$prob = array("TRUE"=>$tr->rct_p1h100,"FALSE"=>100 - $tr->rct_p1h100);
				
				//echo "HP acima de 66%";
				//print_r($prob);
			}
		}else{
		
			if($hp <= 10){ //hp até 10%
			
				$prob = array("TRUE"=>$tr->rct_p2h10,"FALSE"=>100 - $tr->rct_p2h10);
				
			}elseif($hp > 10 & $hp <= 33){ //hp entre 11 e 33%
			
				$prob = array("TRUE"=>$tr->rct_p2h33,"FALSE"=>100 - $tr->rct_p2h33);
				
			}elseif($hp > 33 & $hp <= 66){ //hp entre 34 e 66%
			
				$prob = array("TRUE"=>$tr->rct_p2h66,"FALSE"=>100 - $tr->rct_p2h66);
				
			}else{ //hp acima de 66%
				
				$prob = array("TRUE"=>$tr->rct_p2h100,"FALSE"=>100 - $tr->rct_p2h100);
				
			}
		}	
	}
	
	$rand = mt_rand(1, (int) array_sum($prob));
     
     foreach($prob as $key => $value){
         $rand -= $value;
         if($rand <= 0){
             return $key;
         }
     }  
}
    


