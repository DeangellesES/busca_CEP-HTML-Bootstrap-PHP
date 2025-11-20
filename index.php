<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Busca CEP</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>

<body>
    <div class="container mt-5">
        <h1 class="text-center">Buscar Endereço por CEP</h1>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <form action="" method="post" class="mt-3">
                    <div class="mb-3">
                        <label for="form-label">Digite o seu CEP</label>
                        <div class="input-group">
                            <input type="text" class="form-control" name="cep" placeholder="Exe.: 81.000.000" require>
                            <button type="submit" class="btn btn-primary">Buscar</button>
                        </div>
                    </div>

                </form>

                <?php
                $post = filter_input(INPUT_POST, 'cep', FILTER_SANITIZE_SPECIAL_CHARS);
                if (isset($post)) {
                    // https://brasilapi.com.br/api/cep/v1

                    $cep = preg_replace('/[^0-9]/', '', $post);

                    $url = "https://brasilapi.com.br/api/cep/v1/{$cep}";

                    $ch = curl_init();

                    curl_setopt($ch, CURLOPT_URL, $url);

                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                    $response = curl_exec($ch);

                    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

                    curl_close($ch);

                    if ($httpCode === 200) {
                        $data = json_decode($response, true);

                        echo '
                            <div class="card mt-3">
                                <div class="card-body">
                                    <div class="alert alert-success">
                                        <h5 class="card-title"></h5>
                                        <p><strong>CEP:</strong>'.$data['cep'].'</p>
                                        <p><strong>Estado:</strong>'.$data['state'].'</p>
                                        <p><strong>Cidade:</strong>'.$data['city'].'</p>
                                        <p><strong>Endereço:</strong>'.$data['street'].'</p>
                                        <p><strong>Bairro:</strong>'.$data['neighborhood'].'</p>
                                    </div>
                                </div>
                            </div>
                        ';

                    } else {
                        echo '<div class="alert alert-danger">CEP Inválido</div>';
                    }
                }



                ?>


            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>

</html>