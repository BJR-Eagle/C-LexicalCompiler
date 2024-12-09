<!DOCTYPE html>
<html>

<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Page Title</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel='stylesheet' type='text/css' media='screen' href='main.css'>
    <script src='main.js'></script>
</head>

<body>
    <div class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{session('error')}}
                        </div>
                    @endif
                    @if(session('sucess'))
                        <div class="alert alert-sucess">
                            {{session('sucess')}}
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <section>
            <form action="{{ route('lexar.compiler')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div id="fileInputGroup" class="mb-3">
                    <label for="code" class="form-label"> Upload C file</label>
                    <input type="file" id="code" name="code" class="form-control">
                </div>
                <button class="btn btn-primary" id="butao"> Analise</button>
            </form>
            @if(session('tokens'))
                <div class="mt-5">
                    <h3>Resultado Tabela de Tokens</h3>
                    <p><strong>Total Tokens:</strong> {{ count(session('tokens'))}}</p>
                </div>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Tipo</th>
                            <th>valor</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach(session('tokens') as $token)
                            <tr>
                                <td>{{ $token['type'] }}</td>
                                <td>{{ $token['value'] }}</td>
                                @if(isset($token['ID']))
                                    <td>{{ $token['ID'] }}</td>
                                @else
                                    <td></td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
            @if(session('tokens'))
                <div class="mt-5">
                    <h3>Resultado tabela Simbolo</h3>
                </div>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Tipo</th>
                            <th>valor</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach (session('tokens') as $simbol)
                            <tr>
                                @if(isset($simbol['ID']) && !isset($printedSimbols[$simbol['ID']]))
                                    <td>{{ $simbol['ID'] }}</td>
                                    <td>{{ $simbol['value'] }}</td>
                                    @php            $printedSimbols[$simbol['ID']] = true; @endphp
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </section>
    </div>
</body>

</html>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>