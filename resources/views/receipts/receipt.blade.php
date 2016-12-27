<DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8"/>
        <title>Recibos</title>
        <link href="{{ asset('assets/css/receipt.css') }}" rel="stylesheet">
        <link rel="shortcut icon" href="favicon"/>
    </head>
    <body>

    @foreach($contracts as $contract)
      <div class="row">
          <header>
             <div class="contrato">
                 <p>{{ (int)$contract["contract"]->contrato }}</p>
             </div>

             <div class="recibo1">
                 <p>{{ $contract["contract"]->receipt_number }}</p>
             </div>

             <div class="vencim">
                 <p>{{ $contract["contract"]->due_date }}</p>
             </div>

             <div class="mesF">
                 <p>{{ $contract["contract"]->invoiced_month }}</p>
             </div>

             <div class="medidor">
                 <p>{{ trim($contract["contract"]->medidor) }}</p>
             </div>

             <div class="sec">
                 <p>{{ $contract["contract"]->sector }}</p>
             </div>

             <div class="rut">
                 <p>{{ $contract["contract"]->ruta }}</p>
             </div>

             <div class="folio">
                 <p>{{ $contract["contract"]->folio }}</p>
             </div>

            @if(!is_null($contract["lecture"]))
                <div class="ant">
                    <p>
                       {{ $contract["lecture"]->lec_anterior}}
                    </p>
                </div>
                <div class="act">
                    <p>
                       {{ $contract["lecture"]->lec_actual}}
                    </p>
                </div>
                <div class="consm">
                    <p>
                       {{ $contract["lecture"]->consumo}}
                    </p>
                </div>
            @endif

             <div class="prom">
                 <p>
                    {{ $contract["contract"]->cons_promedio }}
                 </p>
             </div>
             <div class="mrezago">
                 <p>
                    {{ $contract["contract"]->pagos_ven }}
                 </p>
             </div>

             <div class="nombre">
                 <p>
                    {{ trim($contract["contract"]->nombre) }}
                 </p>
             </div>
             <div class="rfc">
                 <p>
                    {{ trim($contract["contract"]->rfc_u) }}
                 </p>
             </div>
             <div class="tarifa">
                 <p>
                    {{ $contract["contract"]->rate_description }}
                </p>
             </div>
             <div class="direcc">
                 <p>
                    {!! $contract["contract"]->service_address !!}
                </p>
             </div>
             <div class="direccF">
                <p>
                    {{ $contract["contract"]->fiscal_address }}
                </p>
             </div>
             <div class="ccatastral">
                 <p>
                    {{ $contract["contract"]->cve_ubica }}
                 </p>
             </div>
        </header>

        <section>
            <table class="t1">
            @if(!is_null($contract["details"]))
               @foreach ($contract["details"] as $detail)
                      <tr>
                        <td>{{  trim($detail->concept_description) }} </td>
                        <td>{{  ((float)$detail->importe_a != 0) ? trim($detail->importe_a) : "" }} </td>
                        <td>{{  ((float)$detail->importe_v != 0) ? trim($detail->importe_v) : "" }} </td>
                      </tr>
                @endforeach
            @endif
            </table>

            <div class="fact">FACTURACIÓN 2016</div>
            <div class="total_description">
                {{ $contract["contract"]->total_format }}
            </div>
            <div class="total1">
                  {{ $contract["contract"]->total }}
            </div>
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
          <div class="totalPA">

          </div>

          <div class="tContrato">
              <p>
                  {{ $contract["contract"]->contrato }}
              </p>
          </div>
          <div class="tRecibo">
              <p>
                  {{ $contract["contract"]->ReceiptNumber }}
              </p>
          </div>
          <div class="tSec">
              <p>
                  {{ $contract["contract"]->sector }}
              </p>
          </div>
          <div class="tRut">
              <p>
                  {{ $contract["contract"]->ruta }}
              </p>
          </div>
          <div class="tFol">
              <p>
                  {{ $contract["contract"]->folio }}
              </p>
          </div>
          <div class="tVen">
              <p>
                  {{ $contract["contract"]->due_date }}
              </p>
          </div>

          <div class="tContrato2"><p> </p></div>
          <div class="tRecibo2"><p> </p></div>
          <div class="tSec2"><p> </p></div>
          <div class="tRut2"><p> </p></div>
          <div class="tFol2"><p> </p></div>
          <div class="tVen2"><p> </p></div>

          <div class="barcode">
              {!! DNS1D::getBarcodeHTML($contract["contract"]->monthly_payment_reference, "C128",0.7,30) !!}
          </div>

          <div class="barcode2">

          </div>
        </footer>
    </div>

    <div style="page-break-after: always;">
    </div>
  @endforeach

    </body>
</html>
