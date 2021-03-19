<!DOCTYPE html>
<html lang="en">
<head>
    <title>Welcome to sofoste</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!--my CSS-->
    <link rel="stylesheet" href="styles_1.css">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1"
          crossorigin="anonymous">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body class="bg-light">
<div class="card card-header text-center text-monospace text-success text-uppercase fixed-top" id="header">
    {- sofoste - Ensuring a better future for our city - Mangwa -}
</div>
<div class="jumbotron jumbotron-fluid m-3 text-monospace">
    <div class="container">
        <h1 class="display-3">Welcome to So<sub class="text-info">b&gt;</sub>foste virtual Library</h1>
        <p class="lead">Building a new Lib..</p>
        <hr class="my-2 bg-danger">

        <p><a class="btn btn-outline-success"
              href="#">This Lib contains all the books you need..</a></p>
        <div class="d-flex position-relative">
            <img src="lib.jpg" class="flex-shrink-0 me-3" alt="library" id="lib-img">
            <div class="m-3">
                <h5 class="mt-0">A short presentation</h5>
                <p class="card-text">This is the beginning of a big project. We want to,
                    create a virtual library to store useful resources for our town.
                    This library will be one of the first of its type. It will be provided
                    with a multitude of multidisciplinary documents; books covering subjects
                    such as geology, geography, computer science, mathematics, astronomy,
                    medicine, physics, chemistry, literature, artificial intelligence, robotics etc.
                    There will be a suitable choice for everyone.
                </p>
                <a href="README.md" class="btn-link">See the README file</a>
            </div>
        </div>
        <div class="m-3">
            <a class="btn btn-primary btn-lg" href="https://dev.d2eok1re6b88kx.amplifyapp.com"
               role="button">See online version..</a>
        </div>
        <hr class="my-2 bg-danger">
        <p class="card-text text-muted font-weight-bolder">
            PHP version used: <em><?php $version = phpversion(); echo $version?></em><br>
            Languages: <em>PHP, HTML, CSS.</em><br>
            Useful doc: <em><a href="https://www.php.net/manual/en/">php documentation</a></em>
        </p>
    </div>
    <!--content-->

    <!--footer-->
    <div class="card-footer text-center text-warning fixed-bottom" id="footer">
        &copy; sofoste 2021 | php developer | contact:
        <a href="mailto:sobsteph41@yahoo.com" class="stretched-link text-success">
        Steph Fouodji
    </a>
    </div>
</div>

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous">
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
        crossorigin="anonymous">
</script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
        crossorigin="anonymous">
</script>
</body>
</html>