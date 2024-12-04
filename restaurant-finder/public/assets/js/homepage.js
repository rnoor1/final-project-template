// Wait until the DOM is fully loaded
document.addEventListener("DOMContentLoaded", () => {
    const restaurantListContainer = document.getElementById("restaurant-list");
    const searchInput = document.getElementById("search");
    const filterCategory = document.getElementById("filter-category");
    const detailsContainer = document.getElementById("restaurant-details");
    const apiUrl = "/api/restaurants";

    // Fetch and display the list of restaurants
    const fetchRestaurants = async () => {
        try {
            const response = await fetch(apiUrl);
            const restaurants = await response.json();

            if (restaurants.message) {
                restaurantListContainer.innerHTML = `<p>${restaurants.message}</p>`;
            } else {
                displayRestaurants(restaurants);
            }
        } catch (error) {
            console.error("Error fetching restaurants:", error);
            restaurantListContainer.innerHTML = `<p>Failed to load restaurants. Please try again later.</p>`;
        }
    };

    // Display restaurants in the list container
    const displayRestaurants = (restaurants) => {
        restaurantListContainer.innerHTML = restaurants.map((restaurant) => `
            <div class="restaurant-card">
                <h3>${restaurant.name}</h3>
                <p>Category: ${restaurant.category}</p>
                <p>Rating: ${restaurant.rating} / 5</p>
                <button class="view-details" data-id="${restaurant.id}">View Details</button>
            </div>
        `).join("");
    };

    // Search restaurants by name
    const searchRestaurants = async () => {
        const query = searchInput.value.trim().toLowerCase();
        try {
            const response = await fetch(`${apiUrl}?search=${query}`);
            const restaurants = await response.json();
            displayRestaurants(restaurants);
        } catch (error) {
            console.error("Error searching restaurants:", error);
            restaurantListContainer.innerHTML = `<p>Failed to search restaurants. Please try again later.</p>`;
        }
    };

    // Filter restaurants by category
    const filterRestaurants = async () => {
        const category = filterCategory.value;
        try {
            const response = await fetch(`${apiUrl}?category=${category}`);
            const restaurants = await response.json();
            displayRestaurants(restaurants);
        } catch (error) {
            console.error("Error filtering restaurants:", error);
            restaurantListContainer.innerHTML = `<p>Failed to filter restaurants. Please try again later.</p>`;
        }
    };

    // Handle "View Details" button click
    restaurantListContainer.addEventListener("click", async (event) => {
        if (event.target.classList.contains("view-details")) {
            const restaurantId = event.target.dataset.id;
            try {
                const response = await fetch(`/api/restaurant/${restaurantId}`);
                const restaurantDetails = await response.json();
                showRestaurantDetails(restaurantDetails);
            } catch (error) {
                console.error("Error fetching restaurant details:", error);
                detailsContainer.innerHTML = `<p>Failed to load restaurant details. Please try again later.</p>`;
                detailsContainer.style.display = "block";
            }
        }
    });

    // Display restaurant details
    const showRestaurantDetails = (details) => {
        detailsContainer.innerHTML = `
            <h2>${details.name}</h2>
            <p>${details.description}</p>
            <p>Category: ${details.category}</p>
            <p>Rating: ${details.rating} / 5</p>
            <button id="close-details">Close</button>
        `;
        detailsContainer.style.display = "block";

        // Close button functionality
        document.getElementById("close-details").addEventListener("click", () => {
            detailsContainer.style.display = "none";
        });
    };

    // Event listeners for search and filter inputs
    searchInput.addEventListener("input", searchRestaurants);
    filterCategory.addEventListener("change", filterRestaurants);

    // Initialize by fetching the list of restaurants
    fetchRestaurants();
});

