<script>
    const defaultThemeMode = "light";

    const getPreferredTheme = () => {
        const root = document.documentElement;
        if (!root) return defaultThemeMode;

        const attrThemeMode = root.getAttribute("data-bs-theme-mode");
        const storedTheme = localStorage.getItem("data-bs-theme");

        let theme = attrThemeMode || storedTheme || defaultThemeMode;

        if (theme === "system") {
            const prefersDark = window.matchMedia("(prefers-color-scheme: dark)").matches;
            theme = prefersDark ? "dark" : "light";
        }

        return theme;
    };

    const applyTheme = () => {
        const theme = getPreferredTheme();
        document.documentElement.setAttribute("data-bs-theme", theme);
    };

    applyTheme();
</script>
