document.addEventListener("DOMContentLoaded", () => {
    const packagesContainer = document.getElementById('packages-container');
    
    // Fetch travel packages from the JSON file
    fetch('packages.json')
        .then(response => response.json())
        .then(data => {
            data.forEach(package => {
                const packageElement = document.createElement('div');
                packageElement.classList.add('package');
                packageElement.innerHTML = `
                    <h3>${package.title}</h3>
                    <p>${package.duration}</p>
                    <button class="details-btn" data-title="${package.title}" data-details="${JSON.stringify(package.details)}">View Details</button>
                `;
                packagesContainer.appendChild(packageElement);
            });

            // Event listener for detail buttons
            document.querySelectorAll('.details-btn').forEach(button => {
                button.addEventListener('click', () => {
                    const title = button.getAttribute('data-title');
                    const details = JSON.parse(button.getAttribute('data-details'));
                    showModal(title, details);
                });
            });
        })
        .catch(error => console.error('Error fetching packages:', error));

    // Modal functionality
    const modal = document.getElementById("myModal");
    const closeBtn = document.getElementsByClassName("close")[0];

    function showModal(title, details) {
        document.getElementById('modal-package-name').textContent = title;
        document.getElementById('modal-package-details').innerHTML = `
            <strong>Overview:</strong> ${details.overview}<br>
            <strong>Itinerary:</strong><ul>${details.itinerary.map(day => `<li>Day ${day.day}: ${day.activities.join(', ')}</li>`).join('')}</ul>
            <strong>Pricing:</strong> ${details.pricing}
        `;
        modal.style.display = "block";
    }

    closeBtn.onclick = function() {
        modal.style.display = "none";
    }

    window.onclick = function(event) {
        if (event.target === modal) {
            modal.style.display = "none";
        }
    }
});
