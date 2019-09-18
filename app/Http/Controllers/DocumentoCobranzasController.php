<?php

namespace App\Http\Controllers;
use DB;
use App\Cliente;
use App\VboletoP;
use App\Cotizacion;
use App\DagenciaViajes;
use App\DpagoConsolidadores;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Barryvdh\DomPDF\Facade as PDF;
use App\Http\Controllers\Controller;

class DocumentoCobranzasController extends Controller
{
	public function getBoletosPorValidar()
    {
        $vboletos = VboletoP::where('validated',false)
                            ->orderBy('created_at', 'desc')
                            ->get();
        return $vboletos;
    }
    public function getCountBoletosPorValidar()
    {
        return  VboletoP::where('validated',false)->count();
    }
    public function cambiarEstadoBoletos(Request $request,$change)
    {
    	foreach ($request->boletos as $index => $boleto) {
    		$aux_boleto = VboletoP::find($boleto['id']);
    		if ($change == 0) {
    			$aux_boleto->anulado = 1;
    		}
    		$aux_boleto->validated = 1;
    		$aux_boleto->update();
    	}
    	return $this->getBoletosPorValidar();
    }
    public function buscarCodigo($codigo,$tipo, Request $request)
    {

        $boletos = VboletoP::where("codigo",$codigo)->where('anulado',0)->get();
        foreach ($boletos as $index => $boleto) {
            $boleto->cliente = Cliente::where("cedula_rif",$boleto->cliente_id)->first();
        }
        
        $cotizacion = Cotizacion::where("count","=",$boletos->first()->venta_boleto_id)->first();
        
        $pagado = DpagoConsolidadores::where("venta_boleto_id",$cotizacion->id)->sum("abono") + DagenciaViajes::where("venta_boleto_id",$cotizacion->id)->sum("abono");
        if ($tipo == "print") {
            $texto       = $request->texto;
            $soles       = $request->soles;
            $correlativo = collect(DB::select('select * from venta_boletos where id = 1'));
            $correlativo = $correlativo->first()->correlativo;
            $total       = round(VboletoP::where("codigo",$codigo)->where('anulado',0)->sum("tarifa_fee"),2);
            $pdf         = PDF::loadView('vboletos.validar.documento_cobranza',compact("boletos","cotizacion","total","pagado","correlativo","texto","soles"));
            DB::update('update venta_boletos set correlativo = '.($correlativo+1).' where id = 1');
            return $pdf->download('Documento Cobranza.pdf');
        }
        
        return ['boletos' => $boletos, 'cotizacion' => $cotizacion,'pagado' => $pagado ];
    }
}
