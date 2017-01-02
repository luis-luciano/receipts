@foreach($contracts as $contract)
	{{ $contract["contract"]->contrato }} </br>
	{{ $contract["contract"]->receipt_number }}</br></br>
@endforeach