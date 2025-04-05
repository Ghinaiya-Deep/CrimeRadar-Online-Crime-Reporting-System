document.addEventListener("DOMContentLoaded", function () {
    const sidebar = document.querySelector("nav");
    const dashboard = document.querySelector(".dashboard");
    const toggleButton = document.querySelector(".sidebar-toggle");

    if (!sidebar || !toggleButton || !dashboard) {
        console.error("Sidebar, dashboard, or toggle button not found.");
        return;
    }

    // Load previous sidebar state
    if (localStorage.getItem("sidebarStatus") === "close") {
        sidebar.classList.add("close");
        dashboard.classList.add("expanded");
    }

    // Toggle sidebar on click
    toggleButton.addEventListener("click", function () {
        sidebar.classList.toggle("close");
        dashboard.classList.toggle("expanded");

        // Save sidebar state to localStorage
        if (sidebar.classList.contains("close")) {
            localStorage.setItem("sidebarStatus", "close");
        } else {
            localStorage.setItem("sidebarStatus", "open");
        }
    });
});


