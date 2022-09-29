<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Vaccination report | {{ $petPDF->name }}</title>

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('pdf/styles.css') }}">
</head>

<body>
    <header>
        <img loading="lazy" src="vendor/adminlte/dist/img/veterinary.png" alt="Logo">
        <h1>Veterinary Services</h1>
        <h3>Vaccination report</h3>
    </header>

{{--     @foreach($dewormingsPDF as $deworming)
        {{$deworming->type}}
    @endforeach --}}
    {{-- {{$dewormingsPDF}} --}}
     <section>
        <div class="row" style="text-align: right;">
            <b>Expedition date: </b>{{ now()->format('d-M-Y h:i A') }}
        </div>

        <div class="row">
            <h4>Pet</h4>
            <h5>General information</h5>
            <ul>
                <li>
                    <b>Name: </b>{{ $petPDF->name }}
                </li>
                <li >
                    <b>Code: </b>{{ $petPDF->code }}
                </li>
                <li>
                    <b>Species: </b>{{ $petPDF->species->name }} / {{ $petPDF->species->scientific_name }}
                </li>
                <li>
                    <b>Breed: </b>{{ $petPDF->breed }}
                </li>
                <li>
                    <b>Zootechnical function: </b>{{ $petPDF->zootechnical_function }}
                </li>
                <li>
                    <b>Sex: </b>{{ $petPDF->sex }}
                </li>
                <li>
                    <b>Age: </b>{{ $petPDF->dob->format('d-M-Y') }}
                </li>
                <li>
                    <b>Neutered/spayed: </b>{{ $petPDF->neuteredOrSpayed }}
                </li>
            </ul>
            <h5>Pre-existing conditions</h5>
            @if($petPDF->diseases)
                <p class="highlighted">{{ $petPDF->diseases }}</p>
            @else
                <p class="highlighted"> N/A </p>
            @endif
            <h5>Allergies</h5>
            @if($petPDF->allergies)
                <p class="highlighted">{{ $petPDF->allergies }}</p>
            @else
                <p class="highlighted"> N/A </p>
            @endif
        </div>

        <div class="page-break"></div>

        <h4>Deworming history</h4>
        <table>
            <thead>
                <tr>
                    <td colspan="3">Parasiticide</td>
                    <td>Progress</td>
                    <td>Applied</td>
                    <td>Next application</td>
                </tr>
            </thead>
            <tbody>
                 @foreach($dewormingsPDF as $deworming)
                    <tr>
                        <td style="width: auto;border-left: 1px solid #ddd; text-align: left;">{{ $deworming->type }}</td>
                        <td style="width: auto;text-align: left;"width="10px">{{ $deworming->name }}</td>
                        <td style="width: auto;text-align: left;"width="10px">{{ $deworming->manufacturer }}</td>
                        <td style="text-align: center; border-right: 1px solid #ddd;">{{ $deworming->dose_number }} / {{ $deworming->doses_required }}</td>
                        <td style="text-align: center;" class="danger">{{ $deworming->updated_at->format('d-M-Y') }}</td>
                        <td style="text-align: center;"> {{ $deworming->duration }}</td>
{{--                         <td style="width: auto;text-align: center;"width="10px">{{ $vaccination->status }}</td>
                        <td>{{ $vaccination->batch_number }}</td>--}}


{{--                         @if($deworming->applied)
                            <td style="text-align: center;" class="success">{{ $deworming->done->format('d-M-Y') }}</td>
                        @elseif(!$deworming->applied)
                            @if($deworming->done->isPast())
                                <td style="text-align: center;" class="danger">{{ $deworming->done->format('d-M-Y') }}</td>
                            @else
                                <td style="text-align: center;" class="warning">{{ $deworming->done->format('d-M-Y') }}</td>
                            @endif
                        @endif --}}
                    </tr>
                @endforeach
            </tbody>
        </table>
        <hr>
        <table>
            <tfoot>
                <tr>
                    <td style="width: 33.33333%" class="success">Applied</td>
                    <td style="width: 33.33333%" class="warning">Scheduled</td>
                    <td style="width: 33.33333%" class="danger">Delayed</td>
                </tr>
            </tfoot>
        </table>

    </section>
</body>
</html>