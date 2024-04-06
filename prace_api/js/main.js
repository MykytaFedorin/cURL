async function fetchData() {
    var requestData = {
        "department": "Institute of Computer Science and Mathematics - FEI",
        "thesis_type": "Dissertation thesis"
    };

    try {
        const response = await fetch('https://node34.webte.fei.stuba.sk/zadanie2/prace_api/prace', {
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
        console.log("au");

        $('#thesisTable').DataTable({
            data: responseData,
            columns: [
                { data: 'thesis_type' },
                { data: 'topic' },
                { data: 'supervisor' },
                { data: 'department' },
                { data: 'abstract_' },
                { data: 'programme' }
            ]
        });
    } catch (error) {
        $('#loader').hide();
        console.error(error.message);
    }
}

fetchData();

