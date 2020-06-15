<?php

declare(strict_types = 1);

class ValidaCpf{

    private $cpf;

    public function __construct(string $cpf)
    {
        $this->cpf = $cpf;  
    }

    public function setCpf(string $cpf){
        $this->cpf = $cpf;
    }

    public function getCpf():string{
        return $this->cpf;
    }

    private function removeCaracteresEspeciais():string{
        $cpf = preg_replace('/\D+/', '',$this->cpf);
        return substr($cpf,0,-2);
    }

    private function transformarEmArray():Array{
        $cpf = $this->removeCaracteresEspeciais();
        $array = str_split($cpf,1);
        return $array;
    }

    private function criarDigitos(array $cpf):int{
        $contador = count($cpf) + 1;
        $ac = 0;

        foreach($cpf as $valor){
           $ac += $valor * $contador;
           $contador--;
        }

        $digito = (11 - ($ac % 11)) > 9 ? 0 : (11 - ($ac % 11));
        return $digito;
    }

    private function acrescentaDigitiosNoArray():Array{
        $cpf = $this->transformarEmArray(); 
        $digito1 = $this->criarDigitos($cpf);
        array_push($cpf,$digito1);
        $digito2 = $this->criarDigitos($cpf);
        array_push($cpf,$digito2);
        return $cpf;       
    }

    private function formataCpf():string{
        $cpf = implode('',$this->acrescentaDigitiosNoArray());
        return preg_replace('/(\d{3})(\d{3})(\d{3})(\d{2})/',"\$1.\$2.\$3-\$4",$cpf);
    }

    public function valida():bool{
        if($this->formataCpf() === $this->cpf){
            return true;
        }else{
            return false;
        }
    }
}

$cpf = new ValidaCpf('881.279.840-35');

if($cpf->valida()){
    echo "Este cpf: ". $cpf->getCpf() . " " . " é válido";
}else{
    echo "Este cpf: " . $cpf->getCpf() . " é inválido";
}

?>