
window.addEventListener("DOMContentLoaded", (event) => {
    // Toggle the side navigation
    const sidebarToggle = document.body.querySelector(".sidebar-toggle");

    const sidebar = document.querySelector("#sidebar");

    if (sidebarToggle && sidebar) {
        // Uncomment Below to persist sidebar toggle between refreshes
        if (localStorage.getItem("sidebar-collapsed") === "true") {
            sidebar.classList.add("collapsed");
        }
        sidebarToggle.addEventListener("click", (event) => {
            event.preventDefault();

            sidebar.classList.toggle("collapsed");

            localStorage.setItem(
                "sidebar-collapsed",
                sidebar.classList.contains("collapsed")
            );
        });
    }
});
