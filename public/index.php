<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>JSON validator</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <meta name="description" content="">
    <title>Opis JSON validator</title>
    <link href="https://getbootstrap.com/docs/5.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="icon" href="resources/favicon.ico">
    <meta name="theme-color" content="#712cf9">
    <style>
        .nav-scroller .nav {
            display: flex;
            flex-wrap: nowrap;
            padding-bottom: 1rem;
            margin-top: -1px;
            overflow-x: auto;
            text-align: center;
            white-space: nowrap;
            -webkit-overflow-scrolling: touch;
        }

        #result {
            display: none;
        }
    </style>
</head>
<body class="bg-light">
<div class="container">
    <main>
        <div class="py-5 text-center">
            <img class="d-block mx-auto mb-4" src="resources/json-logo.svg" alt="" width="72" height="57">
            <h2>Json Validator</h2>
            <p class="lead">Put some introduction here</p>
        </div>

        <div class="row">
            <div class="col-md-12 col-lg-12">
                <form class="needs-validation" novalidate>
                    <div class="row g-3">
                        <div class="col-sm-6">
                            <label for="json-data" class="form-label">JSON</label>
                            <textarea class="form-control" id="json-data" rows="10"></textarea>
                            <div class="invalid-feedback">
                                Valid first name is required.
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <label for="json-schema" class="form-label">Schema</label>
                            <textarea class="form-control" id="json-schema" rows="10"></textarea>
                            <div class="invalid-feedback">
                                Valid last name is required.
                            </div>
                        </div>
                    </div>

                    <hr class="my-4">
                    <div class="alert" role="alert" id="result"></div>
                    <hr class="my-4">

                    <button class="w-100 btn btn-primary btn-lg" id="validate" type="button">Check</button>
                </form>
            </div>
        </div>
    </main>

    <footer class="my-5 pt-5 text-muted text-center text-small">
        <p class="mb-1">&copy; 2022 Tlab</p>
    </footer>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
<script>
    $(function(){
        $( "#validate" ).on( "click", function() {
            let jsonData = JSON.parse($("#json-data").val());
            let jsonSchema = JSON.parse($("#json-schema").val());

            let settings = {
                "url": "validator.php",
                "method": "POST",
                "timeout": 0,
                "headers": {
                    "Content-Type": "application/json"
                },
                "data": JSON.stringify({
                    "data": jsonData,
                    "schema": jsonSchema
                }),
            }

            $.ajax(settings).done(function (response) {
                let resultElement = $("#result");
                if(response.valid) {
                    resultElement
                        .removeClass('alert-danger')
                        .addClass('alert-success')
                        .html('Json is valid')
                        .show();
                    return;
                }

                if(!response.valid) {
                    let errorKeys = Object.keys(response.message);
                    console.log(errorKeys);
                    resultElement.html('');
                    errorKeys.forEach(
                        (errorKey) => {
                            $("#result").append('<div><b>' + errorKey + '</b>: ' + response.message[errorKey] + '</div>');
                        }
                    );

                    resultElement
                        .removeClass('alert-success')
                        .addClass('alert-danger').show();
                }
            });
        });
    });
</script>
</body>
</html>
