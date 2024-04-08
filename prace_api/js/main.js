async function fetchData() {
    const dep = $("#departmentSelect").val();
    const thesisType = $("#thesisTypeSelect").val();
    const requestData = {
        department: dep,
        thesis_type: thesisType
    };

    try {
        const response = await fetch('http://localhost/prace_api/prace', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(requestData)
        });

        if (!response.ok) {
            throw new Error('Network response was not ok');
        }

        const responseData = await response.json();
        $('#loader').hide();
        console.log(response);
        console.log(responseData);

        if ($.fn.DataTable.isDataTable('#thesisTable')) {
            // DataTables already initialized, destroy it first
            $('#thesisTable').DataTable().destroy();
        }
        $('#thesisTable').DataTable({
            data: responseData,
            columns: [
                { data: 'topic' },
                { data: 'supervisor' },
                { data: 'programme' }
            ]
        });
    } catch (error) {
        $('#loader').hide();
        console.error(error.message);
    }
}

// Получаем кнопку по id
const refreshButton = document.getElementById('refreshButton');

// Добавляем обработчик события click
refreshButton.addEventListener('click', async () => {
    // Вызываем функцию fetchData() при клике на кнопку
    await fetchData();
});
fetchData();
$('#myTable').DataTable();
