<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Štatistiky</title>
    <?php include 'header.php'; ?>

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
    <style>
        #infoDiv {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: space-around;
            background-color: #81A594;
            width: 50%;
            margin-left: 25%;
            padding: 1rem;
            border-radius: 5px;
        }

        #infoDiv p {
            text-align: center;
        }

        #statistics th,
        #statistics td {
            border: 1px solid black;
            padding: 8px;
            text-align: center;
        }

        @media screen and (max-width: 800px) {
            #infoDiv {

                width: 94%;
                margin-left: 3%;
                padding: 0.5rem;
                border-radius: 5px;
            }
        }
    </style>

    <script>
        $(document).ready(function() {
            var table = $('#tabulka').DataTable({
                language: {
                    pageLength: "Show _MENU_ articles per page"
                },
                lengthMenu: [
                    [10, 25, -1],
                    [10, 25, "All"]
                ],
                paging: true,
                columnDefs: [{
                    "orderable": true,
                    "targets": [0, 1, 2]
                }],
                order: [
                    [0, 'asc'],
                    [1, 'desc']
                ],
            });



            fetch('http://localhost/api.php?countries')
                .then(response => response.json())
                .then(data => {
                    table.clear().draw();
                    data.forEach(country => {
                        table.row.add([
                            country.name,
                            country.country,
                            country.number
                        ]).draw();
                    });

                })
                .catch(error => {
                    console.error('Error fetching drinks:', error);
                });
           
        });

    </script>
</head>

<body>
    <table id="tabulka" style="width:100%">
        <thead>
            <tr>
                <th>Názov</th>
                <th>Krajina</th>
                <th>Počet vyhľadávaní</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
    <div id="infoDiv">
        <div>
            <h4>Počet návštevníkov</h4>
            <p id="visitors">51</p>
        </div>
        <table id="statistics">
            <thead>
                <tr>
                    <th>6:00-15:00</th>
                    <th>15:00-21:00</th>
                    <th>21:00-24:00</th>
                    <th>24:00-6:00.</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="td" id="tz1">10</td>
                    <td class="td" id="tz2">15</td>
                    <td class="td" id="tz3">10</td>
                    <td class="td" id="tz4">8</td>
                </tr>
            </tbody>
        </table>
    </div>
    <script>
        function clearTable() {
            let visitors = document.getElementById("visitors");
            let tz1 = document.getElementById("tz1");
            let tz2 = document.getElementById("tz2");
            let tz3 = document.getElementById("tz3");
            let tz4 = document.getElementById("tz4");
            visitors.innerHTML = '1';
            tz1.innerHTML = '1';
            tz2.innerHTML = '1';
            tz3.innerHTML = '1';
            tz4.innerHTML = '1';
        }

        function fillRow(data, rowId) {
            let row = document.getElementById('tz' + rowId);
            const keys = Object.keys(data[rowId]);
            const count = keys.length;
            row.innerHTML = count;
            return count;
        }

        function fillTable(data) {
            let visitors = document.getElementById("visitors");
            let count = 0;
            count += fillRow(data, '1');
            count += fillRow(data, '2');
            count += fillRow(data, '3');
            count += fillRow(data, '4');
            visitors.innerHTML = count;
        }
        clearTable();

        let tz1 = document.getElementById("tz1");
        let tz2 = document.getElementById("tz2");
        let tz3 = document.getElementById("tz3");
        let tz4 = document.getElementById("tz4");
        fetch('ip.json')
            .then(response => response.json())
            .then(data => {
                fillTable(data);
            });
    </script>
</body>

</html>