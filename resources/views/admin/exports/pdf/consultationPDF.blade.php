<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Examination report | {{ $petPDF->name }}</title>

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('pdf/styles.css') }}">
    {{--  <link rel="stylesheet" href="{{ asset('css/app.css') }}"> --}}
</head>

<body>
    <header>
        <img loading="lazy" src="vendor/adminlte/dist/img/veterinary.png" alt="Logo">
        <h1>Veterinary Services</h1>
        <h3>Examination report</h3>
    </header>

    <section>
        <div class="row" style="text-align: right;">
            <b>Veterinary: </b>{{ $consultationPDF->user->name }} DVM <br>
            <b>Consultation date: </b>{{ $consultationPDF->updated_at->format('d-M-Y h:i A') }}
        </div>
        <div class="row">
            <div class="column" style="margin-right: 1%;">
                <h4>Pet</h4>
                <h5>General information</h5>
                <ul>
                    <li>
                        <b>Name: </b>{{ $petPDF->name ? $petPDF->name : 'n/a' }}
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
                        <b>Age: </b>{{ $consultationPDF->age }}
                    </li>
                    <li>
                        <b>Desexed: </b>{{ $petPDF->desexed }}
                        @if( $petPDF->desexed != 'Desexed')
                            {{$petPDF->desexing_candidate ? '(candidate)' : '(not candidate)'}}
                        @endif
                    </li>
                </ul>
                <h5>Pre-existing conditions</h5>
                @if($petPDF->diseases)
                    <p class="highlighted">{{ $petPDF->diseases }}</p>
                @else
                    <p class="highlighted"> n/a </p>
                @endif
                <h5>Allergies</h5>
                @if($petPDF->allergies)
                    <p class="highlighted">{{ $petPDF->allergies }}</p>
                @else
                    <p class="highlighted"> n/a </p>
                @endif

            </div>

            <div class="column">
                <h4>Consultation</h4>
                <h5>Vital statics</h5>
                <ul>
                    <li>
                        <b>Weight: </b>{{ $consultationPDF->weight }} kilograms
                    </li>
                    <li>
                        <b>Temperature: </b>{{ $consultationPDF->temperature }} °C
                    </li>
                    <li>
                        <b>Oxygen saturation level: </b>{{ $consultationPDF->oxygen_saturation_level }}%
                    </li>
                    <li>
                        <b>Capillary refill time: </b>{{ $consultationPDF->capillary_refill_time }}
                    </li>
                    <li>
                        <b>Heart rate: </b>{{ $consultationPDF->heart_rate }} beats per second
                    </li>
                    <li>
                        <b>Pulse: </b>{{ $consultationPDF->pulse }}
                    </li>
                    <li>
                        <b>Respiratory rate: </b> {{ $consultationPDF->respiratory_rate }} breaths per minute
                    </li>
                </ul>

                <br>

                <h5>More information</h5>
                <ul>
                    <li>
                        <b>Reproductive statud: </b>{{ $consultationPDF->reproductive_status }}
                    </li>
                    <li>
                        <b>Consciousness: </b>{{ $consultationPDF->consciousness }}
                    </li>
                    <li>
                        <b>Hydration: </b>{{ $consultationPDF->hydration }}
                    </li>
                    <li>
                        <b>Pain: </b>{{ $consultationPDF->pain }}
                    </li>
                    <li>
                        <b>Body condition: </b>{{ $consultationPDF->body_condition }}
                    </li>
                </ul>
            </div>
        </div>

        <div class="page-break"></div>

        <div class="row">
            <p>
                {!! $consultationPDF->problem_statement !!}
            </p>
        </div>

        <div class="page-break"></div>

        <div class="row">
            <h4>Diagnosis</h4>
            <p class="highlighted">{{ $consultationPDF->diagnosis }}</p>
        </div>

         <div class="row">
            <h4>Prognosis</h4>
            <p class="highlighted">{{ $consultationPDF->prognosis }}</p>
        </div>

        <div class="row">
            <h4>Treatment plan</h4>
            <p>{{ $consultationPDF->treatment_plan }}</p>
        </div>
    </section>
</body>
</html>