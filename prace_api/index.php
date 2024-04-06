<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thesis Data</title>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.11.5/datatables.min.css"/>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.11.5/datatables.min.js"></script>
    <style>
        #loader {
            display: none;
            position: fixed;
            z-index: 999;
            top: 50%;
            left: 50%;
            border: 16px solid #f3f3f3;
            border-radius: 50%;
            border-top: 16px solid #3498db;
            width: 120px;
            height: 120px;
            -webkit-animation: spin 2s linear infinite;
            animation: spin 2s linear infinite;
        }

        @-webkit-keyframes spin {
            0% { -webkit-transform: rotate(0deg); }
            100% { -webkit-transform: rotate(360deg); }
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body>
    <div id="loader"></div>
    <table id="thesisTable" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <th>Thesis Type</th>
                <th>Topic</th>
                <th>Supervisor</th>
                <th>Department</th>
                <th>Abstract</th>
                <th>Programme</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
    <script src="js/main.js"></script>
</body>
</html>

