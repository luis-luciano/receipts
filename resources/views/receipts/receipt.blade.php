<DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8"/>
        <title>Recibos</title>
        <link href="{{ asset('assets/css/receipt.css') }}" rel="stylesheet">
        <link rel="shortcut icon" href="favicon"/>
    </head>
    <body>


      <div class="row">
          <header>
             <div class="contrato">
                 <p>{{ (int)$contracts->contrato }}</p>
             </div>

             <div class="recibo1">
                 <p>{{ $contracts->receipt_number }}</p>
             </div>

             <div class="vencim">
                 <p>{{ $contracts->due_date }}</p>
             </div>

             <div class="mesF">
                 <p>{{ $contracts->invoiced_month }}</p>
             </div>

             <div class="medidor">
                 <p>{{ trim($contracts->medidor) }}</p>
             </div>

             <div class="sec">
                 <p>{{ $contracts->sector }}</p>
             </div>

             <div class="rut">
                 <p>{{ $contracts->ruta }}</p>
             </div>

             <div class="folio">
                 <p>{{ $contracts->folio }}</p>
             </div>

             <div class="ant">
                 <p>
                    {{ $currentLecture->lec_anterior}}
                 </p>
             </div>
             <div class="act">
                 <p>
                    {{ $currentLecture->lec_actual}}
                 </p>
             </div>
             <div class="consm">
                 <p>
                    {{ $currentLecture->consumo}}
                 </p>
             </div>
             <div class="prom">
                 <p>
                    {{ $contracts->cons_promedio }}
                 </p>
             </div>
             <div class="mrezago">
                 <p>
                    {{ $contracts->pagos_ven }}
                 </p>
             </div>

             <div class="nombre">
                 <p>
                    {{ trim($contracts->nombre) }}
                 </p>
             </div>
             <div class="rfc">
                 <p>
                    {{ trim($contracts->rfc_u) }}
                 </p>
             </div>
             <div class="tarifa">
                 <p>
                    {{ $contracts->rate_description }}
                </p>
             </div>
             <div class="direcc">
                 <p>
                    {!! $contracts->service_address !!}
                </p>
             </div>
             <div class="direccF">
                <p>
                    {{ $contracts->fiscal_address }}
                </p>
             </div>
             <div class="ccatastral">
                 <p>
                    {{ $contracts->cve_ubica }}
                 </p>
             </div>
        </header>

        <section>
            <table class="t1">
                @foreach ($details as $detail)
                      <tr>
                        <td>{{  trim($detail->concept->descripcion) }} </td>
                        <td>{{  ((float)$detail->importe_a != 0) ? trim($detail->importe_a) : "" }} </td>
                        <td>{{  ((float)$detail->importe_v != 0) ? trim($detail->importe_v) : "" }} </td>
                      </tr>
                @endforeach
            </table>

            <div class="fact">FACTURACIÓN 2016</div>
            <div class="total_description">
                {{ $contracts->total_format }}
            </div>
            <div class="total1">
                  {{ $contracts->total }}
            <div class="logo_mes">
                <img class="logo_m" src="{{ asset('assets/img/receipt/mes_recib.png') }}">
            </div>
        </section>

        <aside>
           <table class="t2">

          </table>

          <div class="total2">

          </div>
          <div class="recibo2">

          </div>
        </aside>
        <footer>
          <table class="t3">

          </table>
          <div class="totalFA">

          </div>
          <table class="t4">

          </table>
          <div class="totalPA">1

          </div>

          <div class="tContrato"><p> </p></div>
          <div class="tRecibo"><p> </p></div>
          <div class="tSec"><p> </p></div>
          <div class="tRut"><p> </p></div>
          <div class="tFol"><p> </p></div>
          <div class="tVen"><p> </p></div>

          <div class="tContrato2"><p> </p></div>
          <div class="tRecibo2"><p> </p></div>
          <div class="tSec2"><p> </p></div>
          <div class="tRut2"><p> </p></div>
          <div class="tFol2"><p> </p></div>
          <div class="tVen2"><p> </p></div>

          <div class="barcode">

          </div>

          <div class="barcode2">

          </div>
        </footer>
      </div>
      <div style="page-break-after: always;">
      </div>

    </body>
</html>
