<?php
include('../layout/header.php');

?>

<body class="d-flex flex-column min-vh-100 bg-light">
<div class="container flex-grow-1">
    <div class="row mx-3 mt-5">
        <div class="col-lg-12 mt-3">

           <h2  class="text-success mt-5">Search Results</h2>
            <div id="search" class="mt-3"></div>
        </div>
    </div>
</div>

    <?php include '../layout/footer.php'; ?>


    <script>
        const urlParams = new URLSearchParams(window.location.search);
        const query = urlParams.get('q');
        const suggestionBox = document.getElementById('search');

        function highlightMatch(text, query) {
            const regex = new RegExp(`(${query})`, 'gi');
            return text.replace(regex, '<mark style="background-color: yellow; padding: 0 2px; border-radius: 3px;">$1</mark>');
        }

        if (query && query.length > 1) {
            fetch(`http://localhost/test/pages/search_suggestion.php?q=${encodeURIComponent(query)}`)
                .then(response => response.json())
                .then(data => {
                    suggestionBox.innerHTML = '';
                    if (data.length === 0) {
                        suggestionBox.innerHTML = '<div>No remedies found.</div>';
                        return;
                    }

                    data.forEach(item => {
                        const highlightedName = highlightMatch(item.name, query);
                        const highlightedDesp = highlightMatch(item.desp, query);
                        const highlightedSymptoms = highlightMatch(item.symptoms, query);

                        const card = document.createElement('div');
                        card.className = 'card shadow-sm mb-3'; // Bootstrap card

                        card.innerHTML = `
                            <div class="card-body mt-3">
                                <h5 class="card-title text-success mb-2">${highlightedName}</h5>
                                <p class="card-text"><strong>Description:</strong> ${highlightedDesp}</p>
                                <p class="card-text"><strong>Symptoms:</strong> ${highlightedSymptoms}</p>
                            </div>
                        `;

                        // Add click event
                        card.onclick = function () {
                            window.location.href = `remedy_detail.php?id=${item.id}`;
                            // alert(`You clicked on ${item.name}`);
                        };

                        suggestionBox.appendChild(card);
                    });
                })
                .catch(error => {
                    console.error('Error fetching results:', error);
                    suggestionBox.innerHTML = '<div>Error loading remedies</div>';
                });
                
              
        } else {
            suggestionBox.innerHTML = '<div>No search query provided.</div>';
        }
    </script>

</body>
</html>
