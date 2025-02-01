// Show a specific page and hide others
function showPage(pageId) {
    document.querySelectorAll('.page').forEach(page => {
        page.style.display = page.id === pageId ? 'block' : 'none';
    });
}

// Fetch and display donors
function fetchDonorData() {
    fetch('fetch_donors.php')
        .then(response => response.json())
        .then(data => {
            const donorTableBody = document.getElementById('donorTableBody');
            donorTableBody.innerHTML = ''; // Clear table
            data.forEach(donor => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${donor.firstName}</td>
                    <td>${donor.lastName}</td>
                    <td>${donor.dob}</td>
                    <td>${donor.gender}</td>
                    <td>${donor.bloodType}</td>
                    <td>${donor.phone}</td>
                    <td>${donor.lastDonation || 'N/A'}</td>
                    <td>${donor.location}</td>
                    <td>${donor.aadharCardNumber}</td>
                    <td><button onclick="deleteDonor('${donor.aadharCardNumber}')">Delete</button></td>
                `;
                donorTableBody.appendChild(row);
            });
        })
        .catch(error => console.error('Error fetching donors:', error));
}

// Delete donor by Aadhar Card Number
function deleteDonor(aadharCardNumber) {
    if (confirm('Are you sure you want to delete this donor?')) {
        fetch('delete_donor.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `aadharCardNumber=${encodeURIComponent(aadharCardNumber)}`
        })
        .then(response => response.json())
        .then(result => {
            alert(result.success ? result.message : 'Error: ' + result.message);
            fetchDonorData(); // Refresh donor list
        })
        .catch(error => console.error('Error deleting donor:', error));
    }
}






function fetchBloodNeeders() {
    fetch('filter_blood_needers.php')
        .then(response => response.json())
        .then(data => {
            const tableBody = document.getElementById('bloodNeedersTableBody');
            tableBody.innerHTML = ''; // Clear previous data

            if (data.length > 0) {
                data.forEach(needer => {
                    const row = `
                        <tr>
                            <td>${needer.name}</td>
                            <td>${needer.location}</td>
                            <td>${needer.blood_type}</td>
                            <td>${needer.contact}</td>
                        </tr>
                    `;
                    tableBody.innerHTML += row;
                });
            } else {
                tableBody.innerHTML = '<tr><td colspan="4">No data found</td></tr>';
            }
        })
        .catch(error => console.error('Error fetching blood needers:', error));
}

function filterBloodNeeders(event) {
    event.preventDefault(); // Prevent form submission

    const location = document.getElementById('filterLocation').value;
    const bloodType = document.getElementById('filterBloodType').value;

    fetch(`filter_blood_needers.php?location=${encodeURIComponent(location)}&blood_type=${encodeURIComponent(bloodType)}`)
        .then(response => response.json())
        .then(data => {
            const tableBody = document.getElementById('bloodNeedersTableBody');
            tableBody.innerHTML = ''; // Clear previous data

            if (data.length > 0) {
                data.forEach(needer => {
                    const row = `
                        <tr>
                            <td>${needer.name}</td>
                            <td>${needer.location}</td>
                            <td>${needer.blood_type}</td>
                            <td>${needer.contact}</td>
                        </tr>
                    `;
                    tableBody.innerHTML += row;
                });
            } else {
                tableBody.innerHTML = '<tr><td colspan="4">No data found</td></tr>';
            }
        })
        .catch(error => console.error('Error filtering blood needers:', error));
}





















