document.addEventListener("DOMContentLoaded", function () {
  const searchBtn = document.getElementById("search-btn");
  const searchBox = document.getElementById("search-box");
  const dropdownResults = document.getElementById("dropdown-results");

  // Function to render dropdown results
  function renderResults(games) {
      dropdownResults.innerHTML = ""; // Clear existing results

      if (games.length === 0) {
          dropdownResults.innerHTML = "<p style='padding:10px;'>No results found.</p>";
          dropdownResults.style.display = "block";
          return;
      }

      games.forEach(game => {
          const item = document.createElement("div");
          item.className = "result-item";

          // Format price to two decimals
          const priceFormatted = parseFloat(game.price).toFixed(2);

          item.innerHTML = `
              <img src="${game.image}" alt="${game.name}">
              <h3>${game.name}</h3>
              <div class="price">$${priceFormatted}</div>
              <a href="#">View Game</a>
          `;

          // Add a click event to navigate to the game detail page in the Library
          item.addEventListener("click", function () {
              window.location.href = `/library`; // Adjust the route if needed
          });

          dropdownResults.appendChild(item);
      });
      dropdownResults.style.display = "block";
  }

  // Attach event listener to search button click
  searchBtn.addEventListener("click", function () {
      const query = searchBox.value.trim();
      if (!query) {
          dropdownResults.innerHTML = "<p style='padding:10px;'>Please enter a game name.</p>";
          dropdownResults.style.display = "block";
          return;
      }

      // Fetch search results via AJAX
      fetch(`/search?q=${encodeURIComponent(query)}`)
          .then(response => {
              if (!response.ok) {
                  throw new Error("Search request failed.");
              }
              return response.json();
          })
          .then(games => {
              renderResults(games);
          })
          .catch(error => {
              console.error(error);
              dropdownResults.innerHTML = "<p style='padding:10px;'>Error retrieving results.</p>";
              dropdownResults.style.display = "block";
          });
  });

  // Hide the dropdown when clicking outside the search box
  document.addEventListener("click", function (event) {
      if (!document.querySelector(".search-box").contains(event.target)) {
          dropdownResults.style.display = "none";
      }
  });
});
