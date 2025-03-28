document.addEventListener("DOMContentLoaded", function () {
    console.log("Elementor Cache & Sync script loaded.");

    // Get current URL parameters
    const urlParams = new URLSearchParams(window.location.search);
    const isOnToolsPage = window.location.href.includes('admin.php?page=elementor-tools');
    const triggerSync = urlParams.has('cache_sync_trigger');

    // If user clicked the button but is NOT on Elementor Tools, redirect
    if (!isOnToolsPage && triggerSync) {
        console.log("Redirecting to Elementor Tools page...");
        window.location.href = '/wp-admin/admin.php?page=elementor-tools&cache_sync_trigger=true';
        return; // Stop execution until redirected
    }

    // If already on the tools page with the trigger, execute actions
    if (isOnToolsPage && triggerSync) {
        console.log("Already on Elementor Tools page. Starting actions...");

        setTimeout(function () {
            var clearCacheButton = document.getElementById('elementor-clear-cache-button');
            var syncLibraryButton = document.getElementById('elementor-library-sync-button');

            if (clearCacheButton) {
                console.log("Clear cache button found. Clicking...");
                clearCacheButton.click();
                clearCacheButton.classList.add('elementor-button-spinner');
            } else {
                console.error("Clear cache button not found.");
            }

            setTimeout(function () {
                if (syncLibraryButton) {
                    console.log("Sync library button found. Clicking...");
                    syncLibraryButton.click();
                    syncLibraryButton.classList.add('elementor-button-spinner');
                } else {
                    console.error("Sync library button not found.");
                }

                // Display success message if both actions were successful
                if (clearCacheButton && syncLibraryButton) {
                    setTimeout(function () {
                        console.log("Both actions completed successfully.");
                        alert("Elementor cache has been cleared and the library has been synced.");
                    }, 2000);
                } else {
                    alert("Error: Could not find one or both buttons. Please try again.");
                }

                // Remove cache_sync_trigger from URL to prevent re-triggering on refresh
                history.replaceState(null, "", "/wp-admin/admin.php?page=elementor-tools");

            }, 2000); // Wait 2 seconds before syncing library
        }, 3000); // Wait 3 seconds after redirection
    }
});
