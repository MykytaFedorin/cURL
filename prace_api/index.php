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
      <div id="selectGroup">
        <label for="thesisTypeSelect">Choose thesis type</label>
        <select id="thesisTypeSelect" name="thesis_type">
          <option value="BT">BT</option>
          <option value="MT">MT</option>
        </select>
        <label for="departmentSelect">Choose department</label>
        <select id="departmentSelect" name="department">
          <option value="Institute of Automotive Mechatronics (FEI)">
                  Institute of Automotive Mechatronics (FEI)</option>
          <option value="Institute of Power and Applied Electrical Engineering (FEI)">
                  Institute of Power and Applied Electrical Engineering (FEI)</option>
          <option value="Institute of Electronics and Phototonics (FEI)">
                  Institute of Electronics and Phototonics (FEI)</option>
          <option value="Institute of Electrical Engineering (FEI)">
                  Institute of Electrical Engineering (FEI)</option>
          <option value="Institute of Computer Science and Mathematics (FEI)">
                  Institute of Computer Science and Mathematics (FEI)</option>
          <option value="Institute of Nuclear and Physical Engineering (FEI)">
                  Institute of Nuclear and Physical Engineering (FEI)</option>
          <option value="Institute of Multimedia Information and Communication Technologies (FEI)">
                  Institute of Multimedia Information and Communication Technologies (FEI)</option>
          <option value="Institute of Robotics and Cybernetics (FEI)">
                  Institute of Robotics and Cybernetics (FEI)</option>
        </select>
      </div>
    <table id="thesisTable" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <th>Topic</th>
                <th>Supervisor</th>
                <th>Programme</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
    <button id="refreshButton">GET</button>
    <script src="js/main.js"></script>
</body>
</html>

