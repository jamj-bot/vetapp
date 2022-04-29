@if($pet->alerts)
    <div class="callout callout-info alert alert-dismissible text-sm pb-2 pt-2">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h6>Alerts</h6>
        {{ $pet->alerts }}
    </div>
@endif
@if($pet->diseases)
	<div class="callout callout-warning alert alert-dismissible text-sm pb-2 pt-2">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
			<h6>Pre-existing conditions</h6>
			{{ $pet->diseases }}
	</div>
@endif
@if($pet->allergies)
    <div class="callout callout-danger alert alert-dismissible text-sm pb-2 pt-2">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h6>Allergies</h6>
        {{ $pet->allergies }}
    </div>
@endif