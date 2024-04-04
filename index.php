<?php

// Produto abstrato
abstract class Financiamento
{
    protected $taxaDeJuros;
    protected $valor;

    public function __construct(float $taxaDeJuros, float $valor)
    {
        $this->taxaDeJuros = $taxaDeJuros;
        $this->valor = $valor;
    }

    public abstract function getValorMensal(int $quantidadeParcelas): float;
}


// Produto
class FinanciamentoHabitacional extends Financiamento
{
    public function getValorMensal(int $quantidadeParcelas): float
    {
        $taxa = $this->taxaDeJuros / 100;
        $valorParcela = $this->valor * pow((1 + $taxa), $quantidadeParcelas);

        return $valorParcela / $quantidadeParcelas;
    }
}


// Produto
class FinanciamentoVeicular extends Financiamento
{
    public function getValorMensal(int $quantidadeParcelas): float
    {
        $taxa = $this->taxaDeJuros / 100;
        $valorParcela = $this->valor * (1 + $taxa * $quantidadeParcelas);

        return $valorParcela / $quantidadeParcelas;
    }
}

// Fabrica Abstrata
interface AbstractBancoFactory
{
    public function getFinanciamento(float $valor): Financiamento;
}

// Fabrica concreta
class BancoCaseiro implements AbstractBancoFactory
{
    private const TAXA = 0.5;

    public function getFinanciamento(float $valor): Financiamento
    {
        return new FinanciamentoHabitacional(self::TAXA, $valor);
    }
}

// Fabrica Concreta
class BancoMotorizado implements AbstractBancoFactory
{
    private const TAXA = 0.5;

    public function getFinanciamento(float $valor): Financiamento
    {
        return new FinanciamentoVeicular(self::TAXA, $valor);
    }
}

// Cliente
class Cliente
{

    function getfactory(AbstractBancoFactory $factory, $valor) : Financiamento
    {
        return $factory->getFinanciamento($valor);
        
    }
}

// Exemplo de uso
$cliente = new Cliente();
 echo $cliente->getfactory(new BancoCaseiro, 1000)
        ->getValorMensal(10);
