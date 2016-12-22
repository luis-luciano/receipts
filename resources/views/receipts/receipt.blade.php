<DOCTYPE html>  
<html lang="es">  
    <head>  
        <meta charset="utf-8"/>  
        <title>Recibos</title>  
        <link href="{{ asset('assets/css/receipt.css') }}" rel="stylesheet">
        <link rel="shortcut icon" href="favicon"/>  
    </head>  
    <body>

    @foreach ($list_contracts as $contract) 
      <div class="row">
          <header>  
             <div class="contrato">
                 <p>{{ (int)$contract["contrato"] }}</p>
             </div>
             <div class="recibo1">
                 <p>{{ $contract["recibo"] }}</p>
             </div>

             <div class="vencim">
                 <p>{{ $contract["f_vencimiento"] }}</p>
             </div>
             <div class="mesF">
                 <p>{{ $contract["periodo"] }}</p>
             </div>
             <div class="medidor">
                 <p>{{ $contract["medidor"] }}</p>
             </div>

             <div class="sec">
                 <p>{{ $contract["sector"] }}</p>
             </div>
             <div class="rut">
                 <p>{{ $contract["ruta"] }}</p>
             </div>
             <div class="folio">
                 <p>{{ $contract["folio"] }}</p>
             </div>

             <div class="ant">
                 <p>
                   @if(isset($contract['lec_anterior']))
                    {{ $contract["lec_anterior" ] }}
                  @endif
                 </p>
             </div>
             <div class="act">
                 <p>
                  @if(isset($contract['lec_actual']))
                    {{ $contract["lec_actual" ] }}
                  @endif
                 </p>
             </div>
             <div class="consm">
                 <p>                   
                   @if(isset($contract['consumo']))
                    {{ $contract["consumo" ] }}
                  @endif
                 </p>
             </div>
             <div class="prom">
                 <p>{{ $contract["cons_promedio"] }}</p>
             </div>
             <div class="mrezago">
                 <p>{{ $contract["pagos_ven"] }}</p>
             </div>

             <div class="nombre">
                 <p>{{ $contract["nombre"] }}</p>
             </div>
             <div class="rfc">
                 <p>
                    @if(isset($contract['rfc_u']))
                    {{ $contract["rfc_u" ] }}
                    @endif
                 </p>
             </div>
             <div class="tarifa">
                 <p>{{ $contract["tarifa"] }}</p>
             </div>
             <div class="direcc">
                 <p>{{ $contract["direccion"].' '.$contract["colonia"] }}</p>
             </div>
             <div class="direccF">
                 <p>
                  @if(isset($contract['direccion_fiscal']))
                    {{ $contract["direccion_fiscal" ] }}
                  @endif

                  @if(isset($contract['colonia_fiscal']))
                    {{ $contract["colonia_fiscal" ] }}
                  @endif
                  </p>
             </div>
             <div class="ccatastral">
                 <p>
                 @if(isset($contract['cve_ubica']))
                    {{ $contract["cve_ubica" ] }}
                 @endif
                 </p>
             </div>
        </header>  

        <section>
            <table class="t1">
                @foreach ($contract['conceptos'] as $concept)
                      <tr>
                        <td>{{  $concept['concepto'] }}</td>
                        <td>{{  $concept['importe_a'] }}</td>
                        <td>{{  $concept['importe_v'] }}</td>
                      </tr>
                @endforeach
            </table>  
           
            <div class="fact">FACTURACIÓN 2016</div>
            <div class="total1">
                  @if(isset($contract['tot_apagar']))
                    {{ $contract["tot_apagar" ] }}
                  @endif</div>
            <div class="logo_mes">
            <img class="logo_m" src="{{ asset('assets/img/receipt/mes_recib.png') }}">
            </div>
        </section> 

        <aside>  
           <table class="t2">
              @foreach ($contract['conceptos'] as $concept)
                      <tr>
                        <td>{{  $concept['concepto'] }}</td>
                        <td>{{  $concept['importe_a'] }}</td>
                        <td>{{  $concept['importe_v'] }}</td>
                      </tr>
                @endforeach
          </table>

          <div class="total2">
                  @if(isset($contract['tot_apagar']))
                    {{ $contract["tot_apagar" ] }}
                  @endif
          </div>
          <div class="recibo2">
                  @if(isset($contract['recibo']))
                    {{ $contract["recibo" ] }}
                  @endif
          </div> 
        </aside>  
        <footer> 
          <table class="t3">
              @foreach ($contract['conceptos'] as $concept)
                      <tr>
                        <td>{{  $concept['concepto'] }}</td>
                        <td>{{  $concept['importe_a'] }}</td>
                        <td>{{  $concept['importe_v'] }}</td>
                      </tr>
                @endforeach
          </table>
          <div class="totalFA">
                  @if(isset($contract['tot_apagar']))
                    {{ $contract["tot_apagar" ] }}
                  @endif
          </div>
          <table class="t4">
              @foreach ($contract['conceptos'] as $concept)
                      <tr>
                        <td>{{  $concept['concepto'] }}</td>
                        <td>{{  $concept['importe_a'] }}</td>
                        <td>{{  $concept['importe_v'] }}</td>
                      </tr>
                @endforeach
          </table>
          <div class="totalPA">1
                  @if(isset($contract['tot_apagar']))
                    {{ $contract["tot_apagar" ] }}
                  @endif</div>

          <div class="tContrato"><p>{{ (int)$contract["contrato"] }}</p></div>
          <div class="tRecibo"><p>{{ $contract["recibo"] }}</p></div>
          <div class="tSec"><p>{{ $contract["sector"] }}</p></div>
          <div class="tRut"><p>{{ $contract["ruta"] }}</p></div>
          <div class="tFol"><p>{{ $contract["folio"] }}</p></div>
          <div class="tVen"><p>{{ $contract["f_vencimiento"] }}</p></div>
          
          <div class="tContrato2"><p>{{ (int)$contract["contrato"] }}</p></div>
          <div class="tRecibo2"><p>{{ $contract["recibo"] }}</p></div>
          <div class="tSec2"><p>{{ $contract["sector"] }}</p></div>
          <div class="tRut2"><p>{{ $contract["ruta"] }}</p></div>
          <div class="tFol2"><p>{{ $contract["folio"] }}</p></div>
          <div class="tVen2"><p>{{ $contract["f_vencimiento"] }}</p></div>

          <div class="barcode">
            {{ $contract["barcode-rn"] }}
          </div>

          <div class="barcode2">
            {{ $contract["barcode-pa"] }}
          </div>
        </footer>  
      </div>
      <div style="page-break-after: always;">
      </div>

    @endforeach 
    </body>  
</html>  
