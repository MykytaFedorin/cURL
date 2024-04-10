async function fetchData() {
    const dep = $("#departmentSelect").val();
    const thesisType = $("#thesisTypeSelect").val();
    const requestData = {
        department: dep,
        thesis_type: thesisType,
    };

    try {
        const response = await fetch("/prace_api/prace", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
            },
            body: JSON.stringify(requestData),
        });

        if (!response.ok) {
            throw new Error("Network response was not ok");
        }

        const responseData = await response.json();
        $("#loader").hide();

        if ($.fn.DataTable.isDataTable("#thesisTable")) {
            // DataTables already initialized, destroy it first
            $("#thesisTable").DataTable().destroy();
        }
        $("#thesisTable").DataTable({
            data: responseData,
            columns: [
                {
                    data: "topic",
                    render: function (data, type, row) {
                        // Проверяем, что это отображение в таблице
                        if (type === "display") {
                            // Создаем ссылку с названием темы
                            return `<a href="${row.abstractUrl}">${data}</a>`;
                        }
                        // Для остальных случаев возвращаем исходные данные
                        return data;
                    },
                },
                { data: "supervisor" },
                { data: "programme" },
            ],
        });
    } catch (error) {
        $("#loader").hide();
        console.error(error.message);
    }
}

// Получаем кнопку по id
const refreshButton = document.getElementById("refreshButton");

// Добавляем обработчик события click
refreshButton.addEventListener("click", async () => {
    // Вызываем функцию fetchData() при клике на кнопку
    await fetchData();
});
fetchData();
$("#myTable").DataTable();
