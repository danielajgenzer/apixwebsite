<!doctype html>
<html lang="eng">
<head>
    <meta charset="utf-8">
    <title>localhost</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body>

    <div class="w3-sidebar w3-bar-block w3-card w3-animate-left" style="display:none" id="mySidebar">
        <button class="w3-bar-item w3-button w3-large"
                onclick="w3_close()">Schließen &times;</button>
        <a href="#" class="w3-bar-item w3-button">Dashboad</a>
        <a href="#" class="w3-bar-item w3-button">Einträge hinzufügen</a>
        <a href="#" class="w3-bar-item w3-button">Einträge löschen</a>
        <a href="#" class="w3-bar-item w3-button">Einträge bearbeiten</a>
    </div>

    <div id="main">
        <div class="w3-teal">
            <button id="openNav" class="w3-button w3-teal w3-xlarge" onclick="w3_open()">&#9776;</button>
            <div class="w3-container">
                <h1 style="text-align: center">NGINX Webserver</h1>
            </div>
            <p style="text-align: center">Dieser Webserver soll mit einer CRUD API verbunden werden. Dabei sollen die Abfragen, GET, POST, PUT, DELETE mittels POSTMAN funktionieren</p>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-sm mb-4 b-sm">
                <div class="card-body" >
                    <table class="w3-table table-striped-columns" style="display: block; border: 2px solid #00807c; height: 650px; overflow-y: scroll">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Passwort</th>
                                <th>Email</th>
                            </tr>
                        </thead>
                        @foreach ($users as $user)
                        <tbody >
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->password }}</td>
                                <td>{{ $user->email }}</td>
                            </tr>
                        </tbody>
                        @endforeach
                    </table>
                </div>
            </div>

            <dialog id="favDialog">
                <form method="POST" action="{{ route('add') }}" id="userForm">
                    @csrf
                    <label for="name">Name:</label>
                    <input type="text" name="name" id="name">

                    <label for="password">Password:</label>
                    <input type="password" name="password" id="password">

                    <label for="email">Email:</label>
                    <input type="text" name="email" id="email">

                    <button class="btn btn-secondary" type="submit">Bestätigen</button>
                </form>
            </dialog>

            <menu>
                <button type="button" class="btn btn-secondary" id="updateDetails">Benutzer hinzufügen</button>
            </menu>

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

        </div>
    </div>
</body>

<script>
    function w3_open()
    {
        document.getElementById("main").style.marginLeft = "25%";
        document.getElementById("mySidebar").style.width = "25%";
        document.getElementById("mySidebar").style.display = "block";
        document.getElementById("openNav").style.display = 'none';
    }

    function w3_close()
    {
        document.getElementById("main").style.marginLeft = "0%";
        document.getElementById("mySidebar").style.display = "none";
        document.getElementById("openNav").style.display = "inline-block";
    }


    (() =>
    {
        const updateButton = document.getElementById("updateDetails");
        const closeButton = document.getElementById("close");
        const dialog = document.getElementById("favDialog");
        dialog.returnValue = "favAnimal";

        function openCheck(dialog)
        {
            if (dialog.open)
            {
                console.log("Dialog open");
            } else
            {
                console.log("Dialog closed");
            }
        }

        updateButton.addEventListener("click", () => {
            dialog.showModal();
            openCheck(dialog);
        });

        closeButton.addEventListener("click", () => {
            dialog.close("animalNotChosen");
            openCheck(dialog);
        });
    })();

    document.getElementById('userForm').addEventListener('submit', function (event)
    {
        event.preventDefault();

        fetch('/addUser',
        {
            method: 'POST',
            body: new FormData(this),
        })
            .then(response => response.json())
            .then(data => {
                console.log(data);
            })
            .catch(error => console.error('Error:', error));
    });

    document.getElementById('deleteUserForm').addEventListener('submit', function (event)
    {
        event.preventDefault();

        if (confirm('Möchtest du diesen Benutzer wirklich löschen?'))
        {
            fetch(this.action,
            {
                method: 'POST',
                body: new FormData(this),
            })

            .then(response => response.json())
            .then(data =>
            {
                console.log(data.message);
            })
            .catch(error => console.error('Error:', error));
        }
    });


</script>
</html>
